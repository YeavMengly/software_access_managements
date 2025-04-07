@extends('layouts.master')

@section('form-mandate-upload')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row mb-4">
                    <a class="btn btn-danger" href="{{ route('back') }}"
                        style="width: 120px; height: 40px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-arrow-left"></i>
                    </a>
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
                        <h3 class="card-title text-center mt-4" style="font-weight: 500;">បង្កើតអាណត្តិ</h3>
                        <div class="card-body px-5 py-4">
                            <form action="{{ route('mandates.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row justify-content-center">
                                    <div class="col-md-4 d-flex flex-column align-items-center">
                                        <div class="form-group">
                                            <strong>លេខកូដកម្មវិធី:</strong>
                                            <input type="text" id="searchReportKey" class="form-control"
                                                placeholder="ស្វែងរកលេខកូដកម្មវិធី..." onkeyup="filterReportKeys(event)"
                                                style="width: 230px; height: 40px; text-align: left; line-height: 40px;">
                                            <p id="resultCount" style="font-weight: bold;">ចំនួន: 0</p>

                                            @php
                                                // Sort the reports by report_key in ascending order
                                                $sortedReports = $dataMandate->sortBy('sub_account_key');
                                            @endphp

                                            <select name="report_key" id="reportKeySelect" class="form-control"
                                                size="5" onchange="updateReportInputField()"
                                                style="width: 230px; height: 120px;">
                                                @foreach ($sortedReports as $dataMandate)
                                                    <option value="{{ $dataMandate->id }}">{{ $dataMandate->subAccountKey->sub_account_key ?? 'N/A' }} | {{ $dataMandate->report_key }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 d-flex flex-column justify-content-start align-items-start">
                                        <!-- Form Group for Value Certificate -->
                                        <div class="form-group">
                                            <strong>ចំនួនទឹកប្រាក់:</strong>
                                            <input type="number" name="value_mandate" id="value_mandate"
                                                class="form-control @error('value_mandate') is-invalid @enderror"
                                                style="width: 100%; height: 40px; text-align: center; line-height: 60px;"
                                                oninput="updateApplyValue()">
                                            @error('value_mandate')
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
                                            <label for="attachments"><strong>កាលបរិច្ឆេទ:</strong></label>
                                            <input type="date" class="form-control" id="date_mandate" name="date_mandate"
                                                multiple style="height: 40px; width: 230px;">
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
                            <span id="fin_law" class="form-control"
                                style="width:  230px; height: 40px; text-align: center;">0</span>
                        </div>
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ចលនាឥណទាន:</strong>
                            <span id="credit_movement" class="form-control"
                                style="width:  230px; height: 40px; text-align: center;">0</span>
                        </div>

                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ស្ថានភាពឥណទានថ្មី:</strong>
                            <span id="new_credit_status" class="form-control"
                                style="width:  230px; height: 40px; text-align: center;">0</span>
                        </div>
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ឥណទានទំនេរ:</strong>
                            <span id="credit" class="form-control"
                                style="width:  230px; height: 40px; text-align: center;">0</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ធានាចំណាយពីមុន:</strong>
                            <span id="deadline_balance" class="form-control"
                                style="width:  230px; height: 40px; text-align: center;">0</span>
                        </div>

                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ស្នើរសុំលើកនេះ:</strong>
                            <span id="paying" class="form-control"
                                style="width:  230px; height: 40px; text-align: center;">0</span>
                        </div>

                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ឥណទាននៅសល់:</strong>
                            <span id="remaining_credit" class="form-control"
                                style="width:  230px; height: 40px; text-align: center;">0</span>
                        </div>
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
        document.addEventListener("DOMContentLoaded", () => {
            const searchInput = document.getElementById("searchReportKey");
            const reportKeySelect = document.getElementById("reportKeySelect");
            const resultCount = document.getElementById("resultCount");

            searchInput.addEventListener("keyup", (event) => {
                const searchValue = event.target.value.toLowerCase();

                let matchCount = 0;

                // Loop through each option in the select element
                Array.from(reportKeySelect.options).forEach((option) => {
                    const optionText = option.textContent.toLowerCase();

                    if (optionText.includes(searchValue)) {
                        option.style.display = ""; // Show the option
                        matchCount++;
                    } else {
                        option.style.display = "none"; // Hide the option
                    }
                });

                // Update result count
                resultCount.textContent = `ចំនួន: ${matchCount}`;
            });
        });

        function updateReportInputField() {
            const reportKeySelect = document.getElementById("reportKeySelect");
            const searchReportKey = document.getElementById("searchReportKey");

            // Get the selected value
            const selectedOptionText = reportKeySelect.options[reportKeySelect.selectedIndex].textContent.trim();

            // Update the input field
            searchReportKey.value = selectedOptionText;
        }
    </script>

    <script>
        function updateReportInputField() {
            const select = document.getElementById('reportKeySelect');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                // Update the input field with the selected option's text
                document.getElementById('searchReportKey').value = selectedOption.textContent;

                // Fetch additional data if required
                const mandateId = selectedOption.value; // Get the ID of the selected report
                fetch(`/mandate/${mandateId}/early-balance`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('fin_law').textContent = formatNumber(data.fin_law);
                        document.getElementById('credit_movement').textContent = formatNumber(data.credit_movement);
                        document.getElementById('new_credit_status').textContent = formatNumber(data.new_credit_status);
                        document.getElementById('credit').textContent = formatNumber(data.credit);
                        document.getElementById('deadline_balance').textContent = formatNumber(data.deadline_balance);

                        // Update remaining credit based on fetched data
                        updateRemainingCredit(data.apply || 0);
                    })
                    .catch(error => console.error('Error fetching report data:', error));
            }
        }


        function updateRemainingCredit(value_mandate) {
            const credit = parseFloat(document.getElementById('credit').textContent.replace(/,/g, '')) || 0;
            const remainingCredit = credit - value_mandate;

            if (remainingCredit < 0) {
                // Show SweetAlert error if credit is insufficient
                Swal.fire({
                    icon: 'error',
                    title: 'ជូនដំណឹង',
                    text: 'ឥណទាននៅសល់មិនគ្រប់ចំនួន',
                    confirmButtonText: 'យល់ព្រម'
                });

                document.getElementById('remaining_credit').textContent = "0"; // Set to 0
                return false; // Prevent further action
            }

            document.getElementById('remaining_credit').textContent = formatNumber(remainingCredit);
            return true; // Credit is valid
        }

        document.getElementById('value_mandate').addEventListener('input', function() {
            const valueMandate = parseFloat(this.value) || 0; // Get value or default to 0
            document.getElementById('paying').textContent = formatNumber(valueMandate); // Update paying field

            // Update remaining credit
            updateRemainingCredit(valueMandate);
        });

        function formatNumber(num) {
            if (Number.isInteger(num) || num % 1 === 0) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            } else {
                return num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        }

        // Initialize fields on page load
        document.addEventListener('DOMContentLoaded', () => {
            updateReportInputField();
        });
    </script>

    <script>
        function displaySelectedFiles() {
            const fileInput = document.getElementById('attachments'); // Get the file input
            const fileList = document.getElementById('fileList'); // Get the file list container
            const files = Array.from(fileInput.files); // Convert FileList to Array

            // Clear the list before displaying new files
            fileList.innerHTML = '';

            // Sort files by name
            files.sort((a, b) => a.name.localeCompare(b.name));

            // Loop through files and display their names with icons
            files.forEach((file, index) => {
                const listItem = document.createElement('li');
                listItem.style.cssText = 'display: flex; align-items: center; margin-bottom: 5px;';

                // Create icon element based on file type
                const icon = document.createElement('i');
                if (file.name.endsWith('.pdf')) {
                    icon.className = 'fas fa-file-pdf';
                    icon.style.color = 'red';
                } else if (file.name.endsWith('.doc') || file.name.endsWith('.docx')) {
                    icon.className = 'fas fa-file-word';
                    icon.style.color = 'blue';
                } else {
                    icon.className = 'fas fa-file-alt'; // Default icon for other file types
                    icon.style.color = 'gray';
                }
                icon.style.marginRight = '10px';

                // Add text for file name
                const text = document.createTextNode(`${index + 1}. ${file.name}`);

                // Append icon and text to the list item
                listItem.appendChild(icon);
                listItem.appendChild(text);

                // Append list item to file list
                fileList.appendChild(listItem);
            });
        }
    </script>\

    <script>
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
@endsection
