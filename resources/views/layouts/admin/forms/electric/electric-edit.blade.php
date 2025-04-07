@extends('layouts.master')

@section('form-electric-edit')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-between align-items-center margin-tb mb-4">
                    <a class="btn btn-danger" href="{{ route('electrics.index') }}"
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
                    <h3 class="card-title text-center mt-4" style="font-weight: 500;">បង្កើតទិន្នន័យឥណទានថាមពលអគ្គិសនី</h3>
                    <div class="card-body px-5 py-4">
                        <form action="{{ route('electrics.update', $electric->id) }}" method="POST"
                            enctype="multipart/form-data" onsubmit="validateForm(event)">
                            @csrf
                            @method('PUT') <!-- Method for updating -->
                            <div class="row g-3">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="searchUsageUnit"><strong>អង្គភាពប្រើប្រាស់:</strong></label>
                                        <input type="text" class="form-control text-start"
                                            placeholder="ស្វែងរកអង្គភាពប្រើប្រាស់..." id="searchInput"
                                            value="{{ old('title_usage_unit', ($electric->location_number ?? '') . ' | ' . ($electric->usage_unit ?? '')) }}"
                                            oninput="filterOptions()" style="height: 40px; width: 100%;">

                                        <p id="resultCount" class="font-weight-bold mt-2">ចំនួន: 0</p>

                                        <select name="usage_unit" id="usageUnitSelect" class="form-control" size="5"
                                            style="height: 130px; overflow-x: auto; white-space: nowrap; text-align: start;"
                                            onclick="getSelectedValue()">
                                            @foreach ($titleUsageUnits as $titleUsageUnit)
                                                <option value="{{ $titleUsageUnit->title_usage_unit }}"
                                                    data-full-text="{{ $titleUsageUnit->location_number }} | {{ $titleUsageUnit->title_usage_unit }}"
                                                    {{ old('usage_unit', $electric->usage_unit) == $titleUsageUnit->title_usage_unit ? 'selected' : '' }}>
                                                    {{ $titleUsageUnit->location_number }} |
                                                    {{ $titleUsageUnit->title_usage_unit }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('usage_unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="usage_start"><strong>រយៈពេលចាប់ផ្ដើមប្រើប្រាស់:</strong></label>
                                                <input type="date" name="usage_start" id="usage_start"
                                                    value="{{ $electric->usage_start }}" class="form-control"
                                                    style="height: 40px; width: 100%;">
                                                @error('usage_start')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="usage_end"><strong>រយៈពេលបញ្ចប់ប្រើប្រាស់:</strong></label>
                                                <input type="date" name="usage_end" id="usage_end"
                                                    value="{{ $electric->usage_end }}" class="form-control"
                                                    style="height: 40px; width: 100%;">
                                                @error('usage_end')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="usage_date"><strong>កាលបរិច្ឆេទ:</strong></label>
                                                <input type="date" name="usage_date" id="usage_date"
                                                    value="{{ $electric->usage_date }}" class="form-control"
                                                    style="height: 40px; width: 100%;">
                                                @error('usage_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kilowatt_energy"><strong>ថាមពលគីឡូវ៉ាត់:</strong></label>
                                                <input type="number" name="kilowatt_energy" id="kilowatt_energy"
                                                    value="{{ $electric->kilowatt_energy }}" class="form-control"
                                                    style="height: 40px; width: 100%;" min="0">
                                                @error('kilowatt_energy')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="reactive_energy"><strong>ថាមពលរ៉េអាក់ទិក:</strong></label>
                                                <input type="number" name="reactive_energy" id="reactive_energy"
                                                    value="{{ $electric->reactive_energy }}" class="form-control"
                                                    style="height: 40px; width: 100%;" min="0">
                                                @error('reactive_energy')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="total_amount"><strong>ប្រាក់សរុបជារៀល:</strong></label>
                                                <input type="number" name="total_amount" id="total_amount"
                                                    value="{{ $electric->total_amount }}" class="form-control"
                                                    style="height: 40px; width: 100%;" min="0">
                                                @error('total_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
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
            /* Auto adjust height */
            width: 230px;
            white-space: normal;
            /* Allow text to wrap */
            word-wrap: break-word;
            /* Break long words if necessary */
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
            /* Adjust as necessary */
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
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#subAccountKeySelect').select2({
                placeholder: "ស្វែងរកអង្គភាពប្រើប្រាស់",
                allowClear: true,
                width: '230px'
            });
        });
    </script>

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
        function filterOptions() {
            let input = document.getElementById('searchInput').value.toLowerCase();
            let select = document.getElementById('usageUnitSelect');
            let options = select.getElementsByTagName('option');
            let count = 0;

            for (let option of options) {
                let text = option.dataset.fullText.toLowerCase();
                if (text.includes(input)) {
                    option.style.display = "";
                    count++;
                } else {
                    option.style.display = "none";
                }
            }

            document.getElementById('resultCount').innerText = "ចំនួន: " + count;
        }

        function getSelectedValue() {
            let select = document.getElementById('usageUnitSelect');
            let input = document.getElementById('searchInput');
            let selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                let fullText = selectedOption.dataset.fullText; // Get full text
                input.value = fullText; // Set both values in input
            }
        }
    </script>
@endsection
