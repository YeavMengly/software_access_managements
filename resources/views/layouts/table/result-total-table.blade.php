@extends('layouts.master')

@section('content')
    <div class="result-total-table-container">
        @yield('result-total-table')
    </div>
@endsection

@section('result-total-table')
    <div class="d-flex justify-content-between align-items-center  mt-4 mr-4 ml-4">
        <a class="btn btn-danger" href="{{ route('back') }}"
            style="width: 160px; height: 50px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-arrow-left"></i>&nbsp;&nbsp;
        </a>
    </div>
    <div class="border-wrapper mt-4 mr-4 ml-4">
        <div class="result-total-table-container">

            <h3>របាយការណ៍ធានាចំណាយថវិកាក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h3>
            <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5>
            <div class="table-container">

                {{--            Table           --}}
                <table class="table-border">
                    <thead class="header-border">
                        <tr>
                            <th rowspan="3">ល.រ</th>
                            <th rowspan="3">ជំពូក</th>
                            <th rowspan="3">គណនី</th>
                            <th rowspan="3">អនុគណនី</th>
                            <th rowspan="3">ក.កម្មវិធី</th>
                            <th rowspan="3">ចំណាត់ថ្នាក់</th>
                            <th rowspan="3">ច្បាប់ហិ.វ</th>
                            <th rowspan="3">ឥណទានបច្ចុប្បន្ន</th>
                            <th colspan="5">ចលនាឥណទាន</th>
                            {{-- <th rowspan="3">វិចារណកម្ម</th> --}}
                            <th rowspan="3">ស្ថានភាពឥណទានថ្មី</th>
                            <th rowspan="3">សមតុល្យដើមគ្រា</th>
                            <th rowspan="3">អនុវត្ត</th>
                            <th rowspan="3">សមតុល្យចុងគ្រា</th>
                            <th rowspan="3">ឥណទាននៅសល់</th>
                            <th colspan="2" rowspan="2">%ប្រៀបធៀប</th>
                        </tr>
                        <tr>
                            <th colspan="4">កើន</th>
                            <th rowspan="2">ថយ</th>
                        </tr>
                        <tr>
                            <th>កើនផ្ទៃក្នុង</th>
                            <th>មិនបានគ្រោងទុក</th>
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

                        {{-- start import data --}}
                        @foreach ($reports as $index => $report)
                            @php
                                $currentKeyCode = $report->subAccountKey->accountKey->key->code;
                                $currentAccountKeyCode = $report->subAccountKey->accountKey->account_key;
                                $currentSubAccountKeyCode = $report->subAccountKey->sub_account_key;
                                $currentReportKey = $report->report_key;

                            @endphp

                            <tr>
                                {{-- column Index --}}
                                <td style="border: 1px solid black; text-align: center">
                                    {{-- @if ($index == ($currentKeyCode === $report->subAccountKey->accountKey->key->code))
                            @else
                              
                            @endif --}}
                                    {{ $index + 1 }}
                                </td>
                                {{-- column Index --}}

                                {{-- column keyCode --}}
                                <td style="border: 1px solid black; text-align: center">
                                    {{-- @if ($currentKeyCode === $previousKeyCode)
                                <!-- Do not display if the key code is the same as the previous row -->
                                @if ($currentKeyCode !== $previousKeyCode)
                                    {{ $currentKeyCode }}
                                @endif
                            @else
                                {{ $currentKeyCode }}
                            @endif --}}
                                    {{ $currentKeyCode }}
                                </td>
                                {{-- column keyCode --}}

                                {{-- column accountKeyCode --}}
                                <td style="border: 1px solid black; text-align: center">
                                    {{-- {{ $report->subAccountKey->accountKey->account_key }} --}}

                                    {{-- @if ($currentAccountKeyCode === $previousAccountKeyCode || $currentKeyCode === $previousKeyCode)
                                <!-- Do not display if the key code is the same as the previous row -->
                                @if ($currentAccountKeyCode !== $previousAccountKeyCode || $currentKeyCode === $previousKeyCode)
                                    {{ $currentAccountKeyCode }}
                                    @if ($currentAccountKeyCode !== $previousAccountKeyCode || $currentKeyCode !== $previousKeyCode)
                                        {{ $currentAccountKeyCode }}
                                    @endif
                                @endif
                            @else
                                {{ $currentAccountKeyCode }}
                            @endif --}}
                                    {{ $currentAccountKeyCode }}
                                </td>
                                {{-- column accountKeyCode --}}

                                {{-- column subAccountKey --}}
                                <td style="border: 1px solid black; text-align: center">
                                    {{-- @if ($currentSubAccountKeyCode !== $previousSubAccountKeyCode || $currentAccountKeyCode !== $previousAccountKeyCode)
                                <!-- Do not display if the key code is the same as the previous row -->
                            @else
                                {{ $currentSubAccountKeyCode }}
                            @endif --}}
                                    {{ $currentSubAccountKeyCode }}
                                </td>
                                {{-- column subAccountKey --}}

                                <td style="border: 1px solid black; text-align: center">

                                    {{-- @if ($currentReportKey !== $previousReportKeyCode || $currentSubAccountKeyCode !== $previousSubAccountKeyCode || $currentSubAccountKeyCode === $previousSubAccountKeyCode)
                                <!-- Do not display if the key code is the same as the previous row -->
                                {{ $report->report_key }}
                            @else
                                {{ $currentReportKey }}
                            @endif --}}
                                    {{ $currentReportKey }}


                                </td>
                                <td
                                    style="border: 1px solid black; max-width: 200px; text-align: center; overflow-y: auto; white-space: nowrap;">
                                    {{ $report->name_report_key }}
                                </td>
                                <td
                                    style="border: 1px solid black; max-width: 120px; text-align: center; overflow-y: auto; white-space: normal;">
                                    {{ number_format($report->fin_law, 0, ' ', ' ') }}
                                </td>
                                <td
                                    style="border: 1px solid black; max-width: 120px; text-align: center; overflow-y: auto; white-space: normal;">
                                    {{ number_format($report->current_loan, 0, ' ', ' ') }}
                                </td>
                                <td
                                    style="border: 1px solid black; max-width: 120px; text-align: center; overflow-y: auto; white-space: normal;">
                                    {{ number_format($report->internal_increase, 0, ' ', ' ') }}
                                </td>
                                <td
                                    style="border: 1px solid black; max-width: 120px; text-align: center; overflow-y: auto; white-space: normal;">
                                    {{ number_format($report->unexpected_increase, 0, ' ', ' ') }}
                                </td>
                                <td
                                    style="border: 1px solid black; max-width: 120px; text-align: center; overflow-y: auto; white-space: normal;">
                                    {{ number_format($report->additional_increase, 0, ' ', ' ') }}
                                </td>
                                <td style="border: 1px solid black; max-width: 160px; text-align: center;">
                                    {{ number_format($report->total_increase, 0, ' ', ' ') }}
                                </td>
                                <td style="border: 1px solid black; text-align: center">
                                    {{ number_format($report->decrease, 0, ' ', ' ') }}
                                </td>
                                {{-- <td style="border: 1px solid black; text-align: center;">
                                    {{ $report->editorial }}
                                </td> --}}
                                <td style="border: 1px solid black; text-align: center;">
                                    {{ number_format($report->new_credit_status, 0, ' ', ' ') }}
                                </td>
                                <td style="border: 1px solid black; text-align: center">
                                    {{ number_format($report->early_balance, 0, ' ', ' ') }}</td>
                                <td style="border: 1px solid black; text-align: center">
                                    {{ number_format($report->apply, 0, ' ', ' ') }}</td>
                                <td style="border: 1px solid black; text-align: center">
                                    {{ number_format($report->deadline_balance, 0, ' ', ' ') }}
                                </td>
                                <td style="border: 1px solid black; text-align: center">
                                    {{ number_format($report->credit, 0, ' ', ' ') }} </td>
                                <td style="border: 1px solid black; text-align: center">
                                    {{ $report->law_average }}%
                                </td>
                                <td style="border: 1px solid black; text-align: center">
                                    {{ $report->law_correction }}%
                                </td>
                            </tr>
                            @php
                                $previousKeyCode = $currentKeyCode;
                                $previousAccountKeyCode = $currentAccountKeyCode;
                                $previousSubAccountKeyCode = $currentSubAccountKeyCode;
                            @endphp
                        @endforeach

                        {{-- End import data --}}

                        <!-- Total Row -->
                        <tr>
                            <td colspan="6" style="border: 1px solid black; text-align: center;"><strong>សរុប</strong>
                            </td>
                            <td style="border: 1px solid black; text-align: center"></td>
                            <td style="border: 1px solid black; text-align: center"></td>
                            <td style="border: 1px solid black; max-width: 160px; text-align: center;">
                                {{ $totals['internal_increase'] }}</td>
                            <td style="border: 1px solid black; max-width: 160px; text-align: center;">
                                {{ $totals['unexpected_increase'] }}</td>
                            <td style="border: 1px solid black; max-width: 160px; text-align: center;">
                                {{ $totals['additional_increase'] }}</td>
                            <td style="border: 1px solid black; max-width: 160px; text-align: center;">
                                {{ $totals['internal_increase'] + $totals['unexpected_increase'] + $totals['additional_increase'] }}
                            </td>
                            <td style="border: 1px solid black; text-align: center"> {{ $totals['decrease'] }}</td>
                            <td style="border: 1px solid black; text-align: center;">

                            </td>

                            <td style="border: 1px solid black; max-width: 80px; text-align: center;">
                                {{ $totals['new_credit_status'] }}</td>
                            <td colspan="5" style="border: 1px solid black;">
                                < {{ $totals['new_credit_status'] }}</td>
                                    {{-- <td style="border: 1px solid black; text-align: center"></td> --}}
                        </tr>
                        <!-- End Total Row -->
                    </tbody>
                </table>
                {{--            Table           --}}

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
            font-family: 'Siemreap', sans-serif;
        }

        /* h3, */
        h5 {
            text-align: center;
            font-family: 'OS Moul', sans-serif;
        }

        h3 {
            text-align: center;
            font-family: 'Siemreap', sans-serif;
        }
    </style>
@endsection
