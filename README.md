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

---

##### [Dashboard (Home Page)](#dashboard-home-page)  
![screenshot from this page]  

---

##### [Employees Page](#employees-page)  
![screenshot from this page]  
- 🧑‍💼 **Employee Roles**: `Employee` or `Admin`.  
- 🔒 **Permissions**:  
  - Employees can view only their company's employee list.  
  - Admins and owners can create, update, delete, or view all employees in their company.  

---

##### [Clients Page](#clients-page)  
![screenshot from this page]  
- **Purchases**: Tracks the number of times a client has made purchases.  
- 💵 **Total**: Represents the total amount paid by the client.  

---

##### [Transactions Page](#transactions-page)  
![screenshot from this page]  
- **Types**:  
  - `Income`: Money received from clients.  
  - `Outcome`: Payments made to contractors.  
- 🗓️ **Additional Features**:  
  - Optional due dates for transactions.  
  - If the due date exceeds the current date, the transaction is marked as "Not Paid" by default, but this can be updated manually.  

---

##### [Resources Page](#resources-page)  
![screenshot]  
- Tracks the company's resources, including `Name`, `Quantity`, and `Price`.  

---

##### [Units Page](#units-page)  
![screenshot]  
- Maintains information about units with details like `Code`, `Area`, `Site`, and `Price`.  

---

##### [Contractors Page](#contractors-page)  
![screenshot]  
- **Type**: Indicates the contractor's primary role or service.  
- **Bills**: Tracks the number of times the company has made purchases from the contractor.  
- 💵 **Total**: Represents the total amount paid to the contractor.  

---

##### [Reports Page](#reports-page)  
![screenshot]  
- 📄 Generate and download detailed **PDF** or **Excel** reports.  
- **Report Types**:  
  - **Credits**: Details of money contractors owe to the company.  
  - **Debts**: Details of money owed by the company to clients.  
  - If no specific name is selected for contractors/clients, reports show data for all entries.  

---

##### [Balance Page](#balance-page)  
![screenshot]  
- Displays financial metrics:  
  - 💰 Total Balance  
  - 📈 Net Income  
  - 📥 Total Income  
  - 📤 Total Expenses since company registration  
- Shows the last 10 income and outcome transactions.  

---

##### [Multilingual Support](#multilingual-support)  
- 🌐 Switch between **Arabic** and **English** from the top navigation bar.  

---

##### [Profile Page](#profile-page)  
![screenshot from profile page]  
- View and update profile details.  
- Change password functionality.  

---

Click [here](#installation) to proceed to the **Installation** section.
