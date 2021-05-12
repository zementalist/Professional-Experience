function binarySearch(array, item) {
    let left = 0,
        right = array.length - 1,
        found = false;
    while (left <= right && !found) {
        let mid = Math.floor((right + left) / 2);
        console.log(mid);
        if (item > array[mid]) {
            left = mid + 1;
        }
        else if (item == array[mid]) {
            found = true;
            return "Found " + item + " at position " + (mid + 1);
        }
        else {
            right = mid - 1;
        }
    }
    return item + " not found!";
}