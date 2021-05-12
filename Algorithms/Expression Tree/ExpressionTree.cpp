#include <iostream>
#include <string>
using namespace std;

struct node {
    char data;
    node *parent;
    node *left;
    node *right;
};

struct operation {
    char symbol;
    int weight;
};

class tree {
    public:
        node *root;
        operation *operations = new operation[7];
        string operationsStr = "";
        tree(operation *o) {
            root = NULL;
            operations = o;
            for(int i = 0; i < 7; i++) {
                string str;
                str.push_back(operations[i].symbol);
                operationsStr += str;
            }
        }
        bool isEmpty() {
            return (root == NULL);
        }
        int compare(char x, char y) {
            int xWeight, yWeight;
            for(int i = 0; i < 7; i++) {
                if(x == operations[i].symbol) {
                    xWeight = operations[i].weight;
                }
                else if(y == operations[i].symbol) {
                    yWeight = operations[i].weight;
                }
            }
            int max = (xWeight > yWeight ? 1 : 0);
            return max;
        }
        bool isLetter(char x) {
            char ch = toupper(x);
            return (ch >= 'A' && ch <= 'Z');
        } 
        void insert(char item) {
            node *temp = new node;
            temp->data = item;
            temp->left = NULL;
            temp->right = NULL;
            if(isEmpty()) {
                temp->parent = NULL;
                temp = (temp->data == '(' || temp->data == ')' ? NULL : temp);
                root = temp;
            }
            else {
                node *location=root, *preLocation=NULL;
                if(isLetter(root->data)) {
                    temp = (temp->data == '(' || temp->data == ')' ? NULL : temp);
                    temp->left = root;
                    root = temp;
                }
                else {
                    if(!isLetter(temp->data)) {
                        if(compare(temp->data, root->data)) {
                            temp = (temp->data == '(' || temp->data == ')' ? NULL : temp);
                            if(temp != NULL && root->right == NULL) {
                                root->right = temp;
                            }
                            else {
                                temp->left = root->right;
                                root->right = temp;
                            }
                        }
                        else {
                            if(temp != NULL && root->left == NULL) {
                                root->left = temp;
                            }
                            else {
                                temp->left = root;
                                root = temp;
                            }
                        }
                    }
                    else {
                        node *location = root;
                        while(!isLetter(location->data)) {
                            if(location->right != NULL && !isLetter(location->right->data) && compare(location->right->data,location->data)) {
                                location = location->right;
                            }
                            else if(location->left != NULL && !isLetter(location->left->data) && compare(location->data, location->left->data)) {
                                location = location->left;
                            }
                            else if(location->right != NULL && isLetter(location->right->data)) {
                                temp->left = root->right;
                                root->right = temp;
                            }
                            else {
                                break;
                            }
                        }
                        temp = (temp->data == '(' || temp->data == ')' ? NULL : temp);
                        if(temp != NULL && location->left == NULL) {
                            location->left = temp;
                        }
                        else if(temp != NULL && location->right == NULL) {
                            location->right = temp;
                        }
                        else {
                            cout << "An error happened";
                        }
                    }
                }
            }
        }
        bool search(char item) {
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
                cout << direction->data << "\t";
                inOrder(direction->right);
            }
        }
        void postOrder(node *direction) {
            if(direction) {
                postOrder(direction->left);
                postOrder(direction->right);
                if(direction->data == ')' || direction->data == '(') {
                    ;
                }
                else {
                    cout << direction->data << " ";
                }
            }
        }
};

int main() {
    operation plus = {'+', 1};
    operation minus = {'-', 1};
    operation multiply = {'*', 2};
    operation division = {'/', 2};
    operation power = {'^', 3};
    operation openBracket = {'(', 0};
    operation closeBracket = {')', 0};
    operation *ops = new operation[7];
    ops[0] = plus;
    ops[1] = minus;
    ops[2] = multiply;
    ops[3] = division;
    ops[4] = power;
    ops[5] = openBracket;
    ops[6] = closeBracket;
	tree t(ops);
    string expression;
    cout << "Enter Expression: ";
    cin >> expression;
    for(int i = 0; i < expression.length(); i++) {
        t.insert(expression[i]);
    }
    t.postOrder(t.root);
}