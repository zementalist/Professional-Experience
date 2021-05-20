class Node {
    constructor(item) {
        this.item = item;
        this.right = null; // alias for 'next'
        this.root = null;
    }
}

class LinkedList {
    constructor() {
        this.length = 0;
        this.root = null;
    }
    isEmpty() {
        return this.root == null;
    }
    insertLast(item) {
        let newNode = new Node(item);
        if (this.isEmpty()) {
            this.root = newNode;
        }
        else {
            let current = this.root;
            while (current.right != null) {
                current = current.right;
            }
            current.right = newNode;
        }
        this.length++;
    }
    insertFirst(item) {
        let newNode = new Node(item);
        newNode.right = this.root;
        this.root = newNode;
        this.length++;
    }
    insertAt(index, item) {
        let newNode = new Node(item);
        if (this.isEmpty() || index < 2) {
            this.insertFirst(item);
            console.log("LL is empty, item is inserted at position 1");
            return;
        }
        else {
            let current = this.root;
            let i = 1;
            while (current.right != null && i < index - 1) {
                current = current.right;
                i++;
            }
            newNode.right = current.right;
            current.right = newNode;
            console.log("Item is inserted at position " + i);
        }
        this.length++;
    }
    search(item) {
        if (this.isEmpty()) {
            console.log("LL is empty");
        }
        else {
            let current = this.root;
            let i = 1;
            while (current.right != null && current.item != item) {
                current = current.right;
                i++;
            }
            if (current.item == item) {
                console.log("item found at position " + i);
                return i;
            }
            else {
                console.log("item not found");
                return -1;
            }
        }
    }
    remove(item) {
        if (this.isEmpty()) {
            console.log("LL is empty");
        }
        else {
            let current = this.root;
            let preCurrent = null;
            while (current.item != item) {
                if (current.right == null) {
                    console.log("item not found");
                    return -1;
                }
                else {
                    preCurrent = current;
                    current = current.right;
                }
            }
            if (preCurrent == null) {
                this.root = this.root.right;
                return "deleted";
            }
            else {
                preCurrent.right = current.right;
                return "deleted";
            }
            this.length--;
        }
    }
    print() {
        let current = this.root;
        while (current) {
            console.log(current.item + "\n");
            current = current.right;
        }
    }
}
