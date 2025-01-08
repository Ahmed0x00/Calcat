<!-- Add Contractor Modal -->
<div class="modal fade" id="addContractorModal" tabindex="-1" aria-labelledby="addContractorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContractorModalLabel">Add Contractor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addContractorForm">
                    <div class="mb-3">
                        <label id="contractorFormNameLabel" for="contractorName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="contractorName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label id="contractorFormPhoneLabel" for="contractorPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="contractorPhone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label id="contractorFormTypeLabel" for="contractorType" class="form-label">Type</label>
                        <input type="text" class="form-control" id="contractorType" name="type">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveContractorButton">Save Contractor</button>
            </div>
        </div>
    </div>
</div>

<!-- Alert Container -->
<div id="alertContainer"></div>
