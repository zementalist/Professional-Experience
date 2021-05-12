#include <iostream>
using namespace std;

bool linearR(int arr[], int item, int l, int r) {
    if(l <= r) {
        if(arr[l] == item) {
            return true;
        }
        else if(arr[r] == item) {
            return true;
        }
        else {
            return linearR(arr, item, l+1, r-1);
        }
    }
    return false;
}

int main() {
  int arr[8] = {5, 1, 8, 2, 7, 4, 3, 6};
}