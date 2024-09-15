{{-- @extends('layouts.master') --}}

{{-- @section('result-success')
    <div class="result-total-table-container">
        @yield('result-success-table')
    </div>
@endsection --}}

@section('result-general-pay')
    <div class="border-wrapper mt-4 mr-4 ml-4">
        <div class="container-fluid">
            <h3>កម្មវិធីចំណាយប្រចាំត្រីមាស</h3>
            {{-- <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5> --}}
            <div class="table-container mt-4 mb-4">
                <table class="table-border">
                    <thead class="header-border">
                        <tr>
                            <th rowspan="2">ជំពូក</th>
                            <th rowspan="2"> ចំណាត់ថ្នាក់ចំណាយ
                                ​(តាមមាតិកាថវិកា)</th>
                            <th rowspan="2">ច្បាប់ហិរញ្ញវត្ថុ</th>
                            <th rowspan="2">ឥណទានថ្មី</th>
                            <th rowspan="3">កម្មវិធីចំណាយ​ ប្រចាំ​ ខែមិថុនា</th>
                            <th rowspan="3">ការអនុវត្តទូទៅ​ ​ ខែមិថុនា</th>
                            <th rowspan="3">ធៀបជាភាគរយ %</th>
                            <th rowspan="3">ការធានាចំណាយ​ ខែមិថុនា</th>
                            <th rowspan="3">ធៀបជាភាគរយ %</th>
                        </tr>
                    </thead>
                    <tbody class="cell-border">
                        <!-- Add your rows here -->
                        @foreach ($totals['code'] as $codeId => $totalsByCode)
                            <tr>
                                <td>ជំពូក: {{ $codeId }}</td>
                                <td>{{ $totalsByCode['name'] ?? 'Unknown' }}</td>
                                <td>{{ number_format($totalsByCode['fin_law'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByCode['current_loan'], 0, ' ', ' ') }}</td>
                                <td></td>
                                <td>{{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}</td>
                                <td> % </td>
                                <td>{{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}</td>
                                <td> % </td>
                            </tr>
                        @endforeach
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
