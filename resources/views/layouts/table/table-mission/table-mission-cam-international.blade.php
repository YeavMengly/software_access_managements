@extends('layouts.master')

@section('content-table-mission-cam-international')
    <div id="mission-cam-international" class="border-wrapper mt-3 mr-4 ml-4">
        <div class="result-total-table-container">
            <div class="top-header">
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
                <h4>តារាងរបាយការណ៍ចំណាយបេសកកម្មអន្តរជាតិឆ្នាំ {{ convertToKhmerNumber(request('year', date('Y'))) }}</h4>
                <h4>របស់អគ្គនាយករដ្ឋបាល និងហិរញ្ញវត្ថុ</h4>
            </div>

            <div class="table-container">
                <table class="table-border ">
                    <thead>
                        <tr>
                            <th rowspan="2"
                                style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
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
                                កម្មវត្ថុនៃការចុះបេសកកម្ម</th>
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
                        <!-- Additional rows -->
                    </thead>
                    <tbody>
                        <!-- Dynamic data rows -->
                    </tbody>
                </table>
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
