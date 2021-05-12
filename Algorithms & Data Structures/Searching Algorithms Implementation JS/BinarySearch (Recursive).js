function binaryRec(array, item, left, right) {
    if (left <= right) {
        let mid = Math.floor((left + right) / 2);
        if (item > array[mid]) {
            return this.binaryRec(array, item, mid + 1, right);
        }
        if (item == array[mid]) {
            return "Found " + item + " at position " + (mid + 1);
        }
        if (item < array[mid]) {
            return this.binaryRec(array, item, left, mid - 1);
        }
    }
    return item + " not found";
}