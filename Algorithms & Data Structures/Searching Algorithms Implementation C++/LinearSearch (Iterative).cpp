#include <iostream>
using namespace std;

bool linearI(int arr[], int size, int item) {
    for(int i = 0; i < size; i++) {
        if(arr[i] == item) {
            return true;
        }
    }
    return false;
}

int main() {
  int arr[8] = {5, 1, 8, 2, 7, 4, 3, 6};
}