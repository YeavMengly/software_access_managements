<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Report</title>

    {{-- <style>
        @font-face {
            font-family: khmer;
            font-style: normal;
            font-weight: 400;
            src: url({{ asset('fonts/khmer.ttf') }}) format('true-type');
        }

        body {
            font-family: 'Khmer OS', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .first-header,
        .second-header {
            text-align: center;
            /* Ensures the text inside is centered */
        }

        .result-total-table-container {
            padding: 16px;

        }

        .ministry-text {
            text-align: left;
            padding-left: 20px;
            /* Add padding if necessary */
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
        }

        .result-total-table-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Centers rows horizontally */
        }

        .first-header,
        .second-header {
            text-align: center;
            /* Centers text in these sections */
            width: 100%;
        }

        .ministry-text {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            /* Aligns text to the left */
            width: 100%;
            padding-left: 20px;
            /* Add padding to give some left space */
        }

        .ministry-text h3 {
            margin: 0;
            /* Optional: Adjust this if you want less/more space between lines */
        }
    </style> --}}
    <style>
        @font-face {
            font-family: khmer;
            font-style: normal;
            font-weight: 400;
            src: url({{ asset('fonts/khmer.ttf') }}) format('true-type');
        }

        body {
            font-family: 'Khmer OS', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .result-total-table-container {
            padding: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Centers rows horizontally */
        }

        .first-header,
        .second-header {
            text-align: center;
            /* Centers text in these sections */
            width: 100%;
        }

        .ministry-text {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            /* Aligns text to the left */
            width: 100%;
            padding-left: 20px;
            /* Add padding to give some left space */
        }

        .ministry-text h3 {
            margin: 0;
            /* Optional: Adjust this if you want less/more space between lines */
        }

        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }
    </style>

    <style type="text/css">
        .khmer {
            font-family: 'Khmer', cursive;
        }
    </style>
</head>

<body>

    <div class="border-wrapper">
        <div class="result-total-table-container mt-4">


            <!-- Row 1: Centered -->
            <div class="first-header text-center">
                <h2>ព្រះរាជាណាចក្រកម្ពុជា</h2>
                <h3>ជាតិ សាសនា ព្រះមហាក្សត្រ</h3>
                {{-- <h3>3</h3> --}}
            </div>

            <!-- Row 2: Flex aligned to the left -->
            <div class="ministry-text">
                <h3>ក្រសួងការងារ​ នឹងបណ្ដុះបណ្ដាលវិជ្ជាជីវៈ</h3>
                <h3>នាយកដ្ខានរដ្ខាបាល និងហិរញ្ញវត្ថុ</h3>
                <h3>នាយកដ្ខានហិរញ្ញវត្ថុ និងទ្រព្យសម្បត្តិរដ្ឋ</h3>
                <h3>ការិយាល័យហិរញ្ញវត្ថុ</h3>
            </div>

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
                        <tr style="background-color: rgb(181, 245, 86);">
                            <td><strong>សរុបជំពូក</strong></td>
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
                        <!-- Add your rows here -->
                        @foreach ($totals['code'] as $codeId => $totalsByCode)
                            <tr>
                                <td>{{ $codeId }}</td>
                                <td>{{ number_format($totalsByCode['fin_law'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByCode['current_loan'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByCode['total_increase'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByCode['decrease'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByCode['new_credit_status'], 0, ' ', ' ') }}</td>

                                {{-- Avg of early balance --}}
                                <td>{{ number_format($totalsByCode['early_balance'], 0, ' ', ' ') }}</td>
                                <td>
                                    @if ($totalsByCode['new_credit_status'] > 0)
                                        {{ number_format(($totalsByCode['early_balance'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                {{-- Avg of apply --}}
                                <td>{{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}</td>
                                <td>
                                    @if ($totalsByCode['new_credit_status'] > 0)
                                        {{ number_format(($totalsByCode['apply'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                {{-- Avg of sum refer --}}
                                <td>{{ number_format($totalsByCode['early_balance'] + $totalsByCode['apply'], 0, ' ', ' ') }}
                                </td>
                                <td>
                                    @if ($totalsByCode['new_credit_status'] > 0)
                                        {{ number_format((($totalsByCode['early_balance'] + $totalsByCode['apply']) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>

                                {{-- Avg Remain --}}
                                <td>{{ number_format($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply']), 0, ' ', ' ') }}
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

                        <tr style="background-color: rgb(181, 245, 86);">
                            <td><strong>សរុបកម្មវិធី</strong></td>
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

                        {{-- Display total sums for report_key by the first 3 digits --}}
                        @foreach ($totals['report_key'] as $prefix => $totalsByCode)
                            <tr>
                                <td>{{ $prefix }}</td>
                                <td>{{ number_format($totalsByCode['fin_law'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByCode['current_loan'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByCode['total_increase'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByCode['decrease'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByCode['new_credit_status'], 0, ' ', ' ') }}</td>
                                <td>{{ number_format($totalsByCode['early_balance'], 0, ' ', ' ') }}</td>
                                <td>
                                    @if ($totalsByCode['new_credit_status'] > 0)
                                        {{ number_format(($totalsByCode['early_balance'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td>{{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}</td>
                                <td>
                                    @if ($totalsByCode['new_credit_status'] > 0)
                                        {{ number_format(($totalsByCode['apply'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td>{{ number_format($totalsByCode['early_balance'] + $totalsByCode['apply'], 0, ' ', ' ') }}
                                </td>
                                <td>
                                    @if ($totalsByCode['new_credit_status'] > 0)
                                        {{ number_format((($totalsByCode['early_balance'] + $totalsByCode['apply']) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td>{{ number_format($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply']), 0, ' ', ' ') }}
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

                        @php
                            // Initialize variables for totals
                            $totalFinLaw = 0;
                            $totalCurrentLoan = 0;
                            $totalTotalIncrease = 0;
                            $totalDecrease = 0;
                            $totalNewCreditStatus = 0;
                            $totalEarlyBalance = 0;
                            $totalApply = 0;

                            // Calculate totals based on prefixes
                            foreach ($totals['report_key_seven'] as $prefix => $totalsByCode) {
                                if (in_array(substr($prefix, 0, 3), ['321', '322', '323', '324', '325'])) {
                                    $totalFinLaw += $totalsByCode['fin_law'];
                                    $totalCurrentLoan += $totalsByCode['current_loan'];
                                    $totalTotalIncrease += $totalsByCode['total_increase'];
                                    $totalDecrease += $totalsByCode['decrease'];
                                    $totalNewCreditStatus += $totalsByCode['new_credit_status'];
                                    $totalEarlyBalance += $totalsByCode['early_balance'];
                                    $totalApply += $totalsByCode['apply'];
                                }
                            }
                        @endphp

                        <tr style="background-color: rgb(181, 245, 86);">
                            <td><strong>លម្អិតតាមកម្មវិធី</strong></td>
                            <td>{{ number_format($totalFinLaw, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalCurrentLoan, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalTotalIncrease, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalDecrease, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalNewCreditStatus, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalEarlyBalance, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format(($totalEarlyBalance / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalApply, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format(($totalApply / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalEarlyBalance + $totalApply, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format((($totalEarlyBalance + $totalApply) / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalNewCreditStatus - ($totalEarlyBalance + $totalApply), 0, ' ', ' ') }}
                            </td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format((($totalNewCreditStatus - ($totalEarlyBalance + $totalApply)) / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>


                        {{-- Initialize total variables --}}
                        @php
                            $totalFinLaw = 0;
                            $totalCurrentLoan = 0;
                            $totalTotalIncrease = 0;
                            $totalDecrease = 0;
                            $totalNewCreditStatus = 0;
                            $totalEarlyBalance = 0;
                            $totalApply = 0;
                        @endphp

                        {{-- Loop through totals to calculate the overall totals --}}
                        @foreach ($totals['report_key_seven'] as $prefix => $totalsByCode)
                            @if (substr($prefix, 0, 3) === '321')
                                @php
                                    $totalFinLaw += $totalsByCode['fin_law'];
                                    $totalCurrentLoan += $totalsByCode['current_loan'];
                                    $totalTotalIncrease += $totalsByCode['total_increase'];
                                    $totalDecrease += $totalsByCode['decrease'];
                                    $totalNewCreditStatus += $totalsByCode['new_credit_status'];
                                    $totalEarlyBalance += $totalsByCode['early_balance'];
                                    $totalApply += $totalsByCode['apply'];
                                @endphp
                            @endif
                        @endforeach

                        {{-- Display total row above the detailed rows --}}
                        <tr style="background-color: rgb(181, 245, 86);">
                            <td>កម្មវិធី1</td>
                            <td>{{ number_format($totalFinLaw, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalCurrentLoan, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalTotalIncrease, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalDecrease, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalNewCreditStatus, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalEarlyBalance, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format(($totalEarlyBalance / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalApply, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format(($totalApply / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalEarlyBalance + $totalApply, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format((($totalEarlyBalance + $totalApply) / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalNewCreditStatus - ($totalEarlyBalance + $totalApply), 0, ' ', ' ') }}
                            </td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format((($totalNewCreditStatus - ($totalEarlyBalance + $totalApply)) / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>

                        {{-- Now display the detailed rows --}}
                        @foreach ($totals['report_key_seven'] as $prefix => $totalsByCode)
                            @if (substr($prefix, 0, 3) === '321')
                                <tr>
                                    <td>{{ $prefix }}</td>
                                    <td>{{ number_format($totalsByCode['fin_law'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['current_loan'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['total_increase'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['decrease'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['new_credit_status'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['early_balance'], 0, ' ', ' ') }}</td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format(($totalsByCode['early_balance'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}</td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format(($totalsByCode['apply'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['early_balance'] + $totalsByCode['apply'], 0, ' ', ' ') }}
                                    </td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format((($totalsByCode['early_balance'] + $totalsByCode['apply']) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply']), 0, ' ', ' ') }}
                                    </td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format((($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply'])) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                        {{-- Calculate totals for each field --}}
                        @php
                            $totalFinLaw = 0;
                            $totalCurrentLoan = 0;
                            $totalTotalIncrease = 0;
                            $totalDecrease = 0;
                            $totalNewCreditStatus = 0;
                            $totalEarlyBalance = 0;
                            $totalApply = 0;

                            foreach ($totals['report_key_seven'] as $prefix => $totalsByCode) {
                                if (substr($prefix, 0, 3) === '322') {
                                    $totalFinLaw += $totalsByCode['fin_law'];
                                    $totalCurrentLoan += $totalsByCode['current_loan'];
                                    $totalTotalIncrease += $totalsByCode['total_increase'];
                                    $totalDecrease += $totalsByCode['decrease'];
                                    $totalNewCreditStatus += $totalsByCode['new_credit_status'];
                                    $totalEarlyBalance += $totalsByCode['early_balance'];
                                    $totalApply += $totalsByCode['apply'];
                                }
                            }
                        @endphp

                        {{-- Total row above the loop --}}
                        <tr style="background-color: rgb(181, 245, 86);">
                            <td>កម្មវិធី2</td>
                            <td>{{ number_format($totalFinLaw, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalCurrentLoan, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalTotalIncrease, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalDecrease, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalNewCreditStatus, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalEarlyBalance, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format(($totalEarlyBalance / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalApply, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format(($totalApply / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalEarlyBalance + $totalApply, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format((($totalEarlyBalance + $totalApply) / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalNewCreditStatus - ($totalEarlyBalance + $totalApply), 0, ' ', ' ') }}
                            </td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format((($totalNewCreditStatus - ($totalEarlyBalance + $totalApply)) / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>

                        {{-- Loop through the details --}}
                        @foreach ($totals['report_key_seven'] as $prefix => $totalsByCode)
                            @if (substr($prefix, 0, 3) === '322')
                                <tr>
                                    <td>{{ $prefix }}</td>
                                    <td>{{ number_format($totalsByCode['fin_law'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['current_loan'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['total_increase'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['decrease'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['new_credit_status'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['early_balance'], 0, ' ', ' ') }}</td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format(($totalsByCode['early_balance'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}</td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format(($totalsByCode['apply'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['early_balance'] + $totalsByCode['apply'], 0, ' ', ' ') }}
                                    </td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format((($totalsByCode['early_balance'] + $totalsByCode['apply']) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply']), 0, ' ', ' ') }}
                                    </td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format((($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply'])) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                        @php
                            // Initialize variables for totals
                            $totalFinLaw = 0;
                            $totalCurrentLoan = 0;
                            $totalTotalIncrease = 0;
                            $totalDecrease = 0;
                            $totalNewCreditStatus = 0;
                            $totalEarlyBalance = 0;
                            $totalApply = 0;

                            // Calculate totals first
                            foreach ($totals['report_key_seven'] as $prefix => $totalsByCode) {
                                if (substr($prefix, 0, 3) === '323') {
                                    $totalFinLaw += $totalsByCode['fin_law'];
                                    $totalCurrentLoan += $totalsByCode['current_loan'];
                                    $totalTotalIncrease += $totalsByCode['total_increase'];
                                    $totalDecrease += $totalsByCode['decrease'];
                                    $totalNewCreditStatus += $totalsByCode['new_credit_status'];
                                    $totalEarlyBalance += $totalsByCode['early_balance'];
                                    $totalApply += $totalsByCode['apply'];
                                }
                            }
                        @endphp

                        {{-- Display totals row above the loop --}}
                        <tr style="background-color: rgb(181, 245, 86);">
                            <td>កម្មវិធី3</td>
                            <td>{{ number_format($totalFinLaw, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalCurrentLoan, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalTotalIncrease, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalDecrease, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalNewCreditStatus, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalEarlyBalance, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format(($totalEarlyBalance / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalApply, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format(($totalApply / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalEarlyBalance + $totalApply, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format((($totalEarlyBalance + $totalApply) / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalNewCreditStatus - ($totalEarlyBalance + $totalApply), 0, ' ', ' ') }}
                            </td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format((($totalNewCreditStatus - ($totalEarlyBalance + $totalApply)) / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>

                        {{-- Loop through individual rows --}}
                        @foreach ($totals['report_key_seven'] as $prefix => $totalsByCode)
                            @if (substr($prefix, 0, 3) === '323')
                                <tr>
                                    <td>{{ $prefix }}</td>
                                    <td>{{ number_format($totalsByCode['fin_law'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['current_loan'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['total_increase'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['decrease'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['new_credit_status'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['early_balance'], 0, ' ', ' ') }}</td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format(($totalsByCode['early_balance'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}</td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format(($totalsByCode['apply'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['early_balance'] + $totalsByCode['apply'], 0, ' ', ' ') }}
                                    </td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format((($totalsByCode['early_balance'] + $totalsByCode['apply']) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply']), 0, ' ', ' ') }}
                                    </td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format((($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply'])) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                        @php
                            // Initialize variables for totals
                            $totalFinLaw = 0;
                            $totalCurrentLoan = 0;
                            $totalTotalIncrease = 0;
                            $totalDecrease = 0;
                            $totalNewCreditStatus = 0;
                            $totalEarlyBalance = 0;
                            $totalApply = 0;

                            // Calculate totals first
                            foreach ($totals['report_key_seven'] as $prefix => $totalsByCode) {
                                if (substr($prefix, 0, 3) === '324') {
                                    $totalFinLaw += $totalsByCode['fin_law'];
                                    $totalCurrentLoan += $totalsByCode['current_loan'];
                                    $totalTotalIncrease += $totalsByCode['total_increase'];
                                    $totalDecrease += $totalsByCode['decrease'];
                                    $totalNewCreditStatus += $totalsByCode['new_credit_status'];
                                    $totalEarlyBalance += $totalsByCode['early_balance'];
                                    $totalApply += $totalsByCode['apply'];
                                }
                            }
                        @endphp

                        {{-- Display totals row above the loop --}}
                        <tr style="background-color: rgb(181, 245, 86);">
                            <td>កម្មវិធី4</td>
                            <td>{{ number_format($totalFinLaw, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalCurrentLoan, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalTotalIncrease, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalDecrease, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalNewCreditStatus, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalEarlyBalance, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format(($totalEarlyBalance / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalApply, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format(($totalApply / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalEarlyBalance + $totalApply, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format((($totalEarlyBalance + $totalApply) / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalNewCreditStatus - ($totalEarlyBalance + $totalApply), 0, ' ', ' ') }}
                            </td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format((($totalNewCreditStatus - ($totalEarlyBalance + $totalApply)) / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>

                        {{-- Loop through individual rows --}}
                        @foreach ($totals['report_key_seven'] as $prefix => $totalsByCode)
                            @if (substr($prefix, 0, 3) === '324')
                                <tr>
                                    <td>{{ $prefix }}</td>
                                    <td>{{ number_format($totalsByCode['fin_law'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['current_loan'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['total_increase'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['decrease'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['new_credit_status'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['early_balance'], 0, ' ', ' ') }}</td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format(($totalsByCode['early_balance'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}</td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format(($totalsByCode['apply'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['early_balance'] + $totalsByCode['apply'], 0, ' ', ' ') }}
                                    </td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format((($totalsByCode['early_balance'] + $totalsByCode['apply']) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply']), 0, ' ', ' ') }}
                                    </td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format((($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply'])) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                        @php
                            // Initialize variables for totals
                            $totalFinLaw = 0;
                            $totalCurrentLoan = 0;
                            $totalTotalIncrease = 0;
                            $totalDecrease = 0;
                            $totalNewCreditStatus = 0;
                            $totalEarlyBalance = 0;
                            $totalApply = 0;

                            // Calculate totals first
                            foreach ($totals['report_key_seven'] as $prefix => $totalsByCode) {
                                if (substr($prefix, 0, 3) === '325') {
                                    $totalFinLaw += $totalsByCode['fin_law'];
                                    $totalCurrentLoan += $totalsByCode['current_loan'];
                                    $totalTotalIncrease += $totalsByCode['total_increase'];
                                    $totalDecrease += $totalsByCode['decrease'];
                                    $totalNewCreditStatus += $totalsByCode['new_credit_status'];
                                    $totalEarlyBalance += $totalsByCode['early_balance'];
                                    $totalApply += $totalsByCode['apply'];
                                }
                            }
                        @endphp

                        {{-- Display totals row above the loop --}}
                        <tr style="background-color: rgb(181, 245, 86);">
                            <td>កម្មវិធី5</td>
                            <td>{{ number_format($totalFinLaw, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalCurrentLoan, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalTotalIncrease, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalDecrease, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalNewCreditStatus, 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalEarlyBalance, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format(($totalEarlyBalance / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalApply, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format(($totalApply / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalEarlyBalance + $totalApply, 0, ' ', ' ') }}</td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format((($totalEarlyBalance + $totalApply) / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                            <td>{{ number_format($totalNewCreditStatus - ($totalEarlyBalance + $totalApply), 0, ' ', ' ') }}
                            </td>
                            <td>
                                @if ($totalNewCreditStatus > 0)
                                    {{ number_format((($totalNewCreditStatus - ($totalEarlyBalance + $totalApply)) / $totalNewCreditStatus) * 100, 2, '.', ' ') }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>

                        {{-- Loop through individual rows --}}
                        @foreach ($totals['report_key_seven'] as $prefix => $totalsByCode)
                            @if (substr($prefix, 0, 3) === '325')
                                <tr>
                                    <td>{{ $prefix }}</td>
                                    <td>{{ number_format($totalsByCode['fin_law'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['current_loan'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['total_increase'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['decrease'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['new_credit_status'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByCode['early_balance'], 0, ' ', ' ') }}</td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format(($totalsByCode['early_balance'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}</td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format(($totalsByCode['apply'] / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['early_balance'] + $totalsByCode['apply'], 0, ' ', ' ') }}
                                    </td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format((($totalsByCode['early_balance'] + $totalsByCode['apply']) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>{{ number_format($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply']), 0, ' ', ' ') }}
                                    </td>
                                    <td>
                                        @if ($totalsByCode['new_credit_status'] > 0)
                                            {{ number_format((($totalsByCode['new_credit_status'] - ($totalsByCode['early_balance'] + $totalsByCode['apply'])) / $totalsByCode['new_credit_status']) * 100, 2, '.', ' ') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>

    </div>
</body>

</html>
