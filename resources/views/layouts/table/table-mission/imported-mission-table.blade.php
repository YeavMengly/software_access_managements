@extends('layouts.master')

@section('content-table-mission-cambodia')
    <div class="row">
        <div class="col-lg-6 margin-tb mb-4 mt-4">
            <div class="d-flex justify-content-between align-items-center"
                style="font-family: 'Khmer OS Siemreap', sans-serif;">
                <a class="btn btn-danger" href="{{ route('reports-missions.index') }}"><i class="fas fa-arrow-left"></i>
                    ត្រឡប់ក្រោយ</a>
            </div>
        </div>
    </div>
    <div class="border-wrapper mt-3">
        <div class="table-container">
            <h2 class="text-2xl font-bold mb-5">តារាងទូទាត់ប្រាក់បេសកកម្ម</h2>

            <table class="table-border ">
                <thead>
                    <tr>
                        <th style="border: 2px solid black;" class="px-4 py-2 border-b">ល.រ</th>
                        <th style="border: 2px solid black;" class="px-4 py-2 border-b">អត្តលេខ</th>
                        <th style="border: 2px solid black;" class="px-4 py-2 border-b">ឈ្មោះ-ខ្មែរ</th>
                        <th style="border: 2px solid black;" class="px-4 py-2 border-b">ឈ្មោះ-ឡាតាំង</th>
                        <th style="border: 2px solid black;" class="px-4 py-2 border-b">លេខគណនី</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($importedData->count() > 0)
                        @foreach ($importedData as $data)
                            <tr class="hover:bg-gray-100">
                                <td style="border: 2px solid black;" class="border-b px-4 py-2 text-center">
                                    {{ $loop->iteration }}</td>
                                <td style="border: 2px solid black;" class="border-b px-4 py-2">{{ $data->id_number }}</td>
                                <td style="border: 2px solid black;" class="border-b px-4 py-2">{{ $data->name_khmer }}</td>
                                <td style="border: 2px solid black;" class="border-b px-4 py-2">{{ $data->name_latin }}</td>
                                <td style="border: 2px solid black;" class="border-b px-4 py-2">{{ $data->account_number }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center py-4">No data imported</td>
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
            border: 2px solid black;
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

        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }
    </style>
@endsection
