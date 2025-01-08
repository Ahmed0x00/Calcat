<!-- Modal for creating or editing a resource -->
<div class="modal fade" id="resourceModal" tabindex="-1" aria-labelledby="resourceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="resourceForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="resourceModalLabel">Add Resource</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="resourceId">
                    <div class="mb-3">
                        <label for="resourceName" class="form-label" id="labelResourceName">Name</label>
                        <input type="text" class="form-control" id="resourceName" required>
                    </div>
                    <div class="mb-3">
                        <label for="resourceQuantity" class="form-label" id="labelResourceQuantity">Quantity</label>
                        <input type="text" class="form-control" id="resourceQuantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="resourcePrice" class="form-label" id="labelResourcePrice">Price</label>
                        <input type="text" class="form-control" id="resourcePrice" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeResourceModalButton" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveResourceButton">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Alert Container for Form Feedback -->
<div id="alertContainer" class="container my-3"></div>