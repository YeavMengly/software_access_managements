@extends('layouts.master')

@section('content-total-supplie')
    <div class="border-wrapper">
        <div class="result-total-table-container">

            {{-- Modal Edit --}}
            <div class="modal fade" id="edit_supplie" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 50%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="importModalLabel">បង្កើតប្រេងឥន្ធនៈគ្រប់ប្រភេទ</h3>
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" style="color: red;"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center align-items-center" style="height: 40%;">
                                {{-- @if (isset($totalSupplie)) --}}
                                <form action="{{ route('supplie-totals.update', $totalSupplie->id) }}" method="POST"
                                    style="width:100%;" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- Company Info -->
                                    <div class="mb-3 align-items-center">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="company_name">ឈ្មោះក្រុមហ៊ុន</label>
                                                <input type="text" class="form-control" name="company_name"
                                                    id="company_name" value="{{ $totalSupplie->company_name }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="release_date">កាលបរិច្ឆេទបញ្ចូល</label>
                                                <input type="date" class="form-control" name="release_date"
                                                    id="release_date"
                                                    value="{{ \Carbon\Carbon::parse($totalSupplie->release_date)->format('Y-m-d') }}"
                                                    required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="warehouse">ឃ្លាំងប្រគល់</label>
                                                <input type="text" class="form-control" name="warehouse" id="warehouse"
                                                    value="{{ $totalSupplie->warehouse }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="description">អ្នកបញ្ចូល</label>
                                                <input type="text" class="form-control" name="description"
                                                    id="description" value="{{ $totalSupplie->description }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Refers and Products -->
                                    <div class="mb-3 align-items-center">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="refers">យោង</label>
                                                <textarea class="form-control w-100 mb-2" name="refers" id="refers" rows="3" placeholder="សូមបញ្ចូលយោង...">{{ old('refers', $totalSupplie->refers ?? '') }}</textarea>

                                                <label for="product_name">រាយមុខទំនិញ</label>
                                                <textarea class="form-control w-100" name="product_name" id="product_name" rows="5"
                                                    placeholder="សូមបញ្ចូលរាយមុខទំនិញ...">{{ old('product_name', $totalSupplie->product_name ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Item Info -->
                                    <div class="mb-3 align-items-center">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="unit">ឯកតា</label>
                                                <input type="text" class="form-control" name="unit" id="unit"
                                                    value="{{ $totalSupplie->unit }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="quantity">បរិមាណ</label>
                                                <input type="number" class="form-control" name="quantity" id="quantity"
                                                    value="{{ $totalSupplie->quantity }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="unit_price">តម្លៃឯកតា</label>
                                                <input type="number" step="any" class="form-control" name="unit_price"
                                                    id="unit_price" value="{{ $totalSupplie->unit_price }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="source">ប្រភព</label>
                                                <input type="text" class="form-control" name="source" id="source"
                                                    value="{{ $totalSupplie->source }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="production_year">ឆ្នាំផលិត</label>
                                                <input type="number" class="form-control" name="production_year"
                                                    id="production_year" value="{{ $totalSupplie->production_year }}"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="row justify-content-center mt-4">
                                        <div class="col-12 text-center">
                                            <button type="reset" class="btn btn-secondary">
                                                <i class="fas fa-undo"></i>&nbsp;&nbsp;កំណត់ឡើងវិញ
                                            </button>
                                            <button type="submit" class="btn btn-primary ms-3">
                                                <i class="fas fa-save"></i>&nbsp;&nbsp;រក្សាទុក
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                {{-- @endif --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
