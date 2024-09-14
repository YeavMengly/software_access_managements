<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Report</title>

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
    </style>

    <style type="text/css">
        .khmer {
            font-family: 'Khmer', cursive;
        }
    </style>
</head>

<body>
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <h3>របាយការណ៍ធានាចំណាយថវិកាក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h3>
            <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5>
            <div class="table-container">
                <table id="reportTable" class="table-border">
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
                        @php
                            $previousKeyCode = $previousAccountKeyCode = $previousSubAccountKeyCode = $previousReportKeyCode = null;
                        @endphp
                        @foreach ($reports as $report)
                            @php
                                $currentKeyCode = $report->subAccountKey->accountKey->key->code;
                                $currentAccountKeyCode = $report->subAccountKey->accountKey->account_key;
                                $currentSubAccountKeyCode = $report->subAccountKey->sub_account_key;
                                $currentReportKey = $report->report_key;
                            @endphp
                            <tr>
                                {{-- <td class="filterable" data-filter="6001">{{ $loop->iteration }}</td> --}}
                                <td class="filterable"
                                    data-filter="{{ $report->subAccountKey->accountKey->key->code }}">
                                    {{ $report->subAccountKey->accountKey->key->code }}
                                </td>
                                <td class="filterable"
                                    data-filter="{{ $report->subAccountKey->accountKey->account_key }}">
                                    {{ $report->subAccountKey->accountKey->account_key }}
                                </td>
                                <td class="filterable" data-filter="{{ $report->subAccountKey->sub_account_key }}">
                                    {{ $report->subAccountKey->sub_account_key }}
                                </td>
                                <td class="filterable" data-filter="{{ $report->report_key }}">
                                    {{ $report->report_key }}
                                </td>
                                <td
                                    style="border: 1px solid black; max-width: 200px; text-align: center; overflow-y: auto; white-space: nowrap;">
                                    {{ $report->name_report_key }}
                                </td>
                                <td>{{ number_format($report->fin_law, 0, ' ', ' ') }}</td>
                                <td>{{ number_format($report->current_loan, 0, ' ', ' ') }}</td>
                                <td>{{ number_format($report->internal_increase, 0, ' ', ' ') }}</td>
                                <td>{{ number_format($report->unexpected_increase, 0, ' ', ' ') }}</td>
                                <td>{{ number_format($report->additional_increase, 0, ' ', ' ') }}</td>
                                <td>{{ number_format($report->total_increase, 0, ' ', ' ') }}</td>
                                <td>{{ number_format($report->decrease, 0, ' ', ' ') }}</td>
                                <td>{{ number_format($report->editorial, 0, ' ', ' ') }}</td>
                                <td>{{ number_format($report->new_credit_status, 0, ' ', ' ') }}</td>
                                <td>{{ number_format($report->early_balance, 0, ' ', ' ') }}</td>
                                <td>{{ number_format($report->apply, 0, ' ', ' ') }}</td>
                                <td>{{ number_format($report->deadline_balance, 0, ' ', ' ') }}</td>
                                <td>{{ number_format($report->credit, 0, ' ', ' ') }}</td>
                                <td style="border: 1px solid black; text-align: center">
                                    {{ ($report->early_balance + $report->apply) / $report->fin_law }}%</td>
                                <td style="border: 1px solid black; text-align: center">
                                    {{ $report->law_correction }}%
                                </td>
                            </tr>
                            @php
                                $previousKeyCode = $currentKeyCode;
                                $previousAccountKeyCode = $currentAccountKeyCode;
                                $previousSubAccountKeyCode = $currentSubAccountKeyCode;
                                $previousReportKeyCode = $currentReportKey;
                            @endphp
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</body>

</html>
