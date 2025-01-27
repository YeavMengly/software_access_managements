@extends('layouts.master')

@section('content-table-mission-cambodia')
    <div class="row">
        <div class="col-lg-6 margin-tb mb-4 ml-3">
            <div class="d-flex justify-content-between align-items-center"
                style="font-family: 'Khmer OS Siemreap', sans-serif;">
                <a class="btn btn-danger" style="width: 120px; height: 40px;" href="{{ route('reports-missions.index') }}"><i
                        class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="border-wrapper mt-3 ml-3">
        <div class="table-container">
            <h2 class="text-2xl text-center font-bold mb-4 mt-2">តារាងទូទាត់ប្រាក់បេសកកម្ម</h2>

            <table class="table-border ">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">ល.រ</th>
                        <th class="px-4 py-2 border-b">អត្តលេខ</th>
                        <th class="px-4 py-2 border-b">ឈ្មោះ-ខ្មែរ</th>
                        <th class="px-4 py-2 border-b">ឈ្មោះ-ឡាតាំង</th>
                        <th class="px-4 py-2 border-b">លេខគណនី</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($importedData->count() > 0)
                        @foreach ($importedData as $data)
                            <tr class="hover:bg-gray-100">
                                <td style="border: 1px solid black;" class="border-b px-4 py-2 text-center">
                                    {{ $loop->iteration }}</td>
                                <td class="border-b px-4 py-2">{{ $data->id_number }}</td>
                                <td class="border-b px-4 py-2">{{ $data->name_khmer }}</td>
                                <td class="border-b px-4 py-2">{{ $data->name_latin }}</td>
                                <td class="border-b px-4 py-2">{{ $data->account_number }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center py-2">គ្មានទិន្នន័យទាញយក</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('styles')
    <style>
        .border-wrapper {
            border: 1px solid black;
            padding: 10px;
        }

        .result-total-table-container {
            max-height: 200vh;
            overflow-y: auto;
        }

        .table-container {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        h2 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
        }

        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }
    </style>
@endsection
