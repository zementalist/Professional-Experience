#include <iostream>
#include <cmath>
using namespace std;

void print(int arr[], int size) {
	for (int i = 0; i < size; i++) {
		cout << arr[i] << "\t";
	}
	cout << endl;
}

void merge(int arr[], int l, int r, int mid) {
	int leftSize = (int) ceil( (double) ((r - l + 1) / 2));
	int rightSize = (r - l + 1) / 2;
	int *leftCopy = new int[leftSize];
	int *rightCopy = new int[rightSize];
	int i = l, j = mid + 1;
	for (int a = 0; a < leftSize; a++) {
		leftCopy[a] = arr[i++];
	}
	for (int b = 0; b < rightSize; b++) {
		rightCopy[b] = arr[j++];
	}

	i = l, j = mid + 1;
	int a = 0, b = 0;
	while (a < leftSize && b < leftSize) {
		if (leftCopy[a] < rightCopy[b]) {
			arr[i++] = leftCopy[a++];
		}
		else {
			arr[j++] = rightCopy[b++];
		}
	}

	while (a < leftSize) {
		arr[i++] = leftCopy[a++];
	}

	while (b < rightSize) {

		arr[j++] = rightCopy[b++];
	}


}

void mergeSort(int arr[], int l, int r) {
	if (l < r) {
		int mid = (r + l) / 2;
		mergeSort(arr, l, mid);
		mergeSort(arr, mid + 1, r);
		merge(arr, l, r, mid);
	}
}

int main() {
	int array[5]{ 1,2,3,4,5 };
	mergeSort(array, 0, 4);
	print(array, 5);
}