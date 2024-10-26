@extends('layouts.master')

@section('result')
    <div class="row mt-4 mr-4 ml-2">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <a class="btn btn-danger" href="{{ url('/') }}"> <i class="fas fa-arrow-left"></i>
                    ត្រឡប់ក្រោយ</a>
            </div>
        </div>
    </div>
    <div class="border-wrapper mt-4 mr-4 ml-4">
        <div class="container-fluid">

            {{--                    Start Form Search                      --}}
            <form id="filterForm" class="max-w-md mx-auto mt-3" method="GET" action="{{ route('result.index') }}"
                onsubmit="return validateDateField()">
                <div class="row mb-3">

                    {{-- Filter Code --}}
                    {{-- <div class="col-md-3">
                        <input type="text" name="code_id" value="{{ request('code_id') }}" class="form-control mb-2"
                            placeholder="ជំពូក">
                    </div> --}}

                    {{-- Filter Account --}}
                    {{-- <div class="col-md-3">
                        <input type="text" name="account_key_id" value="{{ request('account_key_id') }}"
                            class="form-control mb-2" placeholder="គណនី">
                    </div> --}}

                    {{-- Filter Sub-Account --}}
                    <div class="col-md-2">
                        <input type="text" name="sub_account_key_id" value="{{ request('sub_account_key_id') }}"
                            class="form-control mb-2" placeholder="អនុគណនី" style="width: 60; height: 60px;">
                    </div>

                    {{-- Filter Report --}}
                    <div class="col-md-2">
                        <input type="text" name="report_key" value="{{ request('report_key') }}"
                            class="form-control mb-2" placeholder="កូដកម្មវិធី" style="width: 60; height: 60px;">
                    </div>

                    {{-- Filter Date --}}
                    <div class="col-md-3">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_date">ថ្ងៃចាប់ផ្ដើម</label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}"
                                    class="form-control mb-2" placeholder="Start Date (YYYY-MM-DD)">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date">ថ្ងៃបញ្ចប់</label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}"
                                    class="form-control mb-2" placeholder="End Date (YYYY-MM-DD)">
                            </div>
                        </div>
                    </div>

                    {{--        Start btn search and reset       --}}
                    <div class="col-md-12">
                        <div class="input-group my-3">
                            <button type="submit" class="btn btn-primary mr-2" style="width: 150px; height: 40px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 50 50">
                                    <path
                                        d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z">
                                    </path>
                                </svg>
                                ស្វែងរក
                            </button>
                            <button type="button" id="resetBtn" class="btn btn-danger"
                                style="width: 150px; height: 40px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-x-circle" viewBox="0 0 16 16">
                                    <path
                                        d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm3.646 4.646a.5.5 0 0 1 0 .708L8.707 8l2.939 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.939a.5.5 0 1 1-.708-.708L7.293 8 4.354 5.354a.5.5 0 1 1 .708-.708L8 7.293l2.646-2.647a.5.5 0 0 1 .707 0z" />
                                </svg>
                                កំណត់ឡើងវិញ
                            </button>

                        </div>
                    </div>
                    {{--        End btn search and reset       --}}
                </div>
            </form>
            {{--                    End Form Search                      --}}


            <div class="border-wrapper">
                <div class="result-total-table-container mt-4">

                    <div class="first-header text-center">
                        <h2>ព្រះរាជាណាចក្រកម្ពុជា</h2>
                        <h3>ជាតិ សាសនា ព្រះមហាក្សត្រ</h3>
                        <h3>3</h3>
                    </div>
                    <h3>ក្រសួងការងារ​ នឹងបណ្ដុះបណ្ដាលវិជ្ជាជីវៈ</h3>
                    <h3>នាយកដ្ខានរដ្ខាបាល និងហិរញ្ញវត្ថុ</h3>
                    <h3>នាយកដ្ខានហិរញ្ញវត្ថុ និងទ្រព្យសម្បត្តិរដ្ឋ</h3>
                    <h3>ការិយាល័យហិរញ្ញវត្ថុ</h3>


                    <div class="second-header text-center">
                        <h3>របាយការណ៍ធានាចំណាយថវិកាក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h3>
                       
                        <h4>
                            ប្រចាំ
                            @if (request('start_date') && request('end_date'))
                                <?php
                                // Use Carbon to parse the dates
                                $startDate = \Carbon\Carbon::parse(request('start_date'));
                                $endDate = \Carbon\Carbon::parse(request('end_date'));
                                ?>
                                <span>
                                    {{ convertToKhmerNumber($startDate->day) }} {{ getKhmerMonth($startDate->month) }}
                                    {{ convertToKhmerNumber($startDate->year) }}
                                    ដល់
                                    {{ convertToKhmerNumber($endDate->day) }} {{ getKhmerMonth($endDate->month) }}
                                    {{ convertToKhmerNumber($endDate->year) }}
                                </span>
                            @else
                                <?php
                                // Get current month and year
                                $currentMonth = date('n'); // Numeric representation of current month (1-12)
                                $currentYear = date('Y'); // Current year
                                ?>
                                <span>ខែ {{ getKhmerMonth($currentMonth) }}
                                    ឆ្នាំ{{ convertToKhmerNumber($currentYear) }}</span> {{-- Default text for current month dynamically --}}
                            @endif
                        </h4>




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
                                        <td colspan="1" style="text-align: start; width: 350px;">
                                            {{ $totalsByCode['name'] }}</td>
                                        <td>{{ number_format($totalsByCode['fin_law'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsByCode['current_loan'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsByCode['internal_increase'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsByCode['unexpected_increase'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsByCode['additional_increase'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsByCode['total_increase'], 0, ' ', ' ') }}</td>

                                        <td style="color: {{ $totalsByCode['decrease'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsByCode['decrease'], 0, ' ', ' ') }}
                                        </td>
                                        <td style="color: {{ $totalsByCode['editorial'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsByCode['editorial'], 0, ' ', ' ') }}
                                        </td>
                                        <td
                                            style="color: {{ $totalsByCode['new_credit_status'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsByCode['new_credit_status'], 0, ' ', ' ') }}
                                        </td>
                                        <td style="color: {{ $totalsByCode['early_balance'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsByCode['early_balance'], 0, ' ', ' ') }}
                                        </td>
                                        <td style="color: {{ $totalsByCode['apply'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}
                                        </td>
                                        <td style="color: {{ $totalsByCode['deadline_balance'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsByCode['deadline_balance'], 0, ' ', ' ') }}
                                        </td>
                                        <td style="color: {{ $totalsByCode['credit'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsByCode['credit'], 0, ' ', ' ') }}
                                        </td>
                                        <td style="color: {{ $totalsByCode['law_average'] < 0 ? 'red' : 'black' }};">
                                            {{ number_format($totalsByCode['law_average'], 2, '.', ' ') }} %</td>
                                        <td style="color: {{ $totalsByCode['law_correction'] < 0 ? 'red' : 'black' }};">
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
                                            <td
                                                style="color: {{ $totalsByAccountKey['decrease'] < 0 ? 'red' : 'black' }};">
                                                {{ number_format($totalsByAccountKey['decrease'], 0, ' ', ' ') }}
                                            </td>
                                            <td
                                                style="color: {{ $totalsByAccountKey['editorial'] < 0 ? 'red' : 'black' }};">
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
                                            <td
                                                style="color: {{ $totalsByAccountKey['law_average'] < 0 ? 'red' : 'black' }};">
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
                                <tr>
                                    <td colspan="5" style="border: 1px solid black; text-align: center;">
                                        <strong>សរុប</strong>: ការរាយការណ៍
                                    </td>
                                    <td colspan="1" style="color: {{ $totals['fin_law'] < 0 ? 'red' : 'black' }};">
                                        {{ number_format($totals['fin_law'], 0, ' ', ' ') }}</td>
                                    <td colspan="1"
                                        style="color: {{ $totals['current_loan'] < 0 ? 'red' : 'black' }};">
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
                                    <td colspan="1"
                                        style="color: {{ $totals['total_increase'] < 0 ? 'red' : 'black' }};">
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
                                    <td colspan="1"
                                        style="color: {{ $totals['early_balance'] < 0 ? 'red' : 'black' }};">
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

                                </tr>
                                {{-- End import data --}}
                            </tbody>
                        </table>
                        {{--            Table           --}}

                    </div>
                </div>

                {{--        Start action btn export and print        --}}
                <div class="d-flex justify-content-end mt-3 mb-3 mr-2">
                    <a href="{{ route('result.export', request()->query()) }}" class="btn btn-danger btn-width mr-2">
                        <i class="fas fa-download"></i> Export
                    </a>
                    <a href="{{ route('result.exportPdf', request()->query()) }}"
                        class="btn btn-primary btn-width mr-2">
                        <i class="fas fa-print"></i> Print
                    </a>
                </div>


                {{--        Start action btn export and print        --}}

            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .border-wrapper {
            border: 2px solid black;

        }

        .result-total-table-container {
            padding: 16px;

        }

        .container-fluid {
            padding: 16px;
            /* max-height: 100vh; */
        }

        .table-container {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .btn,
        .form-control,
        label,
        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 16px;
        }


        h2 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 24px;
        }

        h3,
        h4 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 20px;
        }

        .btn-width {
            width: 120px;
        }

        .filterable {
            cursor: pointer;
            background-color: #f0f0f0;
        }

        .hidden-row {
            display: none;
        }
    </style>
@endsection

@section('scripts')
    {{--            Start action for filter search                --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let typingTimer; // Timer identifier
            const doneTypingInterval = 5000; // Time in ms (0.5 seconds)

            document.querySelectorAll('#filterForm input').forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(typingTimer); // Clear the previous timer
                    typingTimer = setTimeout(() => {
                        document.getElementById('filterForm')
                            .submit(); // Submit the form after the delay
                    }, doneTypingInterval);
                });

                input.addEventListener('keydown', function() {
                    clearTimeout(typingTimer); // Prevent form submission if user is still typing
                });
            });
        });
    </script>
    {{--            End action for filter search                --}}

    {{--            Start action for btn reset                --}}
    <script>
        document.getElementById('resetBtn').addEventListener('click', function() {
            // Clear all input fields
            document.querySelectorAll('#filterForm input').forEach(input => input.value = '');

            // Reload the page without query parameters
            window.location.href = "{{ route('result.index') }}";
        });
    </script>
    {{--            End action for btn reset                --}}

    <script>
        function validateDateField() {
            const dateField = document.getElementById('dateField').value;
            const codeId = document.querySelector('input[name="code_id"]').value;
            const accountKeyId = document.querySelector('input[name="account_key_id"]').value;
            const subAccountKeyId = document.querySelector('input[name="sub_account_key_id"]').value;
            const reportKey = document.querySelector('input[name="report_key"]').value;

            // If any of the fields are filled and date is empty, prevent form submission
            if ((codeId || accountKeyId || subAccountKeyId || reportKey) && !dateField) {
                alert('Please provide a date when applying any of the filters.');
                return false;
            }

            return true;
        }

        function resetForm() {
            document.getElementById('filterForm').reset();
        }
    </script>
@endsection
