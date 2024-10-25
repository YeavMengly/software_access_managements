@extends('layouts.master')

@section('content-table-mission-cambodia')
    <div class="row">
        <div class="col-lg-6 margin-tb mb-4 mt-4">
            <div class="d-flex justify-content-between align-items-center"
                style="font-family: 'Khmer OS Siemreap', sans-serif;">
                <a class="btn btn-danger" href="{{ route('mission-cam.index') }}"><i class="fas fa-arrow-left"></i>
                    ត្រឡប់ក្រោយ</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex align-items-center justify-content-end py-3">
                <a class="btn btn-success" href="{{ route('reports-missions.create') }}"
                    style="font-family: 'Khmer OS Siemreap', sans-serif;">បញ្ចូលទិន្នន័យ</a>
            </div>
        </div>
    </div>
    <div class="row-1">
        <!-- New Officer List Button -->
        <a style="font-family: 'Khmer OS Siemreap', sans-serif;" class="btn btn-success"
            href="{{ route('imported-mission-table') }}"><i class="fas fa-list"></i>
            បញ្ជីឈ្មោះមន្រ្តី</a>

        <!-- Button to Open the Modal -->
        <button style="font-family: 'Khmer OS Siemreap', sans-serif;" type="button" class="btn btn-primary"
            data-bs-toggle="modal" data-bs-target="#uploadModal">
            Upload File
        </button>

        <!-- Modal -->
        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-custom">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Upload File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form style="width: 500px;" method="POST" action="{{ route('report-table.import') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="file" class="form-label text-lg font-semibold text-gray-700">Select
                                    File</label>
                                <input type="file"
                                    class="form-control block mx-auto w-100 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-indigo-300"
                                    name="file" id="file" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit"
                                    class="btn btn-primary w-full py-2 text-white bg-indigo-600 hover:bg-indigo-700 font-semibold text-lg rounded-lg transition duration-300">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- <form style="width: 500px;" method="POST" action="{{ route('report-table.import') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
                <label for="button" class="mt-3 form-label text-lg font-semibold text-gray-700">Upload File</label>
                <input type="file"
                    class="form-control block w-full px-4 py-3 mt-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-indigo-300"
                    name="file" id="file" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit"
                    class="btn btn-primary w-full py-2 text-white bg-indigo-600 hover:bg-indigo-700 font-semibold text-lg rounded-lg transition duration-300">Import</button>
            </div>
        </form> --}}

    </div>
    <div class="border-wrapper mt-3">
        <div class="result-total-table-container">
            <div class="first-header">
                <h4>ព្រះរាជាណាចក្រកម្ពុជា</h4>
                <h3>ជាតិ សាសនា ព្រះមហាក្សត្រ</h3>
            </div>
            <div class="second-header">
                <h4>ក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h4>
                <h4>អគ្គនាយកដ្ឋានរដ្ឋបាល និងហិរញ្ញវត្ថុ</h4>
                <h4>នាយកដ្ឋានហិរញ្ញវត្ថុ និងទ្រព្យសម្បត្តិរដ្ឋ</h4>
                <h4>ការិយាល័យហិរញ្ញវត្ថុ</h4>
            </div>
            <div class="third-header">
                <h4>តារាងទូទាត់ប្រាក់បេសកកម្មក្នុងប្រទេសចាប់ពីថ្ងៃទី៨-២៨ ខែមីនា ឆ្នាំ២០២៤</h4>
                <h4>នៃក្រសួងការងារ និងបណ្ដុះបណ្ដាលវិជ្ជាជីវៈ ត្រូវផ្ទេរទៅធនាគារកាណាឌីយ៉ា ក.អ</h4>
            </div>

            <div class="table-container">
                <table class="table-border">
                    <thead>
                        <tr style="align-items: center; font-family: 'Khmer OS Muol Light', sans-serif;">
                            <th rowspan="2" style="border: 2px solid black;">
                                ល.រ</th>
                            <th rowspan="2" style="border: 2px solid black;">
                                អត្តលេខ</th>
                            <th rowspan="2" style="border: 2px solid black;">
                                ឈ្មោះ-ខ្មែរ</th>
                            <th rowspan="2" style="border: 2px solid black;">
                                ឈ្មោះ-ឡាតាំង</th>
                            <th rowspan="2" style="border: 2px solid black;">
                                លេខគណនី</th>
                            <th rowspan="2" style="border: 2px solid black;">
                                ទឹកប្រាក់សរុប</th>
                            <th rowspan="2" style="border: 2px solid black;">
                                ផ្សេងៗ</th>
                        </tr>
                    </thead>
                    <tbody id="table-body" style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif;">
                        @foreach ($data as $index => $mission)
                            <tr>
                                <td style="border: 2px solid black;">{{ $index + 1 }}</td>
                                <td style="border: 2px solid black;">{{ $mission['id_number'] }}</td>
                                <td style="border: 2px solid black;">{{ $mission['name_khmer'] }}</td>
                                <td style="border: 2px solid black;">{{ $mission['name_latin'] }}</td>
                                <td style="border: 2px solid black;">{{ $mission['account_number'] }}</td>
                                <td style="border: 2px solid black;">{{ number_format($mission['total_amount'], 2) }}</td>
                                <td style="border: 2px solid black;"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

        h3 {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 25px;
        }

        h4 {
            font-family: 'Khmer OS Muol Light', sans-serif;
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

        .first-header {
            text-align: center;
            margin-bottom: 70px;
        }

        .third-header {
            text-align: center;
            padding: 10px;
        }

        .large-checkbox {
            transform: scale(2);
            margin: 7px;
        }

        .modal-custom {
            max-width: 530px;
        }
    </style>
@endsection
