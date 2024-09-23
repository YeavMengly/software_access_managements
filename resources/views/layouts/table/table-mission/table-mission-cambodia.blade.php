@extends('layouts.master')

@section('content-table-mission-cambodia')
    <div class="sticky-header">
        <div class="row mt-4 mr-4">
            <div class="col-lg-12 margin-tb mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <a class="btn btn-danger" href="{{ url('/card_certificate') }}"
                        style="font-family: 'Khmer OS Siemreap', sans-serif;"> <i class="fas fa-arrow-left"></i>
                        ត្រឡប់ក្រោយ</a>
                </div>
            </div>
        </div>
        <form class="max-w-md mx-auto mt-3" method="GET" action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group my-3" style="width: 70%; font-family: 'Khmer OS Siemreap', sans-serif">
                        <input type="search" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="ស្វែងរកទិន្នន័យ" aria-label="Search Address">

                    </div>
                    <!-- Search by date -->
                    <div class="input-group mt-3 my-3" style="width: 70%; font-family: 'Khmer OS Siemreap', sans-serif">
                        <!-- Label for Start Date -->
                        <div class="input-group-prepend">
                            <span class="input-group-text"
                                style="background-color: #007bff; color: white;">ចាប់ពីថ្ងៃ</span>
                        </div>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control"
                            placeholder="Start Date" aria-label="Start Date">
                        <!-- Label for End Date -->
                        <div class="input-group-prepend ml-5">
                            <span class="input-group-text" style="background-color: #007bff; color: white;">ដល់ថ្ងៃ</span>
                        </div>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control"
                            placeholder="End Date" aria-label="End Date">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-end py-3">
                        <a class="btn btn-success" href="{{ route('mission-cam.create') }}"
                            style="font-family: 'Khmer OS Siemreap', sans-serif;">បញ្ចូលទិន្នន័យ</a>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ml-3"
                    style="background-color: #007bff;
                    padding: 10px 40px; 
                    font-size: 18px; 
                    font-family: 'Khmer OS Siemreap', sans-serif; 
                    transition: background-color 0.3s ease, transform 0.3s ease; 
                    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    ស្វែងរក
                </button>

                <!-- Clear Button -->
                <button type="button" class="btn btn-secondary ml-3" onclick="clearSearch()"
                    style="padding: 10px 40px;
                    font-size: 18px;
                    font-family: 'Khmer OS Siemreap', sans-serif;
                    background-color: #6c757d;
                    transition: background-color 0.3s ease;">
                    សម្អាតទិន្នន័យ
                </button>

            </div>
        </form>
        <div class="d-flex justify-content-end mb-2">
            <!-- Dropdown for showing number of items per page -->
            <div style="width: 120px;">
                <select name="per_page" class="form-control" onchange="window.location.href=this.value;">
                    <option value="{{ url()->current() }}?per_page=25" {{ request('per_page') == 25 ? 'selected' : '' }}>
                        បង្ហាញ 25</option>
                    <option value="{{ url()->current() }}?per_page=50" {{ request('per_page') == 50 ? 'selected' : '' }}>
                        បង្ហាញ 50</option>
                    <option value="{{ url()->current() }}?per_page=100" {{ request('per_page') == 100 ? 'selected' : '' }}>
                        បង្ហាញ 100</option>
                </select>
            </div>
        </div>
    </div>

    <div class="border-wrapper mt-3">
        <div class="result-total-table-container">
            <div class="first-header">
                <h4>ព្រះរាជាណាចក្រកម្ពុជា</h4>
                <h3>ជាតិ សាសនា ព្រះមហាក្សត្រ</h3>
            </div>
            <div class="second-header">
                <h4>ក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h4>
                <h4>អគ្គនាយកដ្ឋានរដ្ឋបាល និងហិរញ្ញវត្ថុ</h4>
                <h4>នាយកដ្ឋានហិរញ្ញវត្ថុ និងទ្រព្យសម្បត្តិរដ្ឋ</h4>
                <h4>ការិយាល័យហិរញ្ញវត្ថុ</h4>
            </div>
            <div class="third-header">
                <h4>តារាងរបាយការណ៍ចំណាយបេសកកម្មក្នុងប្រទេសឆ្នាំ ២០២៤</h4>
                <h4>របស់អគ្គនាយករដ្ឋបាល និងហិរញ្ញវត្ថុ</h4>
            </div>

            <div class="table-container">
                <table class="table-border ">
                    <thead>
                        <tr>
                            <th rowspan="2"
                                style="border: 2px solid black; align-items: center; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                ល.រ</th>
                            <th rowspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                គោត្តនាម​​ និងនាម</th>
                            <th rowspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                តួនាទី</th>
                            <th rowspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                ប្រភេទមុខតំណែង</th>
                            <th colspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                លិខិតបញ្ជាបេសកកម្ម</th>
                            <th rowspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                កម្មវត្ថុនៃការចុះបេសកកមម្ម</th>
                            <th rowspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                ទីកន្លែង</th>
                            <th colspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                កាលបរិច្ឆេទចុះបេសកកម្ម</th>
                            <th rowspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                ចំនួនថ្ងៃ</th>
                            <th rowspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                ចំនួនយប់</th>
                            <th rowspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                សោហ៊ុយធ្វើដំណើរ</th>
                            <th colspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                ប្រាក់ហោប៉ៅ</th>
                            <th colspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                ប្រាក់ហូបចុក</th>
                            <th colspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                ប្រាក់ស្នាក់នៅ</th>
                            <th rowspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                សោហ៊ុយផ្សេងៗ</th>
                            <th rowspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                ទឹកប្រាក់សរុប</th>
                            <th rowspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                សកម្មភាព</th>
                        </tr>

                        <tr>
                            <th style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">លេខ
                            </th>
                            <th style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                កាលបរិច្ឆេទ
                            </th>
                            <th style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                ចាប់ផ្ដើម</th>
                            <th style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">ត្រឡប់
                            </th>
                            <th style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">របប
                            </th>
                            <th style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">សរុប
                            </th>
                            <th style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">របប
                            </th>
                            <th style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">សរុប
                            </th>
                            <th style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">របប
                            </th>
                            <th style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">សរុប
                            </th>
                        </tr>
                    </thead>
                    <tbody style="border: 2px solid black;">
                        <tr>
                            <td colspan="23" style="text-align: left; font-family: 'Khmer OS Siemreap', sans-serif">
                                សម្រាប់កម្មវិធីទី០៥ ចង្កោមសកម្មភាពទី០១ ស្ដីពី ពង្រឹងប្រសិទ្ធភាពនៃការអនុវត្តចំណាយ
                                និងការគ្រប់គ្រងកិច្ចការហិរញ្ញវត្ថុតាមប្រព័ន្ធ FMIS</td>
                        </tr>
                        @foreach ($missions->groupBy('letter_number') as $letterNumber => $group)
                            @foreach ($group as $index => $mission)
                                <tr>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $loop->parent->iteration }}.{{ $index + 1 }}</td>
                                    <td
                                        style="border: 2px solid black; width:180px; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->name }}</td>
                                    <td
                                        style="border: 2px solid black; width: 100px; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->role }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->position_type }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->letter_number }}</td>
                                    <td
                                        style="border: 2px solid black; width: 110px; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->letter_date }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->mission_objective }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->location }}</td>
                                    <td
                                        style="border: 2px solid black; width: 110px; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->mission_start_date }}</td>
                                    <td
                                        style="border: 2px solid black; width: 110px; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->mission_end_date }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->days_count }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->nights_count }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->travel_allowance, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->pocket_money, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->total_pocket_money, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->meal_money, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->total_meal_money, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->accommodation_money, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->total_accommodation_money, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->other_allowances, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->final_total, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black;">
                                        <div style="display: flex; gap: 5px;">
                                            <a href="{{ route('missions.edit', $mission->id) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form id="delete-form-{{ $mission->id }}"
                                                action="{{ route('missions.delete', $mission->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete({{ $mission->id }})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <!-- Display the total row for this group -->
                            <tr>
                                <td colspan="12"
                                    style="border: 2px solid black; font-family: 'Khmer OS Muol Light', sans-serif;">
                                    <strong>{{ 'សរុប' }} {{ $loop->index + 1 }}</strong>
                                </td>
                                <td style="border: 2px solid black;">
                                    <strong>{{ number_format($groupedTotals[$letterNumber]['travel_allowance'], 0, '.', ',') }}</strong>
                                </td>
                                <td style="border: 2px solid black;"></td>
                                <td style="border: 2px solid black;">
                                    <strong>{{ number_format($groupedTotals[$letterNumber]['total_pocket_money'], 0, '.', ',') }}</strong>
                                </td>
                                <td style="border: 2px solid black;"></td>
                                <td style="border: 2px solid black;">
                                    <strong>{{ number_format($groupedTotals[$letterNumber]['total_meal_money'], 0, '.', ',') }}</strong>
                                </td>
                                <td style="border: 2px solid black;"></td>
                                <td style="border: 2px solid black;">
                                    <strong>{{ number_format($groupedTotals[$letterNumber]['total_accommodation_money'], 0, '.', ',') }}</strong>
                                </td>
                                <td style="border: 2px solid black;"></td>
                                <td style="border: 2px solid black;">
                                    <strong>{{ number_format($groupedTotals[$letterNumber]['final_total'], 0, '.', ',') }}</strong>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="12"
                                style="border: 2px solid black; font-family: 'Khmer OS Muol Light', sans-serif;">
                                <strong>{{ 'សរុបរួម' }}</strong>
                            </td>
                            <td style="border: 2px solid black;">
                                <strong>{{ number_format($totals['travel_allowance'], 0, '.', ',') }}</strong>
                            </td>
                            <td style="border: 2px solid black;"></td>
                            <td style="border: 2px solid black;">
                                <strong>{{ number_format($totals['total_pocket_money'], 0, '.', ',') }}</strong>
                            </td>
                            <td style="border: 2px solid black;"></td>
                            <td style="border: 2px solid black;">
                                <strong>{{ number_format($totals['total_meal_money'], 0, '.', ',') }}</strong>
                            </td>
                            <td style="border: 2px solid black;"></td>
                            <td style="border: 2px solid black;">
                                <strong>{{ number_format($totals['total_accommodation_money'], 0, '.', ',') }}</strong>
                            </td>
                            <td style="border: 2px solid black;"></td>
                            <td style="border: 2px solid black;">
                                <strong>{{ number_format($totals['final_total'], 0, '.', ',') }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <!-- Custom Pagination -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item{{ $missions->onFirstPage() ? ' disabled' : '' }}">
                                    <a class="page-link"
                                        href="{{ $missions->previousPageUrl() }}&per_page={{ request('per_page') }}"
                                        aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $missions->lastPage(); $i++)
                                    <li class="page-item{{ $missions->currentPage() == $i ? ' active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $missions->url($i) }}&per_page={{ request('per_page') }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item{{ !$missions->hasMorePages() ? ' disabled' : '' }}">
                                    <a class="page-link"
                                        href="{{ $missions->nextPageUrl() }}&per_page={{ request('per_page') }}"
                                        aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div>
                        <p class="text-muted">បង្ហាញ {{ $missions->firstItem() }} ដល់ {{ $missions->lastItem() }} នៃ
                            {{ $missions->total() }} លទ្ធផល</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('table-mission-cambodia', [
                'search' => request('search'),
                'start_date' => request('start_date'),
                'end_date' => request('end_date') ?? '',
            ]) }}"
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
            max-height: 200vh;
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

        .large-checkbox {
            transform: scale(2);
            margin: 7px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        function confirmDelete(missionId) {
            Swal.fire({
                title: 'ពិតជាចង់លុបទិន្នន័យមែនឬទេ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'ត្រឡប់ក្រោយ',
                confirmButtonText: 'លុបទិន្នន័យ!',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + missionId).submit();
                }
            });
        }
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fullscreenButton = document.getElementById('fullscreen-btn');
            const container = document.querySelector('.fullscreen-container');

            function toggleFullscreen() {
                if (document.fullscreenElement) {
                    document.exitFullscreen();
                } else {
                    document.documentElement.requestFullscreen();
                }
            }

            function updateButtonIcon() {
                if (document.fullscreenElement) {
                    fullscreenButton.innerHTML = '<i class="fas fa-compress"></i>';
                } else {
                    fullscreenButton.innerHTML = '<i class="fas fa-expand"></i>';
                }
            }

            fullscreenButton.addEventListener('click', function() {
                toggleFullscreen();
            });

            document.addEventListener('fullscreenchange', updateButtonIcon);
            document.addEventListener('webkitfullscreenchange', updateButtonIcon);
            document.addEventListener('mozfullscreenchange', updateButtonIcon);
            document.addEventListener('MSFullscreenChange', updateButtonIcon);

            updateButtonIcon();
        });
    </script>
    <script>
        function clearSearch() {
            // Reset the form
            document.querySelector('form').reset();

            // Reload the page without query parameters
            window.location.href = "{{ url()->current() }}";
        }
    </script>
@endsection
