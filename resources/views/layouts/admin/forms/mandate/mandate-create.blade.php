@extends('layouts.master')

@section('form-mandate-upload')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 d-flex justify-content-between align-items-center margin-tb mb-4">
                        <a class="btn btn-danger" href="{{ route('back') }}"
                            style="width: 160px; height: 50px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-arrow-left"></i>&nbsp;&nbsp;
                        </a>
                        <h3 class="card-title" style="font-weight: 500;">
                            បញ្ចូលអាណត្តិ</h3>
                        <span></span>
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
                        <form action="{{ route('mandates.store') }}" method="POST" enctype="multipart/form-data"
                            onsubmit="validateForm(event)">
                            @csrf
                            <div class="row d-flex justify-content-between align-items-center margin-tb mb-4">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="report_key">
                                                <strong>លេខអនុគណនី & កម្មវិធី:</strong>
                                            </label>
                                            <input type="text" id="searchReportKey" class="form-control mb-2"
                                                placeholder="ស្វែងរកលេខកូដកម្មវិធី..." onkeyup="filterReportKeys(event)"
                                                style="width: 100%; height: 40px; text-align: center; line-height: 60px;">
                                            <p id="resultCount" style="font-weight: bold;">ចំនួន: 0</p>

                                            @php
                                                // Sort the reports by report_key in ascending order
                                                $sortedReports = $dataMandate->sortBy('sub_account_key');
                                            @endphp

                                            <select name="report_key" id="reportKeySelect" class="form-control"
                                                size="5" onchange="updateReportInputField()"
                                                style="width: 100%; height: 150px;">
                                                @foreach ($sortedReports as $dataMandate)
                                                    <option value="{{ $dataMandate->id }}">
                                                        {{ $dataMandate->subAccountKey->sub_account_key ?? 'N/A' }} >
                                                        {{ $dataMandate->report_key }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pay_mission"><strong>ថវិកា:</strong></label>
                                                <input type="number" name="value_mandate" id="value_mandate"
                                                    class="form-control @error('value_mandate') is-invalid @enderror"
                                                    style="width: 100%; height: 40px;" min="0"
                                                    value="{{ old('value_mandate') }}">
                                                @error('value_mandate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="mission-type"><strong>ប្រភេទបេសកកម្ម</strong></label>
                                                <div>
                                                    @foreach ($missionTypes as $missionType)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="mission_type" id="mission_type{{ $loop->index }}"
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <!-- File Input -->
                                                <label for="attachments"><strong>ជ្រើសរើស ថ្ងៃ ខែ ឆ្នាំ:</strong></label>
                                                <input type="date" class="form-control" id="date_mandate"
                                                    name="date_mandate" multiple
                                                    style="height: 45px; padding: 10px; width: 230px;">
                                            </div>
                                            <div class="form-group">
                                                <!-- File Input -->
                                                <label for="attachments"><strong>ឯកសារភ្ជាប់:</strong></label>
                                                <input type="file" class="form-control" id="attachments"
                                                    name="attachments[]" multiple
                                                    style="height: 45px; padding: 10px; width: 230px;"
                                                    onchange="displaySelectedFiles()">

                                                <!-- Display Selected Files -->
                                                <ul id="fileList" style="margin-top: 10px; padding-left: 20px;"></ul>
                                            </div>
                                        </div>
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
                                        <span id="paying" class="form-control"
                                            style="width: 80%; height: 40px; text-align: center;">0</span>
                                    </div>

                                    <div class="form-group text-center d-flex flex-column align-items-center">
                                        <strong class="d-block mb-2">ឥណទាននៅសល់:</strong>
                                        <span id="remaining_credit" class="form-control"
                                            style="width: 80%; height: 40px; text-align: center;">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn btn-primary ml-auto"
                                    style="width: 150px; height: 50px;">
                                    <i class="fas fa-save"></i> រក្សាទុក
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
            border: 1px solid rgb(133, 131, 131);
            padding: 10px;
        }

        .container-fluid {
            padding: 16px;
        }

        #subAccountKeySelect {
            text-align: left;
        }

        h3 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
        }

        .btn,
        .form-control,
        th,
        td {
            border: 1px solid black;
            /* text-align: center; */
            padding: 6px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
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
                const mandateId = selectedOption.value;
                console.log('Selected Report Key ID:', mandateId);

                fetch(`/mandate/${mandateId}/early-balance`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);

                        document.getElementById('fin_law').textContent = formatNumber(data.fin_law || 0);
                        document.getElementById('credit_movement').textContent = formatNumber(data.credit_movement ||
                        0);
                        document.getElementById('new_credit_status').textContent = formatNumber(data
                            .new_credit_status || 0);
                        document.getElementById('credit').textContent = formatNumber(data.credit || 0);
                        document.getElementById('deadline_balance').textContent = formatNumber(data.deadline_balance ||
                            0);

                        updateRemainingCredit(0); // Initialize remaining credit
                    })
                    .catch(error => {
                        console.error('Error fetching report data:', error);
                        alert('Failed to fetch report data. Please try again.');
                    });
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
    </script>
@endsection
