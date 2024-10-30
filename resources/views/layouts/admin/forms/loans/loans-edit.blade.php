@extends('layouts.master')

@section('form-content-loans-edit')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">កែប្រែទិន្នន័យ</h3>
                            <a class="btn btn-danger" href="{{ route('loans.index') }}"> <i class="fas fa-arrow-left"></i>
                                ត្រឡប់ក្រោយ</a>
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

                <div class="border-wrapper">
                    <div class="form-container">
                        <form action="{{ route('loans.update', $loan->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Sub Account Key Input -->
                                    <div class="form-group">
                                        <strong>លេខអនុគណនី:</strong>
                                        <select name="sub_account_key" class="form-control">
                                            @foreach ($subAccountKeys as $subAccountKey)
                                                <option value="{{ $subAccountKey->id }}"
                                                    {{ $subAccountKey->id == $loan->sub_account_key ? 'selected' : '' }}>
                                                    {{ $subAccountKey->accountKey->key->code }} -
                                                    {{ $subAccountKey->accountKey->account_key }} -
                                                    {{ $subAccountKey->sub_account_key }}
                        <form action="{{ route('loans.update', $loan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Indicate that this is an update request -->

                            <div class="row d-flex justify-content-center">
                                <!-- First Row -->
                                <div class="col-md-3 d-flex flex-column align-items-center">
                                    <!-- Report Key Input -->
                                    <div class="form-group">
                                        <label for="searchReportKey"
                                            class="font-weight-bold"><strong>លេខកូដកម្មវិធី:</strong></label>

                                        <input type="text" id="searchReportKey" class="form-control"
                                            placeholder="ស្វែងរកលេខកូដ អនុគណនី​ នឹងកម្មវិធី..."
                                            onkeyup="filterReportKeys(event)"
                                            style="width: 420px; height: 60px; text-align: center;"
                                            oninput="resetReportKeySelection()">

                                        <p id="reportResultCount" style="font-weight: bold; margin-top: 8px;">ចំនួន: 0</p>

                                        <select name="report_key" id="reportKeySelect" class="form-control" size="5"
                                            onclick="getSelectedReportKey()"
                                            style="height: 260px; width: 420px; text-align: left;">
                                            @foreach ($reports as $report)
                                                <!-- Changed from $loans to $reports -->
                                                <option value="{{ $report->id }}"
                                                    {{ $report->id == $loan->report_key ? 'selected' : '' }}>
                                                    <!-- Check against the loan's report_key -->
                                                    {{ $report->subAccountKey->sub_account_key }} >
                                                    {{ $report->report_key }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Report Key Input -->
                                    <div class="form-group">
                                        <label for="report_key">លេខកូដកម្មវិធី:</label>
                                        <input type="number" name="report_key" id="report_key"
                                            value="{{ old('report_key', $loan->report_key) }}"
                                            class="form-control @error('report_key') is-invalid @enderror">
                                        @error('report_key')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Name Report Key Input -->
                                    <div class="form-group">
                                        <label for="name_report_key">ចំណាត់ថ្នាក់:</label>
                                        <input type="text" name="name_report_key" id="name_report_key"
                                            value="{{ old('name_report_key', $loan->name_report_key) }}"
                                            class="form-control @error('name_report_key') is-invalid @enderror">
                                        @error('name_report_key')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Financial Law Input -->
                                    <div class="form-group">
                                        <label for="fin_law">ច្បាប់ហិរញ្ញវត្ថុ:</label>
                                        <input type="number" name="fin_law" id="fin_law"
                                            value="{{ old('fin_law', $loan->fin_law) }}"
                                            class="form-control @error('fin_law') is-invalid @enderror"
                                            oninput="updateCurrentLoan(this)">
                                        @error('fin_law')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="current_loan">ឥណទានបច្ចុប្បន្ន:</label>
                                        <input type="number" name="current_loan" id="current_loan"
                                            value="{{ old('current_loan', $loan->current_loan) }}"
                                            class="form-control @error('current_loan') is-invalid @enderror">
                                        @error('current_loan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                            </div>

                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn btn-primary ml-auto">បានរក្សាទុក</button>
                            </div>
                        </form>
                                </div>


                                <div class="col-md-3 d-flex flex-column align-items-center">
                                    <!-- Internal Increase Input -->
                                    <div class="form-group">
                                        <label for=""><strong>កើនផ្ទៃក្នុង:</strong></label>
                                        <input type="number" name="internal_increase" id="internal_increase"
                                            class="form-control @error('internal_increase') is-invalid @enderror"
                                            style="width: 420px; height: 60px;" min="0"
                                            value="{{ old('internal_increase', $loan->internal_increase) }}"
                                            oninput="formatNumber(this)">
                                        @error('internal_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for=""> <strong>មិនបានគ្រោងទុក:</strong></label>
                                        <input type="number" name="unexpected_increase" id="unexpected_increase"
                                            class="form-control @error('unexpected_increase') is-invalid @enderror"
                                            style="width: 420px; height: 60px;" min="0"
                                            value="{{ old('unexpected_increase', $loan->unexpected_increase) }}"
                                            oninput="formatNumber(this)">
                                        @error('unexpected_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for=""> <strong>បំពេញបន្ថែម</strong></label>
                                        <input type="number" name="additional_increase" id="additional_increase"
                                            class="form-control @error('additional_increase') is-invalid @enderror"
                                            style="width: 420px; height: 60px;" min="0"
                                            value="{{ old('additional_increase', $loan->additional_increase) }}"
                                            oninput="formatNumber(this)">
                                        @error('additional_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 d-flex flex-column align-items-center">
                                    <!-- Decrease Input -->
                                    <div class="form-group">
                                        <label for=""><strong>ថយ</strong></label>
                                        <input type="number" name="decrease" id="decrease"
                                            class="form-control @error('decrease') is-invalid @enderror" min="0"
                                            style="width: 420px; height: 60px;"
                                            value="{{ old('decrease', $loan->decrease) }}" oninput="formatNumber(this)">
                                        @error('decrease')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for=""> <strong>វិចារណកម្ម</strong></label>
                                        <input type="number" name="editorial" id="editorial"
                                            class="form-control @error('editorial') is-invalid @enderror" min="0"
                                            style="width: 420px; height: 60px;"
                                            value="{{ old('editorial', $loan->editorial) }}" oninput="formatNumber(this)">
                                        @error('editorial')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn btn-primary ml-auto"
                                    style="width: 300px; height: 60px;">
                                    <i class="fas fa-save"></i> បានរក្សាទុក
                                </button>
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
            border: 2px solid black;
            padding: 10px;
        }

        .container-fluid {
            padding: 16px;
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

    <script>
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

            // You can add other calculations if needed here
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
    </script>
@endsection
