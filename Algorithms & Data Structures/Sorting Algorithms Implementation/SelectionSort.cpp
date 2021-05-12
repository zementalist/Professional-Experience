#include <iostream>
using namespace std;

void print(int arr[], int size) {
  for(int i = 0; i < size; i++) {
    cout << arr[i] << endl;
  }
}
int counter = 0;


void selection(int arr[], int size) {
  for(int i = 0; i < size-1; i++) {
    int min = i;
    for(int j = i+1; j < size; j++) {
      //counter++;
      if(arr[j] < arr[min]) {
        min = j;
      }
    }
    int temp = arr[min];
    arr[min] = arr[i];
    arr[i] = temp;
  }
}

int main() {
  int arr[5] = {5,4,3,2,1};
  selection(arr, 5);
  print(arr, 5);
  cout << counter << " steps";
}