document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.export-btn').forEach(button => {
        button.removeEventListener('click', exportTable); // Ensure no duplicate listeners
        button.addEventListener('click', exportTable); // Attach the export function
    });
});

function exportTable(event) {
    event.preventDefault(); // Prevent any default button behavior

    const button = event.currentTarget;
    const tableId = button.closest('.text-end').previousElementSibling.querySelector('table').id;
    const table = document.getElementById(tableId);

    let workbook = XLSX.utils.book_new();
    let data = [];
    let headers = [];
    const headerRow = table.querySelectorAll('thead th');

    // Collect column headers, excluding columns with "data-ignore-export"
    headerRow.forEach(header => {
        if (!header.hasAttribute("data-ignore-export")) {
            headers.push({
                v: header.innerText,
                s: { 
                    font: { color: { rgb: "FFFFFF" } }, // Text color white
                    fill: { fgColor: { rgb: "000000" } } // Background color black
                }
            });
        }
    });
    data.push(headers);

    // Collect table rows
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        let rowData = [];
        row.querySelectorAll('td').forEach((cell, index) => {
            if (index < headers.length) { // Skip cells in columns with "data-ignore-export"
                let cellData = cell.innerText;

                // Check the column name for "Phone" to skip comma formatting
                const isPhoneColumn = headers[index].v.toLowerCase().includes("phone");

                if (!isNaN(cellData.replace(/,/g, '')) && !isPhoneColumn) {
                    // Format numbers with commas as strings if not in the phone column
                    cellData = Number(cellData.replace(/,/g, '')).toLocaleString();
                }
                rowData.push({ v: cellData });
            }
        });
        data.push(rowData);
    });

    // Convert to worksheet and add to workbook
    const worksheet = XLSX.utils.aoa_to_sheet(data);
    XLSX.utils.book_append_sheet(workbook, worksheet, tableId);

    // Export to Excel file
    XLSX.writeFile(workbook, `${tableId}_data.xlsx`);
}
