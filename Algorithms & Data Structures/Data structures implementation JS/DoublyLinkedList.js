class Node {
    constructor(item) {
        this.item = item;
        this.left = null;  // alias for 'previous'
        this.right = null;  // alias for 'next'
        this.root = null;
    }
}

class DoubleLinkedList {
    constructor() {
        this.root = null;
        this.length = 0;
    }
    isEmpty() {
        return this.root == null;
    }
    insertFirst(item) {
        let newNode = new Node(item);
        newNode.right = this.root;
        this.root = newNode;
        this.length++;
    }
    insertLast(item) {
        let newNode = new Node(item);
        let lastNode = this.root;
        while (lastNode && lastNode.right != null) {
            lastNode = lastNode.right;
        }
        if (lastNode) {
            lastNode.right = newNode;
            newNode.left = lastNode;
        }
        else {
            this.insertFirst(item);
            console.log("DLL is empty, item is inserted at position 1");
            return;
        }
        this.length++;
    }
    insertAt(index, item) {
        let newNode = new Node(item);
        if (this.isEmpty() || index < 2) {
            this.insertFirst(item);
            console.log("Dll is empty, item is inserted at position 1");
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
            newNode.left = current;
            current.right = newNode;
            this.length++;
        }
    }
    remove(item) {
        if (this.isEmpty()) {
            console.log("DLL is empty!");
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
                this.root = current.right;
                this.root.left = null;
            }
            else {
                preCurrent.right = current.right;
                current.right ? (current.right.left = preCurrent) : null;
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
