# Invoice & Budget Management System

A Laravel-based Invoice & Budget Management System developed as a
PHP/Laravel Developer interview assessment.

The application provides an admin interface for managing customers,
suppliers, products/services, sales invoices, purchase invoices,
budgets, expenses, payments, financial summaries, reports, and currency
exchange-rate information.

## Features

### Dashboard

-   Financial summary
-   Sales and purchase information
-   Budget and expense overview
-   Payment and invoice status information

### Customer Management

-   Create customers
-   View customer details
-   Edit customers
-   Delete customers

### Supplier Management

-   Create suppliers
-   View supplier details
-   Edit suppliers
-   Delete suppliers

### Product / Service Management

-   Create products/services
-   Set price and tax rate
-   Edit product/service information
-   Delete products/services

### Sales Invoice Management

-   Create sales invoices
-   Select customers
-   Add multiple invoice items
-   Set quantity and unit price
-   Apply discounts
-   Apply tax rates
-   Calculate subtotal, discount, tax, and grand total
-   Edit and delete invoices
-   View invoice details
-   Track payment status:
    -   Pending
    -   Paid
    -   Overdue

### Purchase Invoice Management

-   Create purchase invoices
-   Select suppliers
-   Add multiple invoice items
-   Apply discounts and taxes
-   Calculate invoice totals
-   Edit and delete purchase invoices
-   View purchase invoice details

### Budget Management

-   Create monthly/yearly budgets
-   Define budget amounts and periods
-   Track expenses against budgets
-   View budget information

### Expense Management

-   Record expenses
-   Associate expenses with budgets
-   Track expense amount, date, description, and category

### Payment Management

-   Record invoice payments
-   Track payment amount and date
-   Store payment method
-   Associate payments with sales invoices

### Reports & Financial Tracking

-   Invoice summaries
-   Sales and purchase information
-   Budget and expense tracking
-   Payment status tracking
-   Financial summary information

## API Integration

The project integrates the **Frankfurter Exchange Rate API** to retrieve
currency exchange-rate information.

API endpoint used:

`https://api.frankfurter.dev/v2/rates`

The API data is retrieved from the Laravel backend and displayed in the
designated application UI.

Example API request:

`https://api.frankfurter.dev/v2/rates?base=USD&quotes=EUR`

## Technology Stack

-   PHP 8.3+
-   Laravel 13
-   MySQL
-   Blade Templates
-   Bootstrap 5
-   JavaScript
-   Vite
-   Frankfurter Exchange Rate API

## Project Architecture

The application follows Laravel MVC architecture.

``` text
app/
├── Http/
│   └── Controllers/
├── Models/
└── Services/

database/
├── migrations/
└── seeders/

resources/
└── views/
    ├── customers/
    ├── suppliers/
    ├── products/
    ├── sales-invoices/
    ├── purchase-invoices/
    ├── budgets/
    ├── expenses/
    └── payments/

routes/
└── web.php
```

## Database

The application uses a relational MySQL database with entities for:

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

Foreign-key relationships are used between related entities to maintain
relational data integrity.

## Invoice Calculation

Invoice totals are calculated using the invoice item information.

The calculation includes:

``` text
Item Subtotal = Quantity × Unit Price

Taxable Amount = Item Subtotal - Discount

Tax = Taxable Amount × Tax Rate / 100

Item Total = Taxable Amount + Tax

Grand Total = Subtotal - Total Discount + Total Tax
```

The final invoice totals are calculated on the backend before saving the
invoice.

## Requirements

Before running the project, make sure the following are installed:

-   PHP 8.3 or later
-   Composer
-   MySQL
-   Node.js and npm
-   XAMPP / WAMP or another PHP development environment

## Installation

### 1. Clone the repository

``` bash
git clone YOUR_GITHUB_REPOSITORY_URL
cd invoice-management-system
```

Replace `YOUR_GITHUB_REPOSITORY_URL` with the GitHub repository URL.

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

On Windows:

``` bash
copy .env.example .env
```

Or create the `.env` file manually.

### 5. Configure the database

Create a MySQL database, for example:

``` text
invoice_management
```

Then configure the database section in `.env`:

``` env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invoice_management
DB_USERNAME=root
DB_PASSWORD=
```

Update the username and password according to your local MySQL
configuration.

### 6. Generate the application key

``` bash
php artisan key:generate
```

### 7. Run database migrations

``` bash
php artisan migrate
```

If the project contains seeders:

``` bash
php artisan db:seed
```

### 8. Start the Laravel application

``` bash
php artisan serve
```

The application will normally be available at:

``` text
http://127.0.0.1:8000
```

### 9. Start Vite

In a separate terminal:

``` bash
npm run dev
```

## Configuration Notes

Do not commit the `.env` file to GitHub.

The `.env` file may contain local database credentials and other
environment-specific configuration.

Use `.env.example` as the configuration template.

## Testing

Before submission, verify the following:

-   Customer CRUD
-   Supplier CRUD
-   Product CRUD
-   Sales invoice creation
-   Sales invoice editing
-   Sales invoice deletion
-   Purchase invoice creation
-   Purchase invoice editing
-   Purchase invoice deletion
-   Multiple invoice items
-   Tax calculation
-   Discount calculation
-   Invoice total calculation
-   Payment creation
-   Payment status
-   Budget creation
-   Expense creation
-   Expense vs. budget tracking
-   Dashboard information
-   Reports
-   API response and API error handling
-   Responsive UI

## API Error Handling

If the external exchange-rate API is unavailable, the application
displays an appropriate API-unavailable message instead of exposing an
application error.

## Security

-   Environment-specific configuration is stored in `.env`
-   `.env` should not be committed to the repository
-   Laravel validation is used for form input
-   Database relationships use foreign keys
-   Database operations involving related invoice data use transactions
    where appropriate

## GitHub Submission

The final repository should contain the Laravel source code and this
README file.

Do not commit:

``` text
.env
/vendor
/node_modules
```

The repository should include:

``` text
.env.example
composer.json
composer.lock
package.json
README.md
app/
bootstrap/
config/
database/
public/
resources/
routes/
```

## Project Status

Completed and tested as part of the PHP/Laravel Developer interview
assessment.

## Author

**David Mathiyazhagan**

PHP / Laravel Developer
