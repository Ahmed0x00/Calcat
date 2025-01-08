const companyId = localStorage.getItem('company_id');

$(document).ready(function () {
    fetchContractors();

    $("#searchInput").on("input", function () {
        const searchTerm = $(this).val().toLowerCase();
        fetchContractors(searchTerm);
    });

    $(".add-btn").on("click", function () {
        resetContractorForm();
        $("#addContractorModalLabel").text("Add Contractor");
        $("#saveContractorButton").text("Save Contractor").off("click").on("click", addContractor);
        $("#addContractorModal").modal("show");
    });

    $("#tableBody").on("click", ".btn-edit", function () {
        const id = $(this).data("contractor-id");
        editContractor(id);
    });

    $("#tableBody").on("click", ".btn-delete", function () {
        const id = $(this).data("contractor-id");
        deleteContractor(id);
    });
});

async function fetchContractors(searchTerm = "") {
    try {
        const response = await $.ajax({
            url: `api/${companyId}/contractors`,
            method: "GET"
        });

        $("#tableBody").empty();
        const filteredData = response.filter(contractor =>
            contractor.name.toLowerCase().includes(searchTerm)
        );

        if (filteredData.length > 0) {
            filteredData.forEach(contractor => {
                const contractorRow = `
                    <tr>
                        <td>${contractor.name}</td>
                        <td>${contractor.phone}</td>
                        <td>${contractor.type || '-'}</td>
                        <td>${contractor.bills}</td>
                        <td>${formatNumber(contractor.total)}</td>
                        <td>
                            <button class="btn btn-outline-success btn-edit" data-contractor-id="${contractor.id}" style="font-size: 1rem; padding: 8px 10px;">Edit</button>
                            <button class="btn btn-outline-danger btn-delete" data-contractor-id="${contractor.id}" style="font-size: 1rem; padding: 8px 10px;">Delete</button>
                        </td>
                    </tr>
                `;
                $("#tableBody").append(contractorRow);
            });
        } else {
            $("#tableBody").html('<tr><td colspan="6" class="text-center">No contractors found</td></tr>');
        }
    } catch (error) {
        displayAlert("Failed to fetch contractors.", "danger");
    }
}

function resetContractorForm() {
    $("#contractorName, #contractorPhone, #contractorType").val("");
}
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

async function addContractor() {
    const formData = {
        name: $("#contractorName").val(),
        phone: $("#contractorPhone").val(),
        type: $("#contractorType").val()
    };

    try {
        await $.ajax({
            url: `api/${companyId}/contractors`,
            method: "POST",
            data: formData
        });

        $("#addContractorModal").modal("hide");
        displayAlert("Contractor added successfully.", "success");
        fetchContractors();
    } catch (xhr) {
        displayAlert("Failed to create contractor.", "danger");
    }
}

// Function to edit a contractor
async function editContractor(id) {
    try {
        const response = await $.ajax({
            url: `api/${companyId}/contractors/${id}`,
            method: "GET"
        });

        contractor = response.contractor;

        if (contractor) {
            $("#contractorName").val(contractor.name);
            $("#contractorPhone").val(contractor.phone);
            $("#contractorType").val(contractor.type);
            $("#addContractorModalLabel").text("Edit Contractor");
            $("#saveContractorButton").text("Update Contractor").off("click").on("click", function () {
                updateContractor(id);
            });
            $("#addContractorModal").modal("show");
        }
    } catch (error) {
        displayAlert("Failed to fetch contractor details.", "danger");
    }
}

// Function to update a contractor
async function updateContractor(id) {
    const formData = {
        name: $("#contractorName").val(),
        phone: $("#contractorPhone").val(),
        type: $("#contractorType").val()
    };

    try {
        await $.ajax({
            url: `api/${companyId}/contractors/${id}`,
            method: "PUT",
            data: formData
        });

        $("#addContractorModal").modal("hide");
        displayAlert("Contractor updated successfully.", "success");
        fetchContractors();
    } catch (xhr) {
        displayAlert("Failed to update contractor.", "danger");
    }
}

// Function to delete a contractor
async function deleteContractor(id) {
    try {
        await $.ajax({
            url: `api/${companyId}/contractors/${id}`,
            method: "DELETE"
        });

        displayAlert("Contractor deleted successfully.", "success");
        fetchContractors();
    } catch (error) {
        displayAlert("Failed to delete contractor.", "danger");
    }
}
