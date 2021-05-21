import { userCommand } from "./User.js";
import { Component } from "./Component.js";

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};

export default class Calculator extends Component {
    constructor(resultDOM) {
        super();
        this.user = new userCommand();
        this.textToShow = "";
        this.resultDOM = resultDOM;
        this.transcriptArray = [];
        this.equationAfterFilter = "";
        this.transcriptedText = "";
        this.operations = ["plus", "minus", "multiply", "divided by", "add", "substract", "divide", "to the power of", "square root of"];
        this.operators = ["+", "-", "*", "/", "+", "-", "/", "^", "√"];
        this.arrayOfStringNumbers = ["one", "what", 'when', 'two', 'to', 'do', 'free', 'three', 'for', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'mine', 'ten', 'dim', 'then'];
        this.arrayOfIntegers = [1, 1, 1, 2, 2, 2, 3, 3, 4, 4, 5, 6, 7, 8, 9, 9, 10, 10, 10];
    }
    filter(text) {
        // replace operators_as_words with operators_as_symbols
        text = text.replaceAll('x', '*');
        text = text.replaceAll('÷', '/');
        for(let i = 0; i < this.operators.length; i++) {
            text = text.replaceAll(this.operations[i], this.operators[i]);
        }
        // replace numbers_as_words with numbers_as_integers
        for(let j = 0; j < this.arrayOfStringNumbers.length; j++) {
            text = text.replaceAll(this.arrayOfStringNumbers[j], this.arrayOfIntegers[j]);
        }
        // replace redundant words
        let textAsArray = text.split(" ");
        for(let k = 0; k < textAsArray.length; k++) {
            // if text is not a number && not included in operations_as_words neither numbers_as_words
            if(isNaN(textAsArray[k]) && ! this.operations.includes(textAsArray[k]) && !this.operators.includes(textAsArray[k]) && !this.arrayOfStringNumbers.includes(textAsArray[k])) {
                text = text.replaceAll(textAsArray[k], "");
            }
        }
        return text;
    }
    solve(equation) {
        equation = this.filter(equation);
        equation = equation.replaceAll(/\s+/, "");
        equation = equation.replaceAll("+", "%2B");
        if(equation.includes('√')) {
            while(equation.includes('√')) {
                let squareRegex = /√\d+/;
                let regex = new RegExp(squareRegex);
                let squareTerm = regex.exec(equation)[0];
                let updated_squareTerm = squareTerm.replace('√', 'sqrt(');
                updated_squareTerm += ')';
                equation = equation.replace(squareTerm, updated_squareTerm);
            }
        }
        
        let result = "";
        let url = "https://api.mathjs.org/v4/?expr=";
        var self = this;
        fetch(url+equation).then(function(response){
            if(response.ok) {
                return response.json();
            }
            else {
                console.log("Wrong Expression");
            }
        }).then(function(jsonResponse){
            result = jsonResponse;
            if(result !== undefined) {
                self.resultDOM.innerHTML = result;
            }
            else {
                self.resultDOM.innerHTML = "Invalid Expression";
                document.getElementById("userText").value = "";
                setTimeout(function() {
                    self.resultDOM.innerHTML = "";
                },3000);
            }
        })
    }

    main(e, speechRecognition, textArea) {
        this.transcriptArray = Array.from(e.results)
        .map(result => result[0])
        .map(result => result.transcript);
        console.log(this.transcriptArray[this.transcriptArray.length-1]);
        if(this.user.isSaying("filter", e.results[e.results.length-1][0].transcript)) {
            speechRecognition.abort();
            this.textToShow = this.filter(textArea.value);
            textArea.value = this.textToShow;
            this.equationAfterFilter = textArea.value;
        }
        else if(this.user.isSaying("calculate", e.results[e.results.length-1][0].transcript)) {
            speechRecognition.abort();
            let eq = this.filter(textArea.value);
            this.textToShow = eq;
            textArea.value = this.textToShow;
            this.equationAfterFilter = textArea.value;
            this.solve(eq);
        }
        else if(this.user.isSaying("clear", e.results[e.results.length-1][0].transcript)) {
            speechRecognition.abort();
            this.textToShow ="";
            textArea.value = "";
            this.equationAfterFilter = "";
        }
        else if(this.user.isSaying("games", e.results[e.results.length-1][0].transcript)) {
            window.location = "http://localhost:8000/games";
        }
        else if(this.user.isSaying("notes", e.results[e.results.length-1][0].transcript)) {
            window.location = "http://localhost:8000/note";
        }
        else {
            this.transcriptedText = this.transcriptArray.join(" ");
            this.textToShow = this.equationAfterFilter + this.transcriptedText;
            textArea.value = this.textToShow;
        }
    }
}