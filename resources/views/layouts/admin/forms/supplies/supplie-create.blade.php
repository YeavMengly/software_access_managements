@extends('layouts.master')

@section('form-supplie-upload')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-between align-items-center margin-tb mb-4">
                    <a class="btn btn-danger" href="{{ route('supplies.index') }}"
                        style="width: 120px; height: 40px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success text-center">
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div id="loading-spinner" class="text-center" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p>កំពុងរក្សាទុក... សូមរង់ចាំ</p>
            </div>

            <div class="d-flex justify-content-center align-items-center">
                <div class="card shadow-lg" style="width: 70%;">
                    <h3 class="card-title text-center mt-4" style="font-weight: 500;">បង្កើតទិន្នន័យសម្ភារៈ</h3>
                    <div class="card-body px-5 py-4">

                        <form action="{{ route('supplies.store') }}" method="POST" enctype="multipart/form-data"
                            onsubmit="validateForm(event)">
                            @csrf
                            <div class="row g-3">
                                <!-- Left Column -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fuel_date"><strong>ស្តុកសម្ភារៈ :</strong></label>

                                        <select id="supplie_id" name="supplie_id" class="form-control" style="height: 40px;"
                                            required onclick="getSelectedValue()">
                                            <option style="text-align: left;" value="">-- ជ្រើសរើសកាលបរិច្ឆេទ --
                                            </option>
                                            @foreach ($totalSupplie as $ts)
                                                <option value="{{ $ts->release_date }}">{{ $ts->release_date }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplie_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for=""><strong>កាលបរិច្ឆេទ:</strong></label>
                                        <input type="date" name="date" id="date" class="form-control"
                                            style="height: 40px; width: 100%;">
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Middle Column -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for=""><strong>លេខប័ណ្ណបញ្ចេញ:</strong></label>
                                        <input type="text" name="receipt_number" id="receipt_number" class="form-control"
                                            style="height: 40px; width: 100%;">
                                        @error('receipt_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for=""><strong>បរិយាយ:</strong></label>
                                        <textarea class="form-control" name="description" id="description" cols="30" rows="6"
                                            style="text-align: left; width: 100%;" placeholder="សូមបញ្ចូលបរិយាយ..."></textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column (Dynamic Fields) -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="quantity">បរិមាណ</label>
                                        <input type="text" class="form-control" name="quantity_used" id="quantity_used"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="unit">ឯកតា</label>
                                        <input type="text" class="form-control" name="unit" id="unit" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons Row -->
                            <div class="row justify-content-center mt-4">
                                <div class="col-12 text-center">
                                    <button type="reset" class="btn btn-secondary">
                                        <i class="fas fa-undo"></i>&nbsp;&nbsp;កំណត់ឡើងវិញ
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-3">
                                        <i class="fas fa-save"></i>&nbsp;&nbsp;រក្សាទុក
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .border-wrapper {
            padding-left: 16px;
            padding-right: 16px;
        }

        #subAccountKeySelect {
            text-align: left;
        }

        h3 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
        }

        .form-control,
        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 6px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
        }

        select {
            height: auto;
            width: 230px;
            white-space: normal;
            word-wrap: break-word;
        }

        #searchInput:hover::after {
            content: attr(title);
            position: absolute;
            background-color: #333;
            color: white;
            border-radius: 5px;
            padding: 5px;
            font-size: 12px;
            top: 50px;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
        }

        /* Hide number input arrows in Chrome, Safari, Edge, and Opera */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Hide number input arrows in Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <style>
        /* Style the closed select box */
        .select2-container .select2-selection--single {
            height: 40px !important;
            border: 1px solid black !important;
            display: flex;
            align-items: center;
        }

        /* Fix height and border */
        .select2-container--default .select2-selection--single {
            height: 40px !important;
            border: 1px solid black !important;
        }

        /* Align text vertically */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px !important;
            color: black !important;
            /* Text & placeholder in black */
        }

        /* Adjust dropdown arrow */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }

        /* Clear button (x) alignment fix */
        .select2-selection__clear {

            float: right;
            margin-right: 10px;
        }

        /* Style the dropdown options */
        .select2-results__option {
            height: 40px;
            display: flex;
            align-items: center;
            font-size: 14px;
            border-bottom: 1px solid black;
        }

        /* Optional: last option without bottom border */
        .select2-results__option:last-child {
            border-bottom: none;
        }

        /* Style the rendered text inside the select box */
        .select2-selection__rendered {
            line-height: 40px !important;

            color: #000;
            padding-right: 30px !important;
        }

        /* Arrow alignment */
        .select2-selection__arrow {
            height: 100% !important;
        }

        /* Dropdown container */
        .select2-dropdown {
            border: 1px solid black !important;
        }

        /* Make placeholder text black */
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: black !important;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
        }

        /* Make the clear (x) icon always visible when value is selected */
        .select2-container--default .select2-selection--single .select2-selection__clear {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: red;
            cursor: pointer;
            display: block;
            z-index: 10;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery (Required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        function validateForm(event) {
            event.preventDefault(); // Prevent default form submission

            // Show the loading spinner
            document.getElementById('loading-spinner').style.display = 'block';

            // Disable the submit button to prevent double submission
            document.querySelector('button[type="submit"]').disabled = true;

            // Submit the form immediately
            event.target.submit();
        }
    </script>
    <script>
        // Filter options as user types in the search input
        function filterOptions() {
            var input = document.getElementById("searchInput").value.toLowerCase();
            var select = document.getElementById("supplie_id");
            var options = select.getElementsByTagName("option");
            var count = 0;

            for (var i = 0; i < options.length; i++) {
                var optionText = options[i].textContent.toLowerCase();
                // Show options that match the search input
                if (optionText.includes(input)) {
                    options[i].style.display = "";
                    count++;
                } else {
                    options[i].style.display = "none";
                }
            }
            // Update result count
            document.getElementById("resultCount").innerText = "ចំនួន: " + count;
        }

        // Populate the input field with the selected value when an option is clicked
        function getSelectedValue() {
            var selectElement = document.getElementById("supplie_id");
            var selectedOption = selectElement.options[selectElement.selectedIndex];

            if (selectedOption) {
                // Get the full text (location_number | title_usage_unit) and set it to the input
                document.getElementById("searchInput").value = selectedOption.getAttribute("data-full-text");
            }
        }
    </script>

    {{-- Script for action search  --}}
    <script>
        $(document).ready(function() {
            $('#supplie_id').select2({
                placeholder: "-- ជ្រើសរើសកាលបរិច្ឆេទស្តុកសម្ភារៈ --",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
