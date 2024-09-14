@extends('layouts.master')

@section('form-report-edit')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">កែប្រែទិន្នន័យ</h3>
                            <a class="btn btn-danger" href="{{ route('codes.index') }}"> <i class="fas fa-arrow-left"></i>
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
                                    <!-- Sub Account Key Input -->
                                    <div class="form-group">
                                        <strong>លេខអនុគណនី:</strong>
                                        <select name="sub_account_key" class="form-control">
                                            @foreach ($subAccountKeys as $subAccountKey)
                                                <option value="{{ $subAccountKey->id }}"
                                                    {{ $subAccountKey->id == $report->sub_account_key ? 'selected' : '' }}>
                                                    {{ $subAccountKey->accountKey->key->code }} -
                                                    {{ $subAccountKey->accountKey->account_key }} -
                                                    {{ $subAccountKey->sub_account_key }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Report Key Input -->
                                    <div class="form-group">
                                        <label for="report_key">លេខកូដកម្មវិធី:</label>
                                        <input type="number" name="report_key" id="report_key"
                                            value="{{ old('report_key', $report->report_key) }}"
                                            class="form-control @error('report_key') is-invalid @enderror">
                                        @error('report_key')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Name Report Key Input -->
                                    <div class="form-group">
                                        <label for="name_report_key">ចំណាត់ថ្នាក់:</label>
                                        <input type="text" name="name_report_key" id="name_report_key"
                                            value="{{ old('name_report_key', $report->name_report_key) }}"
                                            class="form-control @error('name_report_key') is-invalid @enderror">
                                        @error('name_report_key')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Financial Law Input -->
                                    <div class="form-group">
                                        <label for="fin_law">ច្បាប់ហិរញ្ញវត្ថុ:</label>
                                        <input type="number" name="fin_law" id="fin_law"
                                            value="{{ old('fin_law', $report->fin_law) }}"
                                            class="form-control @error('fin_law') is-invalid @enderror"
                                            oninput="updateCurrentLoan(this)">
                                        @error('fin_law')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Current Loan Input (readonly) -->
                                    <div class="form-group">
                                        <label for="current_loan">ឥណទានបច្ចុប្បន្ន:</label>
                                        <input type="number" name="current_loan" id="current_loan"
                                            value="{{ old('current_loan', $report->current_loan) }}"
                                            class="form-control @error('current_loan') is-invalid @enderror" readonly>
                                        @error('current_loan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- Internal Increase Input -->
                                    <div class="form-group">
                                        <label for="internal_increase">កើនផ្ទៃក្នុង:</label>
                                        <input type="number" name="internal_increase" id="internal_increase"
                                            value="{{ old('internal_increase', $report->internal_increase) }}"
                                            class="form-control @error('internal_increase') is-invalid @enderror"
                                            oninput="formatNumber(this)">
                                        @error('internal_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Unexpected Increase Input -->
                                    <div class="form-group">
                                        <label for="unexpected_increase">មិនបានគ្រោងទុក:</label>
                                        <input type="number" name="unexpected_increase" id="unexpected_increase"
                                            value="{{ old('unexpected_increase', $report->unexpected_increase) }}"
                                            class="form-control @error('unexpected_increase') is-invalid @enderror"
                                            oninput="formatNumber(this)">
                                        @error('unexpected_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Additional Increase Input -->
                                    <div class="form-group">
                                        <label for="additional_increase">បំពេញបន្ថែម:</label>
                                        <input type="number" name="additional_increase" id="additional_increase"
                                            value="{{ old('additional_increase', $report->additional_increase) }}"
                                            class="form-control @error('additional_increase') is-invalid @enderror"
                                            oninput="formatNumber(this)">
                                        @error('additional_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Decrease Input -->
                                    <div class="form-group">
                                        <label for="decrease">ថយ:</label>
                                        <input type="number" name="decrease" id="decrease"
                                            value="{{ old('decrease', $report->decrease) }}"
                                            class="form-control @error('decrease') is-invalid @enderror"
                                            oninput="formatNumber(this)">
                                        @error('decrease')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group">
                                        <label for="apply">អនុវត្ត:</label>
                                        <input type="number" name="apply" id="apply"
                                            value="{{ old('apply', $report->apply) }}"
                                            class="form-control @error('apply') is-invalid @enderror" readonly>
                                        @error('apply')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> --}}


                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn btn-primary ml-auto">បានរក្សាទុក</button>
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
    </script>
@endsection
