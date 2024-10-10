@extends('layouts.master')

@section('result-total-summaries')
    <div class="result-total-table-container">
        @yield('result-total-table')
    </div>
@endsection

@section('result-total-table')
    <div class="d-flex justify-content-between align-items-center  mt-4 mr-4 ml-4">
        <a class="btn btn-danger" href="{{ route('total_card') }}">
            <i class="fas fa-arrow-left"></i> ត្រឡប់ក្រោយ
        </a>
    </div>
    <div class="border-wrapper mt-4 ml-4 mr-4">
        <div class="result-total-table-container">
            <div class="first-header text-center mt-4">
                <h3>របាយការណ៍សង្ខេប</h3>
                <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5>
            </div>
            <div class="table-container">
                <table class="table-border mt-4 mb-4">
                    <thead class="header-border">
                        <tr>
                            <th rowspan="2">កម្មវិធី</th>
                            <th rowspan="2">ច្បាប់ហិរញ្ញវត្ថុ​ </th>
                            <th rowspan="2">ស្ថានភាព</th>
                            <th rowspan="2">កើន</th>
                            <th rowspan="2">ថយ</th>
                            <th rowspan="2">ស្ថានភាពឥណទានថ្មី</th>
                            <th colspan="2">ដើមគ្រា</th>
                            <th colspan="2">អនុវត្ដ</th>
                            <th colspan="2">បូកយោង</th>
                            <th colspan="2">នៅសល់</th>

                        </tr>
                        <tr>
                            {{-- total start balance --}}
                            <th>សរុប</th>
                            <th>ភាគរយ</th>

                            {{-- total apply --}}
                            <th>សរុប</th>
                            <th>ភាគរយ</th>

                            {{-- total sum refer --}}
                            <th>សរុប</th>
                            <th>ភាគរយ</th>

                            {{-- total remain --}}
                            <th>សរុប</th>
                            <th>ភាគរយ</th>

                        </tr>


                    </thead>
                    <tbody class="cell-border">
                        <!-- Add your rows here -->
                        @foreach ($totals['code'] as $codeId => $totalsByCode)
                            <tr>
                                <td>ជំពូក: {{ $codeId }}</td>
                                <td>{{ number_format($totalsByCode['fin_law'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByCode['current_loan'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByCode['total_increase'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByCode['decrease'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByCode['new_credit_status'], 0, ' ', ' ') }}</td>

                                {{-- Avg of early balance --}}
                                <td>{{ number_format($totalsByCode['early_balance'], 0, ' ', ' ') }}</td>
                                <td> {{ number_format(($totalsByCode['early_balance'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                </td>

                                {{-- Avg of apply --}}
                                <td>{{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}</td>
                                <td> {{ number_format(($totalsByCode['apply'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                </td>

                                {{-- Avg of sum refer --}}
                                <td>{{ number_format($totalsByCode['early_balance'] + $totalsByCode['apply'], 0, ' ', ' ') }}
                                </td>
                                <td>{{ number_format((($totalsByCode['early_balance'] + $totalsByCode['apply']) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                </td>

                                {{-- Avg Remain --}}
                                <td>{{ number_format($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply']), 0, ' ', ' ') }}
                                </td>
                                <td>{{ number_format((($totalsByCode['early_balance'] + $totalsByCode['apply'] - $totalsByCode['new_credit_status']) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                </td>
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
        .border-wrapper {
            border: 2px solid black;
            padding: 10px;
        }

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

        h3 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 25px;
        }

        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 16px;
        }

        h5 {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 25px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        setInterval(function() {
            window.location.reload();
        }, 30000); // 30 seconds
    </script>
@endsection
