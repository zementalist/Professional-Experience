class Node {
    constructor(item) {
        this.item = item;
        this.left = null;
        this.right = null;
        this.parent = null;
        this.root = null;
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