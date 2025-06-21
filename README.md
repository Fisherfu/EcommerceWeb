# 🛒 EcommerceWeb Database Schema Overview

This document provides an overview of the relational database schema used in the `EcommerceWeb` application. The schema is designed to support key functionalities such as user management, product listings, shopping cart operations, and admin control.

---

## 📐 Entity Relationship Model

The database schema consists of six main entities:

---

### 1. `account`
Represents all users of the platform, including both buyers and sellers.

| Column       | Type    | Description                          |
|--------------|---------|--------------------------------------|
| id           | INT     | Primary Key                          |
| name         | VARCHAR | Username                             |
| password     | VARCHAR | Hashed password                      |
| is_seller    | BOOLEAN | Indicates if user is a seller        |
| is_buyer     | BOOLEAN | Indicates if user is a buyer         |

---

### 2. `profile`
Stores extended information about an account.

| Column      | Type      | Description                          |
|-------------|-----------|--------------------------------------|
| account_id  | INT       | Primary Key, FK to `account(id)`     |
| address     | TEXT      | User's address                       |
| phone       | VARCHAR   | Contact number                       |
| created_at  | DATETIME  | Profile creation time                |

---

### 3. `category`
Classifies products into categories.

| Column | Type    | Description          |
|--------|---------|----------------------|
| id     | INT     | Primary Key          |
| name   | VARCHAR | Category name        |

---

### 4. `product`
Represents products listed for sale on the platform.

| Column      | Type        | Description                        |
|-------------|-------------|------------------------------------|
| id          | INT         | Primary Key                        |
| name        | VARCHAR     | Product name                       |
| category_id | INT         | FK to `category(id)`               |
| price       | DECIMAL     | Product price                      |
| image       | VARCHAR     | Path or URL to product image       |

---

### 5. `cart`
Stores items that users intend to purchase.

| Column      | Type | Description                            |
|-------------|------|----------------------------------------|
| id          | INT  | Primary Key                            |
| account_id  | INT  | FK to `account(id)`                    |
| product_id  | INT  | FK to `product(id)`                    |
| quantity    | INT  | Number of units added to the cart      |

---

### 6. `admin`
Represents administrator accounts for backend management.

| Column    | Type    | Description          |
|-----------|---------|----------------------|
| id        | INT     | Primary Key          |
| username  | VARCHAR | Admin login name     |
| password  | VARCHAR | Admin login password |

---

## 🔁 Relationships

- Each `account` has **one** `profile` (1:1).
- Each `profile` is linked to exactly one `account`.
- Each `product` belongs to one `category` (Many:1).
- Each `cart` entry references one `account` and one `product` (Many:1).
- An `admin` account is independent from the user accounts (`account` table).

---

## 🧩 Use Cases Enabled by Schema

- **User Registration & Login** (via `account` and `profile`)
- **Product Browsing** (via `product` and `category`)
- **Shopping Cart Operations** (via `cart`)
- **Admin Control Panel** (via `admin`)
- **Role-based Access Control** (`is_buyer`, `is_seller`)

---

## 🗂 ER Diagram

> See `docs/er-diagram.png` for a visual representation of the schema.

---

## 📌 Notes

- All passwords should be securely hashed before storing.
- The schema supports flexible user roles — users can be buyers, sellers, or both.
