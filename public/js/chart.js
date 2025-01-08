const companyId = localStorage.getItem('company_id');

// Update the Pie Chart with today's income and expenses
const updatePieChart = (income, expense) => {
    const incomeValue = income || 0;
    const expenseValue = expense || 0;

    // If both income and expense are zero, show a 50-50 chart
    const dataValues = incomeValue === 0 && expenseValue === 0 ? [1, 1] : [incomeValue, expenseValue];
    
    const pieData = {
        labels: ['Income', 'Expense'],
        datasets: [{
            data: dataValues,
            backgroundColor: ['#28a745', '#dc3545']
        }]
    };

    const ctxPie = document.getElementById('pieChart').getContext('2d');
    
    new Chart(ctxPie, {
        type: 'doughnut',
        data: pieData,
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: 'bottom' },
                tooltip: { enabled: true } // Enable tooltips for hover functionality
            },
            animation: {
                onComplete: function() {
                    const chart = this;
                    const ctx = chart.ctx;
                    ctx.font = "18px Arial";
                    ctx.textAlign = "center";
                    ctx.textBaseline = "middle";
                    ctx.fillStyle = "#ffffff"; // Text color for percentages

                    // Calculate total for percentage calculations
                    const total = dataValues.reduce((acc, val) => acc + val, 0);

                    // Loop through each segment to draw percentage
                    chart.data.datasets[0].data.forEach((value, index) => {
                        const percentage = ((value / total) * 100).toFixed(1) + '%';
                        const model = chart.getDatasetMeta(0).data[index];
                        const midRadius = (model.innerRadius + model.outerRadius) / 2;
                        const startAngle = model.startAngle;
                        const endAngle = model.endAngle;
                        const midAngle = startAngle + (endAngle - startAngle) / 2;

                        // Calculate coordinates for label
                        const x = midRadius * Math.cos(midAngle);
                        const y = midRadius * Math.sin(midAngle);

                        // Draw the percentage text
                        ctx.fillText(percentage, model.x + x, model.y + y);
                    });
                }
            }
        }
    });
};

// Fetch yearly data for bar chart
const fetchYearlySummary = () => {
    $.ajax({
        url: `/api/${companyId}/year-summary`,
        method: 'GET',
        success: (data) => {
            const labels = data.monthlySummary.map(item => item.month);
            const incomeData = data.monthlySummary.map(item => parseFloat(item.income.replace(/,/g, '')));
            const expenseData = data.monthlySummary.map(item => parseFloat(item.expenses.replace(/,/g, '')));
            const netIncomeData = data.monthlySummary.map(item => parseFloat(item.netIncome.replace(/,/g, '')));

            // Update the Bar Chart with yearly data
            updateBarChart(labels, incomeData, expenseData, netIncomeData);
        },
        error: (xhr, status, error) => {
            console.error('Error fetching year summary:', error);
        }
    });
};

// Update the Bar Chart with yearly data
const updateBarChart = (labels, incomeData, expenseData, netIncomeData) => {
    const ctxBar = document.getElementById('barChart').getContext('2d');
    
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                { label: 'Income', data: incomeData, backgroundColor: '#1cc88a' },
                { label: 'Expense', data: expenseData, backgroundColor: '#4e73df' },
                { label: 'Net', data: netIncomeData, backgroundColor: '#f6c23e' }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            }
        }
    });
};

// Initialize charts
fetchYearlySummary();
