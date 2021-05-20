#include <iostream>
#include <string>
#include <algorithm>
#include <cstdlib>
using namespace std;

struct node {
  int data;
  node *next;
};


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


int main() {
 // Stack: push, pop
 stack s;
}