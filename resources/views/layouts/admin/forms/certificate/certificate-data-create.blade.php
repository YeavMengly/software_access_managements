@extends('layouts.master')

@section('form-certificate-data-upload')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">បង្កើតសលាកបត្រ</h3>
                            <a class="btn btn-danger d-flex justify-content-center align-items-center mr-2" href="{{ route('certificate-data.index') }}"
                                style="width: 160px; height: 50px;"><i
                                class="fas fa-arrow-left"></i> &nbsp; ត្រឡប់ក្រោយ</a>
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
                                <form action="{{ route('certificate-data.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="row justify-content-center">

                                        <div class="col-md-6 d-flex flex-column align-items-center">
                                            <div class="form-group">
                                                <strong>លេខកូដកម្មវិធី:</strong>
                                                <input type="text" id="searchReportKey" class="form-control"
                                                    placeholder="ស្វែងរកលេខកូដកម្មវិធី..." onkeyup="filterReportKeys(event)"
                                                    style="width: 320px; height: 60px; text-align: center; line-height: 60px;">
                                                <p id="resultCount" style="font-weight: bold;">ចំនួន: 0</p>

                                                <select name="report_key" id="reportKeySelect" class="form-control"
                                                    size="5" onchange="updateReportInputField()"
                                                    style="width: 320px; height: 260px;">
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
                                                    style="width: 320px; height: 60px; text-align: center; line-height: 60px;">
                                                @error('value_certificate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" class="btn btn-primary" style="width: 300px; height: 60px;">
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
                            <span id="fin_law" class="form-control"
                                style="width: 320px; height: 60px; text-align: center;">0</span>
                        </div>
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ចលនាឥណទាន:</strong>
                            <span id="credit_movement" class="form-control"
                                style="width: 320px; height: 60px; text-align: center;">0</span>
                        </div>
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ស្ថានភាពឥណទានថ្មី:</strong>
                            <span id="new_credit_status" class="form-control"
                                style="width: 320px; height: 60px; text-align: center;">0</span>
                        </div>
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ឥណទានទំនេរ:</strong>
                            <span id="credit" class="form-control"
                                style="width: 320px; height: 60px; text-align: center;">0</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ធានាចំណាយពីមុន:</strong>
                            <span id="deadline_balance" class="form-control"
                                style="width: 320px; height: 60px; text-align: center;">0</span>
                        </div>

                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ស្នើរសុំលើកនេះ:</strong>
                            <span id="apply" class="form-control"
                                style="width: 320px; height: 60px; text-align: center;">0</span>
                        </div>

                        <div class="form-group text-center d-flex flex-column align-items-center">
                            <strong class="d-block mb-2">ឥណទាននៅសល់:</strong>
                            <span id="remaining_credit" class="form-control"
                                style="width: 320px; height: 60px; text-align: center;">0</span>
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

        .result-total-table-container {
            max-height: 100vh;
            overflow-y: auto;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    {{-- <script>
        let selectedIndex = -1;

        function filterReportKeys(event) {
            const input = document.getElementById('searchReportKey').value.toLowerCase();
            const select = document.getElementById('reportKeySelect');
            const options = select.options;
            let count = 0;

            // Filter options based on input and reset `selectedIndex`
            selectedIndex = -1;
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

            // Handle arrow key navigation and Enter key selection
            if (event.key === 'ArrowDown') {
                navigateOptions('down', options);
            } else if (event.key === 'ArrowUp') {
                navigateOptions('up', options);
            } else if (event.key === 'Enter') {
                updateReportInputField();
            }
        }

        function navigateOptions(direction, options) {
            const step = direction === 'down' ? 1 : -1;
            selectedIndex = (selectedIndex + step + options.length) % options.length;

            while (options[selectedIndex].style.display === 'none') {
                selectedIndex = (selectedIndex + step + options.length) % options.length;
            }

            options[selectedIndex].selected = true;
            updateReportInputField();
        }

        function updateReportInputField() {
            const select = document.getElementById('reportKeySelect');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                document.getElementById('searchReportKey').value = selectedOption.textContent;
            }

            // Reset all options to be visible
            for (const option of select.options) {
                option.style.display = '';
            }

            // Reset result count after selection
            document.getElementById('resultCount').innerText = 'ចំនួន: ' + select.options.length;
        }
    </script> --}}
    {{-- <script>
        function filterReportKeys(event) {
            const searchValue = event.target.value.toLowerCase();
            let matchCount = 0;

            // Filter function for each dropdown
            const filterDropdown = (dropdown) => {
                const options = dropdown.options;
                for (let i = 0; i < options.length; i++) {
                    const optionText = options[i].text.toLowerCase();
                    options[i].style.display = optionText.includes(searchValue) ? 'block' : 'none';
                    if (optionText.includes(searchValue)) matchCount++;
                }
            };

            // Apply filter to both dropdowns
            filterDropdown(document.getElementById("reportKeySelect1"));
            filterDropdown(document.getElementById("reportKeySelect2"));

            // Update result count
            document.getElementById("resultCount").innerText = `ចំនួន: ${matchCount}`;
        }
   
    </script> --}}
    {{--  --}}
    {{-- <script>
        function filterReportKeys(event) {
            var input = document.getElementById('searchReportKey').value.toLowerCase();
            var select = document.getElementById('reportKeySelect');
            var options = select.options;
            var count = 0;

            for (var i = 0; i < options.length; i++) {
                var optionText = options[i].textContent.toLowerCase();
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
                    while (options[selectedIndex].style.display === 'none') {
                        selectedIndex++;
                        if (selectedIndex >= options.length) {
                            selectedIndex = options.length - 1;
                            break;
                        }
                    }
                    options[selectedIndex].selected = true;
                    updateReportInputField();
                }
            } else if (event.key === 'ArrowUp') {
                if (selectedIndex > 0) {
                    selectedIndex--;
                    while (options[selectedIndex].style.display === 'none') {
                        selectedIndex--;
                        if (selectedIndex < 0) {
                            selectedIndex = 0;
                            break;
                        }
                    }
                    options[selectedIndex].selected = true;
                    updateReportInputField();
                }
            } else if (event.key === 'Enter') {
                updateReportInputField();
            }
        }

        function updateReportInputField() {
            var select = document.getElementById('reportKeySelect');
            var selectedOption = select.options[select.selectedIndex];
            if (selectedOption) {
                document.getElementById('searchReportKey').value = selectedOption.textContent;
            }
        }
    </script> --}}
    {{-- <script>
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Example function to update the fields with formatted numbers
        function updateReportInputField() {
            const reportKeySelect = document.getElementById('reportKeySelect');
            const reportKeyId = reportKeySelect.value;

            if (reportKeyId) {
                fetch(`/reports/${reportKeyId}/early-balance`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('fin_law').textContent = formatNumber(data.fin_law);
                        document.getElementById('credit_movement').textContent = formatNumber(data.credit_movement);
                        document.getElementById('new_credit_status').textContent = formatNumber(data.new_credit_status);
                        document.getElementById('credit').textContent = formatNumber(data.credit);
                        document.getElementById('deadline_balance').textContent = formatNumber(data.deadline_balance);
                        document.getElementById('apply').textContent = formatNumber(data.apply);
                        document.getElementById('remaining_credit').textContent = formatNumber(data.credit - data
                            .apply); // Example calculation
                    })
                    .catch(error => console.error('Error fetching report data:', error));
            }
        }
    </script> --}}
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

        function updateReportInputField() {
            const select = document.getElementById('reportKeySelect');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                // Update input field with selected option text
                document.getElementById('searchReportKey').value = selectedOption.textContent;

                // Optionally fetch related data based on the selected report key
                const reportKeyId = selectedOption.value;
                fetch(`/reports/${reportKeyId}/early-balance`)
                    .then(response => response.json())
                    .then(data => {
                        // Assume you have elements to display these values
                        document.getElementById('fin_law').textContent = formatNumber(data.fin_law);
                        document.getElementById('credit_movement').textContent = formatNumber(data.credit_movement);
                        document.getElementById('new_credit_status').textContent = formatNumber(data.new_credit_status);
                        document.getElementById('credit').textContent = formatNumber(data.credit);
                        document.getElementById('deadline_balance').textContent = formatNumber(data.deadline_balance);
                        document.getElementById('apply').textContent = formatNumber(data.apply);
                        document.getElementById('remaining_credit').textContent = formatNumber(data.credit - data
                            .apply); // Example calculation
                    })
                    .catch(error => console.error('Error fetching report data:', error));
            }
        }

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
@endsection
