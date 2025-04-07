@extends('layouts.master')

@section('result-total-apply')
    <div class="result-total-table-container">
        @yield('result-total-table')
    </div>
@endsection

@section('result-total-table')
    <div class="row pl-3">
        <div class="col-lg-12 margin-tb ">
            <div class="d-flex justify-content-between align-items-center">
                <a class="btn btn-danger" href="{{ route('total_card') }}"
                    style="width: 120px; height: 40px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="border-wrapper ">
        <div class="result-total-table-container">
            <div class="first-header text-center mt-2">
                <h3>របាយការណ៍សង្ខេបកម្មវិធី</h3>
                {{-- <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5> --}}
            </div>
            <div class="table-container mb-4">
                <table class="table-border mt-2 ">
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
                            <th style="width: 100px;">ភាគរយ</th>

                            {{-- total apply --}}
                            <th>សរុប</th>
                            <th style="width: 100px;">ភាគរយ</th>

                            {{-- total sum refer --}}
                            <th>សរុប</th>
                            <th style="width: 100px;">ភាគរយ</th>

                            {{-- total remain --}}
                            <th>សរុប</th>
                            <th style="width: 100px;">ភាគរយ</th>

                        </tr>
                    </thead>
                    <tbody class="cell-border">
                        <!-- Add your rows here -->
                        @foreach ($totals['report_key'] as $reportKeyId => $totalsByKey)
                            <tr>
                                <td>{{ $reportKeyId }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByKey['fin_law'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByKey['current_loan'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByKey['total_increase'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByKey['decrease'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByKey['new_credit_status'], 0, ' ', ' ') }}</td>

                                {{-- Avg of early balance --}}
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByKey['early_balance'], 0, ' ', ' ') }}</td>
                                <td>
                                    @if ($totalsByKey['new_credit_status'] > 0)
                                        {{ number_format(($totalsByKey['early_balance'] / $totalsByKey['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                {{-- Avg of apply --}}
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByKey['apply'], 0, ' ', ' ') }}</td>
                                <td>
                                    @if ($totalsByKey['new_credit_status'] > 0)
                                        {{ number_format(($totalsByKey['apply'] / $totalsByKey['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                {{-- Avg of sum refer --}}
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByKey['early_balance'] + $totalsByKey['apply'], 0, ' ', ' ') }}
                                </td>
                                <td>
                                    @if ($totalsByKey['new_credit_status'] > 0)
                                        {{ number_format((($totalsByKey['early_balance'] + $totalsByKey['apply']) / $totalsByKey['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                {{-- Avg Remain --}}
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByKey['new_credit_status'] - ($totalsByKey['early_balance'] + $totalsByKey['apply']), 0, ' ', ' ') }}
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

                        <!-- Totals row -->
                        <tr class="total-row" style="background-color: rgb(181, 245, 86);">
                            <td><strong>សរុប</strong></td>
                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['fin_law'], 0, ' ', ' ') }}</td>
                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['current_loan'], 0, ' ', ' ') }}</td>
                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['total_increase'], 0, ' ', ' ') }}</td>
                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['decrease'], 0, ' ', ' ') }}</td>
                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['new_credit_status'], 0, ' ', ' ') }}</td>
                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['early_balance'], 0, ' ', ' ') }}</td>

                            {{-- Total Avg of early balance --}}
                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format(($totals['total_sums']['early_balance'] / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>

                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['apply'], 0, ' ', ' ') }}</td>

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

                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['total_remain'], 0, ' ', ' ') }}</td>

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
            padding-left: 16px;
            padding-right: 16px;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            /* Enable horizontal scrolling */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
            /* Ensure table does not shrink too much */
        }

        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 6px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
            white-space: nowrap;
            /* Prevent text from wrapping */
        }

        h3 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 18px;
        }

        h5 {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
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
