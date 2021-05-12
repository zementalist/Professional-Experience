#include <iostream>
using namespace std;

bool binaryI(int arr[], int size, int item) {
    int left = 0;
    int right = size - 1;
    bool found = 0;
    while(left <= right && !found) {
        int mid = (left + right) / 2;
        if(item > arr[mid]) {
            left = mid + 1;
        }
        else if(item == arr[mid]) {
            found = true;
        }
        else {
            right = mid - 1;
        }
    }
    return found;
}
  
int main() {
  int arr[8] = {5, 1, 8, 2, 7, 4, 3, 6};
}