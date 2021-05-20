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

int main() {
 // Queue: enqueue, dequeue
 queue q;
}