class Node {
    constructor(item) {
        this.item = item;
        this.right = null; // alias for 'next'
        this.front = null;
        this.rear = null;
    }
}

class Queue {
    constructor() {
        this.length = 0;
        this.front = null;
        this.rear = null;
    }
    isEmpty() {
        return this.front == null && this.rear == null;
    }
    enqueue(item) {
        let newNode = new Node(item);
        if (this.isEmpty()) {
            this.front = newNode;
            this.rear = newNode;
        }
        else {
            this.rear.right = newNode;
            this.rear = newNode;
        }
        this.length++;
    }
    dequeue() {
        if (!this.isEmpty()) {
            if (this.front == this.rear) {
                this.front == null;
                this.rear = null;
            }
            else {
                this.front = this.front.right;
            }
            this.length--;
        }
        else {
            console.log("Queue is empty!");
        }
    }
    print() {
        let current = this.front;
        while (current) {
            console.log(current.item + "\n");
            current = current.right;
        }
    }
}
