@extends('layouts.master')

@section('form-certificate-data-edit')
    {{-- <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">កែសម្រួលសលាកបត្រ</h3>
                    <a class="btn btn-danger d-flex justify-content-center align-items-center mr-2"
                        href="{{ route('certificate-data.index') }}" style="width: 120px; height: 40px;"><i
                            class="fas fa-arrow-left"></i></a>
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

        <div class="row d-flex justify-content-start">
            <div class="col-md-6">
                <div class="border-wrapper">
                    <div class="form-container">
                        <form action="{{ route('certificate-data.update', $certificateData->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row d-flex justify-content-center">
                                <!-- First Row -->
                                <div class="col-md-6 d-flex flex-column align-items-center">
                                    <div class="form-group">
                                        <label for="searchReportKey"
                                            class="font-weight-bold"><strong>លេខកូដកម្មវិធី:</strong></label>

                                        <!-- Input field for searching -->
                                        <input type="text" id="searchReportKey" class="form-control"
                                            placeholder="ស្វែងរកលេខកូដ អនុគណនី​ នឹងកម្មវិធី..."
                                            onkeyup="filterReportKeys(event)"
                                            style="width: 320px; height: 60px; text-align: center;"
                                            oninput="resetReportKeySelection()">

                                        <!-- Hidden input to store the selected report key value -->
                                        <input type="hidden" name="report_key" id="hiddenReportKeyInput"
                                            value="{{ $certificateData->report_key }}">

                                        <!-- Display the count of search results -->
                                        <p id="reportResultCount" style="font-weight: bold; margin-top: 8px;">ចំនួន: 0</p>

                                        <!-- Dropdown for selecting the report -->
                                        <select id="reportKeySelect" class="form-control" size="5"
                                            onclick="getSelectedReportKey()"
                                            style="height: 260px; width: 320px; text-align: left; ">
                                            @foreach ($reports as $report)
                                                <option value="{{ $report->id }}"
                                                    {{ $report->id == $certificateData->report_key ? 'selected' : '' }}>
                                                    {{ $report->subAccountKey->sub_account_key }} >
                                                    {{ $report->report_key }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 d-flex flex-column align-items-center">
                                    <div class="form-group">
                                        <label for="number_value_certificate"><strong>ចំនួនទឹកប្រាក់:</strong></label>
                                        <input type="number" name="value_certificate" id="value_certificate"
                                            value="{{ $certificateData->value_certificate }}"
                                            class="form-control @error('value_certificate') is-invalid @enderror"
                                            style="width: 320px; height: 60px;">
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

            <div class="col-md-3">
                <div class="form-group text-center d-flex flex-column align-items-center">
                    <strong class="d-block mb-2">ឥណទានអនុម័ត:</strong>
                    <span id="fin_law" class="form-control" style="width: 320px; height: 60px; text-align: center;">
                        {{ $report->fin_law ?? 0 }}
                    </span>
                </div>
                <div class="form-group text-center d-flex flex-column align-items-center">
                    <strong class="d-block mb-2">ចលនាឥណទាន:</strong>
                    <span id="credit_movement" class="form-control" style="width: 320px; height: 60px; text-align: center;">
                        {{ $credit_movement ?? 0 }}
                    </span>
                </div>
                <div class="form-group text-center d-flex flex-column align-items-center">
                    <strong class="d-block mb-2">ស្ថានភាពឥណទានថ្មី:</strong>
                    <span id="new_credit_status" class="form-control"
                        style="width: 320px; height: 60px; text-align: center;">
                        {{ $report->new_credit_status ?? 0 }}
                    </span>
                </div>
                <div class="form-group text-center d-flex flex-column align-items-center">
                    <strong class="d-block mb-2">ឥណទានទំនេរ:</strong>
                    <span id="credit" class="form-control" style="width: 320px; height: 60px; text-align: center;">
                        {{ $report->credit ?? 0 }}
                    </span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group text-center d-flex flex-column align-items-center">
                    <strong class="d-block mb-2">ធានាចំណាយពីមុន:</strong>
                    <span id="deadline_balance" class="form-control"
                        style="width: 320px; height: 60px; text-align: center;">
                        {{ $report->deadline_balance ?? 0 }}
                    </span>
                </div>
                <div class="form-group text-center d-flex flex-column align-items-center">
                    <strong class="d-block mb-2">ស្នើរសុំលើកនេះ:</strong>
                    <span id="applying" class="form-control" style="width: 320px; height: 60px; text-align: center;">
                        {{ $certificateData->value_certificate ?? 0 }}
                    </span>
                </div>
                <div class="form-group text-center d-flex flex-column align-items-center">
                    <strong class="d-block mb-2">ឥណទាននៅសល់:</strong>
                    <span id="remaining_credit" class="form-control"
                        style="width: 320px; height: 60px; text-align: center;">
                        {{ $report->credit - $certificateData->value_certificate ?? 0 }}
                    </span>
                </div>
            </div>

        </div>
    </div> --}}
    <div class="border-wrapper">
        <div class="result-total-table-container">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <a class="btn btn-danger d-flex justify-content-center align-items-center "
                                href="{{ route('certificate-data.index') }}" style="width: 120px; height: 40px;"><i
                                    class="fas fa-arrow-left"></i></a>
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
                <div class="d-flex justify-content-center align-items-center  ">
                    <div class="card shadow-lg w-65" style="max-width: 900px;">
                        <h3 class="card-title text-center mt-4" style="font-weight: 500;">កែសលាកបត្រ</h3>
                        <div class="card-body px-5 py-4">
                            <form action="{{ route('certificate-data.update', $certificateData->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT') <!-- Method for updating -->

                                <div class="row justify-content-center">
                                    <div class="col-md-4 d-flex flex-column align-items-center">
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
                                                value="{{ $certificateData->report_key }}">
    
                                            <!-- Display the count of search results -->
                                            <p id="reportResultCount" style="font-weight: bold; margin-top: 8px;">ចំនួន: 0</p>
    
                                            <!-- Dropdown for selecting the report -->
                                            <select id="reportKeySelect" class="form-control" size="5"
                                                onclick="getSelectedReportKey()"
                                                style="height: 120px; width: 230px; text-align: left; ">
                                                @foreach ($reports as $report)
                                                    <option value="{{ $report->id }}"
                                                        {{ $report->id == $certificateData->report_key ? 'selected' : '' }}>
                                                        {{ $report->subAccountKey->sub_account_key }} >
                                                        {{ $report->report_key }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 d-flex flex-column justify-content-start align-items-start">
                                        <!-- Form Group for Value Certificate -->
                                        <div class="form-group">
                                            <label for="number_value_certificate"><strong>ចំនួនទឹកប្រាក់:</strong></label>
                                            <input type="number" name="value_certificate" id="value_certificate"
                                                value="{{ $certificateData->value_certificate }}"
                                                class="form-control @error('value_certificate') is-invalid @enderror"
                                                style="width: 230px; height: 40px;">
                                            @error('value_certificate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Form Group for Mission Type -->
                                        <div class="form-group">
                                            <label for="mission-type"><strong>ប្រភេទបញ្ជី</strong></label>
                                            <div>
                                                @foreach ($missionTypes as $missionType)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="mission_type"
                                                            id="mission_type{{ $loop->index }}"
                                                            value="{{ $missionType->id }}"
                                                            {{ old('mission_type') == $missionType->id ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="mission_type{{ $loop->index }}">
                                                            {{ $missionType->mission_type }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 d-flex flex-column align-items-start">
                                        <div class="form-group">
                                            <!-- File Input -->
                                            <label for="attachments"><strong>ជ្រើសរើស ថ្ងៃ ខែ ឆ្នាំ:</strong></label>
                                            <input type="date" class="form-control" id="date_certificate"
                                                name="date_certificate" multiple
                                                style="height: 40px; width: 230px;">
                                        </div>
                                        <!-- Attachment Files -->
                                        <div class="form-group ">
                                            <label for="attachments"><strong>ឯកសារភ្ជាប់:</strong></label>
                                            <input type="file" class="form-control" id="attachments" name="attachments[]"
                                                multiple style="height: 40px; width: 230px; padding: 6px;"
                                                onchange="displaySelectedFiles()">
                                            <ul id="fileList" style="padding-left: 24px;"></ul>
                                        </div>
                                    </div>
                                </div>
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
                    <div class="col-md-3">
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ឥណទានអនុម័ត:</strong>
                            <span id="fin_law" class="form-control"   style="width: 230px; height: 40px; text-align: center;">
                                {{ $report->fin_law ?? 0 }}
                            </span>
                        </div>
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ចលនាឥណទាន:</strong>
                            <span id="credit_movement" class="form-control"   style="width: 230px; height: 40px; text-align: center;">
                                {{ $credit_movement ?? 0 }}
                            </span>
                        </div>
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ស្ថានភាពឥណទានថ្មី:</strong>
                            <span id="new_credit_status" class="form-control"
                            style="width: 230px; height: 40px; text-align: center;">
                                {{ $report->new_credit_status ?? 0 }}
                            </span>
                        </div>
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ឥណទានទំនេរ:</strong>
                            <span id="credit" class="form-control"  style="width: 230px; height: 40px; text-align: center;">
                                {{ $report->credit ?? 0 }}
                            </span>
                        </div>
                    </div>
        

                    <div class="col-md-3">
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ធានាចំណាយពីមុន:</strong>
                            <span id="deadline_balance" class="form-control"
                                style="width: 230px; height: 40px; text-align: center;">
                                {{ $report->deadline_balance ?? 0 }}
                            </span>
                        </div>
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ស្នើរសុំលើកនេះ:</strong>
                            <span id="applying" class="form-control"   style="width: 230px; height: 40px; text-align: center;">
                                {{ $certificateData->value_certificate ?? 0 }}
                            </span>
                        </div>
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ឥណទាននៅសល់:</strong>
                            <span id="remaining_credit" class="form-control"
                            style="width: 230px; height: 40px; text-align: center;">
                                {{ $report->credit - $certificateData->value_certificate ?? 0 }}
                            </span>
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
    <script>
        let credit = 0;

        async function updateReportInputField() {
            const select = document.getElementById('reportKeySelect');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                document.getElementById('searchReportKey').value = selectedOption.textContent;
                const reportKeyId = selectedOption.value;

                try {
                    const response = await fetch(`/reports/${reportKeyId}/early-balance`);
                    if (!response.ok) throw new Error("Network response was not ok");

                    const data = await response.json();
                    // Update values from data returned by the backend

                    document.getElementById('fin_law').textContent = formatNumber(data.fin_law);
                    document.getElementById('credit_movement').textContent = formatNumber(data.credit_movement);
                    document.getElementById('new_credit_status').textContent = formatNumber(data.new_credit_status);
                    document.getElementById('credit').textContent = formatNumber(data.credit);
                    document.getElementById('deadline_balance').textContent = formatNumber(data.deadline_balance);

                    // Update credit and remaining credit
                    credit = data.credit;
                    updateRemainingCredit(data.apply || 0);
                } catch (error) {
                    console.error('Error fetching report data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Could not fetch report data. Please try again later.',
                        confirmButtonText: 'OK'
                    });
                }
            }
        }

        function updateRemainingCredit(apply) {
            const creditValue = parseFloat(document.getElementById('credit').textContent.replace(/,/g, '')) || 0;
            const remainingCredit = creditValue - apply;

            if (remainingCredit < 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Notice',
                    text: 'Insufficient remaining credit.',
                    confirmButtonText: 'OK'
                });
                document.getElementById('remaining_credit').textContent = "0";
                return false;
            }

            document.getElementById('remaining_credit').textContent = formatNumber(remainingCredit);
            return true;
        }

        function updateApplyValue() {
            const apply = parseFloat(document.getElementById('value_certificate').value) || 0;
            document.getElementById('applying').textContent = formatNumber(apply);
            updateRemainingCredit(apply);
        }

        function formatNumber(num) {
            return Number.isInteger(num) ?
                num.toLocaleString() :
                num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Add input event listener to the value_certificate input
        document.getElementById('value_certificate').addEventListener('input', updateApplyValue);
    </script>
@endsection
