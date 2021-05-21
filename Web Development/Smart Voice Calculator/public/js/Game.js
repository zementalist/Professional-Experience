import { userCommand } from "./User.js";
import {Component} from "./Component.js";
export default class Game extends Component {
    constructor(length, games) {
        super();
        this.length = length;
        this.gameTitles = [];
        this.gameUrls = [];
        var self = this; // a reference to access this scope from inner scope
        this.user = new userCommand(length);
        Object.keys(games).map(function(key) {
            self.gameTitles.push(games[key].getAttribute("discription").toLowerCase().replace("(", "").replace(")",""));
            self.gameUrls.push(games[key].getAttribute("href"));
          });
    }
    isSayingGame(text) {
        text = text.replace(" ", "");
        let isFull = false;
        let gameIndex = -1;
        for(let i = 0; i < this.gameTitles.length; i++) {
            if(this.gameTitles[i].includes(text.toLowerCase())) {
                isFull = this.user.isFullWord(this.gameTitles[i], text);
                gameIndex = isFull? i : -1;
            }

        }
        return gameIndex
    }
    main(e, speechRecognition) {
        let gameIndex = this.isSayingGame(e.results[e.results.length-1][0].transcript);
        if(gameIndex != -1) { // check if number in range of number of games
            speechRecognition.abort();
            window.location = this.gameUrls[gameIndex]; // visit that game
        }
        else if(this.user.isSaying("back", e.results[e.results.length-1][0].transcript)) {
            speechRecognition.abort();
            window.location = "http://localhost:8000/";
        }
        else if(this.user.isSaying("notes", e.results[e.results.length-1][0].transcript)) {
            window.location = "http://localhost:8000/notes";
        }
        else if(this.user.isSaying("calculator", e.results[e.results.length-1][0].transcript)) {
            window.location = "http://localhost:8000/calculator";
        }
    }
}
