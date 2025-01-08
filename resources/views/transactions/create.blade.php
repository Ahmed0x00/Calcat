<!-- Add Transaction Modal -->
<div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionModalLabel">Add Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="transactionForm">
                    <div class="mb-3">
                        <label for="transactionType" class="form-label" id="transactionTypeLabel">Transaction Type</label>
                        <select class="form-select" id="transactionType" name="transactionType" required>
                            <option value="income" id="incomeOption">Income</option>
                            <option value="outcome" id="outcomeOption">Outcome</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="transactionDate" class="form-label" id="transactionDateLabel">Transaction Date (Optional)</label>
                        <input type="date" class="form-control" id="transactionDate" name="transactionDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label" id="amountLabel">Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label" id="typeLabel">Type</label>
                        <input type="text" class="form-control" id="type" name="type" placeholder="e.g., Sale, Expense" required>
                    </div>
                    <div class="mb-3">
                        <label for="clientName" class="form-label" id="clientNameLabel">Client/Contractor Name</label>
                        <input type="text" class="form-control" id="clientName" name="clientName">
                    </div>
                    <div class="mb-3">
                        <label for="clientPhone" class="form-label" id="clientPhoneLabel">Client/Contractor Phone</label>
                        <input type="tel" class="form-control" id="clientPhone" name="clientPhone">
                    </div>
                    <div class="mb-3">
                        <label for="details" class="form-label" id="detailsLabel">Details</label>
                        <textarea class="form-control" id="details" name="details" rows="3" placeholder="Optional"></textarea>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelBtn">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveTransactionBtn">Save Transaction</button>
            </div>
        </div>
    </div>
</div>
