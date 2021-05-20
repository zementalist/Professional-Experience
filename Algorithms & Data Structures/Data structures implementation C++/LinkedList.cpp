#include <iostream>
#include <string>
#include <algorithm>
#include <cstdlib>
using namespace std;

struct node {
  int data;
  node *next;
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

int main() {
 // Linked-list: addFirst, addAfter, addLast, deleteItem, search
 LinkedList l;
}