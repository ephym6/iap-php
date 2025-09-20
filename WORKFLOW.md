
# WORKFLOW.md

## 1️⃣ Overview

This project is a **simple user registration system** built in **PHP**.  
It lets visitors register with their **name** and **email**, stores the record in a MySQL database, and sends a **customized welcome email** via PHPMailer.

Core components:

| Component                          | Purpose |
|------------------------------------|----------|
| `config/`                          | Configuration files (DB, mail, etc.) |
| `config/db_conn.php`               | Creates the MySQL connection (`$conn`) |
| `ClassAutoLoad.php`                | Autoloads classes & returns DB connection |
| `Global/Mail.php`                  | Handles email sending & user registration |
| `Global/Register.php`              | Handles form rendering + submission |
| `index.php`                        | Entry point — instantiates classes & renders page |
| `users` table in `mysql` directory | Stores registered users |

---

## 2️⃣ Workflow: Request Lifecycle

### 2.1 User opens `index.php`

1. `index.php` includes `ClassAutoLoad.php`.  
   - Loads configs.
   - Establishes one **MySQL connection** (`$conn`).
   - Registers the autoloader for classes.

2. `index.php` instantiates required classes:
   - `Layouts`, `Forms`, etc.
   - `Mail($conn)` → PHPMailer + DB access.
   - `Register($conn)` → wraps registration logic & uses `Mail`.

3. The layout header is printed.

4. `Register::handleForm()` runs:
   - If the request is **POST** → process form.
   - If not → do nothing.

5. `Register::renderForm()` always runs (shows the registration form).

6. Layout footer is printed.

---

### 2.2 User submits the form

1. Browser posts `name` & `email` → `Register::handleForm()`.

2. `Register` validates:
   - Both fields must be present.

3. Calls `Mail::registerUser($name, $email)`:
   - **Step 1:** Validate email syntax with `FILTER_VALIDATE_EMAIL`.
   - **Step 2:** Query `users` table to ensure email isn’t already registered.
   - **Step 3:** Insert new row (`name`, `email`, `created_at`) if unique.
   - **Step 4:** Use PHPMailer to send a personalized welcome message.

4. Displays result (success, duplicate, invalid email, etc.).

---

### 2.3 Display registered users (optional)

Somewhere in your code (e.g., `index.php` or another page):

```php
$result = $conn->query("SELECT id, name, email, created_at FROM users ORDER BY created_at ASC");
while ($row = $result->fetch_assoc()) {
    echo "{$row['id']} - {$row['name']} - {$row['email']} - {$row['created_at']}<br>";
}
```

---

## 3️⃣ Database

**Table:** `users`

| Column     | Type         | Attributes |
|------------|--------------|-------------|
| `id`       | INT(11)      | PRIMARY KEY, AUTO_INCREMENT |
| `name`     | VARCHAR(100) | NOT NULL |
| `email`    | VARCHAR(150) | UNIQUE, NOT NULL |
| `created_at` | TIMESTAMP  | DEFAULT CURRENT_TIMESTAMP |

---

## 4️⃣ Email Sending (PHPMailer)

- Config in `config/mail_config.php`:
  - Host, Port, Username, Password, Security (`ENCRYPTION_SMTPS`).
- `Mail` class:
  - Injects `$conn`.
  - Configures PHPMailer.
  - Uses `addAddress()` → dynamic recipient name/email.
  - Sends a **HTML email** + plain-text alternative.
  - If DB insert succeeds but email fails → user is still saved.

---

## 5️⃣ Project Flow Summary

1. **User visits `index.php`**
    - The process begins when the user accesses the `index.php` file.

2. **Configurations and Database Connection**
    - The application loads configuration files  through `ClassAutoLoad.php` and establishes a connection to the database in `config/db_connect.php`.

3. **Class Loading & Header Display**
    - Core classes are loaded.
    - The header section of the page is rendered.

4. **Form Check**
    - If **no form is submitted**, the registration form is displayed.
    - If the form **is submitted**, the `handleForm()` function in `forms/register.php`is executed:
        - Validates user input.
        - Checks the email format and verifies there are no duplicate emails.
        - Saves the user information in the database.
        - Sends a personalized welcome email.

5. **Registered Users List**
    - In `tables/list_users.php`, the list of registered users is fetched from the database and displayed.

6. **Footer Display**
    - The footer section of the page is rendered.

---
