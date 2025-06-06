@extends('layouts.master')

@section('form-report-upload')
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
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-flex justify-content-center align-items-center">
                <div class="card shadow-lg" style="width: 90%;">
                    <h3 class="card-title text-center mt-4" style="font-weight: 500;">បង្កើតទិន្នន័យឥណទានអនុម័តដើមឆ្នាំ
                        សម្រាប់សលាកបត្រ</h3>
                    <div class="card-body px-5 py-4">
                        <form action="{{ route('codes.store') }}" method="POST" enctype="multipart/form-data"
                            onsubmit="validateForm(event)">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-md-4">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="searchSubAccountKey" class="font-weight-bold text-center">
                                                    <strong>លេខអនុគណនី:</strong>
                                                </label>
                                                <input type="text" id="searchSubAccountKey"
                                                    class="form-control text-center" placeholder="ស្វែងរកលេខអនុគណនី..."
                                                    onkeyup="filterSubAccountKeys(event)"
                                                    oninput="resetSubAccountSelection()" style="width: 230px; height: 40px;"
                                                    value="{{ old('searchSubAccountKey') }}">
                                                <p id="resultCount" style="font-weight: bold; margin-top: 8px;">ចំនួន: 0</p>
                                                <select name="sub_account_key" id="subAccountKeySelect" class="form-control"
                                                    size="5" onclick="getSelectedValue()"
                                                    style="height: 130px; width:  230px; ">
                                                    @foreach ($subAccountKeys as $subAccountKey)
                                                        <option
                                                            value="{{ $subAccountKey->sub_account_key }}"{{ old('sub_account_key') == $subAccountKey->id ? 'selected' : '' }}>{{ $subAccountKey->sub_account_key }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('sub_account_key')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="report_key"
                                                    class="font-weight-bold text-center"><strong>លេខកូដកម្មវិធី:</strong></label>
                                                <input type="number" name="report_key" id="report_key"
                                                    class="form-control @error('report_key') is-invalid @enderror"
                                                    style="width: 230px;  height: 40px;" min="0">
                                                @error('report_key')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            </div>
                                            <div class="form-group">
                                                <label for="fin_law"
                                                    class="font-weight-bold text-center"><strong>ច្បាប់ហិរញ្ញវត្ថុ:</strong></label>
                                                <input type="number" name="fin_law" id="fin_law"
                                                    class="form-control @error('fin_law') is-invalid @enderror"
                                                    style="width:  230px;  height: 40px;" min="0"
                                                    oninput="updateCurrentLoan(this); formatNumber(this)">
                                                @error('fin_law')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            </div>

                                            <div class="form-group">
                                                <label for="current_loan"
                                                    class="font-weight-bold text-center"><strong>ឥណទានបច្ចុប្បន្ន:</strong></label>
                                                <input type="number" name="current_loan" id="current_loan"
                                                    class="form-control @error('current_loan') is-invalid @enderror"
                                                    style="width:  230px;  height: 40px;" min="0">
                                                @error('current_loan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name_report_key"
                                            class="font-weight-bold text-center"><strong>ចំណាត់ថ្នាក់:</strong></label>
                                        <textarea name="name_report_key" id="name_report_key"
                                            class="form-control @error('name_report_key') is-invalid @enderror"
                                            style="height: 215px; text-align: left; width: 100%;" placeholder="សូមបញ្ចូលចំណាត់ថ្នាក់នៅនេះ..."></textarea>
                                        @error('name_report_key')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date_year"
                                            class="font-weight-bold text-center"><strong>ឆ្នាំចាប់ផ្ដើម</strong></label>
                                        <select name="date_year" id="date_year"
                                            class="form-control @error('date_year') is-invalid @enderror"
                                            style="width:  230px;  height: 40px;">
                                            <option value="">-- ជ្រើសរើសឆ្នាំ --</option>
                                            @foreach ($years as $year)
                                                @if ($year->status == 'active')
                                                    <option value="{{ $year->id }}"
                                                        {{ 'date_year' == $year->id ? 'selected' : '' }}>
                                                        @php
                                                            $date = \Carbon\Carbon::parse($year->date_year);
                                                            $khmerMonth = getKhmerMonth($date->month);
                                                            $khmerYear = convertToKhmerNumber($date->year);
                                                        @endphp
                                                        {{ $date->day }} {{ $khmerMonth }} {{ $khmerYear }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('date_year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
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
        function updateCurrentLoan(finLawInput) {
            const finLawValue = parseFloat(finLawInput.value) || 0;
            const currentLoanInput = document.getElementById('current_loan');
            currentLoanInput.value = finLawValue;
        }

        function formatNumber(input) {

            const value = input.value;
            input.value = value.replace(/\D/g, '');
        }
    </script>
    <script>
        function setSelectedYear() {
            var selectedYear = document.getElementById('dateYearSelect').value;
            document.getElementById('date_year').value = selectedYear; // Update the readonly input field
        }
    </script>
    <script>
        let selectedIndex = -1;

        function filterSubAccountKeys(event) {
            var input = document.getElementById('searchSubAccountKey').value.toLowerCase();
            var select = document.getElementById('subAccountKeySelect');
            var options = select.options;
            var count = 0;
            for (var i = 0; i < options.length; i++) {
                var optionText = options[i].textContent.toLowerCase();
                if (optionText.includes(input)) {
                    options[i].style.display = '';
                    count++;
                } else {
                    options[i].style.display = 'none';
                }
            }

            document.getElementById('resultCount').innerText = 'ចំនួន: ' + count;

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
                    updateSubAccountInputField();
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
                    updateSubAccountInputField();
                }
            } else if (event.key === 'Enter') {
                updateSubAccountInputField();
            }
        }

        function resetSubAccountSelection() {
            selectedIndex = -1;
            var select = document.getElementById('subAccountKeySelect');
            select.selectedIndex = -1;
        }

        function updateSubAccountInputField() {
            var select = document.getElementById('subAccountKeySelect');
            var selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                document.getElementById('searchSubAccountKey').value = selectedOption.textContent;
            }
        }

        function getSelectedValue() {
            updateSubAccountInputField();
        }
    </script>
@endsection
