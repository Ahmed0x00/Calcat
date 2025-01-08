$(document).ready(() => {
    const companyId = localStorage.getItem('company_id');

    const fetchTodaySummary = () => {
        $.ajax({
            url: `/api/${companyId}/today-summary`,
            method: 'GET',
            success: (data) => {
                $('#transactions-value').text(data.todayTransactions || 'N/A');
                $('#income-value').text(data.todayIncome || 'N/A');
                $('#expense-value').text(data.todayExpenses || 'N/A');

                // Update the Pie Chart with today’s income vs. expenses
                const income = parseFloat(data.todayIncome.replace(/,/g, '')) || 0;
                const expense = parseFloat(data.todayExpenses.replace(/,/g, '')) || 0;
                updatePieChart(income, expense);
            },
            error: (xhr, status, error) => {
                console.error('Error fetching today summary:', error);
            }
        });
    };

    fetchTodaySummary();
});
