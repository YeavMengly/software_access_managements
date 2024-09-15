{{-- @extends('layouts.master')

@section('result-sum-refer') --}}
<div class="border-wrapper mt-4 mr-4 ml-4">
    <div class="result-total-table-container">

    <h3>របាយការណ៍សរុបបូកយោង</h3>
    {{-- <h5>ប្រចាំខែមិថុនា ឆ្នាំ២០២៤</h5> --}}
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
{{-- @endsection --}}


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
        }

        th, .btn,
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
