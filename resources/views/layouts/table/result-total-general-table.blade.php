@extends('layouts.master')

@section('content-result-total-general-table')
    <div class="result-total-general-table-container">
        @yield('result-total-general-table')
    </div>
@endsection

@section('result-total-general-table')
    <h3>របាយការណ៍ធានាចំណាយសកម្មភាពថវិកាទូទៅរបស់រដ្ឋ</h3>
    <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5>
    <div class="table-container">
        <table class="table-border">
            <thead class="header-border">
                <tr>
                    <th rowspan="3" style="border: 1px solid black; font-size: 14px; max-width: 40px;" >ល.រ</th>
                    <th rowspan="3" style="border: 1px solid black; font-size: 14px; max-width: 60px;" >កម្មវិធី</th>
                    <th rowspan="3" style="border: 1px solid black; max-width: 120px; text-align: center">សកម្មភាព</th>
                    <th rowspan="3" style="border: 1px solid black; max-width: 620px; text-align: center">អត្ថន័យចំណាយ</th>
                    <th rowspan="3">ច្បាប់ហិ.វ</th>
                    <th rowspan="3">ឥណទានបច្ចុប្បន្ន</th>
                    <th colspan="5">ចលនាឥណទាន</th>
                    <th rowspan="3">វិចារណកម្ម</th>
                    <th rowspan="3">ស្ថានភាព</th>
                    <th rowspan="3">សមតុល្យដើមគ្រា</th>
                    <th rowspan="3">អនុវត្តក្នុងគ្រា</th>
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
                    <th class="rotate-25">មិនបានគ្រោងទុក</th>
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
                    <td>សកម្មភាព A</td>
                    <td>សកម្មភាព A</td>
                    <td>សកម្មភាព A</td>
                    <td>សកម្មភាព A</td>
                </tr>
                {{-- <tr>
                    <td>១</td>
                  
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
                    <td>សកម្មភាព A</td>
                    <td>សកម្មភាព A</td>
              
                </tr> --}}
                <!-- Repeat rows as needed -->
            </tbody>
        </table>
    </div>
@endsection

@section('styles')
    <style>
        .result-total-general-table-container {
            max-height: 600px; /* Adjust height as needed */
            overflow-y: auto;
        }

        .table-container {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th.rotate-25 {
            transform: rotate(25deg);
            white-space: nowrap;
        }

        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }

        h3, h5 {
            text-align: center;
            font-family: 'OS Moul', sans-serif;
        }
    </style>
@endsection
