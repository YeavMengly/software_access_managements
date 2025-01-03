@extends('layouts.master')

@section('content-table-ms-plan')
    <div class="sticky-header ml-4 mr-4">
        <div class="row mt-3">
            <div class="col-lg-12 margin-tb">
                <div class="d-flex justify-content-between align-items-center">
                    <a class="btn btn-danger" href="{{ route('total_card') }}"
                        style="width: 160px; height: 50px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-arrow-left"></i>&nbsp;
                    </a>
                    {{-- Start action btn export and print --}}
                    <div class="d-flex justify-content-end mt-3 mb-3 ">
                        <a href="{{ route('result.export', request()->query()) }}"
                            class="btn btn-danger btn-width mr-2 d-flex align-items-center justify-content-center"
                            style="width: 120px; height: 40px; text-align: center; font-size: 14px; ">
                            <i class="fas fa-download"></i> <span class="ml-2">Export</span>
                        </a>
                        <a href="{{ route('result.exportPdf', request()->query()) }}"
                            class="btn btn-primary btn-width mr-2 d-flex align-items-center justify-content-center"
                            style="width: 120px; height: 40px; text-align: center; font-size: 14px;">
                            <i class="fas fa-print"></i> <span class="ml-2">Print</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <form class="max-w-md mx-auto" method="GET" action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group my-3"
                        style="width: 25%; display: flex; align-items: center; border: 1px solid #ddd; border-radius: 5px; overflow: hidden;">
                        <!-- Search Input -->
                        <input type="search" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="ស្វែងរកទិន្នន័យ" aria-label="Search Address"
                            style="flex-grow: 1; height: 40px; border: none; padding: 0 10px;">
                        <!-- Search Button -->
                        <button type="submit" class="btn btn-primary"
                            style="width: 60px; height: 40px; display: flex; justify-content: center; align-items: center; border: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 50 50"
                                fill="white">
                                <path
                                    d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <a href="" data-bs-toggle="modal" data-bs-target="#createResultMission"
            class="btn btn-info btn-width mr-2 d-flex align-items-center justify-content-center"
            style="width: 160px; height: 50px; text-align: center; font-size: 14px; color: black; font-weight: 500;">
            <i class="fas fa-download"></i> <span class="ml-2">ទាញតារាងសរុប</span>
        </a>

    </div>
    <!-- Modal for Creating a Year -->
    <div class="modal fade" id="createResultMission" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content ">
                <div class="modal-header">
                    <h3 class="modal-title text-center" id="importModalLabel">តារាងសរុបថវិកាបេសកកម្ម</h3>
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body custom-scrollable">
                    <div class="result-total-table-container">
                        <div class="top-header">
                            <h2>ព្រះរាជាណាចក្រកម្ពុជា</h2>
                            <h3>ជាតិ សាសនា ព្រះមហាក្សត្រ</h3>
                        </div>
                        <div class="second-header">
                            <h3>ក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h3>
                            <h3>អគ្គនាយកដ្ឋានរដ្ឋបាល និងហិរញ្ញវត្ថុ</h3>
                            <h3>នាយកដ្ឋានហិរញ្ញវត្ថុ និងទ្រព្យសម្បត្តិរដ្ឋ</h3>
                            <h3>ការិយាល័យហិរញ្ញវត្ថុ</h3>
                        </div>
                        <div class="third-header">
                            <h3>គម្រោងចំណាយបេសកកម្មតាមចំណាត់ថ្នាក់កម្មវិធីប្រចាំឆ្នាំ
                                {{ convertToKhmerNumber(request('year', date('Y'))) }}</h3>
                            <h3>របស់ក្រសួងការងារ និងបណ្ដុះបណ្តាលវិជ្ជាជីវៈ</h3>
                        </div>
                        <div class="table-container">
                            <table class="table-border ">
                                <thead>
                                    <tr>
                                        <th
                                            style="border: 2px solid black; align-items: center; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                            ជំពូក</th>
                                        <th
                                            style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                            គណនី</th>

                                        <th
                                            style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                            អនុគណនី</th>

                                        <th
                                            style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                            បរិយាយ</th>
                                        <th
                                            style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                            ច្បាប់ហិរញ្ញវត្ថុប្រចាំឆ្នាំ២០២៥</th>
                                        <th
                                            style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                            ឥណទានសម្រាប់បើកផ្ដល់ប្រាក់មុន</th>
                                        <th
                                            style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                            ឥណទានសម្រាប់អនុវត្តនិតិវិធីទូទាត់ត្រង់</th>
                                    </tr>


                                </thead>

                                <tbody>
                                    <tr>
                                        <td colspan="4" style="border: 1px solid black; text-align: center;">
                                            <strong>សរុប</strong>: ការរាយការណ៍
                                        </td>

                                        <td>1
                                        </td>
                                        <td>2
                                        </td>
                                        <td>
                                            3
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center" style="height: 70px;">
                    <a href="{{ route('result.exportPdf', request()->query()) }}"
                        class="btn btn-info btn-width mr-2 d-flex align-items-center justify-content-center"
                        style="width: 160px; height: 50px; text-align: center; font-size: 14px;">
                        <i class="fas fa-print"></i> <span class="ml-2">បោះពុម្ភ</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="border-wrapper mt-3 mr-4 ml-4">
        <div class="result-total-table-container">
            <div class="top-header">
                <h2>ព្រះរាជាណាចក្រកម្ពុជា</h2>
                <h3>ជាតិ សាសនា ព្រះមហាក្សត្រ</h3>
            </div>
            <div class="second-header">
                <h3>ក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h3>
                <h3>អគ្គនាយកដ្ឋានរដ្ឋបាល និងហិរញ្ញវត្ថុ</h3>
                <h3>នាយកដ្ឋានហិរញ្ញវត្ថុ និងទ្រព្យសម្បត្តិរដ្ឋ</h3>
                <h3>ការិយាល័យហិរញ្ញវត្ថុ</h3>
            </div>
            <div class="third-header">
                <h3>គម្រោងចំណាយបេសកកម្មតាមចំណាត់ថ្នាក់កម្មវិធីប្រចាំឆ្នាំ
                    {{ convertToKhmerNumber(request('year', date('Y'))) }}</h4>
                    <h3>របស់ក្រសួងការងារ និងបណ្ដុះបណ្ដាលវិជ្ជាជីវៈ</h4>
            </div>
            <div class="table-container">
                <table class="table-border">
                    <thead>
                        <tr>
                            <th rowspan="2"
                                style="border: 1px solid black; align-items: center; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                ចំណាត់ថ្នាក់កម្មវិធី
                            </th>
                            <th rowspan="2"
                                style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                កម្មវិធី/អនុកម្មវិធី/ចង្កោមសកម្មភាព
                            </th>
                            <th colspan="4"
                                style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                សរុប
                            </th>

                            @php
                                $previousSubAccountKey = null;
                            @endphp

                            {{-- Loop for each missionPlanning --}}
                            @foreach ($missionPlannings as $mp)
                                @if (in_array($mp->sub_account_key, ['61121', '61122', '61123']))
                                    {{-- Display a new sub_account_key header if it changes --}}
                                    @if ($mp->sub_account_key != $previousSubAccountKey)
                                        <th colspan="3"
                                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                            {{ $mp->sub_account_key }}
                                            {{ $mp->report->subAccountKey->name_sub_account_key }}
                                        </th>
                                        @php
                                            $previousSubAccountKey = $mp->sub_account_key;
                                        @endphp
                                    @endif
                                @endif
                            @endforeach
                        </tr>

                        <tr>
                            <th style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                ច្បាប់ហិរញ្ញវត្ថុប្រចាំឆ្នាំ២០២៥
                            </th>
                            <th style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                ឥណទានថ្មី
                            </th>
                            <th style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                ឥណទានសម្រាប់បើកផ្ដល់ប្រាក់មុន
                            </th>
                            <th style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                ឥណទានសម្រាប់អនុវត្តនិតិវិធីទូទាត់ត្រង់
                            </th>

                            @php
                                $previousSubAccountKey = null;
                            @endphp

                            {{-- Loop for each missionPlanning --}}
                            @foreach ($missionPlannings as $mp)
                                @if (in_array($mp->sub_account_key, ['61121', '61122', '61123']))
                                    {{-- Display the corresponding columns for sub_account_key --}}
                                    @if ($mp->sub_account_key != $previousSubAccountKey)
                                        <th style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                            ច្បាប់ហិរញ្ញវត្ថុប្រចាំឆ្នាំ២០២៥
                                        </th>
                                        <th style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                            ឥណទានសម្រាប់បើកផ្ដល់ប្រាក់មុន
                                        </th>
                                        <th style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                            ឥណទានសម្រាប់អនុវត្តនិតិវិធីទូទាត់ត្រង់
                                        </th>
                                        @php
                                            $previousSubAccountKey = $mp->sub_account_key;
                                        @endphp
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>

                        @if (in_array($mp->sub_account_key, ['61121', '61122', '61123']))
                            <tr>
                                <td style="border: 1px solid black;">{{ $mp->report->report_key }}</td>
                                <td style="border: 1px solid black;">{{ $mp->sub_account_key }}</td>
                                <td style="border: 1px solid black;">{{ $mp->pay_mission }}</td>
                                <td style="border: 1px solid black;">0</td>
                                <td style="border: 1px solid black;">0</td>
                                <td style="border: 1px solid black;">0</td>

                                {{-- Check for mission_type conditions --}}
                                @if ($mp->mission_type == '1')
                                    <td style="border: 1px solid black;">{{ $mp->pay_mission }}</td>
                                    <td style="border: 1px solid black;">0</td>
                                @elseif ($mp->mission_type == '2')
                                    <td style="border: 1px solid black;">{{ $mp->pay_mission }}</td>
                                    <td style="border: 1px solid black;">0</td>
                                @elseif ($mp->mission_type == '3')
                                    <td style="border: 1px solid black;"></td>
                                    <td style="border: 1px solid black;"></td>
                                    <td style="border: 1px solid black;"></td>

                                    <td style="border: 1px solid black;">{{ $mp->pay_mission }}</td>
                                    <td style="border: 1px solid black;">0</td>
                                @else
                                    {{-- Default values if mission_type doesn't match any of the conditions --}}
                                    <td style="border: 1px solid black;">0</td>
                                    <td style="border: 1px solid black;">0</td>
                                @endif
                            </tr>
                        @endif

                        {{-- @foreach ($missionPlannings as $mp)
                            <tr>
                                <td style="border: 1px solid black;">{{ $mp->report->report_key }}</td>
                                <td style="border: 1px solid black;">{{ $mp->sub_account_key }}</td>
                                <td style="border: 1px solid black;">{{ $mp->pay_mission }}</td>
                                @if ($mp->mission_type == 'type_1')
                                    <td style="border: 1px solid black;">{{ $mp->pay_mission }}</td>
                                    <td style="border: 1px solid black;">0</td>
                                @elseif ($mp->mission_type == 'type_2')
                                    <td style="border: 1px solid black;">0</td>
                                    <td style="border: 1px solid black;">{{ $mp->pay_mission }}</td>
                                @else
                                    <td style="border: 1px solid black;">0</td>
                                    <td style="border: 1px solid black;">0</td>
                                @endif
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .border-wrapper {
            border: 1px solid black;
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
            border: 1px solid rgb(133, 131, 131);
            text-align: center;
            padding: 4px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
        }

        h2 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 18px;
        }

        h3,
        h4 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
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

        .top-header {
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
    <style>
        .custom-modal-width {
            width: 90% !important;
            max-width: 90%;
            /* Ensure it doesn't exceed 90% */
        }

        .modal-dialog {
            margin: auto;
            /* Center the modal */
        }

        .result-total-table-container {
            max-height: 80vh;
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
            border: 1px solid rgb(133, 131, 131);
            text-align: center;
            padding: 4px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
        }

        h2 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 18px;
        }

        h3,
        h4 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
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


        if (!function_exists('convertToKhmerNumber')) {
            function convertToKhmerNumber($number) {
                $khmerDigits = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
                return str_replace(range(0, 9), $khmerDigits, $number);
            }
        }
    </script>
@endsection
