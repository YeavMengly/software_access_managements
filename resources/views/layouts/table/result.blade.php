@extends('layouts.master')

@section('result')
    <form class="max-w-md mx-auto mt-3" method="GET" action="{{ route('result.index') }}">
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" name="code_id" value="{{ request('code_id') }}" class="form-control mb-2"
                    placeholder="ជំពូក">
            </div>
            <div class="col-md-3">
                <input type="text" name="account_key_id" value="{{ request('account_key_id') }}"
                    class="form-control mb-2" placeholder="គណនី">
            </div>
            <div class="col-md-3">
                <input type="text" name="sub_account_key_id" value="{{ request('sub_account_key_id') }}"
                    class="form-control mb-2" placeholder="អនុគណនី">
            </div>
            <div class="col-md-3">
                <input type="text" name="report_key" value="{{ request('report_key') }}" class="form-control mb-2"
                    placeholder="កូដកម្មវិធី">
            </div>
            <div class="col-md-3">
                <input type="date" name="date" id="date" class="form-control" placeholder="Filter by Date (MM/DD/YYYY)">
            </div>
            <div class="col-md-12">
                <div class="input-group my-3">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 50 50">
                            <path
                                d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z">
                            </path>
                        </svg>
                        ស្វែងរក
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <h3>របាយការណ៍ធានាចំណាយថវិកាក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h3>
            <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5>
            <div class="table-container">
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
                        @foreach ($reports as $report)
                            @php
                                $currentKeyCode = $report->subAccountKey->accountKey->key->code;
                                $currentAccountKeyCode = $report->subAccountKey->accountKey->account_key;
                                $currentSubAccountKeyCode = $report->subAccountKey->sub_account_key;
                                $currentReportKey = $report->report_key;
                            @endphp
                            <tr>
                                <td class="filterable" data-filter="6001">{{ $loop->iteration }}</td>
                                <td class="filterable" data-filter="{{ $report->subAccountKey->accountKey->key->code }}">
                                    {{ $report->subAccountKey->accountKey->key->code }}
                                </td>
                                <td class="filterable" data-filter="{{ $report->subAccountKey->accountKey->account_key }}">
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
                                    {{ $report->name_report_key }}</td>
                                <td> {{ $report->fin_law }}</td>
                                <td>{{ $report->current_loan }}</td>
                                <td> {{ $report->internal_increase }}</td>
                                <td> {{ $report->unexpected_increase }}</td>
                                <td>{{ $report->additional_increase }}</td>
                                <td> {{ $report->internal_increase + $report->unexpected_increase + $report->additional_increase }}
                                </td>
                                <td> {{ $report->decrease }}</td>
                                <td>503 600 000</td>
                                <td>387 694 100</td>
                                <td> </td>
                                <td>387 694 100</td>
                                <td>115 905 900</td>
                                <td>77.54%</td>
                                <td>76.98%</td>
                            </tr>
                            @php
                                $previousKeyCode = $currentKeyCode;
                                $previousAccountKeyCode = $currentAccountKeyCode;
                                $previousSubAccountKeyCode = $currentSubAccountKeyCode;
                                $previousReportKeyCode = $currentReportKey;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-danger btn-width mr-2">Export</button>
            <button type="submit" class="btn btn-primary btn-width">Print</button>
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
{{-- 
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.getElementById('reportTable');
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            const filterableCells = table.querySelectorAll('.filterable');

            function showFilteredRows(filterValue) {
                rows.forEach(row => {
                    row.classList.add('hidden-row');
                });

                rows.forEach(row => {
                    const cellValue = row.querySelector(`td.filterable[data-filter="${filterValue}"]`);
                    if (cellValue) {
                        row.classList.remove('hidden-row');
                    }
                });
            }

            filterableCells.forEach(cell => {
                cell.addEventListener('click', function() {
                    const filterValue = this.getAttribute('data-filter');
                    showFilteredRows(filterValue);
                });

                cell.addEventListener('dblclick', function() {
                    rows.forEach(row => {
                        row.classList.remove('hidden-row');
                    });
                });
            });
        });

        document.getElementById('date').addEventListener('input', function () {
            const filterValue = this.value;
            const tableBody = document.getElementById('tableBody');
            const rows = tableBody.querySelectorAll('tr');
    
            const formattedFilterValue = moment(filterValue, 'MM/DD/YYYY').format('YYYY-MM-DD'); // Use Moment.js
    
            rows.forEach(row => {
                const dateCell = row.querySelector('td.date'); // Assuming you have a `date` class for date cells
                if (dateCell) {
                    const rowDate = dateCell.textContent.trim();
                    const formattedRowDate = moment(rowDate, 'MM/DD/YYYY').format('YYYY-MM-DD');
                    if (formattedRowDate.includes(formattedFilterValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    </script>

    
@endsection --}}
