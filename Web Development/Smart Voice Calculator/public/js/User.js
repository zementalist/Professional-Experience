import {Component} from "./Component.js";

class userCommand extends Component{
    constructor(length) {
        super();
        this.length = length;
        this.stringOfCommandBack = "back beck deck pack big make neck";
        this.stringOfCommandStart = "star start first state";
        this.stringOfCommandDelete = "delete did it reddit daily";
        this.stringOfCommandOpen = "open robin hoping puppy";
        this.stringOfCommandCopy = "copy corby kabni cubby gabby coppi gubby";
        this.stringOfCommandSave = "save sieve say safe dave";
        this.stringOfCommandClear = "clear play cleaner please";
        this.stringOfCommandFilter = "filter felt center centre feltham celta";
        this.stringOfCommandCalculate = "calculate solve";
        this.stringOfUrlCalculator = " calculator ";
        this.stringOfUrlGame = "games game";
        this.stringOfUrlNote = "note notes";
        this.stringOfCommandReset = "reset wrist rest recent resist again play is it receipt set";
        this.arrayOfStringNumbers = ["one", 'when', 'two', 'to', 'do', 'free', 'three', 'for', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'dim'];
        this.arrayOfIntegers = [1, 1, 2, 2, 2, 3, 3, 4, 4, 5, 6, 7, 8, 9, 10, 10];
    }
    isFullWord(stringOfCommand, text) {
        text = text.toLowerCase();
        let ratio = stringOfCommand.indexOf(text) == 0 ? text.length : 1;
        let nextChar = stringOfCommand[stringOfCommand.indexOf(text)+ratio];
        let prevChar = stringOfCommand[stringOfCommand.indexOf(text)-ratio];
        let isFullWord = (nextChar == " " || prevChar == " ");

        return isFullWord;
    }
    isSaying(word, text) {
        let stringOfWords;
        switch(word) {
            case "back":
                stringOfWords = this.stringOfCommandBack;
                break;
            case "start":
                stringOfWords = this.stringOfCommandStart;
                break;
            case "open":
                stringOfWords = this.stringOfCommandOpen;
                break;
            case "delete":
                stringOfWords = this.stringOfCommandDelete;
                break;
            case "copy":
                stringOfWords = this.stringOfCommandCopy;
                break;
            case "save":
                stringOfWords = this.stringOfCommandSave;
                break;
            case "clear":
                stringOfWords = this.stringOfCommandClear;
                break;
            case "reset":
                stringOfWords = this.stringOfCommandReset;
                break;
            case "filter":
                stringOfWords = this.stringOfCommandFilter;
                break;
            case "calculate":
                stringOfWords = this.stringOfCommandCalculate;
                break;
            case "calculator":
                stringOfWords = this.stringOfUrlCalculator;
                break;
            case "games":
                stringOfWords = this.stringOfUrlGame;
                break;
            case "notes":
                stringOfWords = this.stringOfUrlNote;
                break;
        }
        text = text.replace(" ", "");
        if(stringOfWords.includes(text.toLowerCase())) {
            return this.isFullWord(stringOfWords, text);
        }
        return false;
    }
    isSayingNumber(text) {
        text = text.replace(" ", "");
        if(!isNaN(text)) {
            if(parseInt(text) <= this.length && parseInt(text) > 0) {
                return parseInt(text);
            }
        }
        else {
            text = text.replace(" ", "");
            if(this.arrayOfStringNumbers.includes(text)) {
                let num = this.arrayOfIntegers[this.arrayOfStringNumbers.indexOf(text)];
                return (num <= this.length && num > 0 ? num : -1);
            }
            return -1;
        }
        return -1;
    }
}
export {userCommand};