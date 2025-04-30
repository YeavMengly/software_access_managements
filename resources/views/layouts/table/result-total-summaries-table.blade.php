@extends('layouts.master')

@section('result-total-summaries')
    <div class="result-total-table-container">
        @yield('result-total-table')
    </div>
@endsection

@section('result-total-table')
    <div class="border-wrapper ">
        <a class="btn btn-danger" href="{{ route('back') }}"
            style="width: 120px; height: 40px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-arrow-left"></i>&nbsp;&nbsp;
        </a>

        <div class="d-flex justify-content-end mt-3 mb-3">
            <a href="{{ route('result.export', request()->query()) }}"
                class="btn btn-danger btn-width mr-2 d-flex align-items-center justify-content-center position-relative"
                style="width: 120px; height: 40px; text-align: center; font-size: 14px;">
                <i class="fas fa-file-excel fa-1x"></i>
                <span class="ml-2">បម្លែង xls</span>
                <div class="hover-text">Export to Excel</div> <!-- Hover Text -->
            </a>

            <a href="{{ route('result.exportPdf', request()->query()) }}"
                class="btn btn-primary btn-width mr-2 d-flex align-items-center justify-content-center position-relative"
                style="width: 120px; height: 40px; text-align: center; font-size: 14px;">
                <i class="fas fa-print"></i>
                <span class="ml-2">បោះពុម្ភ</span>
                <div class="hover-text">Print PDF</div> <!-- Hover Text -->
            </a>
        </div>

        <div class="result-total-table-container mt-4">
            <!-- Row 1: Centered -->
            {{-- <div class="first-header text-center">
                <h2>ព្រះរាជាណាចក្រកម្ពុជា</h2>
                <h3>ជាតិ សាសនា ព្រះមហាក្សត្រ</h3>
            </div> --}}

            <!-- Row 2: Flex aligned to the left -->
            {{-- <div class="ministry-text">
                <h3>ក្រសួងការងារ​ នឹងបណ្ដុះបណ្ដាលវិជ្ជាជីវៈ</h3>
                <h3>នាយកដ្ខានរដ្ខាបាល និងហិរញ្ញវត្ថុ</h3>
                <h3>នាយកដ្ខានហិរញ្ញវត្ថុ និងទ្រព្យសម្បត្តិរដ្ឋ</h3>
                <h3>ការិយាល័យហិរញ្ញវត្ថុ</h3>
            </div> --}}

            <!-- Row 3: Centered -->
            <div class="second-header text-center">
                <h3>របាយការណ៍សង្ខេប</h3>
                {{-- <h4>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h4> --}}
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
                            <th>សរុប</th>
                            <th>ភាគរយ</th>

                            <th>សរុប</th>
                            <th>ភាគរយ</th>

                            <th>សរុប</th>
                            <th>ភាគរយ</th>

                            <th>សរុប</th>
                            <th>ភាគរយ</th>

                        </tr>
                    </thead>
                    <tbody class="cell-border">
                        <tr style="background-color: rgb(145, 145, 142);">
                            <td><strong>សរុបជំពូក</strong></td>
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
                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format(($totals['total_sums']['early_balance'] / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['apply'], 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format(($totals['total_sums']['apply'] / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>

                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['total_sum_refer'], 0, ' ', ' ') }}</td>

                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format((($totals['total_sums']['early_balance'] + $totals['total_sums']['apply']) / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>

                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['total_remain'], 0, ' ', ' ') }}</td>


                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format((($totals['total_sums']['new_credit_status'] - ($totals['total_sums']['early_balance'] + $totals['total_sums']['apply'])) / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>

                        @foreach ($totals['report_key'] as $codeId => $totalsByCode)

                        
                            <tr>
                                <td>{{ $codeId }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['fin_law'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['current_loan'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['total_increase'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['decrease'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['new_credit_status'], 0, ' ', ' ') }}</td>
                                <td
                                    style="{{ $totalsByCode['early_balance'] == 0 ? 'text-align: center;' : 'text-align: right; padding-right: 32px;' }}">
                                    {{ number_format($totalsByCode['early_balance'], 0, ' ', ' ') }}
                                </td>
                                <td>
                                    @if ($totalsByCode['new_credit_status'] > 0)
                                        {{ number_format(($totalsByCode['early_balance'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                <td
                                    style="{{ $totalsByCode['apply'] == 0 ? 'text-align: center;' : 'text-align: right; padding-right: 32px;' }}">
                                    {{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}
                                </td>

                                <td>
                                    @if ($totalsByCode['new_credit_status'] > 0)
                                        {{ number_format(($totalsByCode['apply'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                <td
                                    style="{{ $totalsByCode['early_balance'] + $totalsByCode['apply'] == 0 ? 'text-align: center;' : 'text-align: right; padding-right: 32px;' }}">
                                    {{ number_format($totalsByCode['early_balance'] + $totalsByCode['apply'], 0, ' ', ' ') }}
                                </td>
                                <td>
                                    @if ($totalsByCode['new_credit_status'] > 0)
                                        {{ number_format((($totalsByCode['early_balance'] + $totalsByCode['apply']) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                <td
                                    style="{{ $totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply']) == 0 ? 'text-align: center;' : 'text-align: right; padding-right: 32px;' }}">
                                    {{ number_format($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply']), 0, ' ', ' ') }}
                                </td>
                                <td>
                                    @if ($totalsByCode['new_credit_status'] > 0)
                                        {{ number_format((($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply'])) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        <tr style="background-color: rgb(145, 145, 142);">
                            <td><strong>សរុបកម្មវិធី</strong></td>
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

                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format(($totals['total_sums']['early_balance'] / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>

                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['apply'], 0, ' ', ' ') }}</td>

                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format(($totals['total_sums']['apply'] / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['total_sum_refer'], 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format((($totals['total_sums']['early_balance'] + $totals['total_sums']['apply']) / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>

                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['total_remain'], 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format((($totals['total_sums']['new_credit_status'] - ($totals['total_sums']['early_balance'] + $totals['total_sums']['apply'])) / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>

                        @foreach ($totals['report_key'] as $prefix => $totalsByCode)
                            <tr>
                                <td>{{ $prefix }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['fin_law'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['current_loan'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['total_increase'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['decrease'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['new_credit_status'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['early_balance'], 0, ' ', ' ') }}</td>

                                <td>
                                    @if ($totals['total_sums']['new_credit_status'] > 0)
                                        {{ number_format(($totals['total_sums']['early_balance'] / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totals['total_sums']['apply'], 0, ' ', ' ') }}</td>

                                <td>
                                    @if ($totals['total_sums']['new_credit_status'] > 0)
                                        {{ number_format(($totals['total_sums']['apply'] / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totals['total_sums']['total_sum_refer'], 0, ' ', ' ') }}</td>

                                <td>
                                    @if ($totals['total_sums']['new_credit_status'] > 0)
                                        {{ number_format((($totals['total_sums']['early_balance'] + $totals['total_sums']['apply']) / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totals['total_sums']['total_remain'], 0, ' ', ' ') }}</td>

                                <td>
                                    @if ($totals['total_sums']['new_credit_status'] > 0)
                                        {{ number_format((($totals['total_sums']['new_credit_status'] - ($totals['total_sums']['early_balance'] + $totals['total_sums']['apply'])) / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        <tr style="background-color: rgb(145, 145, 142);">
                            <td><strong>លម្អិតតាមកម្មវិធី</strong></td>
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

                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format(($totals['total_sums']['early_balance'] / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>

                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['apply'], 0, ' ', ' ') }}</td>

                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format(($totals['total_sums']['apply'] / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>

                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['early_balance'] + $totals['total_sums']['apply'], 0, ' ', ' ') }}
                            </td>

                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format((($totals['total_sums']['early_balance'] + $totals['total_sums']['apply']) / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>

                            <td style="text-align: right; padding-right: 32px;">
                                {{ number_format($totals['total_sums']['new_credit_status'] - ($totals['total_sums']['early_balance'] + $totals['total_sums']['apply']), 0, ' ', ' ') }}
                            </td>

                            <td>
                                @if ($totals['total_sums']['new_credit_status'] > 0)
                                    {{ number_format((($totals['total_sums']['new_credit_status'] - ($totals['total_sums']['early_balance'] + $totals['total_sums']['apply'])) / $totals['total_sums']['new_credit_status']) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>

                        @foreach ($totals['report_key'] as $prefix => $totalsByCode)
                            {{-- Display total row above the detailed rows --}}
                            <tr style="background-color: rgb(181, 245, 86);">
                                <td> កម្មវិធី {{ $prefix }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['fin_law'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['current_loan'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['total_increase'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['decrease'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['new_credit_status'], 0, ' ', ' ') }}</td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['early_balance'], 0, ' ', ' ') }}</td>
                                <td>
                                    @if ($totalsByCode['new_credit_status'] > 0)
                                        {{ number_format(($totalsByCode['early_balance'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}</td>
                                <td>
                                    @if ($totalsByCode['new_credit_status'] > 0)
                                        {{ number_format(($totalsByCode['apply'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['early_balance'] + $totalsByCode['apply'], 0, ' ', ' ') }}
                                </td>
                                <td>
                                    @if ($totalsByCode['new_credit_status'] > 0)
                                        {{ number_format((($totalsByCode['early_balance'] + $totalsByCode['apply']) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td style="text-align: right; padding-right: 32px;">
                                    {{ number_format($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply']), 0, ' ', ' ') }}
                                </td>
                                <td>
                                    @if ($totalsByCode['new_credit_status'] > 0)
                                        {{ number_format((($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply'])) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                            </tr>

                            {{-- @dd($totalsByCode['report_key_seven'] ) --}}
                            @foreach ($totalsByCode['report_key_seven'] as $index => $total)

                     
                                <tr>
                                    <td>{{ $index }}</td>
                                    <td style="text-align: right; padding-right: 32px;">
                                        {{ number_format($total['fin_law'], 0, ' ', ' ') }}</td>
                                    <td style="text-align: right; padding-right: 32px;">
                                        {{ number_format($total['current_loan'], 0, ' ', ' ') }}</td>
                                    <td style="text-align: right; padding-right: 32px;">
                                        {{ number_format($total['total_increase'], 0, ' ', ' ') }}</td>
                                    <td style="text-align: right; padding-right: 32px;">
                                        {{ number_format($total['decrease'], 0, ' ', ' ') }}</td>
                                    <td style="text-align: right; padding-right: 32px;">
                                        {{ number_format($total['new_credit_status'], 0, ' ', ' ') }}</td>
                                    <td style="text-align: right; padding-right: 32px;">
                                        {{ number_format($total['early_balance'], 0, ' ', ' ') }}</td>
                                    <td>
                                        @if ($total['new_credit_status'] > 0)
                                            {{ number_format(($total['early_balance'] / $total['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td style="text-align: right; padding-right: 32px;">
                                        {{ number_format($total['apply'], 0, ' ', ' ') }}</td>
                                    <td>
                                        @if ($total['new_credit_status'] > 0)
                                            {{ number_format(($total['apply'] / $total['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td style="text-align: right; padding-right: 32px;">
                                        {{ number_format($total['early_balance'] + $total['apply'], 0, ' ', ' ') }}</td>
                                    <td>
                                        @if ($total['new_credit_status'] > 0)
                                            {{ number_format((($total['early_balance'] + $total['apply']) / $total['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td style="text-align: right; padding-right: 32px;">
                                        {{ number_format($total['new_credit_status'] - ($total['early_balance'] + $total['apply']), 0, ' ', ' ') }}
                                    </td>
                                    <td>
                                        @if ($total['new_credit_status'] > 0)
                                            {{ number_format((($total['new_credit_status'] - ($total['early_balance'] + $total['apply'])) / $total['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    {{-- <style>
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

        .btn-width {
            width: 120px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        h2 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 18px;
        }

        h3,
        h4 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
        }

        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 6px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
        }

        h5 {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
        }

        .hover-text {
            display: none;
            position: absolute;
            bottom: 50px;
            background-color: #333;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1;
            transition: opacity 0.3s ease;
        }

        a:hover .hover-text {
            display: block;
            opacity: 1;
        }
    </style> --}}

    <style>
        .border-wrapper {
            padding-left: 16px;
            padding-right: 16px;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            /* Enable horizontal scrolling */
            white-space: nowrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
            /* Ensures the table doesn't shrink too much */
        }

        .btn-width {
            width: 120px;
        }

        h2 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 18px;
        }

        h3,
        h4 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
        }

        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 6px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
            white-space: nowrap;
            /* Prevents text from wrapping */
        }

        h5 {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
        }

        /* Hover text */
        .hover-text {
            display: none;
            position: absolute;
            bottom: 50px;
            background-color: #333;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1;
            transition: opacity 0.3s ease;
        }

        a:hover .hover-text {
            display: block;
            opacity: 1;
        }

        /* Make table fully responsive */
        @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
                display: block;
                width: 100%;
            }

            table {
                width: 100%;
                min-width: 900px;
                /* Adjust this value based on content */
            }
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
