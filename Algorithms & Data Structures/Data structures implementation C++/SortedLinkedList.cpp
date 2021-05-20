#include <iostream>
#include <string>
#include <algorithm>
#include <cstdlib>
using namespace std;

struct node {
  int data;
  node *next;
};


// sSorted Linked List //

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


int main() {
 // Sorted LL: insert, search, deleteItem
 SortedLinkedList ll;
}