#include <iostream>
#include <cmath>
using namespace std;

void swap(int *x, int *y) {
  int z = *x;
  x = y;
  y = &z;
}

int partition(int *arr, int start, int end) {
  int pivot = arr[end];
  int partitionIndex = start;
  for(int i = start; i < end; i++) {
    if(arr[i] <= pivot) {
      swap(arr[i], arr[partitionIndex]);
      partitionIndex++;
    }
  }
  swap(arr[partitionIndex], arr[end]);
  return partitionIndex;
}

void quickSort(int *arr, int start, int end) {
  if(start < end) {
    int partitionIndex = partition(arr, start, end);
    quickSort(arr, start, partitionIndex-1);
    quickSort(arr, partitionIndex+1, end);
  }
}

void print(int arr[], int size) {
  for(int i = 0; i < size; i++) {
    cout << arr[i] << "   ";
  }
}

int main() {
  int arr[8] {5, 3, 1, 2, 8, 4, 7, 6};
  
  quickSort(arr, 0, 7);
  print(arr, 8);
}