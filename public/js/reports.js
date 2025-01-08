$(document).ready(function () {
    var companyId = localStorage.getItem("company_id");
    var baseUrl = `/api/${companyId}/reports`;

    // Helper function to format keys into readable column headers
    function formatHeader(key) {
        if (key === "name") return "";
        const formatted = key
            .replace(/_/g, " ") // Replace underscores with spaces
            .replace(/\b\w/g, (c) => c.toUpperCase()); // Capitalize each word
        return formatted;
    }

    // Dynamically generate table HTML
    function generateTable(data, reportType) {
        let table = `<table class="table table-bordered"><thead><tr>`;
        const headers = Object.keys(data[0]);

        // Adjust column names for specific reports
        const adjustedHeaders = headers.map((key) => {
            if (reportType === "income" || reportType === "clients") {
                return key === "name" ? "Client Name" : formatHeader(key);
            }
            if (reportType === "expense" || reportType === "contractors") {
                return key === "name" ? "Contractor Name" : formatHeader(key);
            }
            return formatHeader(key);
        });

        // Generate table headers
        adjustedHeaders.forEach((header) => {
            table += `<th>${header}</th>`;
        });
        table += `</tr></thead><tbody>`;

        // Generate table rows
        data.forEach((item) => {
            table += `<tr>`;
            headers.forEach((key) => {
                const value = item[key] !== null ? item[key] : "";
                table += `<td>${value}</td>`;
            });
            table += `</tr>`;
        });
        table += `</tbody></table>`;
        return table;
    }

    // Print table
    function printData(data, reportType) {
        const tableHtml = generateTable(data, reportType);
        const newWindow = window.open("", "_blank");
        newWindow.document.write(
            `<html><head><title>Report</title><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"></head><body>`
        );
        newWindow.document.write(tableHtml);
        newWindow.document.write("</body></html>");
        newWindow.document.close();
        newWindow.focus();
        newWindow.print();
        newWindow.close();
    }

    // Download Excel
    function downloadExcel(data, reportType, filenamePrefix) {
        const tableHtml = generateTable(data, reportType);
        const uri =
            "data:application/vnd.ms-excel;base64," + btoa(unescape(encodeURIComponent(tableHtml)));
        const link = document.createElement("a");
        link.href = uri;
        link.download = `${filenamePrefix}_report.xls`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Fetch Report Data via AJAX
    function fetchReport(endpoint, filters, onSuccess) {
        $.ajax({
            url: `${baseUrl}${endpoint}`,
            method: "GET",
            data: filters,
            success: function (response) {
                if (response.data) {
                    onSuccess(response.data);
                } else {
                    alert(response.message || "No data found.");
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert("An error occurred while fetching the report.");
            },
        });
    }

    // Event listeners for generating reports

    // Income Report
    $("#printIncome").click(function () {
        const filters = {
            month: $("#incomeMonth").val(),
            year: $("#incomeYear").val(),
        };
        fetchReport("/income", filters, (data) => printData(data, "income"));
    });

    $("#downloadIncomeExcel").click(function () {
        const filters = {
            month: $("#incomeMonth").val(),
            year: $("#incomeYear").val(),
        };
        fetchReport("/income", filters, (data) => downloadExcel(data, "income", "income"));
    });

    // Expense Report
    $("#printExpense").click(function () {
        const filters = {
            month: $("#expenseMonth").val(),
            year: $("#expenseYear").val(),
        };
        fetchReport("/expense", filters, (data) => printData(data, "expense"));
    });

    $("#downloadExpenseExcel").click(function () {
        const filters = {
            month: $("#expenseMonth").val(),
            year: $("#expenseYear").val(),
        };
        fetchReport("/expense", filters, (data) => downloadExcel(data, "expense", "expense"));
    });

    // Contractor Report
    $("#printContractor").click(function () {
        const contractorName = $("#contractorName").val();
        const endpoint = contractorName
            ? `/contractors/${contractorName}`
            : "/contractors";
        fetchReport(endpoint, {}, (data) =>
            printData(data, contractorName ? `${contractorName}_contractor` : "contractors")
        );
    });

    $("#downloadContractorExcel").click(function () {
        const contractorName = $("#contractorName").val();
        const endpoint = contractorName
            ? `/contractors/${contractorName}`
            : "/contractors";
        fetchReport(endpoint, {}, (data) =>
            downloadExcel(
                data,
                contractorName ? `${contractorName}_contractor` : "contractors",
                contractorName ? contractorName : "contractors"
            )
        );
    });

    // Client Report
    $("#printClient").click(function () {
        const clientName = $("#clientName").val();
        const endpoint = clientName ? `/clients/${clientName}` : "/clients";
        fetchReport(endpoint, {}, (data) =>
            printData(data, clientName ? `${clientName}_client` : "clients")
        );
    });

    $("#downloadClientExcel").click(function () {
        const clientName = $("#clientName").val();
        const endpoint = clientName ? `/clients/${clientName}` : "/clients";
        fetchReport(endpoint, {}, (data) =>
            downloadExcel(
                data,
                clientName ? `${clientName}_client` : "clients",
                clientName ? clientName : "clients"
            )
        );
    });

    // Additional reports
    $("#printCredit").click(function () {
        fetchReport("/credit", {}, (data) => printData(data, "credit"));
    });

    $("#downloadCreditExcel").click(function () {
        fetchReport("/credit", {}, (data) => downloadExcel(data, "credit", "credits"));
    });

    $("#printDebt").click(function () {
        fetchReport("/debt", {}, (data) => printData(data, "debt"));
    });

    $("#downloadDebtExcel").click(function () {
        fetchReport("/debt", {}, (data) => downloadExcel(data, "debt", "debts"));
    });
});
