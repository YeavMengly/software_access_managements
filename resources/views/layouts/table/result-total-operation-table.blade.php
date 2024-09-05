@extends('layouts.master')

@section('result-total-operation')
    <div class="result-total-table-container">
        @yield('result-total-table')
    </div>
@endsection

@section('result-total-table')
    <h3>របាយការណ៍ធានាចំណាយថវិកាក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h3>
    <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5>
    <div class="table-container">
        <table class="table-border">
            <thead class="header-border">
                <tr>
                    <th rowspan="3">កម្មវិធី</th>
                    <th rowspan="3">សកម្មភាព</th>
                    <th rowspan="3">អត្ថន័យចំណាយ</th>
                    <th rowspan="3">ច្បាប់ហិរញ្ញវត្ថុ​ ឆ្នាំ២០២៤</th>
                    <th rowspan="3">ឥណទានបច្ចុប្បន្ន</th>
                    <th colspan="5">ចលនាឥណទាន</th>
                    <th rowspan="3">វិចារណកម្ម</th>
                    <th rowspan="3">ស្ថានភាពឥណទានថ្មី</th>
                    <th rowspan="3">សមតុល្យដើមគ្រា</th>
                    <th rowspan="3">អនុវត្ដ
                        ក្នុងគ្រា</th>
                    <th rowspan="3">បូកយោង</th>
                    <th rowspan="3">ឥណទាននៅសល់</th>
                    <th colspan="2" rowspan="2">%ប្រៀបធៀប</th>
                </tr>
                <tr>
                    <th colspan="4">កើន</th>
                    <th rowspan="2">ថយ</th>
                </tr>
                <tr>
                    <th>កើនផ្ទៃក្នុង</th>
                    <th>មិនបានគ្រោងទុក</th>
                    <th>បំពេញបន្ថែម</th>
                    <th>សរុប</th>
                    <th>%ច្បាប់</th>
                    <th>%ច្បាប់កែតម្រូវ</th>
                </tr>
            </thead>
            <tbody class="cell-border">
                <!-- Add your rows here -->
                <tr>
                    <td>១</td>
                    <td>01/01/2024</td>
                    <td>ភូមិ A</td>
                    <td>ឈ្មោះ A</td>
                    <td>30</td>
                    <td>ប្រុស</td>
                    <td>ម្តាយ A</td>
                    <td>ឪពុក A</td>
                    <td>អាស័យដ្ឋាន A</td>
                    <td>ស្ថានភាព A</td>
                    <td>មូលហេតុ 1</td>
                    <td>សកម្មភាព 1</td>
                    <td>ស្ថានភាព 1</td>
                    <td>សារអារាបេត A</td>
                    <td>មូលហេតុ A</td>
                    <td>សកម្មភាព A</td>
                    <td>សកម្មភាព A</td>
                    <td>សកម្មភាព A</td>
                </tr>

                <!-- Repeat rows as needed -->
            </tbody>
        </table>
    </div>
@endsection

@section('styles')
    <style>
        .result-total-table-container {
            max-height: 600px;
            /* Adjust height as needed */
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
    </style>
@endsection
