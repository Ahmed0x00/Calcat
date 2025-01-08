// Get the companyId from local storage
const companyId = localStorage.getItem('company_id');

$(document).ready(function () {
    // Initialize the resource table
    fetchResources();

    // Open the modal for adding a resource
    $(".add-btn").on("click", function () {
        resetResourceForm();
        $("#resourceModalLabel").text("Add Resource");
        $("#saveResourceButton").text("Save");
        $("#resourceModal").modal("show");
    });

    // Handle form submission for both adding and updating resources
    $("#resourceForm").on("submit", function (event) {
        event.preventDefault(); // Prevent default form submission
        const resourceId = $("#resourceId").val();

        // Remove commas from quantity and price before submitting
        $("#resourceQuantity").val(removeCommas($("#resourceQuantity").val()));
        $("#resourcePrice").val(removeCommas($("#resourcePrice").val()));

        if (resourceId) {
            // If resourceId is present, update the resource
            updateResource(resourceId);
        } else {
            // Otherwise, add a new resource
            addResource();
        }
    });

    // Event delegation for edit and delete buttons in the table
    $("#tableBody").on("click", ".btn-edit", function () {
        const resourceId = $(this).data("resource-id");
        editResource(resourceId);
    });

    $("#tableBody").on("click", ".btn-delete", function () {
        const resourceId = $(this).data("resource-id");
        deleteResource(resourceId);
    });

    // Event listener for search input
    $("#searchInput").on("input", function () {
        const searchTerm = $(this).val().toLowerCase();
        fetchResources(searchTerm);
    });

    // Add event listeners for quantity and price inputs to format with commas
    $("#resourceQuantity, #resourcePrice").on("input", function () {
        $(this).val(formatWithCommas($(this).val()));
    });
});

// Function to format numbers with commas
function formatWithCommas(value) {
    value = value.replace(/,/g, ""); // Remove existing commas
    return value.replace(/\B(?=(\d{3})+(?!\d))/g, ","); // Add commas
}

// Function to remove commas from a number
function removeCommas(value) {
    return value.replace(/,/g, "");
}

// Function to fetch resources (filtered by search term)
async function fetchResources(searchTerm = "") {
    try {
        const response = await $.ajax({
            url: `api/${companyId}/resources`,
            method: "GET"
        });

        $("#tableBody").empty();

        if (response.resources.length > 0) {
            const filteredResources = response.resources.filter((resource) =>
                resource.name.toLowerCase().includes(searchTerm)
            );

            filteredResources.forEach((resource) => {
                const resourceRow = `
                    <tr>
                        <td>${resource.name}</td>
                        <td>${formatWithCommas(resource.quantity.toString())}</td>
                        <td>${formatWithCommas(resource.price.toString())}</td>
                        <td>
                            <button class="btn btn-outline-success btn-edit" data-resource-id="${resource.id}" style="font-size: 1rem; padding: 8px 10px;">Edit</button>
                            <button class="btn btn-outline-danger btn-delete" data-resource-id="${resource.id}" style="font-size: 1rem; padding: 8px 10px;">Delete</button>
                        </td>
                    </tr>
                `;
                $("#tableBody").append(resourceRow);
            });
        } else {
            $("#tableBody").html(
                '<tr><td colspan="4" class="text-center">No resources found.</td></tr>'
            );
        }
    } catch (error) {
        displayAlert("Failed to fetch resources.", "danger");
    }
}

// Function to reset the form fields
function resetResourceForm() {
    $("#resourceId").val("");
    $("#resourceName").val("");
    $("#resourceQuantity").val("");
    $("#resourcePrice").val("");
}

// Function to add a new resource
async function addResource() {
    const formData = getResourceFormData();

    try {
        await $.ajax({
            url: `api/${companyId}/resources`,
            method: "POST",
            data: formData
        });

        $("#resourceModal").modal("hide");
        displayAlert("Resource created successfully", "success");
        fetchResources();
    } catch (xhr) {
        handleAjaxError(xhr, "Failed to create resource");
    }
}

// Function to edit a resource
async function editResource(resourceId) {
    try {
        const resource = await $.ajax({
            url: `api/${companyId}/resources/${resourceId}`,
            method: "GET"
        });

        if (resource) {
            // Populate the form with resource data
            $("#resourceId").val(resource.id);
            $("#resourceName").val(resource.name);
            $("#resourceQuantity").val(formatWithCommas(resource.quantity.toString()));
            $("#resourcePrice").val(formatWithCommas(resource.price.toString()));

            // Update modal title and button text for editing
            $("#resourceModalLabel").text("Edit Resource");
            $("#saveResourceButton").text("Update");

            // Show the modal
            $("#resourceModal").modal("show");
        } else {
            displayAlert("No resource found for this ID.", "warning");
        }
    } catch (error) {
        displayAlert("Failed to fetch resource details for editing.", "danger");
    }
}

// Function to update an existing resource
async function updateResource(resourceId) {
    const formData = getResourceFormData();

    try {
        await $.ajax({
            url: `api/${companyId}/resources/${resourceId}`,
            method: "PUT",
            data: formData
        });

        $("#resourceModal").modal("hide");
        displayAlert("Resource updated successfully", "success");
        fetchResources();
    } catch (xhr) {
        handleAjaxError(xhr, "Failed to update resource");
    }
}

// Function to delete a resource
async function deleteResource(resourceId) {
    if (confirm("Are you sure you want to delete this resource?")) {
        try {
            await $.ajax({
                url: `api/${companyId}/resources/${resourceId}`,
                method: "DELETE"
            });

            displayAlert("Resource deleted successfully", "success");
            fetchResources();
        } catch (error) {
            displayAlert("Failed to delete resource.", "danger");
        }
    }
}

// Helper function to get form data
function getResourceFormData() {
    return {
        name: $("#resourceName").val(),
        quantity: removeCommas($("#resourceQuantity").val()),
        price: removeCommas($("#resourcePrice").val())
    };
}

// Helper function to handle AJAX errors
function handleAjaxError(xhr, defaultMessage) {
    const errorMessage =
        xhr.responseJSON && xhr.responseJSON.message
            ? xhr.responseJSON.message
            : defaultMessage;
    
    displayAlert(errorMessage, "danger");
}