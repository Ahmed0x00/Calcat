$(document).ready(() => {
    const companyId = localStorage.getItem("company_id");
    const transactionTableBody = $("#tableBody");
    let currentFilter = "all"; // Track the current filter type
    let selectedDate = null;
    let unpaidFilter = "none"; // Track the unpaid filter type

    // Determine language
    const language = localStorage.getItem("language") || "en";

    // Translations
    const translations = {
        en: {
            income: "Income",
            expense: "Expense",
            yes: "Yes",
            no: "No",
            delete: "Delete",
            invoice: "Invoice",
            updatePaidStatus: "Update Paid Status",
            unpaidToday: "Unpaid transactions today:",
            unpaidMonth: "Unpaid transactions for selected month:",
            unpaidTotal: "Total unpaid transactions:"
        },
        ar: {
            income: "دخل",
            expense: "مصروفات",
            yes: "نعم",
            no: "لا",
            delete: "حذف",
            invoice: "فاتورة",
            updatePaidStatus: "تحديث حالة الدفع",
            unpaidToday: "المعاملات غير المدفوعة اليوم:",
            unpaidMonth: "المعاملات غير المدفوعة للشهر المحدد:",
            unpaidTotal: "إجمالي المعاملات غير المدفوعة:"
        }
    };

    const t = translations[language]; // Get translations based on the current language

    const fetchTransactions = (type = "all", date = null, unpaid = "none") => {
        $.ajax({
            url: `/api/${companyId}/transactions`, // Replace companyId dynamically
            method: "GET",
            success: (data) => {
                let transactions = data.transactions;
    
                // Filter by type (income or outcome)
                if (type === "income" || type === "outcome") {
                    transactions = transactions.filter(
                        (transaction) => transaction.type_of_trans === type
                    );
                }
    
                // Filter by specific date if provided
                if (date) {
                    transactions = transactions.filter(
                        (transaction) => transaction.due_date === date
                    );
                }
    
                // Filter by unpaid status
                if (unpaid === "today") {
                    const today = new Date().toISOString().split("T")[0];
                    transactions = transactions.filter(
                        (transaction) =>
                            !transaction.paid && transaction.due_date === today
                    );
    
                    // Update unpaid count display for today
                    const unpaidTodayCount = transactions.length;
                    $("#unpaidCountLabel").text(
                        `${t.unpaidToday} ${unpaidTodayCount}`
                    );
                } else if (unpaid === "month") {
                    const selectedMonth = parseInt($("#unpaidMonthFilter").val(), 10);
                    transactions = transactions.filter((transaction) => {
                        const transactionDate = new Date(transaction.due_date);
                        return (
                            !transaction.paid &&
                            transactionDate.getMonth() + 1 === selectedMonth
                        );
                    });
    
                    const unpaidMonthCount = transactions.length;
                    $("#unpaidCountLabel").text(
                        `${t.unpaidMonth} ${unpaidMonthCount}`
                    );
                } else {
                    const totalUnpaidCount = transactions.filter(
                        (transaction) => !transaction.paid
                    ).length;
                    $("#unpaidCountLabel").text(
                        `${t.unpaidTotal} ${totalUnpaidCount}`
                    );
                }
    
                // Display filtered transactions in the table
                displayTransactions(transactions);
            },
            error: (xhr, status, error) => {
                console.error("Error fetching transactions:", error);
                displayAlert("Failed to fetch transactions. Please try again.", "danger");
            },
        });
    };

    const displayTransactions = (transactions) => {
        transactionTableBody.empty();

        transactions.forEach((transaction) => {
            const isIncome = transaction.type_of_trans === "income";
            const rowClass = isIncome ? "table-success" : "table-danger";
            const arrowIcon = isIncome
                ? `<i class="fa-solid fa-arrow-right" style="color: green;"></i>`
                : `<i class="fa-solid fa-arrow-left" style="color: red;"></i>`;
            const amountColor = isIncome ? "text-success" : "text-danger";
            const paidStatus = transaction.paid ? t.yes : t.no; // Translate paid status

            const row = $(`
                <tr class="${rowClass}">
                    <td>${isIncome ? t.income : t.expense}</td>
                    <td>${arrowIcon} <span class="${amountColor}">${formatAmount(
                Math.floor(transaction.amount)
            )}</span></td>
                    <td>${transaction.details || "N/A"}</td>
                    <td>${transaction.type}</td>
                    <td>${transaction.name || "N/A"}</td>
                    <td>${transaction.phone || "N/A"}</td>
                    <td>${transaction.due_date}</td>
                    <td>${paidStatus}</td> <!-- Display translated paid status -->
                    <td>
                        <button style="font-size: 1rem; padding: 8px 10px;" class="btn btn-danger btn-lg delete-btn" data-id="${
                            transaction.id
                        }">
                            <i class="fa-solid fa-trash"></i> ${t.delete}
                        </button>
                        <button style="font-size: 1rem; padding: 8px 10px;" class="btn btn-secondary btn-lg invoice-btn" data-id="${
                            transaction.id
                        }">
                            <i class="fa-solid fa-file-invoice"></i> ${t.invoice}
                        </button>
                        <button style="font-size: 1rem; padding: 8px 10px;" class="btn btn-primary btn-lg paid-btn" data-id="${
                            transaction.transaction_id
                        }">
                            ${t.updatePaidStatus}
                        </button>
                    </td>
                </tr>
            `);

            transactionTableBody.append(row);
        });
    };

    // Fetch transactions with the initial filter
    const urlParams = new URLSearchParams(window.location.search);
    const initialFilterType = urlParams.get("type") || "all";
    currentFilter = initialFilterType;
    fetchTransactions(currentFilter);

    // Add commas to amount as user types
    $("#amount").on("input", function () {
        let value = $(this)
            .val()
            .replace(/[^0-9.]/g, "");
        $(this).val(formatAmount(value));
    });

    const formatAmount = (amount) =>
        amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    // Update the date filter to trigger fetchTransactions on change
    $("#transactionDateFilter").on("change", function () {
        selectedDate = $(this).val(); // Get the selected date
        fetchTransactions(currentFilter, selectedDate); // Fetch transactions with the current filter and selected date
    });

    $("#unpaidFilter").on("change", function () {
        unpaidFilter = $(this).val();
    
        if (unpaidFilter === "month") {
            $("#unpaidMonthFilter").show(); // Show the month dropdown
        } else {
            $("#unpaidMonthFilter").hide(); // Hide the month dropdown
        }
    
        fetchTransactions(currentFilter, selectedDate, unpaidFilter);
    });
    
    $("#unpaidMonthFilter").on("change", function () {
        fetchTransactions(currentFilter, selectedDate, "month");
    });
    
    // Filter button event listeners
    $(".filter-btn").on("click", function () {
        $(".filter-btn").removeClass("active");
        $(this).addClass("active");
        currentFilter =
            $(this).data("filter") === "expense"
                ? "outcome"
                : $(this).data("filter");
        fetchTransactions(currentFilter);
    });

    // Delete and invoice actions
    transactionTableBody.on("click", ".delete-btn", async function () {
        const transactionId = $(this).data("id");
        if (confirm("Are you really want to delete this transaction?")) {
            await deleteTransaction(transactionId);
            fetchTransactions(currentFilter); // Use the current filter to refresh the list
        }
    });

    transactionTableBody.on("click", ".invoice-btn", function () {
        const transactionId = $(this).data("id");
        // Code to handle invoice action here
    });

    // Mark as Paid
    transactionTableBody.on('click', '.paid-btn', function () {
        const transactionId = $(this).data('id');
        updatePaidStatus(transactionId);
    });

    const updatePaidStatus = (transactionId) => {
        $.ajax({
            url: `/api/${companyId}/transactions/${transactionId}/update-paid`,
            method: 'GET',
            success: (data) => {
                if (data.message === 'Transaction marked as paid successfully') {
                    displayAlert('Transaction marked as paid successfully', 'success');
                    fetchTransactions(currentFilter, selectedDate, unpaidFilter);
                } else if (data.error) {
                    displayAlert(data.error, 'warning'); // Handle the "already paid" case
                } else {
                    displayAlert('Unexpected response from server', 'danger');
                }
            },
            error: (xhr, status, error) => {
                displayAlert('Error updating paid status', 'danger');
            }
        });
    };
    

    // Delete transaction function
    const deleteTransaction = (transactionId) => {
        return $.ajax({
            url: `/api/${companyId}/transactions/${transactionId}`,
            method: "DELETE",
            success: (data) => {
                if (data.message === "Transaction deleted successfully") {
                    displayAlert("Transaction deleted successfully", "success");
                } else {
                    console.error("Error deleting transaction:", data.message);
                }
            },
            error: (xhr, status, error) => {
                displayAlert("Error deleting transaction", "danger");
            },
        });
    };

    $(document).on("click", ".add-btn", () => {
        $("#addTransactionModal").modal("show");
    });

    const addTransaction = () => {
        const amount = $("#amount").val().replace(/,/g, "");
        const type_of_trans = $("#transactionType").val();
        const details = $("#details").val();
        const type = $("#type").val();
        const name = $("#clientName").val();
        const phone = $("#clientPhone").val();
        const date = $("#transactionDate").val(); // Get the date from the input field

        // Prepare the data to send, only include date if it's provided
        const data = {
            amount,
            details,
            type,
            name,
            phone,
        };

        // Add date only if it's provided
        if (date) {
            data.date = date;
        }

        const endpoint =
            type_of_trans === "income"
                ? `/api/${companyId}/transactions/income`
                : `/api/${companyId}/transactions/outcome`;

        $.ajax({
            url: endpoint,
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: (data) => {
                const successMessage = data.message;
                if (
                    successMessage ===
                        "Income transaction created successfully" ||
                    successMessage ===
                        "Outcome transaction created successfully"
                ) {
                    $("#addTransactionModal").modal("hide");
                    displayAlert(successMessage, "success");
                    fetchTransactions(currentFilter); // Refresh transactions using the current filter
                } else {
                    displayAlert("Error adding transaction", "danger");
                    console.error("Error adding transaction:", successMessage);
                }
            },
            error: (xhr, status, error) => {
                displayAlert("Error adding transaction", "danger");
                console.error("Error adding transaction:", error);
            },
        });
    };

    $("#saveTransactionBtn").on("click", function () {
        addTransaction();
    });
});
