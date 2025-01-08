var companyId = localStorage.getItem('company_id');

$(document).ready(function() {
    // Function to convert a number string with commas into a float
    function parseNumberWithCommas(numberString) {
        return parseFloat(numberString.replace(/,/g, ''));
    }

    // Function to format a number with commas as thousand separators
    function formatNumberWithCommas(number) {
        return number.toLocaleString();
    }

    // Function to add a transaction to the income/outcome list
    function addTransactionToList(containerId, transaction, type) {
        const arrow = type === 'income' 
            ? '<i class="fa-solid fa-arrow-right text-success me-2"></i>' 
            : '<i class="fa-solid fa-arrow-left text-danger me-2"></i>';
        const typeLabel = type === 'income' 
            ? '<span class="text-success me-3">Income</span>' 
            : '<span class="text-danger me-3">Expense</span>';
        
        const amountClass = type === 'income' ? 'text-success' : 'text-danger'; // Class for amount color

        const transactionHTML = `
            <div class="transaction-item d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center">
                    ${arrow}
                    ${typeLabel}
                </div>
                <span class="transaction-amount text-center ${amountClass}">${formatNumberWithCommas(transaction.amount)}</span>
                <span class="transaction-date">${transaction.due_date}</span>
            </div>`;
        $(containerId).append(transactionHTML);
    }

    // Fetch balance and last 15 transactions (income/outcome)
    fetch(`api/${companyId}/today-summary`)
        .then(response => response.json())
        .then(data => {
            $('#balance').text(formatNumberWithCommas(data.balance));

            // Display last income transactions
            $('#lastIncomeTransactions').empty();  // Clear before adding
            data.lastIncomeTransactions.forEach(transaction => {
                addTransactionToList('#lastIncomeTransactions', transaction, 'income');
            });

            // Display last outcome transactions
            $('#lastOutcomeTransactions').empty();  // Clear before adding
            data.lastOutcomeTransactions.forEach(transaction => {
                addTransactionToList('#lastOutcomeTransactions', transaction, 'outcome');
            });
        });

    // Fetch total income data
    fetch(`api/${companyId}/incomes`)
        .then(response => response.json())
        .then(data => {
            const totalIncome = data.totalIncomes;
            $('#totalIncome').text(formatNumberWithCommas(totalIncome));
            updateNetIncome(parseNumberWithCommas(totalIncome), parseNumberWithCommas($('#totalExpenses').text()));
        });

    // Fetch total expenses data
    fetch(`api/${companyId}/outcomes`)
        .then(response => response.json())
        .then(data => {
            const totalExpenses = data.totalExpenses;
            $('#totalExpenses').text(formatNumberWithCommas(totalExpenses));
            updateNetIncome(parseNumberWithCommas($('#totalIncome').text()), parseNumberWithCommas(totalExpenses));
        });

    function updateNetIncome(totalIncome, totalExpenses) {
        const netIncome = totalIncome - totalExpenses;
        $('#netIncome').text(formatNumberWithCommas(netIncome));
    }
});
