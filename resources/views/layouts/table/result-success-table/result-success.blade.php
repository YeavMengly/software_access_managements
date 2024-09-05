@extends('layouts.master')

{{-- @section('result-success')
    <div class="result-total-table-container">
        @yield('result-success-table')
    </div>
@endsection --}}

@section('result-success')
    <h3>របាយការណ៍ធានាចំណាយថវិកាក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h3>
    <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5>
    <div class="table-container">
        <table class="table-border">
            <thead class="header-border">
                <tr>
                    <th rowspan="2">ជំពូក</th>
                    <th rowspan="2">ច្បាប់ហិរញ្ញវត្ថុ</th>
                    <th rowspan="2">ឥណទានថ្មី</th>
                    {{-- <th rowspan="3">គណនី</th>
                    <th rowspan="3">អនុគណនី</th>
                    <th rowspan="3">លេខកូដកម្មវិធី</th>
                    <th rowspan="3">ចំណាត់ថ្នាក់</th>
                    <th rowspan="3">ច្បាប់ហិ.វ</th>
                    <th rowspan="3">ឥណទានបច្ចុប្បន្ន</th> --}}
                    <th colspan="6">សុំធានាចំណាយ</th>
                    <th colspan="6">សុំអាណត្តិកិច្ច</th>
                    <th rowspan="2">ឯកតា: លានរៀល</th>
                    {{-- <th rowspan="2">សមតុល្យដើមគ្រា</th>
                    <th rowspan="2">អនុវត្ត</th>
                    <th rowspan="2">សមតុល្យចុងគ្រា</th>
                    <th rowspan="2">ឥណទាននៅសល់</th> --}}
                    {{-- <th colspan="2" rowspan="2">%ប្រៀបធៀប</th> --}}
                </tr>
                
                <tr>
                    <th>ដើមគ្រា</th>
                    <th>អនុវត្ត</th>
                    <th>%ភាគរយ</th>
                    <th>បូកយោង</th>
                    <th>%ភាគរយ</th>
                    <th>នៅសល់</th>

                    <th>ដើមគ្រា</th>
                    <th>អនុវត្ត</th>
                    <th>%ភាគរយ</th>
                    <th>បូកយោង</th>
                    <th>%ភាគរយ</th>
                    <th>នៅសល់</th>
                </tr>

                {{-- <tr>
                    <th colspan="4">កើន</th>
                    <th rowspan="2">ថយ</th>
                </tr> --}}
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
