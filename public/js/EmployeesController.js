// Get the companyId from local storage
const companyId = localStorage.getItem('company_id');
const language = localStorage.getItem("language") || "en";

$(document).ready(function () {
    // Initialize the table and search input
    fetchEmployees();

    // Event listener for search input
    $("#searchInput").on("input", function () {
        const searchTerm = $(this).val().toLowerCase();
        fetchEmployees(searchTerm);
    });

    // Event listener for Add Employee button
    $(".add-btn").on("click", function () {
        resetEmployeeForm();
        $("#addEmployeeModalLabel").text("Add Employee");
        $("#saveEmployeeButton").text("Save Employee").off("click").on("click", addEmployee);
        $("#addEmployeeModal").modal("show");
    });

    // Event delegation for dynamically created edit and delete buttons
    $("#tableBody").on("click", ".btn-edit", function () {
        const employee_id = $(this).data("employee-id");
        editEmployee(employee_id);
    });

    $("#tableBody").on("click", ".btn-delete", function () {
        const employee_id = $(this).data("employee-id");
        deleteEmployee(employee_id);
    });

    // Add commas to salary as the user types
    $("#employeeSalary").on("input", function () {
        let value = $(this).val().replace(/[^0-9.]/g, ""); // Remove non-numeric characters
        $(this).val(formatAmount(value)); // Add commas
    });
});

// Function to format the amount with commas
const formatAmount = (amount) => amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

// Function to fetch employees (filtered by search term)
async function fetchEmployees(searchTerm = "") {
    try {
        const response = await $.ajax({
            url: `api/${companyId}/employees`,
            method: "GET"
        });

        $("#tableBody").empty();

        if (response.length > 0) {
            const filteredData = response.filter((employee) =>
                employee.name.toLowerCase().includes(searchTerm)
            );

            filteredData.forEach((employee) => {
                const employeeRow = `
                    <tr>
                        <td>${employee.employee_id}</td>
                        <td>${employee.name}</td>
                        <td>${employee.leader}</td>
                        <td>${formatAmount(employee.salary)}</td>
                        <td>${employee.email}</td>
                        <td>${employee.phone || "N/A"}</td>
                        <td>${employee.role}</td>
                        <td>${employee.department_name}</td>
                        <td>
                            <button class="btn btn-outline-success btn-edit" data-employee-id="${employee.employee_id}" style="font-size: 1rem; padding: 8px 10px;">Edit</button>
                            <button class="btn btn-outline-danger btn-delete" data-employee-id="${employee.employee_id}" style="font-size: 1rem; padding: 8px 10px;">Delete</button>
                        </td>
                    </tr>
                `;
                $("#tableBody").append(employeeRow);
            });
        } else {
            $("#tableBody").html(
                '<tr><td colspan="8" class="text-center no-records">There are no recorded Employees</td></tr>'
            );
        }
    } catch (error) {
        alert("Failed to fetch employees.");
    }
}


// Function to reset the form fields
function resetEmployeeForm() {
    $("#employeeName, #employeeEmail, #employeePhone, #employeeDepartment, #employeeRole, #employeePassword").val("");
}

// Function to edit an employee
async function editEmployee(employee_id) {
    try {
        const employee = await $.ajax({
            url: `api/${companyId}/employees/${employee_id}`,
            method: "GET"
        });

        if (employee) {
            // Reset form before populating with new data
            resetEmployeeForm();

            // Populate the form with employee data
            populateEmployeeForm(employee);

            // Update modal title and button text for editing
            $("#addEmployeeModalLabel").text("Edit Employee");
            $("#saveEmployeeButton").text("Update Employee").off("click").on("click", function () {
                updateEmployee(employee_id);
            });

            // Show modal after ensuring data has been populated
            $("#addEmployeeModal").modal("show");
        } else {
            displayAlert("No employee found for this ID.", "danger");
        }
    } catch (error) {
        displayAlert("Failed to fetch employee details for editing.", "danger");
    }
}


// Function to populate form with employee data
function populateEmployeeForm(employeeData) {
    const employee = employeeData.employee;  // Access the nested employee object
    $("#employeeName").val(employee.name || "");
    $("#employeeLeader").val(employee.leader || "");
    $("#employeeSalary").val(formatAmount(employee.salary) || "");
    $("#employeeEmail").val(employee.email || "");
    $("#employeePhone").val(employee.phone || "");
    $("#employeeDepartment").val(employee.department_name || "");
    $("#employeeRole").val(employee.role || "");
    $("#employeePassword").val(""); // Leave password field blank for security
}


// Function to handle adding a new employee
async function addEmployee() {
    const formData = getEmployeeFormData();

    // Default leader to 'None' if not provided
    if (!formData.leader) {
        formData.leader = "N/A";
    }

    try {
        await $.ajax({
            url: `api/${companyId}/employees`,
            method: "POST",
            data: formData
        });

        $("#addEmployeeModal").modal("hide");
        displayAlert("Employee created successfully", "success");
        fetchEmployees();
    } catch (xhr) {
        handleAjaxError(xhr, "Failed to create employee");
    }
}

// Function to update an existing employee
async function updateEmployee(employee_id) {
    const formData = getEmployeeFormData();

    try {
        await $.ajax({
            url: `api/${companyId}/employees/${employee_id}`,
            method: "PUT",
            data: formData
        });

        $("#addEmployeeModal").modal("hide");
        displayAlert("Employee updated successfully", "success");
        fetchEmployees();
    } catch (xhr) {
        handleAjaxError(xhr, "Failed to update employee");
    }
}

// Function to delete an employee
async function deleteEmployee(employee_id) {
    if (confirm("Are you sure you want to delete this employee?")) {
        try {
            await $.ajax({
                url: `api/${companyId}/employees/${employee_id}`,
                method: "DELETE"
            });

            displayAlert("Employee deleted successfully", "success");
            fetchEmployees();
        } catch (error) {
            displayAlert("Failed to delete employee.", "danger");
        }
    }
}

// Helper function to get form data, defaulting leader to 'None' if not inputted
function getEmployeeFormData() {
    return {
        name: $("#employeeName").val(),
        leader: $("#employeeLeader").val() || "N/A",  // Set default leader to "None"
        salary: $("#employeeSalary").val().replace(/,/g, ""),
        email: $("#employeeEmail").val(),
        phone: $("#employeePhone").val(),
        role: $("#employeeRole").val(),
        department_name: $("#employeeDepartment").val(),
        password: $("#employeePassword").val()
    };
}

// Helper function to display alert messages
function displayAlert(message, type) {
    const alertBox = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`;
    $(".alert-container").html(alertBox);
}

// Helper function to handle AJAX errors
function handleAjaxError(xhr, defaultMessage) {
    const errorMessage =
        xhr.responseJSON && xhr.responseJSON.message
            ? xhr.responseJSON.message
            : defaultMessage;
    
    if (xhr.status === 409) {
        displayAlert("Email already exists. Please use a different email.", "danger");
    } else {
        displayAlert(errorMessage, "danger");
    }
}
