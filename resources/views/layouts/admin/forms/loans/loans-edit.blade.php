@extends('layouts.master')

@section('form-content-loans-edit')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="row">
                <div class="col-lg-12 margin-tb mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="btn btn-danger d-flex justify-content-center align-items-center mr-2"
                            href="{{ route('loans.index') }}" style="width: 120px; height: 40px;"> <i
                                class="fas fa-arrow-left"></i> </a>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            @endif

            {{-- <div class="d-flex justify-content-center align-items-center  ">
                <div class="card shadow-lg w-65" style="max-width: 900px;">
                    <h3 class="card-title text-center mt-4" style="font-weight: 500;">បង្កើតទិន្នន័យ</h3>
                    <div class="card-body px-5 py-4">
                    <form action="{{ route('loans.update', $loan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 

                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3 d-flex flex-column align-items-center">
                                <!-- Report Key Input -->
                                <div class="form-group">
                                    <label for="searchReportKey"
                                        class="font-weight-bold"><strong>លេខកូដកម្មវិធី:</strong></label>
                                    <input type="text" id="searchReportKey" class="form-control"
                                        placeholder="ស្វែងរកលេខកូដ អនុគណនី​ នឹងកម្មវិធី..."
                                        onkeyup="filterReportKeys(event)"
                                        style="width: 230px; height: 40px; text-align: center;"
                                        oninput="resetReportKeySelection()">
                                    <p id="reportResultCount" style="font-weight: bold; margin-top: 8px;">ចំនួន: 0</p>

                                    <select name="report_key" id="reportKeySelect" class="form-control" size="5"
                                        onclick="getSelectedReportKey()"
                                        style="height: 260px; width: 230px; text-align: left;">
                                        @foreach ($reports as $report)
                                            <option value="{{ $report->id }}"
                                                {{ $report->id == $loan->report_key ? 'selected' : '' }}>
                                                {{ $report->subAccountKey->sub_account_key }} -
                                                {{ $report->report_key }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 d-flex flex-column align-items-center">
                                <div class="form-group">
                                    <label for="internal_increase"><strong>កើនផ្ទៃក្នុង:</strong></label>
                                    <input type="number" name="internal_increase" id="internal_increase"
                                        class="form-control @error('internal_increase') is-invalid @enderror"
                                        style="width: 230px; height: 40px;" min="0"
                                        value="{{ old('internal_increase', $loan->internal_increase) }}"
                                        oninput="formatNumber(this)">
                                    @error('internal_increase')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="unexpected_increase"><strong>មិនបានគ្រោងទុក:</strong></label>
                                    <input type="number" name="unexpected_increase" id="unexpected_increase"
                                        class="form-control @error('unexpected_increase') is-invalid @enderror"
                                        style="width: 230px; height: 40px;" min="0"
                                        value="{{ old('unexpected_increase', $loan->unexpected_increase) }}"
                                        oninput="formatNumber(this)">
                                    @error('unexpected_increase')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="additional_increase"><strong>បំពេញបន្ថែម:</strong></label>
                                    <input type="number" name="additional_increase" id="additional_increase"
                                        class="form-control @error('additional_increase') is-invalid @enderror"
                                        style="width: 230px; height: 40px;" min="0"
                                        value="{{ old('additional_increase', $loan->additional_increase) }}"
                                        oninput="formatNumber(this)">
                                    @error('additional_increase')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 d-flex flex-column align-items-center">
                                <div class="form-group">
                                    <label for="decrease"><strong>ថយ:</strong></label>
                                    <input type="number" name="decrease" id="decrease"
                                        class="form-control @error('decrease') is-invalid @enderror" min="0"
                                        style="width: 230px; height: 40px;" value="{{ old('decrease', $loan->decrease) }}"
                                        oninput="formatNumber(this)">
                                    @error('decrease')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="editorial"><strong>វិចារណកម្ម:</strong></label>
                                    <input type="number" name="editorial" id="editorial"
                                        class="form-control @error('editorial') is-invalid @enderror" min="0"
                                        style="width: 230px; height: 40px;"
                                        value="{{ old('editorial', $loan->editorial) }}" oninput="formatNumber(this)">
                                    @error('editorial')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-primary ml-auto" style="width: 300px; height: 60px;">
                                <i class="fas fa-save"></i> បានរក្សាទុក
                            </button>
                        </div>
                    </form>
                </div>
                </div>
            </div> --}}
            <div class="d-flex justify-content-center align-items-center  ">
                <div class="card shadow-lg w-65" style="max-width: 900px;">
                    <!-- Centered Card Title -->
                    <h3 class="card-title text-center mt-4" style="font-weight: 500;">បង្កើតទិន្នន័យ</h3>

                    <div class="card-body px-5 py-4">
                        <form action="{{ route('loans.update', $loan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <!-- Column 1 -->
                                <div class="col-md-4">
                                    {{-- <div class="form-group">
                                        <label for="searchReportKey"
                                            class="form-label"><strong>លេខកូដកម្មវិធី:</strong></label>
                                        <input type="text" id="searchReportKey" class="form-control"
                                            placeholder="ស្វែងរកលេខកូដ អនុគណនី​ នឹងកម្មវិធី..."
                                            onkeyup="filterReportKeys(event)" oninput="resetReportKeySelection()">
                                        <p id="reportResultCount" class="mt-2 font-weight-bold">ចំនួន: 0</p>
                                        <select name="report_key" id="reportKeySelect" class="form-control" size="5"
                                            onclick="getSelectedReportKey()">
                                            @foreach ($reports as $report)
                                                <option value="{{ $report->id }}">
                                                    {{ $report->subAccountKey->sub_account_key }} >
                                                    {{ $report->report_key }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="searchReportKey"
                                            class="font-weight-bold"><strong>លេខកូដកម្មវិធី:</strong></label>

                                        <!-- Input field for searching -->
                                        <input type="text" id="searchReportKey" class="form-control"
                                            placeholder="ស្វែងរកលេខកូដ អនុគណនី​ នឹងកម្មវិធី..."
                                            onkeyup="filterReportKeys(event)"
                                            style="width: 230px; height: 40px; text-align: center;"
                                            oninput="resetReportKeySelection()">

                                        <!-- Hidden input to store the selected report key value -->
                                        <input type="hidden" name="report_key" id="hiddenReportKeyInput"
                                            value="{{ $loan->report_key }}">

                                        <!-- Display the count of search results -->
                                        <p id="reportResultCount" style="font-weight: bold; margin-top: 8px;">ចំនួន: 0</p>

                                        <!-- Dropdown for selecting the report -->
                                        <select id="reportKeySelect" class="form-control" size="5"
                                            onclick="getSelectedReportKey()"
                                            style="height: 120px; width: 230px; text-align: left; ">
                                            @foreach ($reports as $report)
                                                <option value="{{ $report->id }}"
                                                    {{ $report->id == $loan->report_key ? 'selected' : '' }}>
                                                    {{ $report->subAccountKey->sub_account_key }} >
                                                    {{ $report->report_key }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Column 2 -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="internal_increase"><strong>កើនផ្ទៃក្នុង:</strong></label>
                                        <input type="number" name="internal_increase" id="internal_increase"
                                            class="form-control @error('internal_increase') is-invalid @enderror"
                                            style="width: 230px; height: 40px;" min="0"
                                            value="{{ old('internal_increase', $loan->internal_increase) }}"
                                            oninput="formatNumber(this)">
                                        @error('internal_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="unexpected_increase"><strong>មិនបានគ្រោងទុក:</strong></label>
                                        <input type="number" name="unexpected_increase" id="unexpected_increase"
                                            class="form-control @error('unexpected_increase') is-invalid @enderror"
                                            style="width: 230px; height: 40px;" min="0"
                                            value="{{ old('unexpected_increase', $loan->unexpected_increase) }}"
                                            oninput="formatNumber(this)">
                                        @error('unexpected_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="additional_increase"><strong>បំពេញបន្ថែម:</strong></label>
                                        <input type="number" name="additional_increase" id="additional_increase"
                                            class="form-control @error('additional_increase') is-invalid @enderror"
                                            style="width: 230px; height: 40px;" min="0"
                                            value="{{ old('additional_increase', $loan->additional_increase) }}"
                                            oninput="formatNumber(this)">
                                        @error('additional_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Column 3 -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="decrease"><strong>ថយ:</strong></label>
                                        <input type="number" name="decrease" id="decrease"
                                            class="form-control @error('decrease') is-invalid @enderror" min="0"
                                            style="width: 230px; height: 40px;"
                                            value="{{ old('decrease', $loan->decrease) }}" oninput="formatNumber(this)">
                                        @error('decrease')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="editorial"><strong>វិចារណកម្ម:</strong></label>
                                        <input type="number" name="editorial" id="editorial"
                                            class="form-control @error('editorial') is-invalid @enderror" min="0"
                                            style="width: 230px; height: 40px;"
                                            value="{{ old('editorial', $loan->editorial) }}"
                                            oninput="formatNumber(this)">
                                        @error('editorial')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-12 text-center">

                                    <!-- Reset Button -->
                                    <button type="reset" class="btn btn-secondary ">
                                        <i class="fas fa-undo"></i>&nbsp;&nbsp;កំណត់ឡើងវិញ
                                    </button>

                                    <!-- Submit Button -->
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


        h3 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
        }


        .form-control,
        th,
        td {
            border: 1px solid black;
            text-align: center;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        (function($) {
            "use strict";

            $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
                if ($(".sidebar").hasClass("toggled")) {
                    $('.sidebar .collapse').collapse('hide');
                }
            });

            $(window).resize(function() {
                if ($(window).width() < 768) {
                    $('.sidebar .collapse').collapse('hide');
                }

                if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
                    $("body").addClass("sidebar-toggled");
                    $(".sidebar").addClass("toggled");
                    $('.sidebar .collapse').collapse('hide');
                }
            });

            function updateCurrentLoan(input) {
                var finLawValue = parseFloat(input.value.replace(/,/g, ''));
                console.log('finLawValue:', finLawValue); // Debugging statement
                if (isNaN(finLawValue)) {
                    finLawValue = 0;
                }
                document.getElementById('current_loan').value = finLawValue.toFixed(2);
            }

            // Format number input to include commas
            function formatNumber(input) {
                var value = input.value.replace(/,/g, '');
                if (!isNaN(value) && value !== '') {
                    input.value = Number(value).toLocaleString('en-US', {
                        minimumFractionDigits: 2
                    });
                }
            }

        })(jQuery); // End of use strict
    </script>
    <script>
        // Function to handle the selected report key and update the input field
        function getSelectedReportKey() {
            const selectElement = document.getElementById('reportKeySelect');
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const searchInputElement = document.getElementById('searchReportKey');

            // Set the input field value to the selected option's text
            searchInputElement.value = selectedOption.text.trim();

            // Also ensure the form is submitting the correct report_key value
            document.getElementById('hiddenReportKeyInput').value = selectedOption.value;
        }

        // Function to filter report keys based on user input
        function filterReportKeys(event) {
            const searchValue = event.target.value.toLowerCase();
            const selectElement = document.getElementById('reportKeySelect');
            const options = selectElement.options;

            let count = 0;
            for (let i = 0; i < options.length; i++) {
                const optionText = options[i].text.toLowerCase();
                const isMatch = optionText.includes(searchValue);

                options[i].style.display = isMatch ? 'block' : 'none';
                if (isMatch) count++;
            }

            document.getElementById('reportResultCount').innerText = `ចំនួន: ${count}`;
        }
    </script>

    {{-- <script>
        function updateApplyValue() {
            let finLaw = parseFloat(document.getElementById('fin_law').value) || 0;
            let internalIncrease = parseFloat(document.getElementById('internal_increase').value) || 0;
            let unexpectedIncrease = parseFloat(document.getElementById('unexpected_increase').value) || 0;
            let additionalIncrease = parseFloat(document.getElementById('additional_increase').value) || 0;
            let decrease = parseFloat(document.getElementById('decrease').value) || 0;

            // Calculate total_increase and new_credit_status
            let totalIncrease = internalIncrease + unexpectedIncrease + additionalIncrease;
            let newCreditStatus = finLaw + totalIncrease - decrease;

            // Update the apply field (if needed)
            document.getElementById('apply').value = newCreditStatus;

        }

        // Attach the event listeners to the fields that affect the calculations
        document.getElementById('fin_law').addEventListener('input', updateApplyValue);
        document.getElementById('internal_increase').addEventListener('input', updateApplyValue);
        document.getElementById('unexpected_increase').addEventListener('input', updateApplyValue);
        document.getElementById('additional_increase').addEventListener('input', updateApplyValue);
        document.getElementById('decrease').addEventListener('input', updateApplyValue);
        // Function to filter report keys based on user input
        function filterReportKeys(event) {
            const searchValue = event.target.value.toLowerCase();
            const selectElement = document.getElementById('reportKeySelect');
            const options = selectElement.options;

            let count = 0; // To count the matched results
            for (let i = 0; i < options.length; i++) {
                const optionText = options[i].text.toLowerCase();
                const isMatch = optionText.includes(searchValue);

                // Show or hide options based on search
                options[i].style.display = isMatch ? 'block' : 'none';
                if (isMatch) count++;
            }

            // Update the result count display
            document.getElementById('reportResultCount').innerText = `ចំនួន: ${count}`;
        }

        // Reset the selection in the dropdown when input changes
        function resetReportKeySelection() {
            const selectElement = document.getElementById('reportKeySelect');
            selectElement.selectedIndex = -1; // Deselect any selected option
        }

        // Function to handle the selected report key (optional)
        function getSelectedReportKey() {
            const selectElement = document.getElementById('reportKeySelect');
            const selectedValue = selectElement.value;
            console.log('Selected Report Key ID:', selectedValue); // For debugging
        }
    </script> --}}
@endsection
