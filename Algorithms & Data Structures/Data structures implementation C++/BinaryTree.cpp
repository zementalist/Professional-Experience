#include <iostream>
using namespace std;

struct node {
    int data;
    node *parent;
    node *left;
    node *right;
};

class tree {
    public:
        node *root;
        tree() {
            root = NULL;
        }
        bool isEmpty() {
            return (root == NULL);
        }
        void insert(int item) {
            node *temp = new node;
            temp->data = item;
            temp->left = NULL;
            temp->right = NULL;
            if(isEmpty()) {
                temp->parent = NULL;
                root = temp;
            }
            else {
                node *location=root, *preLocation=NULL;
                while(location!=NULL) {
                    if(item > location->data) {
                        preLocation = location;
                        location = location->right;
                    }
                    else {
                        preLocation = location;
                        location = location->left;
                    }
                }
                if(item > preLocation->data) {
                    preLocation->right = temp;
                }
                else {
                    preLocation->left = temp;
                }
                temp->parent = preLocation;
            }
        }
        bool search(int item) {
            node *location = root;
            while(location != NULL) {
                if(item > location->data) {
                    location = location->right;
                }
                else if(item < location->data) {
                    location = location->left;
                }
                else {
                    return true;
                }
            }
            return false;
        }
        void deleteItem(int item) {
            node *location=root, *preLocation=NULL;
            while(location != NULL) {
                if(item > location->data) {
                    preLocation = location;
                    location = location->right;
                }
                else if(item < location->data) {
                    preLocation = location;
                    location = location->left;
                }
                else if(item == location->data) {
                    break;
                }
            }
            if(location == NULL) {
                cout << "element not found" << endl;
            }
            else if(location->left != NULL && location->right != NULL) {
                node *successor = location->right;
                while(successor->left != NULL) {
                    successor = successor->left;
                }
                if(successor->right != NULL) {
                    if(successor->right->data > location->data) {
                      location->right = successor->right;
                      successor->right->parent = location;
                    }
                    else {
                        successor->parent->left = successor->right;
                        successor->right->parent = successor->parent;
                    }
                }
                if(successor->data > successor->parent->data) {
                  successor->parent->right = NULL;
                }
                else {
                  successor->parent->left = NULL;
                }
                int temp = successor->data;
                successor->data = location->data;
                location->data = temp;
                location = successor;
            }
            else if(location->left != NULL || location->right != NULL) {
                if(location->right != NULL && location->right->data > preLocation->data) {
                    preLocation->right = location->right;
                    location->right->parent = preLocation;
                }
                else if(location->right != NULL && location->right->data < preLocation->data) {
                    preLocation->left = location->right;
                    location->right->parent = preLocation;
                }
                else if(location->left != NULL && location->left->data > preLocation->data) {
                    preLocation->right = location->left;
                    location->left->parent = preLocation;
                }
                else {
                    preLocation->left = location->left;
                    location->left->parent = preLocation;
                }
            }
            else {
                if(location->data > preLocation->data) {
                    preLocation->right = NULL;
                }
                else {
                    preLocation->left = NULL;
                }
            }
            delete location;
        }
        void breadthFirst() {
            node *left=root->left, *right=root->right;
            cout << root->data << "\t";
            while(left != NULL || right != NULL) {
                if(left != NULL) {
                    cout << left->data << "\t";
                    if(right == NULL) {
                        right = left->right;
                    }
                    left = left->left;
                }
                if(right != NULL) {
                    cout << right->data << "\t";
                    if(left == NULL) {
                        left = right->left;
                    }
                    right = right->right;
                }
            }
        }
        void preOrder(node *direction) {
            if(direction) {
                cout << direction->data << "\t";
                preOrder(direction->left);
                preOrder(direction->right);
            }
        }
        void inOrder(node *direction) {
            if(direction) {
                inOrder(direction->left);
                cout << direction->data << " ";
                inOrder(direction->right);
            }
        }
        void postOrder(node *direction) {
            if(direction) {
                postOrder(direction->left);
                postOrder(direction->right);
                cout << direction->data << "\t";
            }
        }
};

int main() {
    tree t;
    t.insert(4);
    t.insert(3);
    t.insert(6);
    t.insert(1);
    t.insert(5);
    t.insert(8);
    t.insert(2);
    t.insert(7);
    t.insert(0);
    t.breadthFirst();
}
