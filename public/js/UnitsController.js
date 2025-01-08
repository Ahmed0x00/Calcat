// Get the companyId from local storage
const companyId = localStorage.getItem('company_id');

$(document).ready(function () {
    // Initialize the units table
    fetchUnits();

    // Open the modal for adding a unit
    $(".add-btn").on("click", function () {
        resetUnitForm();
        $("#unitModalLabel").text("Add Unit");
        $("#saveUnitButton").text("Save");
        $("#unitModal").modal("show");
    });

    // Handle form submission
    $("#unitForm").on("submit", function (event) {
        event.preventDefault();
        const unitId = $("#unitId").val();

        if (unitId) {
            // Update unit if unitId exists
            updateUnit(unitId);
        } else {
            // Add new unit if unitId is empty
            addUnit();
        }
    });

    // Event delegation for edit and delete buttons in the table
    $("#tableBody").on("click", ".btn-edit", function () {
        const unitId = $(this).data("unit-id");
        editUnit(unitId);
    });

    $("#tableBody").on("click", ".btn-delete", function () {
        const unitId = $(this).data("unit-id");
        deleteUnit(unitId);
    });

    // Event listener for search input
    $("#searchInput").on("input", function () {
        const searchTerm = $(this).val().toLowerCase();
        fetchUnits(searchTerm);
    });
});

// Function to fetch units (filtered by search term)
async function fetchUnits(searchTerm = "") {
    try {
        const response = await $.ajax({
            url: `api/${companyId}/units`,
            method: "GET"
        });

        $("#tableBody").empty();

        if (response.units.length > 0) {
            const filteredUnits = response.units.filter((unit) =>
                unit.code.toLowerCase().includes(searchTerm)
            );

            filteredUnits.forEach((unit) => {
                const unitRow = `
                    <tr>
                        <td>${unit.code}</td>
                        <td>${formatNumber(unit.area)}</td>
                        <td>${unit.site}</td>
                        <td>${formatNumber(unit.price)}</td>
                        <td>
                            <button class="btn btn-outline-success btn-edit" data-unit-id="${unit.id}" style="font-size: 1rem; padding: 8px 10px;">Edit</button>
                            <button class="btn btn-outline-danger btn-delete" data-unit-id="${unit.id}" style="font-size: 1rem; padding: 8px 10px;">Delete</button>
                        </td>
                    </tr>
                `;
                $("#tableBody").append(unitRow);
            });
        } else {
            $("#tableBody").html('<tr><td colspan="5" class="text-center">No units found.</td></tr>');
        }
    } catch (error) {
        displayAlert("Failed to fetch units.", "danger");
    }
}

// Function to reset the form fields
function resetUnitForm() {
    $("#unitId").val("");
    $("#unitCode").val("");
    $("#unitArea").val("");
    $("#unitPrice").val("");
    $("#unitSite").val("");
}

// Format price and area input fields on input
$("#unitPrice, #unitArea").on("input", function () {
    formatInputWithCommas(this);
});

// Function to format input value with commas
function formatInputWithCommas(input) {
    // Remove non-numeric characters except for dots (in case of decimals)
    let value = input.value.replace(/[^0-9]/g, '');
    
    // Convert the value to a number and format with commas
    if (value) {
        input.value = parseInt(value).toLocaleString('en-US');
    } else {
        input.value = '';
    }
}


// Function to add a new unit
async function addUnit() {
    const formData = getUnitFormData();

    try {
        await $.ajax({
            url: `api/${companyId}/units`,
            method: "POST",
            data: formData
        });

        $("#unitModal").modal("hide");
        displayAlert("Unit created successfully", "success");
        fetchUnits();
    } catch (xhr) {
        handleAjaxError(xhr, "Failed to create unit");
    }
}

// Function to edit a unit
async function editUnit(unitId) {
    try {
        const unit = await $.ajax({
            url: `api/${companyId}/units/${unitId}`,
            method: "GET"
        });

        if (unit) {
            // Populate the form with unit data
            $("#unitId").val(unit.id);
            $("#unitCode").val(unit.code);
            $("#unitArea").val(formatNumber(unit.area));
            $("#unitPrice").val(formatNumber(unit.price));
            $("#unitSite").val(unit.site);

            // Update modal title and button text for editing
            $("#unitModalLabel").text("Edit Unit");
            $("#saveUnitButton").text("Update");

            // Show the modal
            $("#unitModal").modal("show");
        } else {
            displayAlert("No unit found for this ID.", "danger");
        }
    } catch (error) {
        displayAlert("Failed to fetch unit details for editing.", "danger");
    }
}

// Function to update an existing unit
async function updateUnit(unitId) {
    const formData = getUnitFormData();

    try {
        await $.ajax({
            url: `api/${companyId}/units/${unitId}`,
            method: "PUT",
            data: formData
        });

        $("#unitModal").modal("hide");
        displayAlert("Unit updated successfully", "success");
        fetchUnits();
    } catch (xhr) {
        handleAjaxError(xhr, "Failed to update unit");
    }
}

// Function to delete a unit
async function deleteUnit(unitId) {
    if (confirm("Are you sure you want to delete this unit?")) {
        try {
            await $.ajax({
                url: `api/${companyId}/units/${unitId}`,
                method: "DELETE"
            });

            displayAlert("Unit deleted successfully", "success");
            fetchUnits();
        } catch (error) {
            displayAlert("Failed to delete unit.", "danger");
        }
    }
}

// Helper function to get form data, removing commas from price and area
function getUnitFormData() {
    return {
        code: $("#unitCode").val(),
        area: $("#unitArea").val().replace(/,/g, ""), // Remove commas
        price: $("#unitPrice").val().replace(/,/g, ""), // Remove commas
        site: $("#unitSite").val()
    };
}

// Helper function to display alerts
function displayAlert(message, type) {
    $("#alertContainer").html(`
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `);
}

// Helper function to format numbers with commas
function formatNumber(value) {
    return Number(value).toLocaleString("en");
}

// Helper function to handle AJAX errors
function handleAjaxError(xhr, defaultMessage) {
    const errorMessage = xhr.responseJSON && xhr.responseJSON.message
        ? xhr.responseJSON.message
        : defaultMessage;
    displayAlert(errorMessage, "danger");
}
