function linearRec(array, item, left, right) {
    if (left <= right) {
        if (array[left] == item) {
            return "Found " + item + " at position " + (left + 1);
        }
        if (array[right] == item) {
            return "Found " + item + " at position " + (right + 1);
        }
        return this.linearRec(array, item, left + 1, right - 1);
    }
    return item + " not found!";
}