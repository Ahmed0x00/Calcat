@if ($showSearch ?? false)
    <div class="input-group mb-3 w-25">
        <span class="input-group-text">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input type="text" class="form-control search-input" id="searchInput"
            placeholder="{{ $searchPlaceholder ?? 'Search' }}" aria-label="Search">
    </div>
@endif

<div class="custom-table table-scrollable">
    <table class="table table-hover text-center" id="{{ $tableId ?? 'dynamicTable' }}">
        <thead class="table-dark">
            <tr>
                @foreach ($columns as $column)
                    <th id="{{ $column['id'] }}">{{ $column['name'] }}</th>
                @endforeach
                <th id="actionsHeader" data-ignore-export="true">Actions</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <!-- Dynamic rows will be inserted here -->
        </tbody>
    </table>
</div>

<div class="text-end mt-3">
    <button class="btn btn-outline-dark add-btn">
        <i class="fa-solid fa-plus"></i> <span id="addButtonLabel">Add</span>
    </button>
    <button class="btn btn-outline-dark ms-3 export-btn">
        <i class="fa-solid fa-download"></i> <span id="exportButtonLabel">Export</span>
    </button>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="js/table.js"></script>
