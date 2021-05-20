let array = [3, 1, 6, 8, 7, 5, 2, 4];
let sortedArray = [1, 2, 3, 4, 5, 6, 7, 8]
/*

Linear Search (normal + recursion)
Binary Search (normal + recursion)
Linked List (Single, Double, Circular)
Queue
Stack
BST

*/
class Algorithm {
    constructor() {}
    linearSearch(array, item) {
        for (let i = 0; i < array.length; i++) {
            if (array[i] == item) {
                return "Found " + item + " at position " + (i + 1);
            }
        }
        return item + " not found!";
    }
    linearRec(array, item, left, right) {
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
    binarySearch(array, item) {
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
    binaryRec(array, item, left, right) {
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
}

class DataStructure {
    constructor() {
        if (this.constructor === DataStructure) {
            throw new Error("Abstract Class");
        }
    }
}

class Node {
    constructor(item) {
        this.item = item;
        this.left = null;
        this.right = null;
        this.front = null;
        this.rear = null;
        this.parent = null;
        this.root = null;
        this.top = null;
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

class BinarySearchTree {
    constructor() {
        this.root = null;
        this.length = 0;
    }
    isEmpty() {
        return this.root == null;
    }
    insert(item) {
        let newNode = new Node(item);
        if (this.isEmpty()) {
            this.root = newNode;
        }
        else {
            let current = this.root;
            while (current.right != null && current.left != null) {
                if (item >= current.item) {
                    current = current.right;
                }
                else {
                    current = current.left;
                }
            }
            if (item >= current.item) {
                current.right = newNode;
            }
            else {
                current.left = newNode;
            }
            newNode.parent = current;
        }
    }
    search(item) {
        if (this.isEmpty()) {
            console.log("Tree is empty");
            return -1;
        }
        else {
            let current = this.root;
            let level = 1;
            while (current) {
                if (item > current.item) {
                    current = current.right;
                }
                else if (item == current.item) {
                    console.log(item + " found at level " + level);
                    return level;
                }
                else {
                    current = current.left;
                }
                level++;
            }
            if (current == null) {
                console.log("NOT found!");
                return -1;
            }
        }
    }
    preOrder(node) {
        if (node) {
            console.log(node.item);
            this.preOrder(node.left);
            this.preOrder(node.right);
        }
    }
    inOrder(node) {
        if (node) {
            this.inOrder(node.left);
            console.log(node.item);
            this.inOrder(node.right);
        }
    }
    postOrder(node) {
        if (node) {
            this.postOrder(node.left);
            this.postOrder(node.right);
            console.log(node.item);
        }
    }
}

let algo = new Algorithm();
let ll = new LinkedList();
let dll = new DoubleLinkedList();
let queue = new Queue();
let stack = new Stack();
let tree = new BinarySearchTree();