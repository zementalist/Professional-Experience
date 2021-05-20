#include <iostream>
using namespace std;
class node {
    public:
    node *before;
    int data;
    node *next;
};
class list {
    node *start;
    node *current;
    node *temp;
    public:
        list() {
            start = NULL;
            current = NULL;
        }
        void insert(int val) {
            temp = new node;
            temp->data = val;
            temp->next = NULL;
            if(start == NULL) {
                temp->before = NULL;
                start = temp;
                current = temp;
            }
            else {
                temp->before = current;
                current->next = temp;
                current = temp;
            }
        }
        void insertAfter(int specific, int val) {
            node *preLocation;
            preLocation = start;
            temp = new node;
            temp->data = val;
            while(preLocation->data != specific && preLocation != NULL) {
                preLocation = preLocation->next;
            }
            temp->before = preLocation;
            temp->next = preLocation->next;
            preLocation->next = temp;
        }
        void insertBefore(int specific, int val) {
            node *nextLocation;
            node *preLocation;
            nextLocation = start;
            preLocation = start->before;
            temp = new node;
            temp->data = val;
            while(nextLocation->data != specific && nextLocation != NULL) {
                preLocation = nextLocation;
                nextLocation = nextLocation->next;
            }
            temp->next = nextLocation;
            temp->before = preLocation;
            nextLocation->before = temp;
            if(preLocation != NULL) {
                preLocation->next = temp;
            }
            else {
                start = temp;
            }
        }
        bool search(int val) {
            temp = current;
            bool found = false;
            while(!found && temp != NULL) {
                if(temp->data == val) {
                    found = true;
                }
                temp = temp->before;
            }
            return found;
        }
        void deleteItem(int val) {
            node *location;
            node *preLocation;
            location = start;
            if(location->data == val) {
                start = start->next;
            }
            else {
                while(location->next != NULL) {
                    if(location->data == val) {
                        break;
                    }
                    preLocation = location;
                    location = location->next;
                }
                preLocation->next = location->next;
            }
            delete location;
        }
        void print() {
            temp = start;
            while(temp != NULL) {
                cout << temp->data << endl;
                temp = temp->next;
            }
        }
};
int main() {
    list l;
    l.insert(1);
    l.insert(2);
    l.insert(3);
    l.insertBefore(3, 4);
    l.print();
}
