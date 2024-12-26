@extends('layouts.master')

@section('form-plans-upload')
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
                            តារាងបញ្ចូលបេសកកម្មចំណាយតាមកម្មវិធី</h3>
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
                        <form action="{{ route('mission-planning.store') }}" method="POST" enctype="multipart/form-data" onsubmit="validateForm(event)">
                            @csrf
                            <div class="row d-flex justify-content-between align-items-center margin-tb mb-4">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="report_key"> <strong>លេខកូដកម្មវិធី:</strong></label>
                                            <input type="text" id="searchReportKey" class="form-control mb-2"
                                                placeholder="ស្វែងរកលេខកូដកម្មវិធី..." onkeyup="filterReportKeys(event)"
                                                style="width: 100%; height: 40px; text-align: center; line-height: 60px;">
                                            <p id="resultCount" style="font-weight: bold;">ចំនួន: 0</p>
                                            <select name="report_key" id="reportKeySelect" class="form-control"
                                                size="5" onchange="updateReportInputField()"
                                                style="width: 100%; height: 150px;">
                                                @foreach ($reports as $report)
                                                    <option value="{{ $report->id }}"> <!-- This sends the ID -->
                                                        <span>{{ $report->subAccountKey->sub_account_key ?? 'N/A' }} > {{ $report->report_key }}</span>
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pay_mission"><strong>ទឹកប្រាក់ចំណាយបេសកកម្ម:</strong></label>
                                                <input type="number" name="pay_mission" id="pay_mission"
                                                    class="form-control @error('pay_mission') is-invalid @enderror"
                                                    style="width: 80%; height: 40px;" min="0"
                                                    value="{{ old('pay_mission') }}">
                                                @error('pay_mission')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                
                                        <div class="col-md-4">
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
                
                                    </div>
                                </div>
                            </div>
                
                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn btn-primary ml-auto" style="width: 150px; height: 50px;">
                                    <i class="fas fa-save"></i> Save
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
@endsection
