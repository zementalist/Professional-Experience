import { Command } from "./static/js/Command.js";
import { userCommand } from "./static/js/User.js";
import {Component} from "./static/js/Component.js";

export class Note extends Component {
    constructor(notes, authenticated) {
        super(authenticated);
        this.command = new Command();
        this.user = new userCommand(notes.length);
        this.textToShow = "";
        this.notes = notes;
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
            let header = document.getElementById('header');
            if(header.textContent == "No active note.") {
                header.innerHTML = "New note";
            }
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
                if(document.getElementById("userText").textContent.length > 0)
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
        else if(this.command.isNormal(this.currentMode) && this.user.isSaying("open", e.results[e.results.length-1][0].transcript)) {
            let lastMode = this.currentMode[this.currentMode.length-1];
            if(this.authenticated) {
                this.currentMode.push("Open");
                modeDocument.innerHTML = this.currentMode[this.currentMode.length -1];
                speechRecognition.abort();
            }
            else if(this.authenticated && notes.length == 0) {
                modeDocument.innerHTML = "<b>You don't have any saved notes.<b>";
                setTimeout(function() {
                    modeDocument.innerHTML = lastMode;
                },3000)
            }
            else if(!this.authenticated) {
                modeDocument.innerHTML = "<b>Log in to open a note<b>";
                setTimeout(function() {
                    modeDocument.innerHTML = lastMode;
                },3000)
            }
        }
        else if(this.command.isNormal(this.currentMode) && this.user.isSaying("delete", e.results[e.results.length-1][0].transcript)) {
            let lastMode = this.currentMode[this.currentMode.length-1];
            if(this.authenticated) {
                this.currentMode.push("Delete");
                speechRecognition.abort();
                modeDocument.innerHTML = this.currentMode[this.currentMode.length-1];
            }
            else if(this.authenticated && notes.length == 0) {
                modeDocument.innerHTML = "<b>You don't have any saved notes<b>";
                setTimeout(function() {
                    modeDocument.innerHTML = lastMode;
                },3000)
            }
            else if(!this.authenticated) {
                modeDocument.innerHTML = "<b>Log in to delete a note<b>";
                setTimeout(function() {
                    modeDocument.innerHTML = lastMode;
                },3000)
            }
        }
        else if(this.command.isOpen(this.currentMode) || this.command.isDelete(this.currentMode)) {
            let number = this.user.isSayingNumber(e.results[e.results.length-1][0].transcript);
            if(number != -1) {
                speechRecognition.abort();
                let note = this.notes[number-1];
                if(this.command.isOpen(this.currentMode)) {
                    document.getElementById("userText").textContent = note.content;
                    this.oldText =  note.content + " ";
                    document.getElementById("header").innerHTML = note.content.substring(0, 15) + "...   " + "(Created at: " + note.created_at + ")";
                }
                else {
                    // note_id isn't inputted in DOM->hiddenElement.innerHTML
                    document.getElementById('note_id').value = note.note_id;
                    document.getElementById("userTextDelete").textContent = note.content;
                    document.getElementById("myFormDelete").submit();
                    
                }
                this.currentMode.pop();
                modeDocument.innerHTML = this.currentMode[this.currentMode.length-1];
            }
        }
        else if(this.command.isNormal(this.currentMode) && this.user.isSaying("back", e.results[e.results.length-1][0].transcript)) {
            window.location = "http://localhost:8000/";
        }
        else if(this.command.isNormal(this.currentMode) && this.user.isSaying("games", e.results[e.results.length-1][0].transcript)) {
            window.location = "http://localhost:8000/games";
        }
        else if(this.command.isNormal(this.currentMode) && this.user.isSaying("calculator", e.results[e.results.length-1][0].transcript)) {
            window.location = "http://localhost:8000/calculator";
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
                    document.getElementById("userText").select();
                    document.execthis.command("copy");
                    modeDocument.innerHTML = "Copied Successfully!";
                    modeDocument.style.fontWeight = 900;
                    setTimeout(function() {
                        modeDocument.innerHTML = this.currentMode[this.currentMode.length-1];
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

export default Note;