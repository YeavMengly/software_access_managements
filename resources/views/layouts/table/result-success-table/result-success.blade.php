@extends('layouts.master')

@section('result-success')
    <div class="row mt-4 mr-4 ml-2">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <a class="btn btn-danger" href="{{ url('/total_card') }}"> <i class="fas fa-arrow-left"></i>
                    ត្រឡប់ក្រោយ</a>
            </div>
        </div>
    </div>
    <div class="border-wrapper mt-4 mr-4 ml-4">
        <div class="container-fluid">
            <div class="first-header text-center mt-4">
                <h3>របាយការណ៍ធានាចំណាយថវិកាក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h3>
                <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5>
            </div>
            <div class="table-container mt-4 mb-4">
                <table class="table-border">
                    <thead class="header-border">
                        <tr>
                            <th rowspan="2">ជំពូក</th>
                            <th rowspan="2">ច្បាប់ហិរញ្ញវត្ថុ</th>
                            <th rowspan="2">ឥណទានថ្មី</th>
                            <th colspan="6">សុំធានាចំណាយ</th>
                            <th colspan="6">សុំអាណត្តិកិច្ច</th>
                            <th rowspan="2">ប្រៀបធៀប</th>
                        </tr>
                        <tr>
                            <th>ដើមគ្រា</th>
                            <th>អនុវត្ត</th>
                            <th>%ភាគរយ</th>
                            <th>បូកយោង</th>
                            <th>%ភាគរយ</th>
                            <th>នៅសល់</th>

                            <th>ដើមគ្រា</th>
                            <th>អនុវត្ត</th>
                            <th>%ភាគរយ</th>
                            <th>បូកយោង</th>
                            <th>%ភាគរយ</th>
                            <th>នៅសល់</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6 = 5/3</td>
                            <td>7 = 4+5</td>
                            <td>8 = 7/3</td>
                            <td>9 = 3-7</td>
                            <td>10</td>
                            <td>11</td>
                            <td>12 = 11/3</td>
                            <td>13 = 10+11</td>
                            <td>14 = 13/3</td>
                            <td>15 = 3-13</td>
                            <td>16 = 11/5</td>
                        </tr>
                    </thead>
                    <tbody class="cell-border">
                        @foreach ($totals['code'] as $codeId => $totalsByCode)
                        <tr>
                            <td colspan="1">ជំពូក: {{ $codeId }} </td>
                            <td>{{ number_format($totalsByCode['fin_law'], 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalsByCode['current_loan'], 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalsByCode['early_balance'], 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalsByCode['apply'] / $totalsByCode['current_loan'], 2, '.', ' ') }} %</td>
                            <td>{{ number_format($totalsByCode['early_balance'] + $totalsByCode['apply'], 0, ' ', ' ') }}</td>
                            <td>{{ number_format(($totalsByCode['early_balance'] + $totalsByCode['apply']) / $totalsByCode['current_loan'], 2, '.', ' ') }} %</td>
                            <td>{{ number_format($totalsByCode['current_loan'] - ($totalsByCode['early_balance'] + $totalsByCode['apply']), 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalsByCode['early_balance'], 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalsByCode['apply'], 0, ' ', ' ') }}</td>
                            <td>{{ number_format($totalsByCode['apply'] / $totalsByCode['current_loan'], 2, '.', ' ') }} %</td>
                            <td>{{ number_format($totalsByCode['early_balance'] + $totalsByCode['apply'], 0, ' ', ' ') }}</td>
                            <td>{{ number_format(($totalsByCode['early_balance'] + $totalsByCode['apply']) / $totalsByCode['current_loan'], 2, '.', ' ') }} %</td>
                            <td>{{ number_format($totalsByCode['current_loan'] - ($totalsByCode['early_balance'] + $totalsByCode['apply']) / $totalsByCode['current_loan'], 2, '.', ' ') }}</td>
                            <td></td>
                        </tr>
                    

                            {{-- @foreach ($totals['accountKey'][$codeId] as $accountKeyId => $totalsByAccountKey)
                                <tr>
                                    <td colspan="2">{{ $accountKeyId }}</td>
                                    <td>{{ number_format($totalsByAccountKey['fin_law'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['current_loan'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['internal_increase'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['unexpected_increase'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['additional_increase'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['decrease'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['editorial'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['new_credit_status'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['early_balance'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['apply'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['deadline_balance'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['credit'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['law_average'], 0, ' ', ' ') }}</td>
                                    <td>{{ number_format($totalsByAccountKey['law_correction'], 0, ' ', ' ') }}</td>
                                </tr>

                                @foreach ($totals['subAccountKey'][$codeId][$accountKeyId] as $subAccountKeyId => $totalsBySubAccountKey)
                                    <tr>
                                        <td colspan="2">{{ $subAccountKeyId }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['fin_law'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['current_loan'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['internal_increase'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['unexpected_increase'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['additional_increase'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['decrease'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['editorial'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['new_credit_status'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['early_balance'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['apply'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['deadline_balance'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['credit'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['law_average'], 0, ' ', ' ') }}</td>
                                        <td>{{ number_format($totalsBySubAccountKey['law_correction'], 0, ' ', ' ') }}</td>
                                    </tr>
                                @endforeach
                            @endforeach --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
            @include('layouts.table.result-success-table.result-cost-perform')

            @include('layouts.table.result-success-table.result-administrative-plan')

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

        .border-wrapper {
            border: 2px solid black;

        }

        .result-total-table-container {
            padding: 16px;

        }

      
        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 16px;
        }

        .table-container {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, .btn,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }

        h3 {
            text-align: center;
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 25px;
        }

        h5 {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 25px;
        }
    </style>
@endsection
