# ShoeStyle - Online Shoe Store

Welcome to **ShoeStyle**, your premier destination for stylish and comfortable footwear. This repository contains the source code for the ShoeStyle online store, including features like product browsing, cart management, wishlist functionality, and user account management.

---

## **Features**
- **Homepage**: Browse featured products with search and filtering options.
- **Product Catalog**: View detailed product information, including images, descriptions, and prices.
- **Cart Management**: Add, update, and remove items from the shopping cart.
- **Wishlist**: Save products to your wishlist for later purchase.
- **User Accounts**: Register, login, and manage your profile.
- **Admin Panel**: Manage products, categories, and orders.
- **Responsive Design**: Optimized for desktop and mobile devices.

---

## **Folder Structure**
/Applications/XAMPP/xamppfiles/htdocs/shoe-store ├── about.php ├── admin/ │ ├── add_category.php │ ├── add_product.php │ ├── dashboard.php │ ├── delete_category.php │ ├── delete_product.php │ ├── edit_category.php │ ├── edit_product.php │ ├── users.php │ └── ... ├── assets/ │ ├── css/ │ │ ├── style.css │ │ ├── footer.css │ │ ├── header.css │ │ ├── wishlist.css │ │ └── ... │ ├── js/ │ │ ├── main.js │ │ └── script.js │ └── images/ ├── includes/ │ ├── header.php │ ├── footer.php │ ├── config.php │ ├── database.php │ ├── functions.php │ └── ... ├── user/ │ ├── profile.php │ ├── register.php │ ├── wishlist.php │ └── ... ├── products/ │ ├── product.php │ └── ... ├── tests/ │ ├── unit/ │ ├── integration/ │ └── ... ├── index.php ├── faq.php ├── contact.php ├── term.php ├── shoeshopdb.sql └── README.md


---

## **Installation**
1. Steps for Local Setup
   Download the project files to your local machine:
   git clone https://github.com/your-username/shoestyle.git
2. Place the shoe-store folder to /htdocs in XAMPP
3. Start Database server and Application Server in XAMPP.
4. Open phpMyAdmin or any MySQL client.
5. Create a new database (e.g., shoestyle_db).
    -Import the shoeshopdb.sql file located in the project root:
    -In phpMyAdmin, go to the Import tab.
    -Select the shoeshopdb.sql file and click Go.
6. Access the site at:
   http://localhost/shoe-store

## **Usage**
**User Features**
Browse products, add them to the cart, and proceed to checkout.
Save products to your wishlist for later.
Manage your profile and change your password.

**Admin Features**
Add, edit, and delete products and categories.
View and manage user accounts and orders.

**Technologies Used**
Frontend: HTML, CSS, JavaScript
Backend: PHP
Database: MySQL
Libraries: Composer, PHPUnit

**Contact**
For questions or support, please contact:
Email: support@shoestyle.com
Phone: +1 (555) 123-4567
Address: NØRREPORT, COPENHAGEN, DENMARK, 1400


   