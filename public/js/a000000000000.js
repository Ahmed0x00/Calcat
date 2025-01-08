$(document).ready(function () {
    const tableBody = $('#tableBody');
    const searchInput = $('#searchInput');

    async function fetchCompanies(searchTerm = '') {
        try {
            const response = await $.ajax({
                url: `api/companies`,
                method: 'GET',
                dataType: 'json'
            });
            
            const filteredCompanies = response.filter(company => {
                const ownerName = company.owner_name ? company.owner_name.toLowerCase() : '';
                const email = company.email ? company.email.toLowerCase() : '';
                return ownerName.includes(searchTerm.toLowerCase()) || email.includes(searchTerm.toLowerCase());
            });

            populateCompanyTable(filteredCompanies);
        } catch (error) {
            console.error("Error fetching companies:", error);
            displayAlert("Failed to fetch companies.", "danger");
        }
    }

    function populateCompanyTable(companies) {
        tableBody.empty();

        if (companies.length === 0) {
            tableBody.append(`
                <tr>
                    <td colspan="${$('th').length}" class="text-center no-records">There are no recorded Companies</td>
                </tr>
            `);
            return;
        }

        companies.forEach(company => {
            const blockedStatus = company.blocked ? 'Yes' : 'No';
            const validUntil = company.valid_until ? new Date(company.valid_until).toLocaleDateString() : 'N/A';
            const actions = `
                <button class="btn btn-danger btn-sm" onclick="deleteCompany(${company.id})" style="font-size: 1rem; padding: 8px 10px;">Delete</button>
                <button id="block-btn-${company.id}" style="font-size: 1rem; padding: 8px 10px;" class="btn btn-secondary btn-sm" onclick="toggleCompanyBlock(${company.id}, ${company.blocked})">
                    ${company.blocked ? 'Unblock' : 'Block'}
                </button>
            `;

            tableBody.append(`
                <tr id="company-${company.id}">
                    <td>${company.owner_name || 'N/A'}</td>
                    <td>${company.email || 'N/A'}</td>
                    <td>${company.license_key || 'N/A'}</td>
                    <td class="blocked-status">${blockedStatus}</td>
                    <td>${validUntil}</td>
                    <td>${actions}</td>
                </tr>
            `);
        });
    }

    searchInput.on('input', function () {
        const searchTerm = $(this).val();
        fetchCompanies(searchTerm);
    });

    fetchCompanies();

    async function createCompany() {
        try {
            const response = await $.ajax({
                url: 'api/companies',
                method: 'POST'
            });
            displayAlert(response.message, "success");
            fetchCompanies();
        } catch (error) {
            console.error("Error creating company:", error);
            displayAlert("Failed to create company.", "danger");
        }
    }

    window.toggleCompanyBlock = async function (id, isBlocked) {
        const button = $(`#block-btn-${id}`);
        
        // Optimistic UI update
        button.text("Processing...")
              .addClass("btn-warning")
              .prop("disabled", true);

        try {
            const response = await $.ajax({
                url: `api/companies/${id}/${isBlocked ? 'unblock' : 'block'}`,
                method: 'PATCH'
            });

            // Update UI based on actual response
            displayAlert(response.message, "success");

            const newStatus = !isBlocked;
            $(`#company-${id} .blocked-status`).text(newStatus ? 'Yes' : 'No');
            button.text(newStatus ? 'Unblock' : 'Block')
                  .toggleClass("btn-secondary", false)
                  .prop("disabled", false)
                  .attr("onclick", `toggleCompanyBlock(${id}, ${newStatus})`);

        } catch (error) {
            console.error("Error toggling company block:", error);
            displayAlert("Failed to update company status.", "danger");

            // Reset UI on error
            button.text(isBlocked ? 'Unblock' : 'Block')
                  .toggleClass("btn-secondary", false)
                  .prop("disabled", false);
        }
    };

    window.deleteCompany = async function (id) {
        if (confirm('Are you sure you want to delete this company?')) {
            try {
                const response = await $.ajax({
                    url: `api/companies/${id}`,
                    method: 'DELETE'
                });
                displayAlert(response.message, "success");
                $(`#company-${id}`).remove();
            } catch (error) {
                console.error("Error deleting company:", error);
                displayAlert("Failed to delete company.", "danger");
            }
        }
    };

    $('.add-btn').on('click', createCompany);
});
