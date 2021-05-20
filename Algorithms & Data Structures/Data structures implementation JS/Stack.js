class Node {
    constructor(item) {
        this.item = item;
        this.right = null; // alias for 'next'
        this.top = null;
    }
}

class Stack {
    constructor() {
        this.length = 0;
        this.top = null;
    }
    isEmpty() {
        return this.top == null;
    }
    push(item) {
        let newNode = new Node(item);
        newNode.right = this.top;
        this.top = newNode;
        this.length++;
    }
    pop() {
        if (!this.isEmpty()) {
            this.top = this.top.right;
            this.length--;
        }
        else {
            console.log("Stack is empty!");
        }
    }
    print() {
        let current = this.top;
        while (current) {
            console.log(current.item + "\n");
            current = current.right;
        }
    }
}