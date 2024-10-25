@extends('layouts.master')

@section('content-result-total-general-table')
    <div class="result-total-general-table-container">
        @yield('result-total-general-table')
    </div>
@endsection

@section('result-total-general-table')
    <div class="d-flex justify-content-between align-items-center mt-4 mr-4 ml-4">
        <a class="btn btn-danger" href="{{ route('total_card') }}">
            <i class="fas fa-arrow-left"></i> ត្រឡប់ក្រោយ
        </a>
    </div>
    <div class="first-header text-center mt-4">
        <h3>របាយការណ៍ធានាចំណាយសកម្មភាពថវិកាទូទៅរបស់រដ្ឋ</h3>
        <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5>
    </div>
    <div class="table-container mt-4 pr-4 pl-4">
        <table class="table-border">
            <thead class="header-border">
                <tr>
                    <th rowspan="3">លេខ</th>
                    <th rowspan="3">កម្មវិធី</th>
                    <th rowspan="3">សកម្មភាព</th>
                    <th rowspan="3">អត្ថន័យចំណាយ</th>
                    <th rowspan="3">ច្បាប់ហិ.វ</th>
                    <th rowspan="3">ឥណទានបច្ចុប្បន្ន</th>
                    <th rowspan="3">ឥណទានបច្ចុប្បន្ន</th>
                    <th colspan="5">ចលនាឥណទាន</th>
                    <th rowspan="3">វិចារណកម្ម</th>
                    <th rowspan="3">ស្ថានភាពឥណទានថ្មី</th>
                    <th rowspan="3">ស.ម.ដើមគ្រា</th>
                    <th rowspan="3">អនុវត្តក្នុងគ្រា</th>
                    <th rowspan="3">បូកយោង</th>
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
                     <td>សកម្មភាព A</td>
                </tr>
                <!-- Repeat rows as needed -->
            </tbody>
        </table>
    </div>
@endsection

@section('styles')
    <style>
        .border-wrapper {
            border: 2px solid black;

        }

        .result-total-table-container {
            padding: 16px;

        }

        .container-fluid {
            padding: 16px;
            /* max-height: 100vh; */
        }

        .table-container {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .btn,
        .form-control,
        label,
        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 16px;
        }


        h2 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 24px;
        }

        h3,
        h4 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 20px;
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
