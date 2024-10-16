@extends('layouts.master')

@section('result-total-apply')
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
                <h3>របាយការណ៍សង្ខេបកម្មវិធី</h3>
                {{-- <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5> --}}
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
                        @foreach ($totals['report_key'] as $reportKeyId => $totalsByKey)
                            <tr>
                                <td>{{ $reportKeyId }}</td>
                                <td>{{ number_format($totalsByKey['fin_law'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByKey['current_loan'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByKey['total_increase'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByKey['decrease'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByKey['new_credit_status'], 0, ' ', ' ') }}</td>

                                {{-- Avg of early balance --}}
                                <td>{{ number_format($totalsByKey['early_balance'], 0, ' ', ' ') }}</td>
                                <td>
                                    @if ($totalsByKey['new_credit_status'] > 0)
                                        {{ number_format(($totalsByKey['early_balance'] / $totalsByKey['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                {{-- Avg of apply --}}
                                <td>{{ number_format($totalsByKey['apply'], 0, ' ', ' ') }}</td>
                                <td>
                                    @if ($totalsByKey['new_credit_status'] > 0)
                                        {{ number_format(($totalsByKey['apply'] / $totalsByKey['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                {{-- Avg of sum refer --}}
                                <td>{{ number_format($totalsByKey['early_balance'] + $totalsByKey['apply'], 0, ' ', ' ') }}
                                </td>
                                <td>
                                    @if ($totalsByKey['new_credit_status'] > 0)
                                        {{ number_format((($totalsByKey['early_balance'] + $totalsByKey['apply']) / $totalsByKey['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                {{-- Avg Remain --}}
                                <td>{{ number_format($totalsByKey['new_credit_status'] - ($totalsByKey['early_balance'] + $totalsByKey['apply']), 0, ' ', ' ') }}
                                </td>
                                <td>
                                    @if ($totalsByKey['new_credit_status'] > 0)
                                        {{ number_format((($totalsByKey['new_credit_status'] - ($totalsByKey['early_balance'] + $totalsByKey['apply'])) / $totalsByKey['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                            </tr>
                        @endforeach


                        <!-- Repeat rows as needed -->

                        <!-- Totals row -->
                        <tr class="total-row">
                            <td><strong>សរុប</strong></td>
                            <td>{{ number_format($totals['total_sums']['fin_law'], 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totals['total_sums']['current_loan'], 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totals['total_sums']['total_increase'], 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totals['total_sums']['decrease'], 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totals['total_sums']['new_credit_status'], 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totals['total_sums']['early_balance'], 0, ' ', ' ') }}</td>

                            {{-- Total Avg of early balance --}}
                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format(($totals['total_sums']['early_balance'] / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>

                            <td>{{ number_format($totals['total_sums']['apply'], 0, ' ', ' ') }}</td>

                            {{-- Total Avg of apply --}}
                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format(($totals['total_sums']['apply'] / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>

                            <td>{{ number_format($totals['total_sums']['total_sum_refer'], 0, ' ', ' ') }}</td>

                            {{-- Total Avg of sum refer --}}
                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format((($totals['total_sums']['early_balance'] + $totals['total_sums']['apply']) / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>

                            <td>{{ number_format($totals['total_sums']['total_remain'], 0, ' ', ' ') }}</td>

                            {{-- Total Avg Remain --}}
                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format((($totals['total_sums']['new_credit_status'] - ($totals['total_sums']['early_balance'] + $totals['total_sums']['apply'])) / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>
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

        .table-container {
            width: 100%;
        }

        .total-row {
            background-color: #f8f9fa;
            /* Light background color for total row */
            font-weight: bold;
            /* Make the font bold for emphasis */
            border-top: 2px solid #dee2e6;
            /* Add a top border to the row */
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
