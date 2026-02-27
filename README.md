
# 🏠 EasyColoc

EasyColoc is a Laravel web application that helps roommates manage shared expenses and automatically calculate balances.

It provides a clear view of **“who owes who”** and simplifies reimbursements.

---

## 🚀 Tech Stack

* **Laravel (MVC Architecture)**
* **PostgreSQL**
* **Eloquent ORM**
* **Laravel Breeze (Authentication)**
* Blade Templates
* **Docker**
* **Docker Compose**
* **Nginx**

---

## 👥 Roles

* **Member** – Add expenses, view balances, mark payments, leave colocation
* **Owner** – Create colocation, invite/remove members, manage categories
* **Global Admin** – View statistics, ban/unban users

> The first registered user is automatically promoted to Global Admin.

---

## 🔑 Main Features

* Authentication & user profile
* Create and manage colocations
* Invitation system (email + unique token)
* One active colocation per user
* Add expenses (amount, date, category, payer)
* Automatic balance calculation
* Settlement view (“who owes who”)
* Mark payments as completed
* Reputation system (+1 / -1 based on behavior)
* Admin dashboard (users, colocations, expenses, bans)
* Monthly expense filter

---

## Diagrams

### Use Case Diagram
![alt text](<Diagrams/usecase Easy coloc v2.drawio.png>)

### Class Diagram
![alt text](<Diagrams/Class Diagram EasyColoc v2.png>)