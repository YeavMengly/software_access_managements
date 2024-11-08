@extends('layouts.master')

@section('form-report-edit')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span></span>
                            <h3 class="card-title" style="font-weight: 700;">កែប្រែទិន្នន័យ</h3>
                            <a class="btn btn-danger d-flex justify-content-center align-items-center mr-2"
                                href="{{ route('codes.index') }}" style="width: 160px; height: 50px;"> <i
                                    class="fas fa-arrow-left"></i> &nbsp;
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
                        <form action="{{ route('codes.update', $report->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="combinedField"
                                                    class="font-weight-bold"><strong>លេខអនុគណនី:</strong></label>
                                                <input type="text" id="combinedField" class="form-control text-center"
                                                    placeholder="ស្វែងរកលេខអនុគណនី..." onkeyup="filterSubAccountKeys(event)"
                                                    style="width: 420px; height: 60px;">

                                                <p id="resultCount" style="font-weight: bold; margin-top: 8px;">ចំនួន: 0</p>

                                                <select name="sub_account_key" id="subAccountKeySelect" class="form-control"
                                                    size="5" onclick="getSelectedValue()"
                                                    style="height: 170px; width: 420px;">
                                                    @foreach ($subAccountKeys as $subAccountKey)
                                                        <option value="{{ $subAccountKey->id }}"
                                                            data-report-key="{{ $subAccountKey->report_key }}"
                                                            {{ $subAccountKey->id == $report->sub_account_key ? 'selected' : '' }}>
                                                            {{ $subAccountKey->sub_account_key }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="report_key"><strong>លេខកូដកម្មវិធី:</strong></label>
                                                <input type="number" name="report_key" id="report_key"
                                                    class="form-control @error('report_key') is-invalid @enderror"
                                                    style="width: 420px; height: 60px;"
                                                    value="{{ old('report_key', $report->report_key) }}">
                                                @error('report_key')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="fin_law"><strong>ច្បាប់ហិរញ្ញវត្ថុ:</strong></label>
                                                <input type="number" name="fin_law" id="fin_law"
                                                    class="form-control @error('fin_law') is-invalid @enderror"
                                                    style="width: 420px; height: 60px;" min="0"
                                                    oninput="updateCurrentLoan(this); formatNumber(this)"
                                                    value="{{ old('fin_law', $report->fin_law) }}">
                                                @error('fin_law')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="current_loan"><strong>ឥណទានបច្ចុប្បន្ន:</strong></label>
                                                <input type="number" name="current_loan" id="current_loan"
                                                    class="form-control @error('current_loan') is-invalid @enderror"
                                                    style="width: 420px; height: 60px;" min="0"
                                                    value="{{ old('current_loan', $report->current_loan) }}">
                                                @error('current_loan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_report_key"><strong>ចំណាត់ថ្នាក់:</strong></label>
                                        <textarea name="name_report_key" id="name_report_key"
                                            class="form-control @error('name_report_key') is-invalid @enderror" style="height: 270px; text-align: left;"
                                            placeholder="សូមបញ្ចូលចំណាត់ថ្នាក់នៅនេះ...">
                                            {{ old('name_report_key', $report->name_report_key) }}</textarea>
                                        @error('name_report_key')
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
        }

        function getSelectedValue() {
            const select = document.getElementById('subAccountKeySelect');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                const subAccountKey = selectedOption.text; // Get the selected option text
                const reportKey = selectedOption.getAttribute('data-report-key'); // Get the report key

                // Update the combinedField input with the formatted value
                document.getElementById('combinedField').value = `${subAccountKey}`;
            }
        }
    </script>
@endsection
