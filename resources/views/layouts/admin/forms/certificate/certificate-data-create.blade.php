@extends('layouts.master')

@section('form-certificate-data-upload')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <a class="btn btn-danger d-flex justify-content-center align-items-center mr-2"
                                href="{{ route('back') }}" style="width: 160px; height: 50px;"><i
                                    class="fas fa-arrow-left"></i> &nbsp;</a>
                            <h3 class="card-title" style="font-weight: 500;">បង្កើតសលាកបត្រ</h3>
                            <span></span>
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
                            <form action="{{ route('certificate-data.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row justify-content-center">
                                    <div class="col-md-6 d-flex flex-column align-items-center">
                                        <div class="form-group">
                                            <strong>លេខកូដកម្មវិធី:</strong>
                                            <input type="text" id="searchReportKey" class="form-control"
                                                placeholder="ស្វែងរកលេខកូដកម្មវិធី..." onkeyup="filterReportKeys(event)"
                                                style="width: 100%; height: 40px; text-align: center; line-height: 60px;">
                                            <p id="resultCount" style="font-weight: bold;">ចំនួន: 0</p>

                                            <select name="report_key" id="reportKeySelect" class="form-control"
                                                size="5" onchange="updateReportInputField()"
                                                style="width: 100%; height: 150px;">
                                                @foreach ($reports as $report)
                                                    <option value="{{ $report->id }}"><span>{{ $report->subAccountKey->sub_account_key }} > {{ $report->report_key }}</span>
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 d-flex flex-column align-items-center">
                                        <div class="form-group text-center">
                                            <strong>ចំនួនទឹកប្រាក់:</strong>
                                            <input type="number" name="value_certificate" id="value_certificate"
                                                class="form-control @error('value_certificate') is-invalid @enderror"
                                                style="width: 100%; height: 40px; text-align: center; line-height: 60px;"
                                                oninput="updateApplyValue()">
                                            @error('value_certificate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary" style="width: 200px; height: 50px;">
                                        <i class="fas fa-save"></i> រក្សាទុក
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ឥណទានអនុម័ត:</strong>
                            <span id="fin_law" class="form-control"
                                style="width: 80%; height: 40px; text-align: center;">0</span>
                        </div>
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ចលនាឥណទាន:</strong>
                            <span id="credit_movement" class="form-control"
                                style="width: 80%; height: 40px; text-align: center;">0</span>
                        </div>

                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ស្ថានភាពឥណទានថ្មី:</strong>
                            <span id="new_credit_status" class="form-control"
                                style="width: 80%; height: 40px; text-align: center;">0</span>
                        </div>
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ឥណទានទំនេរ:</strong>
                            <span id="credit" class="form-control"
                                style="width: 80%; height: 40px; text-align: center;">0</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ធានាចំណាយពីមុន:</strong>
                            <span id="deadline_balance" class="form-control"
                                style="width: 80%; height: 40px; text-align: center;">0</span>
                        </div>

                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ស្នើរសុំលើកនេះ:</strong>
                            <span id="applying" class="form-control"
                                style="width: 80%; height: 40px; text-align: center;">0</span>
                        </div>

                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ឥណទាននៅសល់:</strong>
                            <span id="remaining_credit" class="form-control"
                                style="width: 80%; height: 40px; text-align: center;">0</span>
                        </div>
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

        h3 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
        }

        .result-total-table-container {
            max-height: 100vh;
            overflow-y: auto;
        }


        .btn,
        .form-control,
        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 6px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Initialize selectedIndex for keyboard navigation
        let selectedIndex = -1;

        function filterReportKeys(event) {
            const input = document.getElementById('searchReportKey').value.toLowerCase();
            const select = document.getElementById('reportKeySelect');
            const options = select.options;
            let count = 0;

            for (let i = 0; i < options.length; i++) {
                const optionText = options[i].textContent.toLowerCase();
                if (optionText.includes(input)) {
                    options[i].style.display = ''; // Show matching option
                    count++;
                } else {
                    options[i].style.display = 'none'; // Hide non-matching option
                }
            }

            document.getElementById('resultCount').innerText = 'ចំនួន: ' + count;

            // Handle arrow key navigation
            if (event.key === 'ArrowDown') {
                if (selectedIndex < options.length - 1) {
                    selectedIndex++;
                    while (selectedIndex < options.length && options[selectedIndex].style.display === 'none') {
                        selectedIndex++;
                    }
                    if (selectedIndex < options.length) {
                        options[selectedIndex].selected = true;
                        updateReportInputField();
                    }
                }
            } else if (event.key === 'ArrowUp') {
                if (selectedIndex > 0) {
                    selectedIndex--;
                    while (selectedIndex >= 0 && options[selectedIndex].style.display === 'none') {
                        selectedIndex--;
                    }
                    if (selectedIndex >= 0) {
                        options[selectedIndex].selected = true;
                        updateReportInputField();
                    }
                }
            } else if (event.key === 'Enter') {
                updateReportInputField();
            }
        }
    </script>
    <script>
        let credit = 0;

        function updateReportInputField() {
            const select = document.getElementById('reportKeySelect');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                document.getElementById('searchReportKey').value = selectedOption.textContent;

                const reportKeyId = selectedOption.value;
                fetch(`/reports/${reportKeyId}/early-balance`)
                    .then(response => response.json())
                    .then(data => {
                        credit = data.credit;
                        document.getElementById('fin_law').textContent = formatNumber(data.fin_law);
                        document.getElementById('credit_movement').textContent = formatNumber(data.credit_movement);
                        document.getElementById('new_credit_status').textContent = formatNumber(data.new_credit_status);
                        document.getElementById('credit').textContent = formatNumber(data.credit);
                        document.getElementById('deadline_balance').textContent = formatNumber(data.deadline_balance);

                        // Initial calculation of remaining credit
                        updateRemainingCredit(data.apply || 0);
                    })
                    .catch(error => console.error('Error fetching report data:', error));
            }
        }


        function updateRemainingCredit(apply) {
            const credit = parseFloat(document.getElementById('credit').textContent.replace(/,/g, '')) || 0;
            const remainingCredit = credit - apply;

            if (remainingCredit < 0) {
                // SweetAlert alert if remaining credit is less than 0
                Swal.fire({
                    icon: 'error',
                    title: 'ជូនដំណឹង',
                    text: 'ឥណទាននៅសល់មិនគ្រប់ចំនួន',
                    confirmButtonText: 'យល់ព្រម'
                });

                document.getElementById('remaining_credit').textContent = "0"; // Optionally set to 0
                return false; // Prevent further action
            }

            document.getElementById('remaining_credit').textContent = formatNumber(remainingCredit);
            return true; // Indicate that remaining credit is valid
        }

        function updateApplyValue() {
            // Get the value from the input field
            const apply = parseFloat(document.getElementById('value_certificate').value) || 0;

            // Update the apply span
            document.getElementById('applying').textContent = formatNumber(apply);

            // Check and update remaining credit with SweetAlert
            updateRemainingCredit(apply);
        }


        function formatNumber(num) {

            // Remove decimal if the number is an integer or ends in .00
            if (Number.isInteger(num) || num % 1 === 0) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            } else {
                // Format with two decimal places
                return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            return formattedNum.endsWith(".00") ? formattedNum.slice(0, -3) : formattedNum;
        }
    </script>
@endsection
