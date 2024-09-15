@extends('layouts.master')

@section('content-table-mission-cambodia')
    <form class="max-w-md mx-auto mt-3" method="GET" action="">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group my-3" style="width: 70%;">
                    <input type="search" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="ស្វែងរកទិន្នន័យ" aria-label="Search Address">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 50 50">
                            <path
                                d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z">
                            </path>
                        </svg>
                    </button>
                </div>
                <!-- Search by date -->
                <div class="input-group my-3" style="width: 70%; font-family: 'Khmer OS Siemreap', sans-serif">
                    <input type="date" name="search_date" value="{{ request('search_date') }}" class="form-control"
                        placeholder="Start Date" aria-label="Start Date">
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-end py-3">
                    <a class="btn btn-success" href="{{ route('mission-cam.create') }}" style="font-family: 'Khmer OS Siemreap', sans-serif;">បញ្ចូលទិន្នន័យ</a>
                </div>
            </div>
        </div>
    </form>
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="first-header">
                <h4>ព្រះរាជាណាចក្រកម្ពុជា</h4>
                <h3>ជាតិ​ សាសនា ព្រះមហាក្សត្រ</h3>
            </div>
            <div class="second-header">
                <h4>ក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h4>
                <h4>អគ្គនាយកដ្ឋានរដ្ឋបាល និងហិរញ្ញវត្ថុ</h4>
                <h4>នាយកដ្ឋានហិរញ្ញវត្ថុ និងទ្រព្យសម្បត្តិរដ្ឋ</h4>
                <h4>ការិយាល័យហិរញ្ញវត្ថុ</h4>
            </div>
            <div class="third-header">
                <h4>តារាងរបាយការណ៍ចំណាយបេសកកម្មក្រៅប្រទេសឆ្នាំ ២០២៤</h4>
                <h4>របស់អគ្គនាយករដ្ឋបាល និងហិរញ្ញវត្ថុ</h4>
            </div>
            <div class="table-container">
                <table class="table-border ">
                    <thead>
                        <tr>
                            <th rowspan="2" style="border: 2px solid black; align-items: center;">ល.រ</th>
                            <th rowspan="2" style="border: 2px solid black;">គោត្តនាម​​ និងនាម</th>
                            <th rowspan="2" style="border: 2px solid black;">តួនាទី</th>
                            <th rowspan="2" style="border: 2px solid black;">ប្រភេទមុខតំណែង</th>
                            <th colspan="2" style="border: 2px solid black;">លិខិតបញ្ជាបេសកកម្ម</th>
                            <th rowspan="2" style="border: 2px solid black;">កម្មវត្ថុនៃការចុះបេសកកមម្ម</th>
                            <th rowspan="2" style="border: 2px solid black;">ទីកន្លែង</th>
                            <th colspan="2" style="border: 2px solid black;">កាលបរិច្ឆេទចុះបេសកកម្ម</th>
                            <th rowspan="2" style="border: 2px solid black;">ចំនួនថ្ងៃ</th>
                            <th rowspan="2" style="border: 2px solid black;">ចំនួនយប់</th>
                            <th rowspan="2" style="border: 2px solid black;">សោហ៊ុយធ្វើដំណើរ</th>
                            <th colspan="2" style="border: 2px solid black;">ប្រាក់ហោប៉ៅ</th>
                            <th colspan="2" style="border: 2px solid black;">ប្រាក់ហូបចុក</th>
                            <th colspan="2" style="border: 2px solid black;">ប្រាក់ស្នាក់នៅ</th>
                            <th rowspan="2" style="border: 2px solid black;">សោហ៊ុយផ្សេងៗ</th>
                            <th rowspan="2" style="border: 2px solid black;">ទឹកប្រាក់សរុប</th>
                        </tr>
                        <tr>
                            <th style="border: 2px solid black;">លេខ</th>
                            <th style="border: 2px solid black;">កាលបរិច្ឆេទ</th>
                            <th style="border: 2px solid black;">ចាប់ផ្ដើម</th>
                            <th style="border: 2px solid black;">ត្រឡប់</th>
                            <th style="border: 2px solid black;">របប</th>
                            <th style="border: 2px solid black;">សរុប</th>
                            <th style="border: 2px solid black;">របប</th>
                            <th style="border: 2px solid black;">សរុប</th>
                            <th style="border: 2px solid black;">របប</th>
                            <th style="border: 2px solid black;">សរុប</th>
                        </tr>
                    </thead>
                    <tbody style="border: 2px solid black;">
                        <tr>
                            <td colspan="21" style="text-align: left;">សម្រាប់កម្មវិធីទី០៥ ចង្កោមសកម្មភាពទី០១ ស្ដីពី
                                ពង្រឹងប្រសិទ្ធភាពនៃការអនុវត្តចំណាយ និងការគ្រប់គ្រងកិច្ចការហិរញ្ញវត្ថុតាមប្រព័ន្ធ FMIS</td>
                        </tr>
                        @foreach ($missions as $index => $mission)
                            <tr>
                                <td style="border: 2px solid black;">{{ $index + 1 }}</td>
                                <td style="border: 2px solid black; width:180px;">{{ $mission->name }}</td>
                                <td style="border: 2px solid black; width: 100px;">{{ $mission->role }}</td>
                                <td style="border: 2px solid black;">{{ $mission->position_type }}</td>
                                <td style="border: 2px solid black;">{{ $mission->letter_number }}</td>
                                <td style="border: 2px solid black; width: 110px;">{{ $mission->letter_date }}</td>
                                <td style="border: 2px solid black;">{{ $mission->mission_objective }}</td>
                                <td style="border: 2px solid black;">{{ $mission->location }}</td>
                                <td style="border: 2px solid black; width: 110px;">{{ $mission->mission_start_date }}</td>
                                <td style="border: 2px solid black; width: 110px;">{{ $mission->mission_end_date }}</td>
                                <td style="border: 2px solid black;">{{ $mission->days_count }}</td>
                                <td style="border: 2px solid black;">{{ $mission->nights_count }}</td>
                                <td style="border: 2px solid black;">
                                    {{ number_format($mission->travel_allowance, 0, '.', ',') }}</td>
                                <td style="border: 2px solid black;">
                                    {{ number_format($mission->pocket_money, 0, '.', ',') }}</td>
                                <td style="border: 2px solid black;">
                                    {{ number_format($mission->total_pocket_money, 0, '.', ',') }}</td>
                                <td style="border: 2px solid black;">{{ number_format($mission->meal_money, 0, '.', ',') }}
                                </td>
                                <td style="border: 2px solid black;">
                                    {{ number_format($mission->total_meal_money, 0, '.', ',') }}</td>
                                <td style="border: 2px solid black;">
                                    {{ number_format($mission->accommodation_money, 0, '.', ',') }}</td>
                                <td style="border: 2px solid black;">
                                    {{ number_format($mission->total_accommodation_money, 0, '.', ',') }}</td>
                                <td style="border: 2px solid black;">
                                    {{ number_format($mission->other_allowances, 0, '.', ',') }}</td>
                                <td style="border: 2px solid black;">
                                    {{ number_format($mission->final_total, 0, '.', ',') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('table-mission-abroad') }}?search={{ request('search') }}"
                class="btn btn-danger btn-width mr-2">Export</a>
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

        h3 {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 25px;
        }

        h4 {
            font-family: 'Khmer OS Muol Light', sans-serif;
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

        .first-header {
            text-align: center;
            margin-bottom: 70px;
        }

        .third-header {
            text-align: center;
            padding: 10px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.getElementById('reportTable');
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            const filterableCells = table.querySelectorAll('.filterable');

            let filtersToShow = [];
            let allRows = rows; // Keep reference to all rows for double-click reset

            function showFilteredRows(filterValue) {
                // Hide all rows first
                rows.forEach(row => {
                    row.classList.add('hidden-row');
                });

                // Show rows that match the filter value in any filterable cell
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
                    filtersToShow.push(filterValue);

                    // Check if the filterValue is unique and adjust the display accordingly
                    const filteredRows = rows.filter(row => {
                        return row.querySelector(
                            `td.filterable[data-filter="${filterValue}"]`);
                    });

                    if (filteredRows.length > 0) {
                        showFilteredRows(filterValue);
                    }
                });

                cell.addEventListener('dblclick', function() {
                    filtersToShow = [];
                    rows.forEach(row => {
                        row.classList.remove('hidden-row');
                    });
                });
            });
        });
    </script>
@endsection
