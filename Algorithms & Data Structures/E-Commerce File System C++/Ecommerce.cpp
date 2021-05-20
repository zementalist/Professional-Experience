#include <iostream>
#include <iomanip>
#include <filesystem>
#include <fstream>
#include <string>
#include <cstring>
#include <vector>
#include <ctype.h>
#include <stdlib.h>

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
string APP_NAME = "ConsoleApplication5";
fstream file;
Product p;
vector<Product> cart;
const int recordSize = 45;
char temp[recordSize];

string getCategoryPath(char categoryTitle[]) {
  string path = "../" + APP_NAME + "/categories/" + (string)categoryTitle + ".txt";
  return path;
}

void createCategory(vector<string> &v) {
  char categoryTitle[15];
  cout << "Enter category title: ";
  cin >> categoryTitle;
  // check if category exists before creation
  fstream ofile(getCategoryPath(categoryTitle));
  if (ofile) {
    cout << "Category already exists";
  }
  else {
    file.open(getCategoryPath(categoryTitle), ios::out);
    if (file.is_open()) {
      cout << "Category created succesffully" << endl;
      v.push_back(categoryTitle);
      file.close();
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
  cout << endl;
  cout << "ID: " << pr.id << "\n";
  cout << "Title: " << pr.title << "\n";
  cout << "Available: " << pr.available << "\n";
  cout << "Cost: " << pr.cost << "$\n";
  cout << endl;
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
  strcpy_s(temp, p.id);
  strcat_s(temp, "|");
  strcat_s(temp, p.title);
  strcat_s(temp, "|");
  strcat_s(temp, p.available);
  strcat_s(temp, "|");
  strcat_s(temp, p.cost);
  strcat_s(temp, "\n");
}

void unpack(string str) {
  // Convert record to Product object (Divide & Conquer)
  strcpy_s(p.id, str.substr(0, str.find("|")).c_str());
  str = str.substr(str.find("|") + 1, str.size());
  strcpy_s(p.title, str.substr(0, str.find("|")).c_str());
  str = str.substr(str.find("|") + 1, str.size());
  strcpy_s(p.available, str.substr(0, str.find("|")).c_str());
  str = str.substr(str.find("|") + 1, str.size());
  strcpy_s(p.cost, str.substr(0, str.find("|")).c_str());
}

vector<Product> listProducts(char categoryTitle[]) {
  // List products in an organized format
  file.open(getCategoryPath(categoryTitle), ios::in);
  vector<Product> products;
  if (file.is_open()) {
    int length = 0;
    string record;
    cout << setw(10) << "ID\t" << setw(10) << "Title\t" << setw(10) << "Available" << setw(10) << "Cost" << endl << endl;
    while (getline(file, record, '\n')) {
      unpack(record);
      products.push_back(p);
      cout << (++length) << "- " << setw(6) << p.id;
      cout << setw(15) << p.title << "\t";
      cout << setw(7) << p.available << "\t";
      cout << setw(11) << p.cost << "$\n";
    }
    file.close();
  }
  else {
    cout << endl << "Operation failed." << endl;
  }
  return products;
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
    listProducts(categoryTitle);
    return;
  }
  cout << endl << "Operation failed." << endl;
}

int searchProduct(char categoryTitle[]) {
  // Search for a product in a category
  // Another fstream object used to solve collisions
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
        int endIndex = (int)file.tellg();
        file.close();
        return endIndex - record.size() - 1;
      }
    }
    // Record not found
    cout << "Record is not found!" << endl;
    file.close();
    return -1;
  }
  cout << "Operation failed." << endl;
  return -1;
}


void modifyProduct(char categoryTitle[]) {
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
    file.close();
    // If record is found & updated, rewrite data to file
    if (found) {
      fstream ofile;
      ofile.open(getCategoryPath(categoryTitle), ios::out | ios::trunc);

      if (ofile.is_open()) {
        // Loop over products vector, write to file
        for (unsigned int j = 0; j < products.size(); j++) {
          p = products.at(j);
          pack();
          ofile << temp;
        }
        cout << "\nProduct is updated successfully." << endl;
        ofile.close();
        listProducts(categoryTitle);

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
    file.close();

    // If a product is found and removed (skipped): rewrite remaining products
    if (found) {
      file.open(getCategoryPath(categoryTitle), ios::out | ios::trunc);
      if (file.is_open()) {
        for (unsigned int j = 0; j < products.size(); j++) {
          p = products.at(j);
          pack();
          file << temp;
        }
        cout << endl << "Product is removed successfully." << endl;
        file.close();
        listProducts(categoryTitle);

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
  cout << endl << "[" << p.title << "]" << " added successfully to your cart." << endl;
  cart.push_back(p);
}

void removeFromCart(char productId[]) {
  // Remove product from customer's cart by productId
  // Loop over cart to find product
  for (unsigned int i = 0; i < cart.size(); i++) {
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
  cout << "Your cart contains: " << endl << endl;
  cout << setw(10) << "ID\t" << setw(10) << "Title\t" << setw(10) << "Available" << setw(10) << "Cost" << endl << endl;
  for (int i = 0; i < (signed int)cart.size(); i++) {
    cout << (i+1) << "- " << setw(6) << cart.at(i).id;
    cout << setw(15) << cart.at(i).title << "\t";
    cout << setw(7) << cart.at(i).available << "\t";
    cout << setw(11) << cart.at(i).cost << "$\n";

  }
}

float getTotalCost() {
  // Get total cost of products in customer's cart
  float total = 0;
  for (unsigned int i = 0; i < cart.size(); i++) {
    total += (float)atof(cart.at(i).cost); // convert cost to float
  }

  return total;
}

void viewCategories(vector<string> v) {
  for (unsigned int i = 0; i < v.size(); i++) {
    cout << (i+1) << "- " << v.at(i) << endl;
  }
}

void viewChoices(bool user_is_admin) {
  if (user_is_admin) {
    cout << endl << "-1) Add a product" << endl;
    cout << "-2) Remove product" << endl;
    cout << "-3) Modify product" << endl;
    cout << "-4) Search for a product" << endl;
    cout << "-5) Back to categories" << endl << endl;
    cout << "0- Exit" << endl << endl;
  }
  else {
    cout << endl << "Choose a product to add it to your cart or" << endl;
    cout << "-1) Search a product" << endl;
    cout << "-2) View my cart" << endl;
    cout << "-3) Remove a product from my cart" << endl;
    cout << "-4) Purchase products in my cart" << endl;
    cout << "-5) Back to categories" << endl;
    cout << endl << "0- Exit" << endl;
  }
}

int main(int argc, char** argv)
{

  // Initialize variables
  vector<string> categories = {};
  string username, password;
  bool user_is_admin;
  int running = 1, choice=-5;
  char currentCategory[15];

  // Collect files into categories vector
  for (auto& p : fs::directory_iterator("../" + APP_NAME + "/categories/")) {
    string filename = p.path().filename().string();
    string category = filename.substr(0, filename.size() - 4);
    categories.push_back(category);
  }

  // Read data for authentication
  cout << "Please login using your username: ";
  cin >> username;
  cout << "Password: ";
  cin >> password;
  cout << "Welcome " << username  << endl << endl;
  user_is_admin = auth(username, password);

  // Start the system: display categories and deal with choices
  cout << "[Categories]" << endl << endl;
  viewCategories(categories);
  cout << endl << "0- Exit" << endl;

  // Outer loop is concerned with categories .. Inner loops are handling products
  // 0 for exit | -5 to skip inner loops and execute outer loop (this one below)
  while (choice != 0 || choice == -5) {

    // If user role is admin
    if (user_is_admin) {
      // Read choice
      cout << "-1) Add category" << endl;
      cout << "-2) Remove category" << endl << endl;
      cout << "Choose an operation: ";
      cin >> choice;

      // choice is between -2-0 : (add | remove) category | exit
      if (choice < 0 && choice >= -2) {
        switch (choice) {
        // case add category
        case -1:
          createCategory(categories);
          cout << endl << endl << "[Categories]" << endl << endl;
          viewCategories(categories);
          break;

        // case remove category
        case -2:
          // read category number
          cout << "Choose category number: ";
          int categoryNumber;
          cin >> categoryNumber;

          // convert string to char array
          char categoryTitle[15];
          strcpy_s(categoryTitle, categories.at(categoryNumber - 1).c_str());

          // remove category
          removeCategory(categoryTitle);
          categories.erase(categories.begin() + (categoryNumber - 1));

          // View categories after deletion
          cout << endl;
          viewCategories(categories);
          break;
        }
      }

      // else if choice is between 1 - N of categories: (add | remove | search | modify) product | back to categories |exit
      else if(choice > 0 && choice <= (signed int)categories.size()) {

        // store current category, initialize products of category and their length
        strcpy_s(currentCategory, categories.at(choice - 1).c_str());
        vector<Product> products = listProducts(currentCategory);
        int sizeOfProducts = products.size();

        // set choice to negative number to enter the loop and its condition (will not affect user choice)
        choice = -1;

        // loop is running while the choice is not to go to outer loop (Categories things)
        while (choice != -5) {

          // Products are numbered (positive), so all our operations are numbered < 0
          if (choice < 0) {
            // Read choice
            viewChoices(user_is_admin);
            cout << "Choose an operation: ";
            cin >> choice;

            switch (choice) {
            case 0:
              return 0;
            case -1:
              writeProduct(currentCategory);
              break;
            case -2:
              removeProduct(currentCategory);
              break;
            case -3:
              modifyProduct(currentCategory);
              break;
            case -4:
              searchProduct(currentCategory);
              break;

            // case user wants to return back to categories (outer loop)
            case -5:
              cout << endl << endl << endl;
              break;
            default:
              break;
            }
          }

          // else - User's choice is a positive number
          else {
            // set choice to negative to re-enter the loop and read another choice
            choice = -1;
          }
        }
      }

    }

    // else - User
    else {

      // read choice
      cout << endl << "Choose an operation: ";
      cin >> choice;

      // if choice is between 0 - N of categories : set current category & display products
      if (choice > 0 && choice <= (signed int)categories.size()) {
        strcpy_s(currentCategory, categories.at(choice - 1).c_str());
      }
      vector<Product> products = listProducts(currentCategory);
      int sizeOfProducts = products.size();

      // Read choice to do something to products
      viewChoices(user_is_admin);
      cout << endl << "Choose an operation: ";
      cin >> choice;

      // 0 is to exit the loop
      while (choice != 0) {

        // choice is between -5 .. products.size  (except 0)
        // choice(-1 .. -5) : searchProduct | viewCart | removeFromCart | purchase | back to categories
        // choice(1 .. N of products) : buy the product
        if (choice >= -5 && choice <= ((signed int)products.size())) {

          // positive choice : buy product
          if (choice > 0) {
            addToCart(products.at(choice - 1));
          }

          // negative choice
          else {

            switch (choice) {
            case 0: // seems to be redundant
              return 0;
              break;
            case -1:
              searchProduct(currentCategory);
              break;
            case -2:
              viewCart();
              break;

            // Remove product from cart
            case -3:
              // view cart & read product id to delete
              char prodID[5];
              viewCart();
              cout << endl << "Enter product ID to remove from your cart: ";
              cin >> setw(5) >> prodID;

              // delete product by id then view cart
              removeFromCart(prodID);
              viewCart();
              break;

            // Purchase products in cart
            case -4:
              cout << "Purchased. total cost = " << getTotalCost() << "$" << endl;
              purchase();
              break;

            // Back to categories
            case -5:
              //clear current_category and products
              strcpy_s(currentCategory, "");
              products.clear();
              cout << endl << endl << endl;
              break;
            }

            // if choice is to back to categories : break the loop
            if (choice == -5) {
              break;
            }
          }
        }

        // in case choice is out of specified range
        else {
          cout << endl << "Choose an operation: ";
          cin >> choice;
        }

        // After each operation, re-read a choice for next operation
        viewChoices(user_is_admin);
        cout << endl << "Choose an operation: ";
        cin >> choice;
      }
    }

    // Inner loops are stopped, outer loop (categories) executes
    cout << "[Categories]" << endl << endl;
    viewCategories(categories);
    cout << endl << "0- Exit" << endl;
    
  }

  //Functions:

  //1- Category
  //createCategory(char category[])
  //removeCategory(char category[])
  //viewCategories(vector<string>)

  //2- Product
  //listProducts(char category[]);
  //writeProduct(char category[]); // succesffuly msg
  //modifyProduct(category); // validate user input
  //searchProduct(char category[]);
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
  //viewChoices(bool isAdmin)
}


