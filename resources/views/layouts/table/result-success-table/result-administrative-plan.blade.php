{{-- @extends('layouts.master') --}}

{{-- @section('result-success')
    <div class="result-total-table-container">
        @yield('result-success-table')
    </div>
@endsection --}}

@section('result-administrative-plan')
    <div class="border-wrapper mt-4 mr-4 ml-4">
        <div class="container-fluid">
            <h3>ការប្រៀបធៀបការអនុវត្តចំណាយនឹងកម្មវិធីចំណាយប្រចាំត្រីមាស</h3>
            {{-- <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5> --}}
            <div class="table-container mt-4 mb-4">
                <table class="table-border">
                    <thead class="header-border">
                        <tr>
                            <th rowspan="2">ជំពូក</th>
                            <th rowspan="2">ចំណាត់ថ្នាក់ចំណាយ</th>
                            <th rowspan="2">ច្បាប់ហិរញ្ញវត្ថុ</th>
                            <th colspan="7">កម្មវិធីចំណាយប្រចាំឆមាសទី១</th>
                            <th rowspan="2">ផ្សេងៗ</th>
                        </tr>

                        <tr>
                            <th>សរុប</th>
                            <th>ខែមករា</th>
                            <th>ខែកុម្ភះ</th>
                            <th>ខែមីនា</th>
                            <th>ខែមេសា</th>
                            <th>ខែឧសភា</th>
                            <th>ខែមិថុនា</th>
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


                        </tr>

                        <!-- Repeat rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
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

        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 16px;
        }

        h3 {
            text-align: center;
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 25px;
        }

        h5 {
            text-align: center;
            font-family: 'OS Moul', sans-serif;
        }
    </style>
@endsection
