# Invoice & Budget Management System

A Laravel-based Invoice & Budget Management System developed as a web
application for managing customers, suppliers, products/services,
purchase invoices, sales invoices, budgets, expenses, payments, and
financial reports.

## Project Overview

The application provides an admin dashboard for managing day-to-day
invoice and budget operations. It uses Laravel's MVC architecture, Blade
templates, Bootstrap, MySQL, and a public currency exchange-rate API.

### Main Features

-   Admin login and authentication
-   Protected dashboard
-   Financial summary dashboard
-   Customer management
-   Supplier management
-   Product / service management
-   Sales invoice management
-   Purchase invoice management
-   Invoice item management
-   Automatic subtotal, discount, tax, and total calculations
-   Budget management
-   Expense tracking against budgets
-   Payment tracking
-   Payment status management
-   Reports and analytics
-   Currency exchange-rate API integration
-   Responsive Bootstrap UI

## Authentication

The application uses Laravel authentication to protect the admin
dashboard and management pages.

Unauthenticated users cannot access the dashboard directly.

### Login Flow

``` text
/dashboard
    ↓
Authentication Check
    ↓
/login
    ↓
Successful Login
    ↓
/dashboard
```

For example, when an unauthenticated user visits:

``` text
http://127.0.0.1:8000/dashboard
```

the application redirects the user to:

``` text
http://127.0.0.1:8000/login
```

After successful authentication, the user is redirected to the
dashboard.

### Protected Sections

-   Dashboard
-   Customers
-   Suppliers
-   Products / Services
-   Sales Invoices
-   Purchase Invoices
-   Budgets
-   Expenses
-   Payments
-   Reports

The login page is available at:

``` text
/login
```

For security reasons, actual login passwords are not stored in this
README.

## Technology Stack

-   **Framework:** Laravel 13
-   **Language:** PHP 8.3+
-   **Database:** MySQL
-   **Frontend:** Blade, HTML5, CSS3, JavaScript
-   **CSS Framework:** Bootstrap 5
-   **Build Tool:** Vite
-   **API:** Frankfurter Exchange Rates API
-   **Architecture:** MVC
-   **Authentication:** Laravel Authentication
-   **Version Control:** Git / GitHub

## Application Modules

### Dashboard

The dashboard provides an overview of the application's financial
information, including relevant invoice, budget, expense, payment, and
reporting data.

### Customers

Manage customer information including:

-   Name
-   Email
-   Phone
-   Address
-   City
-   State

### Suppliers

Manage supplier information including:

-   Name
-   Email
-   Phone
-   Address
-   City
-   State

### Products / Services

Manage products and services with:

-   Name
-   Type
-   Description
-   Price
-   Tax rate

### Sales Invoices

Create and manage sales invoices with:

-   Customer
-   Invoice number
-   Invoice date
-   Due date
-   Products/services
-   Quantity
-   Unit price
-   Discount
-   Tax rate
-   Notes
-   Payment status

Supported statuses:

-   Pending
-   Paid
-   Overdue

### Purchase Invoices

Manage supplier purchase invoices using similar invoice and calculation
functionality.

### Budgets

Manage monthly and yearly budgets with:

-   Budget name
-   Budget type
-   Amount
-   Start date
-   End date

### Expenses

Track expenses against budgets using:

-   Expense description
-   Category
-   Amount
-   Expense date
-   Budget

### Payments

Track invoice payments including payment amount, payment date, payment
method, and related invoice information.

### Reports

The application provides reports and analytics for financial information
managed through the system.

## Invoice Calculation

Invoice calculations are handled on the server side to ensure that the
final stored values are reliable.

The calculation follows this structure:

``` text
Item Subtotal = Quantity × Unit Price

Taxable Amount = Item Subtotal − Discount

Tax = Taxable Amount × Tax Rate / 100

Item Total = Taxable Amount + Tax

Invoice Subtotal = Sum of Item Subtotals

Invoice Discount = Sum of Discounts

Invoice Tax = Sum of Item Taxes

Grand Total = Invoice Subtotal − Invoice Discount + Invoice Tax
```

The application also provides live calculation feedback in the invoice
form using JavaScript, while the final calculation is performed on the
backend.

## Database Structure

The application uses MySQL with Laravel migrations.

Main database entities include:

-   Users
-   Customers
-   Suppliers
-   Products / Services
-   Sales Invoices
-   Sales Invoice Items
-   Purchase Invoices
-   Purchase Invoice Items
-   Budgets
-   Expenses
-   Payments

The relationships between invoices and invoice items allow multiple
products/services to be associated with a single invoice.

## API Integration

The application integrates the **Frankfurter Exchange Rates API** to
retrieve public currency exchange-rate data.

Example endpoint:

``` text
https://api.frankfurter.dev/v2/rates?base=USD&quotes=INR,EUR,GBP
```

The exchange-rate information is displayed within the application UI.

The API does not require an API key for the implemented public endpoint.

## Project Structure

``` text
invoice-management/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   ├── Models/
│   └── Services/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   └── views/
├── routes/
│   ├── web.php
│   └── console.php
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
└── README.md
```

## Requirements

Before installing the project, make sure the following are available:

-   PHP 8.3 or later
-   Composer
-   MySQL
-   Node.js and npm
-   XAMPP, WAMP, or another PHP/MySQL development environment

## Installation

### 1. Clone the repository

``` bash
git clone https://github.com/Davidmathi-dev/invoice-management.git
cd invoice-management
```

### 2. Install PHP dependencies

``` bash
composer install
```

### 3. Install frontend dependencies

``` bash
npm install
```

### 4. Create the environment file

Copy `.env.example` to `.env`.

On Windows PowerShell:

``` powershell
copy .env.example .env
```

On macOS/Linux:

``` bash
cp .env.example .env
```

### 5. Configure the database

Create a MySQL database, for example:

``` text
invoice_management
```

Update the database configuration in `.env`:

``` env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invoice_management
DB_USERNAME=root
DB_PASSWORD=
```

Use the appropriate username and password for your local MySQL
installation.

### 6. Generate the application key

``` bash
php artisan key:generate
```

### 7. Run migrations

``` bash
php artisan migrate
```

If seeders are available and required for the local setup:

``` bash
php artisan db:seed
```

### 8. Clear cached configuration

``` bash
php artisan optimize:clear
```

### 9. Start the Laravel development server

``` bash
php artisan serve
```

The application will normally be available at:

``` text
http://127.0.0.1:8000
```

### 10. Start the frontend development server

In a separate terminal:

``` bash
npm run dev
```

## Local Login

Open:

``` text
http://127.0.0.1:8000/login
```

Use the admin credentials provided separately for the assessment/demo
environment.

Do not commit real passwords or sensitive credentials to GitHub.

## Testing Authentication

To verify that protected routes are working:

1.  Open a private/incognito browser window.
2.  Visit:

``` text
http://127.0.0.1:8000/dashboard
```

3.  Without logging in, the application should redirect to:

``` text
http://127.0.0.1:8000/login
```

4.  Log in with the provided admin credentials.
5.  After successful authentication, the application should redirect to
    the dashboard.

## Security

The project follows common Laravel security practices, including:

-   Authentication middleware for protected routes
-   Session regeneration after successful login
-   Session invalidation during logout
-   CSRF protection for web forms
-   Server-side request validation
-   Password hashing through Laravel authentication
-   Environment variables for application/database configuration
-   `.env` excluded from Git using `.gitignore`

## GitHub Repository

Repository:

https://github.com/Davidmathi-dev/invoice-management

## Important Git Files

The repository intentionally excludes environment-specific and generated
dependencies such as:

``` text
.env
/vendor
/node_modules
/public/build
```

These files/directories can be recreated by following the installation
instructions above.

## Development Notes

The project follows Laravel's MVC structure:

-   **Models** handle database relationships and data access.
-   **Controllers** handle HTTP requests and application flow.
-   **Blade Views** provide the user interface.
-   **Services** contain reusable application logic such as invoice
    calculations.
-   **Migrations** define the database structure.

## Author

**David Mathiyazhagan**

BCA Graduate \| Web Developer

Skills used in this project include PHP, Laravel, MySQL, Bootstrap,
Blade, JavaScript, REST API integration, CRUD operations, MVC
architecture, database management, and responsive web development.
