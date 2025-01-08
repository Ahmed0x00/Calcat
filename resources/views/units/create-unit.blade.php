<!-- Modal -->
<div class="modal fade" id="unitModal" tabindex="-1" aria-labelledby="unitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="unitForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="unitModalLabel">Add Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="unitId">
                    <div class="mb-3">
                        <label for="unitCode" class="form-label" id="labelUnitCode">Code</label>
                        <input type="text" class="form-control" id="unitCode" required>
                    </div>
                    <div class="mb-3">
                        <label for="unitArea" class="form-label" id="labelUnitArea">Area</label>
                        <input type="text" class="form-control" id="unitArea" required>
                    </div>
                    <div class="mb-3">
                        <label for="unitPrice" class="form-label" id="labelUnitPrice">Price</label>
                        <input type="text" class="form-control" id="unitPrice" required>
                    </div>
                    <div class="mb-3">
                        <label for="unitSite" class="form-label" id="labelUnitSite">Site</label>
                        <input type="text" class="form-control" id="unitSite">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCloseUnit">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveUnitButton">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Alert Container for Form Feedback -->
<div id="alertContainer" class="container my-3"></div>
