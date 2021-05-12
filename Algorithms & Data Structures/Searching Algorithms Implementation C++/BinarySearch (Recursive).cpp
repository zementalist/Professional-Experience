#include <iostream>
using namespace std;

bool binaryR(int arr[], int left, int right, int item) {
    if(left <= right) {
        int mid = (right + left) / 2;
        if(item > arr[mid]) {
            return binaryR(arr, mid+1, right, item);
       }
        else if(item == arr[mid]) {
            return true;
        }
        else {
            return binaryR(arr, left, mid-1, item);
        }
    }
    return false;
}

int main() {
  int arr[8] = {5, 1, 8, 2, 7, 4, 3, 6};
}