#include <iostream>
using namespace std;

void print(int arr[], int size) {
  for(int i = 0; i < size; i++) {
    cout << arr[i] << endl;
  }
}
int counter = 0;
void bubble(int arr[], int size) {
  for(int i = 0; i < size-1; i++) {
    for(int j = i+1; j < size; j++) {
      //counter++;
      if(arr[i] > arr[j]) {
        int temp = arr[i];
        arr[i] = arr[j];
        arr[j] = temp;
      }
    }
  }
}


int main() {
  int arr[5] = {5,4,3,2,1};
  bubble(arr, 5);
  print(arr, 5);
  cout << counter << " steps";
}