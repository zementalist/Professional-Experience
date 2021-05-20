#include <iostream>
#include <string>
#include <algorithm>
#include <cstdlib>
using namespace std;

struct node {
  int data;
  node *next;
  node *parent;
  node *left;
  node *right;
};

// Unsorted Linked List //

class LinkedList {
  public:
    node *start;
    LinkedList() {
      start = NULL;
    }
    void addFirst(int item) {
      node *temp = new node;
      temp->data = item;
      temp->next = start;
      start = temp;
    }
    void addAfter(int item, int after) {
      node *temp = new node;
      temp->data = item;
      node *location = start;
      while(location->data != after) {
        location = location->next;
      }
      temp->next = location->next;
      location->next = temp;
    }
    void addLast(int item) {
      node *temp = new node;
      temp->data = item;
      temp->next = NULL;
      node *location = start;
      while(location != NULL && location->next != NULL) {
        location = location->next;
      }
      if(location == NULL) {
        temp->next = location;
        start = temp;
      }
      else {
        location->next = temp;
      }
    }
    void deleteItem(int item) {
      node *location = start;
      node *preLocation = NULL;
      if(location->data == item) {
        start = start->next;
      }
      else {
        while(location->data != item) {
          preLocation = location;
          location = location->next;
        }
        preLocation->next = location->next;
        delete location;
      }
    }
    bool search(int item) {
      node *location = start;
      while(location != NULL) {
        if(location->data == item) {
          return true;
        }
        location = location->next;
      }
      return false;
    }
};
// Unsorted linked list END //

// Sorted Linked List //

class SortedLinkedList {
  public:
    node *start;
    SortedLinkedList() {
      start = NULL;
    }
    void insert(int item) {
      node *temp = new node;
      temp->data = item;
      node *location = start;
      node *preLocation = NULL;
      while(location != NULL && item > location->data) {
        preLocation = location;
        location = location->next;
      }
      if(preLocation == NULL) {
        temp->next = start;
        start = temp;
      }
      else {
        temp->next = preLocation->next;
        preLocation->next = temp;
      }
    }
    void deleteItem(int item) {
      node *location = start;
      node *preLocation = NULL;
      if(location->data == item) {
        start = start->next;
      }
      else {
        while(location != NULL && item > location->data) {
          preLocation = location;
          location = location->next;
        }
        preLocation->next = location->next;
        delete location;
      }
    }
    bool search(int item) {
      node *location = start;
      while(location != NULL && item >= location->data) {
        if(location->data == item) {
          return true;
        }
        location = location->next;
      }
      return false;
    }
};

// Sorted Linked List END //

// Queue //

class queue {
  public:
    node *front, *rear;
    queue() {
      front = NULL;
      rear = NULL;
    }
    void enqueue(int item) {
      node *temp = new node;
      temp->data = item;
      temp->next = NULL;
      if(front == NULL) {
        front = temp;
        rear = temp;
      }
      else {
        rear->next = temp;
        rear = temp;
      }
    }
    int dequeue() {
      node *old = front;
      front = front->next;
      if(front == NULL) {
        rear = NULL; // I'm not sure of importance of this line :D //
      }
      int oldData = old->data;
      delete old;
      return oldData;
    }
};

// Queue END //


// Stack //

class stack {
  public:
    node *top;
    stack() {
      top = NULL;
    }
    void push(int item) {
      node *temp = new node;
      temp->data = item;
      temp->next = top;
      top = temp;
    }
    int pop() {
      node *old = top;
      top = top->next;
      int oldData = old->data;
      delete old;
      return oldData;
    }
};

//Stack END //

//Tree //
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

// Tree END //

// Function to print items of (linked-list, queue, stack)

void print(node *location) {
  while(location != NULL) {
    cout << location->data << endl;
    location = location->next;
  }
}
// print function END //


int main() {
 // Linked-list: addFirst, addAfter, addLast, deleteItem, search
 LinkedList l;
 // Unsorted LL: insert, search, deleteItem
 SortedLinkedList ll;
 // Queue: enqueue, dequeue
 queue q;
 // Stack: push, pop
 stack s;
 // Tree: insert, search, pre/in/post - order, deleteItem, breadthFirst
 tree t;
}