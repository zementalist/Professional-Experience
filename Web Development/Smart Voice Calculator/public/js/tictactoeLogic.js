
var iconsArray = ["../img/x.png", "../img/o.png"]; // img src
var players = ['Your', 'Computer\'s']; // who's turn 
var username = players[0]; //user turn
let emptyCellLen = 1; // every cell length is 1 , means it's empty
var pcname = players[1]; // Computer's turn
var turnNumber = 0; // tracking who's turn
var cells = ['c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9'];
var winPatterns = [ ['c1', 'c2', 'c3'], ['c4', 'c5', 'c6'], ['c7', 'c8', 'c9'], ['c1', 'c4', 'c7'], ['c2', 'c5', 'c8'], ['c3', 'c6', 'c9'], ['c1', 'c5', 'c9'], ['c3', 'c5', 'c7'] ];

var userIcon, pcIcon, playerTurn;
window.onload = function() {
     playerIcons = document.getElementById("playerIcons");
 board = document.getElementById('board');
 turn = document.getElementById("turn"); // to type who's turn
 resetBtn = document.getElementById("resetBtn");
}
function generateBasicData() {
    rand = Math.round(Math.random() * 1);
    turnNumber = 0;
    userIcon = iconsArray[rand]; // random icon for user
    pcIcon = rand == 0 ? iconsArray[1] : iconsArray[0];
    playerTurn = players[rand]; // random turn
    playerIcons.innerHTML = "<h4>You : <img src='" + userIcon + "' style='width:15px;height:15px;'></h4><br><h4>Computer: <img src='" + pcIcon + "' style='width:15px;height:15px;'></h4>";
    turn.innerHTML = playerTurn + " turn!";
    giveClickEvents(); // set onclick event for cells
    resetBtn.addEventListener("click", reset);
    if(playerTurn == pcname) { // if player turn is the computer, let it play
        setTimeout(computerPlay, Math.round(Math.random() * 1000) + 1000);
    }
}
function giveClickEvents() {
    // function to set onclick events for cells
    for(let i = 0; i < cells.length; i++) {
        document.getElementsByClassName("cell")[i].addEventListener("click", function(){play(this)});
    }
}
function play(cell) {
    // this function runs when user choose to play in a cell
    var won = win(); 
    if(cell.innerHTML.length == emptyCellLen && playerTurn == username && !won) {
        // if the chosen cell is empty  && it's user's turn && no player won the game
        cell.innerHTML = "<img class='imgCard' src='" + userIcon + "'>";
        playerTurn = pcname; // set turn for pc
        turnNumber++;
        turn.innerHTML = playerTurn + " turn!";
        if(!won) { // let the computer play
            setTimeout(computerPlay, Math.round(Math.random() * 1000) + 1000);
        }
    }
}
function imgType(cell) {
    var text = String(cell.innerHTML);
    if(text.includes("o.png")) {
        return "../img/o.png";
    }
    else if(text.includes("x.png")) {
        return "../img/x.png";
    }
    else {
        return 'none';
    }
}
function computerPlay() {
    if(!win()) {
        if(turnNumber <= 2) {
            var cell = null;
            var AIRANDOM = Math.floor(Math.random() * 1);
            var randomClass = null;
            if(AIRANDOM != 0) {
                randomClass = 'c' + String(Math.floor(Math.random() * 9) + 1);
                cell = document.getElementsByClassName('c5')[0];
            }
            else {
                randomClass = 'c' + String(Math.floor(Math.random() * 9) + 1);
                console.log("ran = " + randomClass)
                cell = document.getElementsByClassName(randomClass)[0];
            }
            while(cell.innerHTML.length > emptyCellLen) {
                randomClass = parseInt(randomClass.replace("c", ""));
                randomClass = 'c' + (randomClass >= 9 || !randomClass == 1 || !randomClass == 4 || !randomClass == 7 ? --randomClass - 1 : randomClass + 1);
                console.log(randomClass);
                randomClass = String(randomClass);
                cell = document.getElementsByClassName(randomClass)[0];
            }
            cell.innerHTML = "<img class='imgCard' src='" + pcIcon + "'>";
            playerTurn = username;
            turn.innerHTML = playerTurn + " turn!";
            turnNumber++;
        } 
        else {
            var attackCell, defenseCell, attackPeriority = 0, defensePeriority = 0;
            var emptyCells = [];
            for(var i = 0; i < winPatterns.length; i++) {
                var cell1 = document.getElementsByClassName(winPatterns[i][0])[0];
                var cell2 = document.getElementsByClassName(winPatterns[i][1])[0];
                var cell3 = document.getElementsByClassName(winPatterns[i][2])[0];
                if( (imgType(cell1) == pcIcon && imgType(cell2) == pcIcon && cell3.innerHTML.length == emptyCellLen) || (imgType(cell1) == pcIcon && imgType(cell3) == pcIcon && cell2.innerHTML.length == emptyCellLen) || (imgType(cell2) == pcIcon && imgType(cell3) == pcIcon && cell1.innerHTML.length == emptyCellLen) ) {
                    if(imgType(cell1) == pcIcon && imgType(cell2) == pcIcon && cell3.innerHTML.length == emptyCellLen) {
                        attackCell = cell3;
                        playerTurn = username;
                        turn.innerHTML = playerTurn + " turn!";
                        turnNumber++;
                        attackPeriority++;
                    }
                    else if(imgType(cell1) == pcIcon && imgType(cell3) == pcIcon && cell2.innerHTML.length == emptyCellLen) {
                        attackCell = cell2;
                        playerTurn = username;
                        turn.innerHTML = playerTurn + " turn!";
                        turnNumber++;
                        attackPeriority++;
                    }
                    else if(imgType(cell2) == pcIcon && imgType(cell3) == pcIcon && cell1.innerHTML.length == emptyCellLen) {
                        attackCell = cell1;
                        playerTurn = username;
                        turn.innerHTML = playerTurn + " turn!";
                        turnNumber++;
                        attackPeriority++;
                    }
                }
                else if( (imgType(cell1) == userIcon && imgType(cell2) == userIcon && cell3.innerHTML.length == emptyCellLen) || (imgType(cell1) == userIcon && imgType(cell3) == userIcon && cell2.innerHTML.length == emptyCellLen) || (imgType(cell2) == userIcon && imgType(cell3) == userIcon && cell1.innerHTML.length == emptyCellLen) ) {
                    if(imgType(cell1) == userIcon && imgType(cell2) == userIcon && cell3.innerHTML.length == emptyCellLen) {
                        defenseCell = cell3;
                        playerTurn = username;
                        turn.innerHTML = playerTurn + " turn!";
                        turnNumber++;
                        defensePeriority++;
                    }
                    else if(imgType(cell1) == userIcon && imgType(cell3) == userIcon && cell2.innerHTML.length == emptyCellLen) {
                        defenseCell = cell2;
                        playerTurn = username;
                        turn.innerHTML = playerTurn + " turn!";
                        turnNumber++;
                        defensePeriority++;
                    }
                    else if(imgType(cell2) == userIcon && imgType(cell3) == userIcon && cell1.innerHTML.length == emptyCellLen) {
                        defenseCell = cell1;
                        playerTurn = username;
                        turn.innerHTML = playerTurn + " turn!";
                        turnNumber++;
                        defensePeriority++;
                    }
                }
                else if((cell1.innerHTML.length == emptyCellLen || cell2.innerHTML.length == emptyCellLen || cell3.innerHTML.length == emptyCellLen)) {
                    if(cell1.innerHTML.length == emptyCellLen) {
                        emptyCells.push(winPatterns[i][0]);
                    }
                    else if(cell2.innerHTML.length == emptyCellLen) {
                        emptyCells.push(winPatterns[i][1]);
                    }
                    else if(cell3.innerHTML.length == emptyCellLen){
                        emptyCells.push(winPatterns[i][2]);
                    }
                }
            }
            var ifCondition = [attackPeriority >= defensePeriority && attackPeriority != 0, attackPeriority >= 1];
            var elseCondition = [attackPeriority < defensePeriority, attackPeriority == 0 && defensePeriority > 0];
            // the first element of them are not used yet, this is just testing phase
            if(ifCondition[1]) {
                console.log("attack higher");
                attackCell.innerHTML = "<img class='imgCard' src='" + pcIcon + "'>";
            }
            else if(elseCondition[1]){
                console.log("defense Higher");
                defenseCell.innerHTML = "<img class='imgCard' src='" + pcIcon + "'>";
            }
            else {
                // no attack chances exists nor defense
                document.getElementsByClassName(emptyCells[0])[0].innerHTML = "<img class='imgCard' src='" + pcIcon + "'>";
                playerTurn = username;
                turn.innerHTML = playerTurn + " turn!";
                turnNumber++;
            }
        }
    }
    win();
}
function win() {
    var userWon = 0;
    var oppoWon = 0;
    var counter = 0;
    for(var i = 0; i < winPatterns.length; i++) {
        userWon = 0;
        oppoWon = 0;
        for(var j = 0; j < winPatterns[i].length; j++) {
            var cell = document.getElementsByClassName(winPatterns[i][j])[0];
            if(cell.innerHTML.length == emptyCellLen) {
                counter++;
            }
            if(cell.innerHTML.length > emptyCellLen && imgType(cell) == userIcon) {
                userWon++;
                if(userWon == 3) {
                    turn.innerHTML = "Winner: " + "<img class='winCard2' src='" + userIcon + "'>";
                    document.getElementById("retro").innerHTML = "WINNER:";
                    document.getElementById("winnerText").innerHTML = "<img class='winCard' src='" + userIcon + "'>";
                    if(document.getElementById("winner")) {
                        document.getElementById("winner").setAttribute("id", "winner-won");
                    }
                    return true;
                }
            }
            else if(cell.innerHTML.length > emptyCellLen && imgType(cell) == pcIcon){
                oppoWon++;
                if(oppoWon == 3) {
                    turn.innerHTML = "Winner: " + "<img class='winCard2' src='" + pcIcon + "'>";
                    document.getElementById("retro").innerHTML = "WINNER:";
                    document.getElementById("winnerText").innerHTML = "<img class='winCard' src='" + pcIcon + "'>";
                    if(document.getElementById("winner")) {
                        document.getElementById("winner").setAttribute("id", "winner-won");
                    }
                    return true;
                }
            }
        }
    }
    if(counter == 0 && (oppoWon != 3 && userWon != 3)) {
        turn.innerHTML = "Draw!";
        document.getElementById("winnerText").innerHTML = "";
        document.getElementById("retro").innerHTML = "DRAW!";
        console.log("WTF");
        if(document.getElementById("winner")) {
            document.getElementById("winner").setAttribute("id", "winner-won");
        }
        return true;
    }
    return false;
}
function reset() {
    for(let i = 0; i < cells.length; i++) {
        document.getElementsByClassName("cell")[i].innerHTML = i+1;
    }
    if(document.getElementById("winner-won")) {
        document.getElementById("winner-won").setAttribute("id", "winner");
    }
    document.getElementById("winnerText").innerHTML = "";
    generateBasicData();
}
