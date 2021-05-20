#include <iostream>
using namespace std;

struct node {
    int data;
    node* next;
};

class list {
public:
    node* start;
    list()
    {
        start = NULL;
    }
    void add(int item)
    {
        node* temp = new node;
        temp->data = item;
        if (start == NULL) {
            start = temp;
            temp->next = start;
        }
        else {
            node* startCopy = start; // copy of first node //
            node* location = start->next;
            while (location->next != startCopy) {
                location = location->next;
            }
            location->next = temp;
            temp->next = start;
        }
    }
    void addFirst(int item)
    {
        node* temp = new node;
        temp->data = item;
        if (start == NULL) {
            start = temp;
            temp->next = start;
        }
        else {
            temp->next = start;
            node* last = start->next;
            while (last->next != start) {
                last = last->next;
            }
            start = temp;
            last->next = start;
        }
    }
    void print()
    {
        node* startCopy = start;
        node* location = start->next;
        cout << startCopy->data << endl;
        while (location != startCopy) {
            cout << location->data << endl;
            location = location->next;
        }
    }
};

int main()
{
    list l;
    l.addFirst(1);
    l.addFirst(2);
    l.addFirst(3);
    l.addFirst(4);
    l.print();
}