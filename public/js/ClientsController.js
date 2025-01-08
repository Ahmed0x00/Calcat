// Get companyId from local storage
const companyId = localStorage.getItem('company_id');

$(document).ready(function () {
    // Initialize the table and search input
    fetchClients();

    // Event listener for search input
    $("#searchInput").on("input", function () {
        const searchTerm = $(this).val().toLowerCase();
        fetchClients(searchTerm);
    });

    // Event listener for Add Client button
    $(".add-btn").on("click", function () {
        resetClientForm();
        $("#addClientModalLabel").text("Add Client");
        $("#saveClientButton").text("Save Client").off("click").on("click", addClient);
        $("#addClientModal").modal("show");
    });

    // Event delegation for dynamically created edit and delete buttons
    $("#tableBody").on("click", ".btn-edit", function () {
        const client_id = $(this).data("client-id");
        editClient(client_id);
    });

    $("#tableBody").on("click", ".btn-delete", function () {
        const client_id = $(this).data("client-id");
        deleteClient(client_id);
    });
});

// Function to fetch clients (filtered by search term)
async function fetchClients(searchTerm = "") {
    try {
        const response = await $.ajax({
            url: `api/${companyId}/clients`,
            method: "GET"
        });

        $("#tableBody").empty();

        const filteredData = response.filter(client =>
            client.name.toLowerCase().includes(searchTerm)
        );

        if (filteredData.length > 0) {
            filteredData.forEach(client => {
                const clientRow = `
                    <tr>
                        <td>${client.name}</td>
                        <td>${client.phone}</td>
                        <td>${client.purchases_count}</td>
                        <td>${formatNumber(client.total)}</td>
                        <td>
                            <button class="btn btn-outline-success btn-edit" data-client-id="${client.client_id}" style="font-size: 1rem; padding: 8px 10px;">Edit</button>
                            <button class="btn btn-outline-danger btn-delete" data-client-id="${client.client_id}" style="font-size: 1rem; padding: 8px 10px;">Delete</button>
                        </td>
                    </tr>
                `;
                $("#tableBody").append(clientRow);
            });
        } else {
            $("#tableBody").html('<tr><td colspan="5" class="text-center">No clients found</td></tr>');
        }
    } catch (error) {
        displayAlert("Failed to fetch clients.", "danger");
    }
}

// Function to reset form fields
function resetClientForm() {
    $("#clientName, #clientPhone").val("");
}

// Function to format number with commas
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Function to add a new client
async function addClient() {
    const formData = {
        name: $("#clientName").val(),
        phone: $("#clientPhone").val()
    };

    try {
        await $.ajax({
            url: `api/${companyId}/clients`,
            method: "POST",
            data: formData
        });

        $("#addClientModal").modal("hide");
        displayAlert("Client added successfully.", "success");
        fetchClients();
    } catch (xhr) {
        displayAlert("Failed to create client.", "danger");
    }
}

// Function to edit a client
async function editClient(client_id) {
    try {
        const response = await $.ajax({
            url: `api/${companyId}/clients/${client_id}`,
            method: "GET"
        });

        client = response.client;

        if (client) {
            console.log(client);
            $("#clientName").val(client.name);
            $("#clientPhone").val(client.phone);
            $("#addClientModalLabel").text("Edit Client");
            $("#saveClientButton").text("Update Client").off("click").on("click", function () {
                updateClient(client_id);
            });
            $("#addClientModal").modal("show");
        }
    } catch (error) {
        displayAlert("Failed to fetch client details.", "danger");
    }
}

// Function to update a client
async function updateClient(client_id) {
    const formData = {
        name: $("#clientName").val(),
        phone: $("#clientPhone").val()
    };

    try {
        await $.ajax({
            url: `api/${companyId}/clients/${client_id}`,
            method: "PUT",
            data: formData
        });

        $("#addClientModal").modal("hide");
        displayAlert("Client updated successfully.", "success");
        fetchClients();
    } catch (xhr) {
        displayAlert("Failed to update client.", "danger");
    }
}

// Function to delete a client
async function deleteClient(client_id) {
    if (confirm("Are you sure you want to delete this client?")) {
        try {
            await $.ajax({
                url: `api/${companyId}/clients/${client_id}`,
                method: "DELETE"
            });
            displayAlert("Client deleted successfully.", "success");

            fetchClients();
        } catch (error) {
            displayAlert("Failed to delete client.", "danger");
        }
    }
}
