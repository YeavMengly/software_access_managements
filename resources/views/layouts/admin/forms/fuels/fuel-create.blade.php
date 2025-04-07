@extends('layouts.master')

@section('form-fuel-upload')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-between align-items-center margin-tb mb-4">
                    <a class="btn btn-danger" href="{{ route('back') }}"
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
                    <h3 class="card-title text-center mt-4" style="font-weight: 500;">បង្កើតទិន្នន័យប្រេងឥន្ធនៈ</h3>
                    <div class="card-body px-5 py-4">
                        {{-- <form action="{{ route('fuels.store') }}" method="POST" enctype="multipart/form-data"
                            onsubmit="validateForm(event)">
                            @csrf
                            <div class="row g-3">
                                <!-- Left Column -->
                                <div class="col-md-12">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for=""><strong>កាលបរិច្ឆេទ:</strong></label>
                                                <input type="date" name="" id="" class="form-control"
                                                    style="height: 40px; width: 100%;">
                                                @error('')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for=""><strong>បញ្ចេញ:</strong></label>
                                                <input type="number" name="" id="" class="form-control"
                                                    style="height: 40px; width: 100%;" min="0">
                                                @error('')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for=""><strong>លេខប័ណ្ណបញ្ចេញ:</strong></label>
                                                <input type="text" name="" id="" class="form-control"
                                                    style="height: 40px; width: 100%;">
                                                @error('')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for=""><strong>បរិយាយ:</strong></label>
                                                <textarea class="form-control" name="" id="" cols="30" rows="6"
                                                    style=" text-align: left; width: 100%;" placeholder="សូមបញ្ចូលបរិយាយ..."></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6 d-flex">
                                            <div id="dynamic-field-container">
                                                <div class="row" id="dynamic-row-1">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for=""><strong>ប្រភេទប្រេង:</strong></label>
                                                            <input type="text" name="oil_type[]" class="form-control"
                                                                style="height: 40px; width: 100%;">
                                                            @error('oil_type')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for=""><strong>បញ្ចេញ:</strong></label>
                                                            <input type="text" name="quantity[]" class="form-control"
                                                                style="height: 40px; width: 100%;">
                                                            @error('quantity')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-success" id="add-row"><i
                                                            class="fas fa-plus"></i> បន្ថែម</button>
                                                    <button type="button" class="btn btn-danger" id="remove-row"><i
                                                            class="fas fa-trash"></i> លុប</button>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <!-- Buttons to add and remove rows -->

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
                        </form> --}}
                        <form action="{{ route('fuels.store') }}" method="POST" enctype="multipart/form-data"
                            onsubmit="validateForm(event)">
                            @csrf
                            <div class="row g-3">
                                <!-- Left Column -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fuel_date"><strong>ស្តុកប្រេង:</strong></label>
                                        <select name="fuel_id" id="fuel_id" class="form-control" style="height: 40px;">
                                            <option value="">-- ជ្រើសរើសកាលបរិច្ឆេទ --</option>
                                
                                            @foreach ($fuelData as $fuel)
                                                <option value="{{ $fuel->id }}">
                                                    {{ $fuel->warehouse_entry_number }} - {{ $fuel->release_date }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                            style=" text-align: left; width: 100%;" placeholder="សូមបញ្ចូលបរិយាយ..."></textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column (Dynamic Fields) -->
                                <div class="col-md-4">
                                    <div id="dynamic-field-container">
                                        <div class="row" id="dynamic-row-1">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="oil_type"><strong>ប្រភេទប្រេង:</strong></label>
                                                    <select name="oil_type[]" class="form-control"
                                                        style="height: 40px; width: 100%;">
                                                        <option value="" disabled selected>ជ្រើសរើសប្រភេទប្រេង
                                                        </option>
                                                        @foreach ($fuelTags as $fuelTag)
                                                            <option value="{{ $fuelTag->fuel_tag }}"
                                                                style="text-align: start;"> {{ $fuelTag->fuel_tag }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('oil_type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><strong>បញ្ចេញ:</strong></label>
                                                    <input type="text" name="quantity[]" class="form-control"
                                                        style="height: 40px; width: 100%;">
                                                    @error('quantity')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-success" id="add-row"><i
                                                class="fas fa-plus"></i> បន្ថែម</button>
                                        <button type="button" class="btn btn-danger" id="remove-row"><i
                                                class="fas fa-trash"></i> លុប</button>
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
        // Filter options as user types in the search input
        function filterOptions() {
            var input = document.getElementById("searchInput").value.toLowerCase();
            var select = document.getElementById("usageUnitWaterSelect");
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
            var selectElement = document.getElementById("usageUnitWaterSelect");
            var selectedOption = selectElement.options[selectElement.selectedIndex];

            if (selectedOption) {
                // Get the full text (location_number | title_usage_unit) and set it to the input
                document.getElementById("searchInput").value = selectedOption.getAttribute("data-full-text");
            }
        }
    </script>
    <script>
        let rowCount = 1; // Track the row count

        // Add row function
        document.getElementById('add-row').addEventListener('click', function() {
            rowCount++;
            let newRow = document.createElement('div');
            newRow.classList.add('row');
            newRow.setAttribute('id', 'dynamic-row-' + rowCount);

            newRow.innerHTML = `
            <div class="col-md-6">
                <div class="form-group">
                    <label for="oil_type"><strong>ប្រភេទប្រេង:</strong></label>
                        <select name="oil_type[]" class="form-control" style="height: 40px; width: 100%;">
                            <option value="" disabled selected>ជ្រើសរើសប្រភេទប្រេង</option>
                            @foreach ($fuelTags as $fuelTag)
                                <option value="{{ $fuelTag->fuel_tag }}" style="text-align: start;"> {{ $fuelTag->fuel_tag }}</option>
                            @endforeach
                        </select>
                        @error('oil_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for=""><strong>បញ្ចេញ:</strong></label>
                    <input type="text" name="quantity[]" class="form-control"
                        style="height: 40px; width: 100%;">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        `;
            document.getElementById('dynamic-field-container').appendChild(newRow);
        });

        // Remove row function
        document.getElementById('remove-row').addEventListener('click', function() {
            if (rowCount > 1) {
                let rowToRemove = document.getElementById('dynamic-row-' + rowCount);
                rowToRemove.remove();
                rowCount--;
            }
        });
    </script>
@endsection
