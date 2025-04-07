@extends('layouts.master')

@section('result-total-fmc-table')
    <div class="d-flex justify-content-between align-items-center mr-4 ml-4">
        <a class="btn btn-danger" href="{{ route('total_card') }}">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>
    <div class="first-header text-center">
        <h3>តារាង​ច្បាប់ អាណត្តិ និងសលាកបត្រ</h3>
        <h5></h5>
    </div>
    <div class="table-container mt-4 pr-4 pl-4 mb-4">
        <table class="table-border">
            <thead class="header-border">
                <tr>
                    <th style="text-align: center; width: 120px;">អនុគណនី</th>
                    <th style="text-align: center; width: 120px;">កម្មវិធី</th>
                    <th>ច្បាប់ហិ.វ</th>
                    <th>ឥណទានថ្មី</th>
                    <th>សលាកបត្រ​</th>
                    <th>អាណត្តិ</th>
                </tr>
            </thead>
            <tbody class="cell-border">

                @foreach ($mergedReports as $report)
                    <tr>
                        <td>{{ $report->sub_account_key }}</td>
                        <td>{{ $report->report_key }}</td>
                        <td>{{ $report->fin_law }}</td>
                        <td>{{ $report->new_credit_status }}</td>
                        <td>{{ $report->value_certificate }}</td>
                        <td>{{ $report->value_mandate }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('styles')
    <style>
        .border-wrapper {
            padding-left: 16px;
            padding-right: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .form-control,
        label,
        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 6px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
        }

        .btn {
            border-radius: 4px;
            width: 120px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h2 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
        }

        h3 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
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
