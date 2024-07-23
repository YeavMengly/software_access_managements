@extends('layouts.master')

@section('result')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <h3>របាយការណ៍ធានាចំណាយថវិកាក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h3>
            <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5>
            <div class="table-container">
                <table id="reportTable" class="table-border">
                    <thead class="header-border">
                        <tr>
                            <th rowspan="3">លេខ</th>
                            <th rowspan="3">កាលបរិច្ឆេទ</th>
                            <th rowspan="3">ជំពូក</th>
                            <th rowspan="3">គណនី</th>
                            <th rowspan="3">អនុគណនី</th>
                            <th rowspan="3">លេខកូដកម្មវិធី</th>
                            <th rowspan="3">ចំណាត់ថ្នាក់</th>
                            <th rowspan="3">ច្បាប់ហិ.វ</th>
                            <th rowspan="3">ឥណទានបច្ចុប្បន្ន</th>
                            <th colspan="5">ចលនាឥណទាន</th>
                            <th rowspan="3">ស្ថានភាពឥណទានថ្មី</th>
                            <th rowspan="3">សមតុល្យដើមគ្រា</th>
                            <th rowspan="3">អនុវត្ត</th>
                            <th rowspan="3">សមតុល្យចុងគ្រា</th>
                            <th rowspan="3">ឥណទាននៅសល់</th>
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
                        <!-- Add your rows here -->
                        <tr>
                            <td class="filterable" data-filter="6001">1</td>
                            <td>01/01/2024</td>
                            <td class="filterable" data-filter="60">60</td>
                            <td >6001</td>
                            <td>60011</td>
                            <td>3250104</td>
                            <td>ចង្កោមសកម្មភាពទី៤៖ ធ្វើឱ្យកាន់តែប្រសើរនូវសេវារដ្ឋបាល និងសេវាផ្សេងៗ ព្រមទាំងសហការរៀបចំកម្មវិធីនានារបស់ក្រសួង</td>
                            <td>500000000</td>
                            <td>500000000</td>
                            <td>1 200 000</td>
                            <td>1 200 000</td>
                            <td>1 200 000</td>
                            <td>3 600 000</td>
                            <td> </td>
                            <td>503 600 000</td>
                            <td>387 694 100</td>
                            <td> </td>
                            <td>387 694 100</td>
                            <td>115 905 900</td>
                            <td>77.54%</td>
                            <td>76.98%</td>
                        </tr>
                        <tr>
                            <td class="filterable" data-filter="6002"></td>
                            <td></td>
                            <td class="filterable" data-filter="60"></td>
                            <td >6002</td>
                            <td>60012</td>
                            <td>3250105</td>
                            <td>ព្រឹត្តិការណ៍ចំរើនសកម្មភាពថ្មីៗក្នុងក្រសួង</td>
                            <td>400000000</td>
                            <td>400000000</td>
                            <td>1 000 000</td>
                            <td>1 000 000</td>
                            <td>1 000 000</td>
                            <td>3 000 000</td>
                            <td> </td>
                            <td>403 000 000</td>
                            <td>300 000 000</td>
                            <td> </td>
                            <td>300 000 000</td>
                            <td>103 000 000</td>
                            <td>75.00%</td>
                            <td>74.50%</td>
                        </tr>
                        <tr>
                            <td class="filterable" data-filter="6003"></td>
                            <td></td>
                            <td class="filterable" data-filter="60"></td>
                            <td >6003</td>
                            <td>60013</td>
                            <td>3250106</td>
                            <td>ការងារសង្គមសង្គ្រោះបន្ទាន់និងជំនួយ</td>
                            <td>300000000</td>
                            <td>300000000</td>
                            <td>800 000</td>
                            <td>800 000</td>
                            <td>800 000</td>
                            <td>2 400 000</td>
                            <td> </td>
                            <td>302 400 000</td>
                            <td>200 000 000</td>
                            <td> </td>
                            <td>200 000 000</td>
                            <td>102 400 000</td>
                            <td>70.00%</td>
                            <td>69.50%</td>
                        </tr>

                        <!-- Repeat rows as needed -->
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        cell.addEventListener('click', function () {
            const filterValue = this.getAttribute('data-filter');
            filtersToShow.push(filterValue);

            // Check if the filterValue is unique and adjust the display accordingly
            const filteredRows = rows.filter(row => {
                return row.querySelector(`td.filterable[data-filter="${filterValue}"]`);
            });

            if (filteredRows.length > 0) {
                showFilteredRows(filterValue);
            }
        });

        cell.addEventListener('dblclick', function () {
            filtersToShow = [];
            rows.forEach(row => {
                row.classList.remove('hidden-row');
            });
        });
    });
});

    </script>
@endsection
