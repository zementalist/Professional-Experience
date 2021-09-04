//export default Note;
class Command {

    isNormal(currentModeArray) {
        if(currentModeArray[currentModeArray.length-1] == "Normal") {
            return true;
        }
        return false;
    }
    isText(currentModeArray) {
        if(currentModeArray[currentModeArray.length-1] == "Typing") {
            return true;
        }
        return false;
    }
    isOpen(currentModeArray) {
        if(currentModeArray[currentModeArray.length-1] == "Open") {
            return true;
        }
        return false;
    }
    isDelete(currentModeArray) {
        if(currentModeArray[currentModeArray.length-1] == "Delete") {
            return true;
        }
        return false;
    }
    getLastWord(text) {
        if(text.length > 0) {
            while(text[text.length-1] == " ") {
                text = text.substring(0, text.length -1);
            }
            let lastWord = text.substring(text.lastIndexOf(" "), text.length);
            return lastWord;
        }
    }
}

class Component {
    constructor(authenticated) {
        this.authenticated = authenticated;
    }
    isSaying(word, text) {
        console.log("This class is for test only");
    }
    isSayingNumber(text) {
        console.log("This class is for test only");
    }
    isFullWord(commands, text) {
        console.log("This class is for test only");
    }
    isSayingGame(text) {
        console.log("This class is for test only");
    }
}

class userCommand extends Component{
    constructor(length) {
        super();
        this.length = length;
        this.stringOfCommandBack = "back beck deck pack big make neck";
        this.stringOfCommandStart = "star start first state";
        this.stringOfCommandDelete = "delete did it reddit daily";
        this.stringOfCommandOpen = "open robin hoping puppy";
        this.stringOfCommandCopy = "copy corby kabni cubby gabby coppi gubby kobe dappy";
        this.stringOfCommandSave = "save sieve say safe dave";
        this.stringOfCommandClear = "clear play cleaner please";
        this.stringOfCommandFilter = "filter felt";
        this.stringOfCommandCalculate = "calculate solve";
        this.stringOfUrlCalculator = " calculator ";
        this.stringOfUrlGame = "games game";
        this.stringOfUrlNote = "note notes";
        this.stringOfPost = "post posted posts boast boost";
        this.stringOfTitle = 'title data dating datel';
        this.stringOfBody = 'body buddy';
        this.stringOfCancel = 'cancel ';
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
            case "post":
                stringOfWords = this.stringOfPost;
                break;
            case "cancel":
                stringOfWords = this.stringOfCancel;
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

class Note extends Component {
    constructor(notes, authenticated) {
        super(authenticated);
        this.command = new Command();
        this.user = new userCommand(notes.length);
        this.textToShow = "";
        this.transcriptArray = [];
        this.currentMode = ["Normal"];
        this.oldText = "";
        this.transcriptedText = "";
        this.authenticated = authenticated;
    }
    main(e, speechRecognition, modeDocument, textArea) {

        this.transcriptArray = Array.from(e.results)
        .map(result => result[0])
        .map(result => result.transcript);
        //console.log(e.results[e.results.length-1][0].transcript + " : " + e.results[e.results.length-1][0].confidence);
        //console.log(this.command.isNormal(this.currentMode) + e.results[e.results.length-1][0].transcript);
        console.log(this.transcriptArray + " : " +this.user.isSaying("delete", this.transcriptArray[this.transcriptArray.length -1]));
        if(this.command.isNormal(this.currentMode) && this.user.isSaying("start", e.results[e.results.length-1][0].transcript)) {
            // if current mode is Normal and the this.user said start -> start typing
            this.currentMode.push("Typing");
            speechRecognition.abort();
            modeDocument.innerHTML = this.currentMode[this.currentMode.length -1];
        }
        else if(this.command.isText(this.currentMode) && this.user.isSaying("back", e.results[e.results.length-1][0].transcript)) {
            // if current mode is text(ing) and the this.user said back -> stop typing , wait for new this.command
            this.currentMode.pop();
            modeDocument.innerHTML = this.currentMode[this.currentMode.length -1];
            speechRecognition.abort();
        }
        else if(!this.command.isNormal(this.currentMode) && this.user.isSaying("back", e.results[e.results.length-1][0].transcript)) {
            speechRecognition.abort();
            this.currentMode.pop();
            modeDocument.innerHTML = this.currentMode[this.currentMode.length-1];
        }
        else if(this.command.isNormal(this.currentMode) && this.user.isSaying("save", e.results[e.results.length-1][0].transcript)) {
            let lastMode = this.currentMode[this.currentMode.length-1];
            if(this.authenticated) {
                if(textArea.textContent.length > 0)
                    document.getElementById('myForm').submit();
                speechRecognition.abort();
            }
            else if(!this.authenticated) {
                modeDocument.innerHTML = "<b>Log in to save a note<b>";
                setTimeout(function() {
                    modeDocument.innerHTML = lastMode;
                },3000)
            }
        }
        else if(this.command.isNormal(this.currentMode) && this.user.isSaying("post", e.results[e.results.length-1][0].transcript)) {
            document.forms['postForm'].submit();
        }

        else if(this.command.isNormal(this.currentMode) && this.user.isSaying("cancel", e.results[e.results.length-1][0].transcript)) {
            window.history.back();
        }


            if(this.command.isText(this.currentMode)) {
            if(e.results[e.results.length-1][0].confidence >= 0.809){ // High confidence words
                this.transcriptedText = this.transcriptArray.join(" ");
                if(this.user.isSaying("clear", this.transcriptArray[this.transcriptArray.length-1])) {
                    //startingIndex = transcriptedText.length;
                    speechRecognition.abort();
                    textArea.textContent = "";
                    this.oldText = "";
                }
                else if(this.user.isSaying("delete", this.transcriptArray[this.transcriptArray.length -1])) {
                    //transcriptedText = transcriptedText.substring(0, transcriptedText.lastIndexOf("  delete"));
                    let lastWord = this.command.getLastWord(textArea.textContent);
                    let endIndex = textArea.textContent.lastIndexOf(lastWord); // Last word starting index
                    this.oldText = textArea.textContent.substring(0, endIndex) + " ";
                    textArea.textContent = this.oldText;
                    console.log(this.transcriptArray);
                    speechRecognition.abort();
    
                }
                else if(this.user.isSaying("copy", this.transcriptArray[this.transcriptArray.length -1])) {
                    this.oldText = textArea.textContent + " ";
                    speechRecognition.abort();
                    document.getElementById('userText').select();
                    document.execCommand("copy");
                    modeDocument.innerHTML = "Copied Successfully!";
                    modeDocument.style.fontWeight = 900;
                    let that = this;
                    setTimeout(function() {
                        modeDocument.innerHTML = that.currentMode[that.currentMode.length-1];
                    }, 3000)
                }
                else {
                    this.textToShow = this.transcriptedText;
                    textArea.textContent = this.oldText + this.textToShow;
                    console.log(this.transcriptArray[this.transcriptArray.length-1]);
                }
            }
            else {
    
            }
        }
        else {
            if(this.transcriptArray.length > 0) {
                this.transcriptArray.pop();
            }
            
        }
    
    }
}

