@extends('layouts.master')

@section('result')
    <div class="border-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12 margin-tb mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="btn btn-danger" href="{{ url('/') }}"> <i class="fas fa-arrow-left"></i>
                            ត្រឡប់ក្រោយ</a>
                    </div>
                </div>
            </div>

            {{--                    Start Form Search                      --}}
            <form id="filterForm" class="max-w-md mx-auto mt-3" method="GET" action="{{ route('result.index') }}">
                <div class="row mb-3">

                    {{-- Filter Code --}}
                    <div class="col-md-3">
                        <input type="text" name="code_id" value="{{ request('code_id') }}" class="form-control mb-2"
                            placeholder="ជំពូក">
                    </div>

                    {{-- Filter Account --}}
                    <div class="col-md-3">
                        <input type="text" name="account_key_id" value="{{ request('account_key_id') }}"
                            class="form-control mb-2" placeholder="គណនី">
                    </div>

                    {{-- Filter Sub-Account --}}
                    <div class="col-md-3">
                        <input type="text" name="sub_account_key_id" value="{{ request('sub_account_key_id') }}"
                            class="form-control mb-2" placeholder="អនុគណនី">
                    </div>

                    {{-- Filter Report --}}
                    <div class="col-md-3">
                        <input type="text" name="report_key" value="{{ request('report_key') }}"
                            class="form-control mb-2" placeholder="កូដកម្មវិធី">
                    </div>

                    {{-- Filter Date --}}
                    <div class="col-md-3">
                        <input type="date" name="date" id="date" value="{{ request('date') }}"
                            class="form-control" placeholder="Filter by Date (MM/DD/YYYY)">
                    </div>

                    {{--        Start btn search and reset       --}}
                    <div class="col-md-12">
                        <div class="input-group my-3">
                            <button type="submit" class="btn btn-primary mr-2" style="width: 150px; height: 40px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 50 50">
                                    <path
                                        d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z">
                                    </path>
                                </svg>
                                ស្វែងរក
                            </button>
                            <button type="button" id="resetBtn" class="btn btn-danger"
                                style="width: 150px; height: 40px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-x-circle" viewBox="0 0 16 16">
                                    <path
                                        d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm3.646 4.646a.5.5 0 0 1 0 .708L8.707 8l2.939 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.939a.5.5 0 1 1-.708-.708L7.293 8 4.354 5.354a.5.5 0 1 1 .708-.708L8 7.293l2.646-2.647a.5.5 0 0 1 .707 0z" />
                                </svg>
                                កំណត់ឡើងវិញ
                            </button>

                        </div>
                    </div>
                    {{--        End btn search and reset       --}}
                </div>
            </form>
            {{--                    End Form Search                      --}}


            <div class="border-wrapper">
                <div class="result-total-table-container">
                    <h3>របាយការណ៍ធានាចំណាយថវិកាក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h3>
                    <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5>
                    <div class="table-container">

                        {{--            Table           --}}
                        <table id="reportTable" class="table-border">
                            <thead class="header-border">
                                <tr>
                                    <th rowspan="3">លេខ</th>
                                    <th rowspan="3">ជំពូក</th>
                                    <th rowspan="3">គណនី</th>
                                    <th rowspan="3">អនុគណនី</th>
                                    <th rowspan="3">កូដកម្មវិធី</th>
                                    <th rowspan="3">ចំណាត់ថ្នាក់</th>
                                    <th rowspan="3">ច្បាប់ហិ.វ</th>
                                    <th rowspan="3">ឥណទានបច្ចុប្បន្ន</th>
                                    <th colspan="5">ចលនាឥណទាន</th>
                                    <th rowspan="3">វិចារណកម្ម</th>
                                    <th rowspan="3">ស្ថានភាពឥណទានថ្មី</th>
                                    <th rowspan="3">ស.ម.ដើមគ្រា</th>
                                    <th rowspan="3">អនុវត្ត</th>
                                    <th rowspan="3">ស.ម.ចុងគ្រា</th>
                                    <th rowspan="3">ឥ.សល់</th>
                                    <th colspan="2" rowspan="2">%ប្រៀបធៀប</th>
                                </tr>
                                <tr>
                                    <th colspan="4">កើន</th>
                                    <th rowspan="2">ថយ</th>
                                </tr>
                                <tr>
                                    <th>កើនផ្ទៃក្នុង</th>
                                    <th class="rotate-text">មិនបានគ្រោងទុក</th>
                                    <th>បំពេញបន្ថែម</th>
                                    <th>សរុប</th>
                                    <th>%ច្បាប់</th>
                                    <th>%ច្បាប់កែតម្រូវ</th>
                                </tr>
                            </thead>
                            <tbody class="cell-border">
                                @php
                                    $previousKeyCode = $previousAccountKeyCode = $previousSubAccountKeyCode = $previousReportKeyCode = null;
                                @endphp
                                {{-- start import data --}}
                                @foreach ($reports as $report)
                                    @php
                                        $currentKeyCode = $report->subAccountKey->accountKey->key->code;
                                        $currentAccountKeyCode = $report->subAccountKey->accountKey->account_key;
                                        $currentSubAccountKeyCode = $report->subAccountKey->sub_account_key;
                                        $currentReportKey = $report->report_key;
                                    @endphp
                                    <tr>
                                        <td class="filterable" data-filter="6001">{{ $loop->iteration }}</td>
                                        <td class="filterable"
                                            data-filter="{{ $report->subAccountKey->accountKey->key->code }}">
                                            {{ $report->subAccountKey->accountKey->key->code }}
                                        </td>
                                        <td class="filterable"
                                            data-filter="{{ $report->subAccountKey->accountKey->account_key }}">
                                            {{ $report->subAccountKey->accountKey->account_key }}
                                        </td>
                                        <td class="filterable" data-filter="{{ $report->subAccountKey->sub_account_key }}">
                                            {{ $report->subAccountKey->sub_account_key }}
                                        </td>
                                        <td class="filterable" data-filter="{{ $report->report_key }}">
                                            {{ $report->report_key }}
                                        </td>
                                        <td
                                            style="border: 1px solid black; max-width: 200px; text-align: center; overflow-y: auto; white-space: nowrap;">
                                            {{ $report->name_report_key }}
                                        </td>
                                        <td>{{ number_format($report->fin_law, 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($report->current_loan, 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($report->internal_increase, 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($report->unexpected_increase, 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($report->additional_increase, 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($report->total_increase, 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($report->decrease, 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($report->editorial, 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($report->new_credit_status, 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($report->early_balance, 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($report->apply, 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($report->deadline_balance, 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($report->credit, 0, ' ', ' ') }}</td>
                                        {{-- <td>{{ $report->law_average }}</td>
                                <td>{{ $report->law_correction }}</td> --}}
                                        <td style="border: 1px solid black; text-align: center">
                                            {{ ($report->earlyBalance + $report->apply) / $report->fin_law }}%</td>
                                        <td style="border: 1px solid black; text-align: center">
                                            {{ $report->law_correction }}%
                                        </td>
                                    </tr>
                                    @php
                                        $previousKeyCode = $currentKeyCode;
                                        $previousAccountKeyCode = $currentAccountKeyCode;
                                        $previousSubAccountKeyCode = $currentSubAccountKeyCode;
                                        $previousReportKeyCode = $currentReportKey;
                                    @endphp
                                @endforeach
                                {{-- End import data --}}
                            </tbody>
                        </table>
                        {{--            Table           --}}

                    </div>
                </div>

                {{--        Start action btn export and print        --}}
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('result.export') }}" class="btn btn-danger btn-width mr-2">Export</a>
                    <a href="{{ route('result.exportPdf') }}" class="btn btn-primary btn-width mr-2">Print</a>
                </div>
                {{--        Start action btn export and print        --}}

            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .border-wrapper {
            border: 2px solid black;

        }

        .container-fluid {
            padding: 16px;
            max-height: 100vh;
        }

        .table-container {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }

        h3,
        h5 {
            text-align: center;
            font-family: 'OS Moul', sans-serif;
        }

        .btn-width {
            width: 120px;
        }

        .filterable {
            cursor: pointer;
            background-color: #f0f0f0;
        }

        .hidden-row {
            display: none;
        }
    </style>
@endsection

@section('scripts')
    {{--            Start action for filter search                --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let typingTimer; // Timer identifier
            const doneTypingInterval = 5000; // Time in ms (0.5 seconds)

            document.querySelectorAll('#filterForm input').forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(typingTimer); // Clear the previous timer
                    typingTimer = setTimeout(() => {
                        document.getElementById('filterForm')
                            .submit(); // Submit the form after the delay
                    }, doneTypingInterval);
                });

                input.addEventListener('keydown', function() {
                    clearTimeout(typingTimer); // Prevent form submission if user is still typing
                });
            });
        });
    </script>
    {{--            End action for filter search                --}}

    {{--            Start action for btn reset                --}}
    <script>
        document.getElementById('resetBtn').addEventListener('click', function() {
            // Clear all input fields
            document.querySelectorAll('#filterForm input').forEach(input => input.value = '');

            // Reload the page without query parameters
            window.location.href = "{{ route('result.index') }}";
        });
    </script>
    {{--            End action for btn reset                --}}
@endsection
