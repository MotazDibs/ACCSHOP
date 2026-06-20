# AccShop

AccShop is a PHP-based accounting and shop management system built with the CodeIgniter framework.
The project provides basic business management features such as product management, supplier management, order handling, delivery records, admin users, and document import/export features.

## Project Overview

AccShop is designed as an internal web-based management system for small business operations. It helps organize products, suppliers, orders, delivery information, uploaded documents, and imported Excel data.

The system follows the MVC structure used by CodeIgniter:

* Controllers handle page routing and business actions.
* Models handle database operations.
* Views render the user interface.
* Uploaded documents and Excel files can be processed and stored.

## Main Features

* Admin login and logout
* Admin user management
* Products management
* Suppliers management
* Orders management
* Delivery records management
* Product and supplier details pages
* Excel file upload and table generation
* Word/document upload
* Document listing, viewing, editing, downloading, and deletion
* Dynamic database table creation for imported files
* CodeIgniter MVC structure

## Main Pages

### Authentication

* Login page
* Logout action

### Dashboard

* Home page / main control panel

### Admin Management

* Add admin
* View admins
* Edit admin
* Delete admin

### Products

* Add product
* View products
* Edit product
* Delete product
* Product details page

### Suppliers

* Add supplier
* View suppliers
* Edit supplier
* Delete supplier
* Supplier details page
* Supplier-product relation page

### Orders

* Add order
* View orders
* Edit order
* Delete order

### Delivery

* Add delivery record
* View delivery records

### Documents

* Add/upload file
* Add Word document
* List uploaded files
* View file
* Edit file
* Download file
* Delete file

### Excel Import

* Upload Excel file
* Generate database tables from Excel data
* List generated tables
* View imported table data

## Project Structure

```text
accshop/
├── application/
│   ├── config/
│   ├── controllers/
│   ├── models/
│   ├── views/
│   │   └── html/
│   └── third_party/
├── system/
├── upload/
├── uploads/
├── index.php
├── composer.json
├── .htaccess
└── README.md
```

## Technology Stack

* PHP
* CodeIgniter
* MySQL / MariaDB
* HTML
* CSS
* JavaScript
* PHPExcel
* PHPWord-related document handling

## Controllers

The project includes several main controllers:

* `C.php`
  Handles main page loading, products, suppliers, orders, delivery, admins, and file-related pages.

* `Cont.php`
  Handles form submissions, login, insert, update, delete, and logout actions.

* `documents.php`
  Handles document upload, view, edit, update, download, and delete operations.

* `Excel_reader.php`
  Handles Excel file upload and import logic.

* `Welcome.php`
  Default CodeIgniter welcome controller.

## Models

The project includes database models such as:

* `model.php`
  Main database model for products, suppliers, admins, orders, login, and dynamic table creation.

* `Document_model.php`
  Handles uploaded document metadata and dynamic document content tables.

* `ExcelModel.php`
  Handles Excel table creation, row insertion, and uploaded table logging.

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/MotazDibs/accshop.git
```

### 2. Move Project to Local Server

Place the project folder inside your local server directory, for example:

```text
C:\xampp\htdocs\accshop
```

### 3. Configure Database

Open:

```text
application/config/database.php
```

Set your local database settings:

```php
'hostname' => 'localhost',
'username' => 'root',
'password' => '',
'database' => 'acctest',
'dbdriver' => 'mysqli',
```

### 4. Create Database

Create a MySQL database named:

```text
acctest
```

If you have a database dump file, import it into this database.

> Note: The database SQL dump is not included in this repository by default.

### 5. Run the Project

Start Apache and MySQL using XAMPP, then open:

```text
http://localhost/accshop
```

## Important Notes

* Do not upload real production database passwords.
* Do not upload private customer documents.
* The `uploads` and `upload` folders should be kept for runtime files, not for source code storage.
* Make sure folder permissions allow file uploads when deployed.
* Before deployment, update database credentials and environment settings.

## Recommended Git Ignore Rules

The project should ignore cache, logs, uploaded user files, and local environment files:

```gitignore
application/logs/*
!application/logs/index.html

application/cache/*
!application/cache/index.html

uploads/*
!uploads/.gitkeep

upload/*
!upload/.gitkeep

.env
*.log
vendor/
.vscode/
.idea/
```

## License

This project is developed as a business management and accounting system. 
Motaz AldibsAll rights reserved.
