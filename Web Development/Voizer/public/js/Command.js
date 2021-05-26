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
export {Command};