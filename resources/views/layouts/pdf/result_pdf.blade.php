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
                <h3>របាយការណ៍ធានាចំណាយថវិកាក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h3>
                <h4>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h4>
            </div>

            <div class="table-container">

                {{--            Table           --}}
                <table id="reportTable" class="table-border mt-4">
                    <thead class="header-border">
                        <tr>
                            {{-- <th rowspan="3">លេខ</th> --}}
                            <th rowspan="3">ជំពូក</th>
                            <th rowspan="3">គណនី</th>
                            <th rowspan="3">អនុគណនី</th>
                            <th rowspan="3">កូដកម្មវិធី</th>
                            <th rowspan="3">ចំណាត់ថ្នាក់</th>
                            <th rowspan="3">ច្បាប់ហិ.វ</th>
                            <th rowspan="3">ឥណទានបច្ចុប្បន្ន</th>
                            <th colspan="5">ចលនាឥណទាន</th>
                            <th rowspan="3">វិចារណកម្ម</th>
                            <th rowspan="3">ស្ថានភាពឥណទានថ្មី</th>
                            <th rowspan="3">ស.ម.ដើមគ្រា</th>
                            <th rowspan="3">អនុវត្ត</th>
                            <th rowspan="3">ស.ម.ចុងគ្រា</th>
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

                        {{-- Group Code --}}
                        @foreach ($totals['code'] as $codeId => $totalsByCode)
                            <tr style="background-color: rgb(181, 245, 86);">
                                {{-- <td>{{ $loop->iteration }}</td> --}}
                                <td colspan="1"> {{ $codeId }} </td>
                                <td colspan="1"></td>
                                <td colspan="1"></td>
                                <td colspan="1"></td>
                                <td colspan="1" style="text-align: start; width: 400px;">
                                    {{ $totalsByCode['name'] }}</td>
                                <td>{{ number_format($totalsByCode['fin_law'], 0, ',', ',') }}</td>
                                <td>{{ number_format($totalsByCode['current_loan'], 0, ',', ',') }}</td>
                                <td>{{ number_format($totalsByCode['internal_increase'], 0, ',', ',') }}</td>
                                <td>{{ number_format($totalsByCode['unexpected_increase'], 0, ',', ',') }}</td>
                                <td>{{ number_format($totalsByCode['additional_increase'], 0, ',', ',') }}</td>
                                <td>{{ number_format($totalsByCode['total_increase'], 0, ',', ',') }}</td>

                                <td style="color: {{ $totalsByCode['decrease'] < 0 ? 'red' : 'black' }}; ">
                                    {{ number_format($totalsByCode['decrease'], 0, ',', ',') }}
                                </td>
                                <td style="color: {{ $totalsByCode['editorial'] < 0 ? 'red' : 'black' }}; ">
                                    {{ number_format($totalsByCode['editorial'], 0, ',', ',') }}
                                </td>
                                <td style="color: {{ $totalsByCode['new_credit_status'] < 0 ? 'red' : 'black' }}; ">
                                    {{ number_format($totalsByCode['new_credit_status'], 0, ',', ',') }}
                                </td>
                                <td style="color: {{ $totalsByCode['early_balance'] < 0 ? 'red' : 'black' }}; ">
                                    {{ number_format($totalsByCode['early_balance'], 0, ',', ',') }}
                                </td>
                                <td style="color: {{ $totalsByCode['apply'] < 0 ? 'red' : 'black' }}; ">
                                    {{ number_format($totalsByCode['apply'], 0, ',', ',') }}
                                </td>
                                <td style="color: {{ $totalsByCode['deadline_balance'] < 0 ? 'red' : 'black' }}; ">
                                    {{ number_format($totalsByCode['deadline_balance'], 0, ',', ',') }}
                                </td>
                                <td style="color: {{ $totalsByCode['credit'] < 0 ? 'red' : 'black' }}; ">
                                    {{ number_format($totalsByCode['credit'], 0, ',', ',') }}
                                </td>
                                <td style="color: {{ $totalsByCode['law_average'] < 0 ? 'red' : 'black' }}; ">
                                    {{ number_format($totalsByCode['law_average'], 2, '.', ' ') }} %</td>
                                <td style="color: {{ $totalsByCode['law_correction'] < 0 ? 'red' : 'black' }}; ">
                                    {{ number_format($totalsByCode['law_correction'], 2, '.', ' ') }} %</td>
                            </tr>

                            {{-- Group Account --}}
                            @foreach ($totals['accountKey'][$codeId] as $accountKeyId => $totalsByAccountKey)
                                <tr>
                                    {{-- <td></td> --}}
                                    <td></td>
                                    <td colspan="1">{{ $accountKeyId }}</td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="1" style="text-align: start;">
                                        {{ $totalsByAccountKey['name_account_key'] }}</td>
                                    <td>{{ number_format($totalsByAccountKey['fin_law'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['current_loan'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['internal_increase'], 0, ' ', ' ') }}
                                    </td>
                                    <td>{{ number_format($totalsByAccountKey['unexpected_increase'], 0, ' ', ' ') }}
                                    </td>
                                    <td>{{ number_format($totalsByAccountKey['additional_increase'], 0, ' ', ' ') }}
                                    </td>

                                    <td>{{ number_format($totalsByAccountKey['total_increase'], 0, ' ', ' ') }}
                                    </td>
                                    <td style="color: {{ $totalsByAccountKey['decrease'] < 0 ? 'red' : 'black' }};">
                                        {{ number_format($totalsByAccountKey['decrease'], 0, ' ', ' ') }}
                                    </td>
                                    <td style="color: {{ $totalsByAccountKey['editorial'] < 0 ? 'red' : 'black' }};">
                                        {{ number_format($totalsByAccountKey['editorial'], 0, ' ', ' ') }}
                                    </td>
                                    <td
                                        style="color: {{ $totalsByAccountKey['new_credit_status'] < 0 ? 'red' : 'black' }};">
                                        {{ number_format($totalsByAccountKey['new_credit_status'], 0, ' ', ' ') }}
                                    </td>
                                    <td
                                        style="color: {{ $totalsByAccountKey['early_balance'] < 0 ? 'red' : 'black' }};">
                                        {{ number_format($totalsByAccountKey['early_balance'], 0, ' ', ' ') }}
                                    </td>
                                    <td style="color: {{ $totalsByAccountKey['apply'] < 0 ? 'red' : 'black' }};">
                                        {{ number_format($totalsByAccountKey['apply'], 0, ' ', ' ') }}
                                    </td>
                                    <td
                                        style="color: {{ $totalsByAccountKey['deadline_balance'] < 0 ? 'red' : 'black' }};">
                                        {{ number_format($totalsByAccountKey['deadline_balance'], 0, ' ', ' ') }}
                                    </td>
                                    <td style="color: {{ $totalsByAccountKey['credit'] < 0 ? 'red' : 'black' }};">
                                        {{ number_format($totalsByAccountKey['credit'], 0, ' ', ' ') }}
                                    </td>
                                    <td style="color: {{ $totalsByAccountKey['law_average'] < 0 ? 'red' : 'black' }};">
                                        {{ number_format($totalsByAccountKey['law_average'], 2, '.', ' ') }} %</td>
                                    <td
                                        style="color: {{ $totalsByAccountKey['law_correction'] < 0 ? 'red' : 'black' }};">
                                        {{ number_format($totalsByAccountKey['law_correction'], 2, '.', ' ') }} %
                                    </td>
                                </tr>

                                {{-- Group Sub Account --}}
                                @foreach ($totals['subAccountKey'][$codeId][$accountKeyId] as $subAccountKeyId => $totalsBySubAccountKey)
                                    <tr>
                                        {{-- <td></td> --}}
                                        <td></td>
                                        <td></td>
                                        <td colspan="1">{{ $subAccountKeyId }}</td>
                                        <td></td>
                                        <td colspan="1" style="text-align: start;">
                                            {{ $totalsBySubAccountKey['name_sub_account_key'] }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['fin_law'], 0, ' ', ' ') }}
                                        </td>
                                        <td>{{ number_format($totalsBySubAccountKey['current_loan'], 0, ' ', ' ') }}
                                        </td>
                                        <td>{{ number_format($totalsBySubAccountKey['internal_increase'], 0, ' ', ' ') }}
                                        </td>
                                        <td>{{ number_format($totalsBySubAccountKey['unexpected_increase'], 0, ' ', ' ') }}
                                        </td>
                                        <td>{{ number_format($totalsBySubAccountKey['additional_increase'], 0, ' ', ' ') }}
                                        </td>

                                        <td>{{ number_format($totalsBySubAccountKey['total_increase'], 0, ' ', ' ') }}
                                        </td>
                                        <td
                                            style="color: {{ $totalsBySubAccountKey['decrease'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsBySubAccountKey['decrease'], 0, ' ', ' ') }}
                                        </td>
                                        <td
                                            style="color: {{ $totalsBySubAccountKey['editorial'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsBySubAccountKey['editorial'], 0, ' ', ' ') }}
                                        </td>
                                        <td
                                            style="color: {{ $totalsBySubAccountKey['new_credit_status'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsBySubAccountKey['new_credit_status'], 0, ' ', ' ') }}
                                        </td>
                                        <td
                                            style="color: {{ $totalsBySubAccountKey['early_balance'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsBySubAccountKey['early_balance'], 0, ' ', ' ') }}
                                        </td>
                                        <td
                                            style="color: {{ $totalsBySubAccountKey['apply'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsBySubAccountKey['apply'], 0, ' ', ' ') }}
                                        </td>
                                        <td
                                            style="color: {{ $totalsBySubAccountKey['deadline_balance'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsBySubAccountKey['deadline_balance'], 0, ' ', ' ') }}
                                        </td>
                                        <td
                                            style="color: {{ $totalsBySubAccountKey['credit'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsBySubAccountKey['credit'], 0, ' ', ' ') }}
                                        </td>
                                        <td
                                            style="color: {{ $totalsBySubAccountKey['law_average'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsBySubAccountKey['law_average'], 2, '.', ' ') }}
                                            %</td>
                                        <td
                                            style="color: {{ $totalsBySubAccountKey['law_correction'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsBySubAccountKey['law_correction'], 2, '.', ' ') }}
                                            %</td>
                                    </tr>

                                    {{-- Listing Data Report --}}
                                    @foreach ($totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId] as $reportKeyId => $totalsByReportKey)
                                        <tr>
                                            {{-- <td></td> --}}
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td colspan="1">{{ $reportKeyId }}</td>
                                            <td colspan="1" style="text-align: start;">
                                                {{ $totalsByReportKey['name_report_key'] }}</td>
                                            <td>{{ number_format($totalsByReportKey['fin_law'], 0, ' ', ' ') }}
                                            </td>
                                            <td>{{ number_format($totalsByReportKey['current_loan'], 0, ' ', ' ') }}
                                            </td>
                                            <td>{{ number_format($totalsByReportKey['internal_increase'], 0, ' ', ' ') }}
                                            </td>
                                            <td>{{ number_format($totalsByReportKey['unexpected_increase'], 0, ' ', ' ') }}
                                            </td>
                                            <td>{{ number_format($totalsByReportKey['additional_increase'], 0, ' ', ' ') }}
                                            </td>
                                            <td>{{ number_format($totalsByReportKey['total_increase'], 0, ' ', ' ') }}
                                            </td>
                                            <td
                                                style="color: {{ $totalsByReportKey['decrease'] < 0 ? 'red' : 'black' }};">
                                                {{ number_format($totalsByReportKey['decrease'], 0, ' ', ' ') }}
                                            </td>
                                            <td
                                                style="color: {{ $totalsByReportKey['editorial'] < 0 ? 'red' : 'black' }};">
                                                {{ number_format($totalsByReportKey['editorial'], 0, ' ', ' ') }}
                                            </td>
                                            <td
                                                style="color: {{ $totalsByReportKey['new_credit_status'] < 0 ? 'red' : 'black' }};">
                                                {{ number_format($totalsByReportKey['new_credit_status'], 0, ' ', ' ') }}
                                            </td>
                                            <td
                                                style="color: {{ $totalsByReportKey['early_balance'] < 0 ? 'red' : 'black' }};">
                                                {{ number_format($totalsByReportKey['early_balance'], 0, ' ', ' ') }}
                                            </td>
                                            <td
                                                style="color: {{ $totalsByReportKey['apply'] < 0 ? 'red' : 'black' }};">
                                                {{ number_format($totalsByReportKey['apply'], 0, ' ', ' ') }}
                                            </td>
                                            <td
                                                style="color: {{ $totalsByReportKey['deadline_balance'] < 0 ? 'red' : 'black' }};">
                                                {{ number_format($totalsByReportKey['deadline_balance'], 0, ' ', ' ') }}
                                            </td>
                                            <td
                                                style="color: {{ $totalsByReportKey['credit'] < 0 ? 'red' : 'black' }};">
                                                {{ number_format($totalsByReportKey['credit'], 0, ' ', ' ') }}
                                            </td>
                                            <td
                                                style="color: {{ $totalsByReportKey['law_average'] < 0 ? 'red' : 'black' }};">
                                                {{ number_format($totalsByReportKey['law_average'], 2, '.', '') }}
                                                %
                                            </td>
                                            <td
                                                style="color: {{ $totalsByReportKey['law_correction'] < 0 ? 'red' : 'black' }};">
                                                {{ number_format($totalsByReportKey['law_correction'], 2, '.', '') }}
                                                %
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach

                        {{--                  Total                  --}}
                        {{-- <tr>
                            <td colspan="5" style="border: 1px solid black; text-align: center;">
                                <strong>សរុប</strong>: ការរាយការណ៍
                            </td>
                            <td colspan="1" style="color: {{ $totals['fin_law'] < 0 ? 'red' : 'black' }};">
                                {{ number_format($totals['fin_law'], 0, ' ', ' ') }}</td>
                            <td colspan="1" style="color: {{ $totals['current_loan'] < 0 ? 'red' : 'black' }};">
                                {{ number_format($totals['current_loan'], 0, ' ', ' ') }}</td>
                            <td colspan="1"
                                style="color: {{ $totals['internal_increase'] < 0 ? 'red' : 'black' }};">
                                {{ number_format($totals['internal_increase'], 0, ' ', ' ') }}</td>
                            <td colspan="1"
                                style="color: {{ $totals['unexpected_increase'] < 0 ? 'red' : 'black' }};">
                                {{ number_format($totals['unexpected_increase'], 0, ' ', ' ') }}
                            </td>
                            <td colspan="1"
                                style="color: {{ $totals['additional_increase'] < 0 ? 'red' : 'black' }};">
                                {{ number_format($totals['additional_increase'], 0, ' ', ' ') }} </td>
                            <td colspan="1" style="color: {{ $totals['total_increase'] < 0 ? 'red' : 'black' }};">
                                {{ number_format($totals['total_increase'], 0, ' ', ' ') }} </td>
                            <td colspan="1" style="color: {{ $totals['decrease'] < 0 ? 'red' : 'black' }};">
                                {{ number_format($totals['decrease'], 0, ' ', ' ') }} </td>
                            <td colspan="1" style="color: {{ $totals['editorial'] < 0 ? 'red' : 'black' }};">
                                {{ number_format($totals['editorial'], 0, ' ', ' ') }}
                            </td>
                            <td colspan="1"
                                style="color: {{ $totals['new_credit_status'] < 0 ? 'red' : 'black' }};">
                                {{ number_format($totals['new_credit_status'], 0, ' ', ' ') }}
                            </td>
                            <td colspan="1" style="color: {{ $totals['early_balance'] < 0 ? 'red' : 'black' }};">
                                {{ number_format($totals['early_balance'], 0, ' ', ' ') }}
                            </td>
                            <td colspan="1" style="color: {{ $totals['apply'] < 0 ? 'red' : 'black' }};">
                                {{ number_format($totals['apply'], 0, ' ', ' ') }} </td>
                            <td colspan="1"
                                style="color: {{ $totals['deadline_balance'] < 0 ? 'red' : 'black' }};">
                                {{ number_format($totals['deadline_balance'], 0, ' ', ' ') }} </td>
                            <td colspan="1" style="color: {{ $totals['credit'] < 0 ? 'red' : 'black' }};">
                                {{ number_format($totals['credit'], 0, ' ', ' ') }} </td>
                            <td
                                style="color: {{ $totals['law_average'] !== null && $totals['law_average'] < 0 ? 'red' : 'black' }};">
                                {{ $totals['law_average'] !== null ? number_format($totals['law_average'], 2, '.', '') . '%' : 'N/A' }}
                            </td>
                            <td
                                style="color: {{ $totals['law_correction'] !== null && $totals['law_correction'] < 0 ? 'red' : 'black' }};">
                                {{ $totals['law_correction'] !== null ? number_format($totals['law_correction'], 2, '.', '') . '%' : 'N/A' }}
                            </td>

                        </tr> --}}
                        {{-- End import data --}}
                    </tbody>
                </table>
                {{--            Table           --}}

            </div>
        </div>

        {{--        Start action btn export and print        --}}
        {{-- <div class="d-flex justify-content-end mt-3 mb-3 mr-2">
            <a href="{{ route('result.export', request()->query()) }}" class="btn btn-danger btn-width mr-2">
                <i class="fas fa-download"></i> Export
            </a>
            <a href="{{ route('result.exportPdf', request()->query()) }}"
                class="btn btn-primary btn-width mr-2">
                <i class="fas fa-print"></i> Print
            </a>
        </div> --}}


        {{--        Start action btn export and print        --}}

    </div>
</body>

</html>
