@extends('layouts.master')

@section('form-certificate-data-upload')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">បង្កើតសលាកបត្រ</h3>
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
                        <form action="{{ route('certificate-data.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row d-flex justify-content-center ">
                                <!-- First Row -->
                                <div class="col-md-3  d-flex flex-column align-items-center">
                                    <div class="form-group">
                                        <strong>លេខកូដកម្មវិធី:</strong>
                                        <input type="text" id="searchReportKey" class="form-control"
                                            placeholder="ស្វែងរកលេខកូដកម្មវិធី..." onkeyup="filterReportKeys(event)"
                                            placeholder="ស្វែងរកលេខកូដ អនុគណនី​ នឹងកម្មវិធី..." onkeyup="filterReportKeys(event)"
                                            style="width: 420px; height: 60px; text-align: center; line-height: 60px;">
                                        <p id="resultCount" style="font-weight: bold;">ចំនួន: 0</p>

                                        <select name="report_key" id="reportKeySelect" class="form-control" size="5"
                                            onchange="updateReportInputField()" style="width: 420px; height: 260px;">
                                            @foreach ($reports as $report)
                                                <option value="{{ $report->id }}">
                                                    {{$report->subAccountKey->sub_account_key }} >
                                                    {{ $report->report_key }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3  d-flex flex-column align-items-center">
                                    <div class="form-group">
                                        <strong>ចំនួនទឹកប្រាក់:</strong>
                                        <input type="number" name="value_certificate" id="value_certificate"
                                            class="form-control @error('value_certificate') is-invalid @enderror"
                                            style="width: 420px; height: 60px; text-align: center; line-height: 60px;">
                                        @error('value_certificate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn btn-primary ml-auto"
                                style="width: 300px; height: 60px;">
                                <i class="fas fa-save"></i> រក្សាទុក</button>
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

        .result-total-table-container {
            max-height: 100vh;
            overflow-y: auto;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
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
    </script>
@endsection
