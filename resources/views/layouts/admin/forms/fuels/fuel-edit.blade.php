<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="editModalLabel">Edit Fuel Data</h3>
                <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="{{ route('fuel-totals.update', $fuelTotal->id ?? '') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" id="productName" name="product_name" class="form-control" value="{{ old('product_name', $fuelTotal->product_name ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" step="0.01" value="{{ old('quantity', $fuelTotal->quantity ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="unitPrice" class="form-label">Unit Price</label>
                        <input type="number" id="unitPrice" name="unit_price" class="form-control" step="0.01" value="{{ old('unit_price', $fuelTotal->unit_price ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="3" required>{{ old('description', $fuelTotal->description ?? '') }}</textarea>
                    </div>

                    <div class="mb-3 text-center">
                        <button type="submit" id="saveButton" class="btn btn-success" style="height: 60px; width: 100%;">
                            <i class="fas fa-save me-2"></i> Save Changes
                        </button>
                    </div>

                    <div id="successMessage" class="text-center d-none">
                        <p class="mt-2 text-success">Data updated successfully!</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>