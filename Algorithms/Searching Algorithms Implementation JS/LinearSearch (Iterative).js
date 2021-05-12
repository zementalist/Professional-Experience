function linearSearch(array, item) {
    for (let i = 0; i < array.length; i++) {
        if (array[i] == item) {
            return "Found " + item + " at position " + (i + 1);
        }
    }
    return item + " not found!";
}