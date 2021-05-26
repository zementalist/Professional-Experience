import { userCommand } from "./User.js";
import {Component} from "./Component.js";

export default class Tictactoe extends Component {
    constructor(cellsDOM, resetButton) {
        super();
        // max & min cell number
        this.max = 9;
        this.min = 1;
        this.user = new userCommand(this.max);
        this.cells = [];
        this.resetButton = resetButton; // as DOM element
        var self = this;
        Object.keys(cellsDOM).map(function(key) {
            self.cells.push(cellsDOM[key]);
          });
    }

    main(e, speechRecognition) {
        console.log(e.results[e.results.length-1][0].transcript);

        let cellNumber = this.user.isSayingNumber(e.results[e.results.length-1][0].transcript);
        if(cellNumber != -1) {
            speechRecognition.abort();
            play(this.cells[cellNumber-1]);
        }
        else if(this.user.isSaying("reset", e.results[e.results.length-1][0].transcript)) {
            this.resetButton.click();
            speechRecognition.abort();
        }
        else if(this.user.isSaying("games", e.results[e.results.length-1][0].transcript)) {
            window.location = "http://localhost:8000/games";
        }
        else if(this.user.isSaying("notes", e.results[e.results.length-1][0].transcript)) {
            window.location = "http://localhost:8000/note";
        }
        else if(this.user.isSaying("calculator", e.results[e.results.length-1][0].transcript)) {
            window.location = "http://localhost:8000/calculator";
        }
    }
}