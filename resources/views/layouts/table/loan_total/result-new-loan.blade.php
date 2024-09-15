@extends('layouts.master')

@section('result-new-loan')
    <div class="d-flex justify-content-between align-items-center mt-4 mr-4 ml-4">
        <a class="btn btn-danger" href="{{ route('total_card') }}">
            <i class="fas fa-arrow-left"></i> ត្រឡប់ក្រោយ
        </a>
    </div>

    <div class="d-flex justify-content-center align-items-center mt-4 mr-4 ml-4">
        <h2 style="font-weight: 700;">ផែនការថវិការដ្ឋ</h2>
    </div>

    <div class="border-wrapper mt-4 mr-4 ml-4">
        <div class="result-total-table-container">
            <h3>របាយការណ៍សរុបឥណនទាន</h3>
            <div class="table-container">
                <table class="table-border">
                    <thead class="header-border">
                        <tr>
                            <th rowspan="2">កម្មវិធី</th>
                            <!-- Use Blade logic to display unique code -->
                            @php
                                $displayedCodes = [];
                            @endphp
                            @foreach ($reports as $report)
                                @php
                                    $code = $report->subAccountKey->accountKey->key->code;
                                    if (!in_array($code, $displayedCodes)) {
                                        $displayedCodes[] = $code;
                                @endphp
                                    <th rowspan="2">ជំពូក​ {{ $code }}</th>
                                @php
                                    }
                                @endphp
                            @endforeach
                        </tr>

                        <tr>
                            <!-- Additional headers if needed -->
                        </tr>
                    </thead>
                   
                        
                    <tbody class="cell-border">
                        <!-- Add your rows here -->
                        <tr>
                            <td>កម្មវិធីទី១</td>
                            @foreach ($displayedCodes as $code)
                                <td><!-- Data for {{ $code }} --></td>
                            @endforeach
                        </tr>

                        <tr>
                            <td>កម្មវិធីទី២</td>
                            @foreach ($displayedCodes as $code)
                                <td><!-- Data for {{ $code }} --></td>
                            @endforeach
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('result.export') }}" class="btn btn-danger btn-width mr-2">Export</a>
            <button type="button" class="btn btn-primary btn-width">Print</button>
        </div>
    </div>

    {{-- import file into --}}
    @include('layouts.table.loan_total.result-sum-refer')
    @include('layouts.table.loan_total.result-remain')
@endsection

@section('styles')
    <style>
        .border-wrapper {
            border: 2px solid black;
            padding: 10px;
        }

        .result-total-table-container {
            max-height: 600px;
            overflow-y: auto;
        }

        .table-container {
            width: 100%;
        }

        th, .btn,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
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
            font-family: 'OS Moul', sans-serif;
        }
    </style>
@endsection
