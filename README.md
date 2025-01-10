### Calcat - Simple Accounting Web App for Companies

#### **Table of Contents**  
1. [Project Overview](#project-overview)  
   - [Admin Panel](#admin-panel)  
   - [Owner Panel Features](#owner-panel-features)  
     - [Dashboard (Home Page)](#dashboard-home-page)  
     - [Employees Page](#employees-page)  
     - [Clients Page](#clients-page)  
     - [Transactions Page](#transactions-page)  
     - [Resources Page](#resources-page)  
     - [Units Page](#units-page)  
     - [Contractors Page](#contractors-page)  
     - [Reports Page](#reports-page)  
     - [Balance Page](#balance-page)  
     - [Multilingual Support](#multilingual-support)  
     - [Profile Page](#profile-page)  
2. [Installation](#installation)  

---

### **Project Overview**  

**Calcat** is a Laravel-based web application designed to help companies manage their operations with ease. While it is marketed as an accounting app, it primarily focuses on managing company-related data and transactions without full-fledged accounting functionalities. Below are the key features and functionalities available in Calcat.  

---

#### **Admin Panel**  
Admin panel for The Web Application Administrators:

![Screenshot_20250110_165153](https://github.com/user-attachments/assets/028c7ff2-81e5-4fc1-be93-1c9c14cb0cf9)


- 🏢 **Company Management**:  
  Admins can add, delete, block, and unblock companies.  
  Each company is assigned a license key, valid for one year. Licenses exceeding their validity period are automatically blocked.  

  **Admin Credentials**:  
  - Email: `admin@gmail.com`  
  - Password: `123`  

- 📤 **Export to Excel**:  
  All tables in the admin panel can be exported as Excel sheets using the **Export** button.  

- 📝 **Company Registration Workflow**:  
  After adding a company, save the generated license key.  
  Log out of the admin account and register the company using the license key.  

---

#### **Owner Panel Features**  

Once a company is successfully registered, the owner can log in and access the following features:  


##### [Dashboard (Home Page)](#dashboard-home-page)  

![Screenshot_20250109_221427](https://github.com/user-attachments/assets/b231a977-c7d3-4cd4-9629-a33525c21444)

---

##### [Employees Page](#employees-page)  
Adding new Employee:
![Screenshot_20250108_181617](https://github.com/user-attachments/assets/18aeb4af-6492-4544-ab49-ea868d445c2a)


- 🧑‍💼 **Employee Roles**: `Employee` or `Admin`.  
- 🔒 **Permissions**:  
  - Employees can view only their company's employee list.  
  - Admins and owners can create, update, delete, or view all employees in their company.

![Screenshot_20250108_191031](https://github.com/user-attachments/assets/9f8dfa24-636a-4526-9653-b5d870703d02)

---

##### [Clients Page](#clients-page)  
![Screenshot_20250109_221437](https://github.com/user-attachments/assets/d065b282-2105-4e19-8ad1-3c6701fbb0ff)

- **Type**: Indicates the client's primary role or service.  
- **Purchases**: Tracks the number of times a client has made purchases.  
- 💵 **Total**: Represents the total amount paid by the client.  

---

##### [Transactions Page](#transactions-page)  
Add a new transaction:
![Screenshot_20250110_170238](https://github.com/user-attachments/assets/73196add-dc26-4238-b6c1-7be352fc9182)

- **Types**:  
  - `Income`: Money received from clients.  
  - `Outcome`: Payments made to contractors.  
- 🗓️ **Additional Features**:  
  - Optional due dates for transactions.  
  - If the due date exceeds the current date, the transaction is marked as "Not Paid" by default, but this can be updated manually.
  
![Screenshot_20250109_223120](https://github.com/user-attachments/assets/125b8d8c-692f-44bc-9a70-a3a8d51993f8)

---

##### [Resources Page](#resources-page)  
![Screenshot_20250109_221633](https://github.com/user-attachments/assets/553787f0-6811-4819-92ed-4e333a34a6ae)

- Tracks the company's resources, including `Name`, `Quantity`, and `Price`.  

---

##### [Units Page](#units-page)  
![Screenshot_20250109_221741](https://github.com/user-attachments/assets/a1bf8eb6-4448-4a91-9e3a-791f5a2f16bf)

- Maintains information about units with details like `Code`, `Area`, `Site`, and `Price`.  

---

##### [Contractors Page](#contractors-page)  
![Screenshot_20250109_223125](https://github.com/user-attachments/assets/6eaf640c-8649-4e3b-bd20-0c527a909e8e)

- **Type**: Indicates the contractor's primary role or service.  
- **Bills**: Tracks the number of times the company has made purchases from the contractor.  
- 💵 **Total**: Represents the total amount paid to the contractor.  

---

##### [Reports Page](#reports-page)  
![Screenshot_20250110_182313](https://github.com/user-attachments/assets/f296498b-c1c7-4069-b607-c6a3345a3175)

- 📄 Generate and download detailed **PDF** or **Excel** reports.  
- **Report Types**:  
  - **Income**: Summarizes income transactions by month/year.  
  - **Expense**: Lists outgoing payments by month/year.  
  - **Credits**: Details of money contractors owe to the company.  
  - **Debts**: Details of money owed by the company to clients.  
  - **Contractors**: Includes contractor details.
  - **Clients**: Highlights client details.
**Note**: If no specific name is selected for contractors/clients, reports show data for all entries.

---

##### [Balance Page](#balance-page)  
![Screenshot_20250109_225859](https://github.com/user-attachments/assets/7c4d7af8-6fbf-4a52-a92e-6c56fdff2424)


- Displays financial metrics:  
  - 💰 Total Balance  
  - 📈 Net Income  
  - 📥 Total Income  
  - 📤 Total Expenses
- **Note**: this data are since company registration.
  
---

##### [Profile Page](#profile-page)  
![Screenshot_20250109_223428](https://github.com/user-attachments/assets/65afcc21-3530-44c0-9aca-70bba5b4351e)

- View profile details.  
- Change password functionality.  

---

##### [Multilingual Support](#multilingual-support)  
- 🌐 Switch between **Arabic** and **English** from the top navigation bar.  

- - -

## [Installation](#installation)  

#### **Prerequisites**  
1. Ensure you have the following installed on your system:  
   - [PHP](https://www.php.net/downloads) (version compatible with Laravel 11).  
   - [Composer](https://getcomposer.org/).  
   - [MySQL](https://dev.mysql.com/downloads/installer/).  

2. Clone or download the project files to your local machine.  

---

#### **Steps to Install**  

1. **Set up the Database**:  
   - Open your MySQL management tool (e.g., phpMyAdmin, MySQL Workbench, or the MySQL CLI).  
   - Create a new database named `calcat`:  
     ```sql
     CREATE DATABASE calcat;
     ```  
   - Navigate to the `database_code` folder in the project directory.  
   - Locate the `calcat.sql` file and import it into the `calcat` database:  
     - **phpMyAdmin**:  
       1. Open phpMyAdmin and select the `calcat` database.  
       2. Click the **Import** tab.  
       3. Choose the `calcat.sql` file from your local directory.  
       4. Click **Go** to import the database.  
     - **MySQL Workbench**:  
       1. Open MySQL Workbench and connect to your MySQL server.  
       2. Select the `calcat` database.  
       3. Go to **File > Open SQL Script** and select `calcat.sql`.  
       4. Execute the script to populate the database.  
     - **Command Line**:  
       Run the following command in your terminal:  
       ```bash
       mysql -u [username] -p calcat < path/to/calcat.sql
       ```  

2. **Adjust Environment Configuration**:  
   - Copy `.env.example` to `.env` in the project root directory:  
     ```bash
     cp .env.example .env
     ```  
   - Open the `.env` file and update the database credentials:  
     ```env
     DB_CONNECTION=mysql  
     DB_HOST=127.0.0.1  
     DB_PORT=3306  
     DB_DATABASE=calcat  
     DB_USERNAME=<your_username>  
     DB_PASSWORD=<password>  
     ```  

3. **Install Dependencies**:  
   - Run the following command to install all required dependencies:  
     ```bash
     composer install
     ```  

4. **Generate the Application Key**:  
   - Run the following command to generate a new application key:  
     ```bash
     php artisan key:generate
     ```  

5. **Run the Application**:  
   - Start the Laravel development server:  
     ```bash
     php artisan serve
     ```  
   - Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

---

#### **Default Credentials**  
- **Admin Panel Login**:  
  - Email: `admin@gmail.com`  
  - Password: `123`  

