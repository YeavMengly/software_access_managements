@extends('layouts.master')

@section('form-certificate-data-edit')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">កែសម្រួលសលាកបត្រ</h3>
                    <a class="btn btn-primary" href="{{ route('certificate-data.index') }}">ត្រឡប់ក្រោយ</a>
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
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="border-wrapper">
            <div class="form-container">
                {{-- <form action="{{ route('certificate-data.update', $certificateData->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row d-flex justify-content-center">
                        <!-- First Row -->
                        <div class="col-md-3 d-flex flex-column align-items-center">
                            <div class="form-group">
                                <label for="searchReportKey"
                                    class="font-weight-bold"><strong>លេខកូដកម្មវិធី:</strong></label>

                                <!-- Input field for searching -->
                                <input type="text" id="searchReportKey" class="form-control"
                                    placeholder="ស្វែងរកលេខកូដ អនុគណនី​ នឹងកម្មវិធី..." onkeyup="filterReportKeys(event)"
                                    style="width: 420px; height: 60px; text-align: center;"
                                    oninput="resetReportKeySelection()">

                                <!-- Display the count of search results -->
                                <p id="reportResultCount" style="font-weight: bold; margin-top: 8px;">ចំនួន: 0</p>

                                <!-- Dropdown for selecting the report -->
                                <select name="report_key" id="reportKeySelect" class="form-control" size="5"
                                    onclick="getSelectedReportKey()" style="height: 260px; width: 420px; text-align: left;">
                                    @foreach ($reports as $report)
                                        <option value="{{ $report->id }}"
                                            {{ $report->id == $certificateData->report_key ? 'selected' : '' }}>
                                            {{ $report->subAccountKey->sub_account_key }} > {{ $report->report_key }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="col-md-3 d-flex flex-column align-items-center">
                            <div class="form-group">
                                <label for="number_value_certificate"> <strong>ចំនួនទឹកប្រាក់:</strong></label>
                                <input type="number" name="value_certificate" id="value_certificate"
                                    value="{{ $certificateData->value_certificate }}"
                                    class="form-control @error('value_certificate') is-invalid @enderror"
                                    style="width: 420px; height: 60px;">
                                @error('value_certificate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-primary ml-auto" style="width: 300px; height: 60px;">
                            <i class="fas fa-save"></i> រក្សាទុក</button>
                    </div>
                </form> --}}
                <form action="{{ route('certificate-data.update', $certificateData->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row d-flex justify-content-center">
                        <!-- First Row -->
                        <div class="col-md-3 d-flex flex-column align-items-center">
                            <div class="form-group">
                                <label for="searchReportKey"
                                    class="font-weight-bold"><strong>លេខកូដកម្មវិធី:</strong></label>

                                <!-- Input field for searching -->
                                <input type="text" id="searchReportKey" class="form-control"
                                    placeholder="ស្វែងរកលេខកូដ អនុគណនី​ នឹងកម្មវិធី..." onkeyup="filterReportKeys(event)"
                                    style="width: 420px; height: 60px; text-align: center;"
                                    oninput="resetReportKeySelection()">

                                <!-- Hidden input to store the selected report key value -->
                                <input type="hidden" name="report_key" id="hiddenReportKeyInput"
                                    value="{{ $certificateData->report_key }}">

                                <!-- Display the count of search results -->
                                <p id="reportResultCount" style="font-weight: bold; margin-top: 8px;">ចំនួន: 0</p>

                                <!-- Dropdown for selecting the report -->
                                <select id="reportKeySelect" class="form-control" size="5"
                                    onclick="getSelectedReportKey()" style="height: 260px; width: 420px; text-align: left;">
                                    @foreach ($reports as $report)
                                        <option value="{{ $report->id }}"
                                            {{ $report->id == $certificateData->report_key ? 'selected' : '' }}>
                                            {{ $report->subAccountKey->sub_account_key }} > {{ $report->report_key }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 d-flex flex-column align-items-center">
                            <div class="form-group">
                                <label for="number_value_certificate"><strong>ចំនួនទឹកប្រាក់:</strong></label>
                                <input type="number" name="value_certificate" id="value_certificate"
                                    value="{{ $certificateData->value_certificate }}"
                                    class="form-control @error('value_certificate') is-invalid @enderror"
                                    style="width: 420px; height: 60px;">
                                @error('value_certificate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-primary ml-auto" style="width: 300px; height: 60px;">
                            <i class="fas fa-save"></i> រក្សាទុក
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .border-wrapper {
            border: 2px solid black;
            padding: 10px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        (function($) {
            "use strict"; // Start of use strict

            // Toggle the side navigation
            $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
                if ($(".sidebar").hasClass("toggled")) {
                    $('.sidebar .collapse').collapse('hide');
                }
            });

            // Close any open menu accordions when window is resized below 768px
            $(window).resize(function() {
                if ($(window).width() < 768) {
                    $('.sidebar .collapse').collapse('hide');
                }

                // Toggle the side navigation when window is resized below 480px
                if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
                    $("body").addClass("sidebar-toggled");
                    $(".sidebar").addClass("toggled");
                    $('.sidebar .collapse').collapse('hide');
                }
            });

            // Update the current loan field based on fin_law input
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

    {{-- <script>
        function filterSubAccountKeys(event) {
            const searchTerm = event.target.value.toLowerCase(); // Get the search term
            const select = document.getElementById('subAccountKeySelect');
            const options = select.options;
            let count = 0;

            // Filter the options based on the search term
            for (let i = 0; i < options.length; i++) {
                const optionText = options[i].textContent.toLowerCase(); // Get the option text
                if (optionText.includes(searchTerm)) {
                    options[i].style.display = ''; // Show matching option
                    count++;
                } else {
                    options[i].style.display = 'none'; // Hide non-matching option
                }
            }

            // Update the result count
            document.getElementById('resultCount').textContent = 'ចំនួន: ' + count;

            // Optionally clear the input if no results are found
            if (count === 0) {
                document.getElementById('combinedField').value = ''; // Clear if no matches
            }
        }

        function getSelectedValue() {
            const select = document.getElementById('subAccountKeySelect');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                const subAccountKey = selectedOption.text; // Get the selected option text
                const reportKey = selectedOption.getAttribute('data-report-key'); // Get the report key

                // Update the combinedField input with the selected value
                document.getElementById('combinedField').value = subAccountKey;

                // If you need to do something with the reportKey, you can store it as needed
                console.log('Selected Report Key:', reportKey); // Example usage
            }
        }
    </script> --}}
    {{-- <script>
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

        // Function to handle the selected report key and update the input field
        function getSelectedReportKey() {
            const selectElement = document.getElementById('reportKeySelect');
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const inputElement = document.getElementById('searchReportKey');

            // Set the input value to the selected option's text
            inputElement.value = selectedOption.text.trim();
        }
    </script> --}}
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
@endsection
