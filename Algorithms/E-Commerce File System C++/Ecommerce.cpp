#include <iostream>
#include <iomanip>
#include <filesystem>
#include <fstream>
#include <string>
#include <cstring>
#include <vector>

namespace fs = std::experimental::filesystem;
using namespace std;

class Product {
public:
	char id[5];
	char title[15];
	char available[5];
	char cost[10];
	int idSize, titleSize, availSize, costSize;
	Product() {
		idSize = 5, titleSize = 15, availSize = 5, costSize = 10;
	}
};

fstream file;
Product p;
vector<Product> cart;
const int recordSize = 45;
char temp[recordSize];

string getCategoryPath(char categoryTitle[]) {
	string path = "../ConsoleApplication5/categories/" + (string)categoryTitle + ".txt";
	return path;
}

void createCategory(char categoryTitle[]) {

	// check if category exists before creation
	fstream ofile(getCategoryPath(categoryTitle));
	if (ofile) {
		cout << "Category already exists";
	}
	else {
		file.open(getCategoryPath(categoryTitle), ios::out);
		if (file.is_open()) {
			cout << "Category created succesffully" << endl;
		}
		else {
			cout << "Category couldn't be created!" << endl;
		}
	}
}

void removeCategory(char categoryTitle[]) {

	// Check if category exists;
	if (remove(getCategoryPath(categoryTitle).c_str()) != 0) {
		cout << "Operation failed!" << endl;
	}
	else {
		cout << "Category removed successfully." << endl;
	}
}

void viewProduct(Product pr) {
	cout << "ID: " << pr.id << "\n";
	cout << "Title: " << pr.title << "\n";
	cout << "Available: " << pr.available << "\n";
	cout << "Cost: " << pr.cost << "$\n";
}

void readProduct() {
	// Read data from usem
	cout << "Product ID: ";
	cin >> setw(p.idSize) >> p.id;
	cout << "Product title: ";
	cin >> setw(p.titleSize) >> p.title;
	cout << "Number of available items: ";
	cin >> setw(p.availSize) >> p.available;
	cout << "Product cost: ";
	cin >> setw(p.costSize) >> p.cost;
}

void pack() {
	// Convert product to record
	strcpy(temp, p.id);
	strcat(temp, "|");
	strcat(temp, p.title);
	strcat(temp, "|");
	strcat(temp, p.available);
	strcat(temp, "|");
	strcat(temp, p.cost);
	strcat(temp, "\n");
}

void writeProduct(char categoryTitle[]) {
	// Write record to category	
	file.open(getCategoryPath(categoryTitle), ios::out | ios::app);
	if (file.is_open()) {
		readProduct();
		pack();
		file << temp;
		file.close();
		cout << endl << "Product is added successfully." << endl;
		return;
	}
	cout << endl << "Operation failed." << endl;
}

void unpack(string str) {
	// Convert record to Product object (Divide & Conquer)
	strcpy(p.id, str.substr(0, str.find("|")).c_str());
	str = str.substr(str.find("|") + 1, str.size());
	strcpy(p.title, str.substr(0, str.find("|")).c_str());
	str = str.substr(str.find("|") + 1, str.size());
	strcpy(p.available, str.substr(0, str.find("|")).c_str());
	str = str.substr(str.find("|") + 1, str.size());
	strcpy(p.cost, str.substr(0, str.find("|")).c_str());
}

int search(char categoryTitle[]) {
	// Search for a product in a category
	file.open(getCategoryPath(categoryTitle), ios::in);

	if (file.is_open()) {
		// Read id
		cout << "Enter product ID: ";
		string record, input_id;
		cin >> input_id;
		// Loop over records
		while (getline(file, record, '\n')) {
			unpack(record);
			// Compare IDs
			if (input_id.compare(p.id) == 0) {
				viewProduct(p);
				int endIndex = file.tellg();
				return endIndex - record.size() - 1;
			}
		}
		// Record not found
		cout << "Record is not found!" << endl;
		file.close();
		return -1;
	}

}

void listProducts(char categoryTitle[]) {
	// List products in an organized format
	file.open(getCategoryPath(categoryTitle), ios::in);
	if (file.is_open()) {
		string record;
		cout << setw(p.idSize) << "ID\t" << setw(p.titleSize / 2) << "Title\t" << setw(p.availSize) << "Available\t" << setw(p.costSize) << "Cost" << endl << endl;
		while (getline(file, record, '\n')) {
			unpack(record);
			cout << setw(p.idSize) << p.id;
			cout << setw(p.titleSize / 2) << p.title << "\t";
			cout << setw(p.availSize) << p.available << "\t\t";
			cout << setw(p.costSize) << p.cost << "$\n";
		}
	}
	else {
		cout << endl << "Operation failed." << endl;
	}
}


void modify(char categoryTitle[]) {
	// Update a specific record
	file.open(getCategoryPath(categoryTitle), ios::in);
	if (file.is_open()) {
		// Initialize data
		vector<Product> products;
		string input_id, record = "";
		bool found = false;
		// Read input id
		cout << "Enter product ID to update: ";
		cin >> input_id;
		cout << endl;
		// Loop over records
		while (getline(file, record, '\n')) {
			unpack(record);
			// Compare IDs, update if this is the one, push to products
			if (input_id.compare(p.id) == 0) {
				found = true;
				viewProduct(p);
				cout << "\nEnter new product's data\n\n";
				readProduct();
			}
			products.push_back(p);
		}
		// If record is found & updated, rewrite data to file
		if (found) {
			fstream ofile;
			ofile.open(getCategoryPath(categoryTitle), ios::out | ios::trunc);

			if (ofile.is_open()) {
				// Loop over products vector, write to file
				for (int j = 0; j < products.size(); j++) {
					p = products.at(j);
					pack();
					ofile << temp;
				}
				cout << "\nProduct is updated successfully." << endl;
				ofile.close();
			}

			// Ofile didn't open
			else {
				cout << endl << "Operation failed!" << endl;
			}
		}

		// Product is not found
		else {
			cout << endl << "Product is not found!" << endl;
		}
	}

	// File didn't open
	else {
		cout << endl << "Operation failed!" << endl;
	}

	file.close();
}
void removeProduct(char categoryTitle[]) {
	// Remove product from a specific category
	file.open(getCategoryPath(categoryTitle), ios::in);

	if (file.is_open()) {
		// Initialize variables
		vector<Product> products;
		string cid, record = "";
		bool found = false;

		// Read input id
		cout << "Enter product ID: ";
		cin >> cid;

		// Loop over records
		while (getline(file, record, '\n')) {
			unpack(record);
			// When IDs match, skip storing the product
			if (cid.compare(p.id) == 0) {
				found = true;
				continue;
			}
			products.push_back(p);
		}

		// If a product is found and removed (skipped): rewrite remaining products
		if (found) {
			fstream ofile;
			ofile.open(categoryTitle, ios::out | ios::trunc);
			if (ofile.is_open()) {
				for (int j = 0; j < products.size(); j++) {
					p = products.at(j);
					pack();
					ofile << temp;
				}
				ofile.close();
			}
		}
		// Product is not found
		else {
			cout << "Product is not found!" << endl;
		}

	}
	// File not open
	else {
		cout << "Operation failed!" << endl;
	}
}


bool auth(string username, string password) {
	// Function to authenticate user -> admin=1 | user=0
	// check pass
	if (password.compare("123") == 0) {
		return 1;
	}
	return 0;
}

void addToCart(Product p) {
	cart.push_back(p);
}


void removeFromCart(char productId[]) {
	// Remove product from customer's cart by productId
	// Loop over cart to find product
	for (int i = 0; i < cart.size(); i++) {
		// If found, remove it .. yes, just that simple!
		if (strcmp(productId, cart.at(i).id) == 0) {
			cart.erase(cart.begin() + i);
			cout << endl << "Product removed from cart." << endl;
			return;
		}
	}
	// If product is not found, line below is executed
	cout << "Product isn't in your cart" << endl;
}

void purchase() {
	cart.clear();
}

void viewCart() {
	// Display products in customer's cart
	for (int i = 0; i < cart.size(); i++) {
		cout << endl << setw(p.idSize) << "ID\t" << setw(p.titleSize / 2) << "Title\t" << setw(p.availSize) << "Available\t" << setw(p.costSize) << "Cost" << endl << endl;
		cout << setw(p.idSize) << cart.at(i).id;
		cout << setw(p.titleSize / 2) << cart.at(i).title << "\t";
		cout << setw(p.availSize) << cart.at(i).available << "\t\t";
		cout << setw(p.costSize) << cart.at(i).cost << "\n";
	}
}

float getTotalCost() {
	// Get total cost of products in customer's cart
	float total = 0;
	for (int i = 0; i < cart.size(); i++) {
		total += atof(cart.at(i).cost); // convert cost to float
	}
	return total;
}


int main(int argc, char** argv)
{
	//Functions:

	//1- Category
	//createCategory(char category[])
	//removeCategory(char category[])

	//2- Product
	//listProducts(char category[]);
	//writeProduct(char category[]); // succesffuly msg
	//modify(category); // validate user input
	//search(char category[]);
	//removeProduct(char category[]); // stop printing all         records
	//removeCategory(char category[]);

	//3- Cart
	//addToCart(Product);
	//viewCart();
	//removeFromCart(char id[]);
	//getTotalCost()
	//purchase();

	//4- User
	//auth(string username, string password)


	// Main scenario :
	//

	// Skip this for now
	//int nOfCategories = 0;
	//for (auto& p : fs::directory_iterator("../ConsoleApplication5/categories/")) {
	//	//std::cout << p.path().filename() << '\n';
	//	nOfCategories++;
	//}

}