@extends('layouts.master')

@section('content-electric')
    <div class="border-wrapper">

        @if (isset($connectionError) && $connectionError)
            <div class="alert alert-danger" role="alert">
                <strong>No internet connection:</strong> Please check your network settings and try again.
            </div>
        @else
            <!-- Existing content -->
            <div class="result-total-table-container">
                <div class="row">
                </div>
            </div>
        @endif

        <div class="result-total-table-container">
            <div class="row">
                <div class="col-lg-12 margin-tb">

                    <div class="d-flex justify-content-between align-items-center">
                        <a class="btn btn-danger d-flex justify-content-center align-items-center" href="{{ route('back') }}"
                            style="width: 120px; height: 40px;">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h3 style="font-weight: 500;">បញ្ចូលឥណទានថាមពលអគ្គិសនី</h3>
                        <div class="btn-group">
                            <a href="" data-bs-toggle="modal" data-bs-target="#createResultElectric"
                                class="btn btn-info btn-width d-flex align-items-center justify-content-center"
                                style="text-align: center; color: rgb(245, 245, 245); border-radius: 4px;"
                                data-bs-toggle="tooltip" title="បង្ហាញលទ្ធផលថ្មី">
                                <i class="fas fa-file-alt"></i>
                            </a>
                            &nbsp;
                            <a class="btn btn-secondary d-flex justify-content-center align-items-center" href="#"
                                data-bs-toggle="modal" data-bs-target="#importModal" href=""
                                style="width: 120px; height: 40px; border-radius: 4px;">
                                Import&nbsp;<i class="fas fa-file-import"></i>
                            </a>
                            &nbsp;
                            <a class="btn btn-primary d-flex justify-content-center align-items-center"
                                href="{{ route('electrics.create') }}"
                                style="width: 120px; height: 40px; border-radius: 4px;">
                                បញ្ចូល
                            </a>
                        </div>
                    </div>
                    <div class="modal fade" id="createResultElectric" tabindex="-1" aria-labelledby="importModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content ">
                                <div class="modal-header">

                                    <h3 class="modal-title text-center" id="importModalLabel">
                                        តារាងទូទាត់ថ្លៃប្រើប្រាស់ថាមពលអគ្គិសនីរបស់វិទ្យាស្ថាន​​ និងមជ្ឈមណ្ឌលតាមរាជធានីខេត្ត
                                    </h3>
                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times" style="color: red;"></i>
                                    </button>
                                </div>
                                <div class="modal-body custom-scrollable">
                                    <div class="result-total-table-container">
                                        <div class="table-container">
                                            <table class="table-border ">
                                                <thead>
                                                    <tr>
                                                        <th style="border: 1px solid black; font-size: 14px; width: 120px;">
                                                            ល.រ</th>
                                                        <th style="border: 1px solid black; font-size: 14px; ">
                                                            អង្គភាពប្រើប្រាស់</th>
                                                        <th style="border: 1px solid black; font-size: 14px; width: 120px;">
                                                            លេខទីតាំង</th>
                                                        <th style="border: 1px solid black; font-size: 14px; width: 160px;">
                                                            កាលបរិច្ឆេទ
                                                        </th>
                                                        <th style="border: 1px solid black; font-size: 14px; width: 200px;">
                                                            រយៈពេលប្រើប្រាស់</th>
                                                        <th style="border: 1px solid black; font-size: 14px; width: 160px;">
                                                            ថាមពលគីឡូវ៉ាត់
                                                        </th>
                                                        <th style="border: 1px solid black; font-size: 14px; width: 160px;">
                                                            ថាមពលរ៉េអាក់ទិក
                                                        </th>
                                                        <th style="border: 1px solid black; font-size: 14px; width: 160px;">
                                                            ប្រាក់សរុបជារៀល
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $previousLocation = null;
                                                        $previousUsageUnit = null;
                                                        $previousCreatedYear = null;
                                                        $index = 1; 
                                                        $sortedElectrics = $electrics->sortByDesc(function ($electric) {
                                                            return \Carbon\Carbon::parse($electric->created_at)->format(
                                                                'Y',
                                                            );
                                                        });
                                                    @endphp

                                                    @foreach ($sortedElectrics as $electric)
                                                        @php
                                                            $createdYear = \Carbon\Carbon::parse(
                                                                $electric->created_at,
                                                            )->format('Y'); 
                                                        @endphp

                                                        @if ($createdYear !== $previousCreatedYear)
                                                            <tr>
                                                                <td colspan="8"
                                                                    style="text-align: center; font-weight: bold; background-color: #f2f2f2;">
                                                                    {{ $createdYear }}
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $index = 1;
                                                            @endphp
                                                        @endif

                                                        @if (
                                                            $electric->location_number !== $previousLocation || 
                                                                $electric->usage_unit !== $previousUsageUnit ||
                                                                $createdYear !== $previousCreatedYear)
                                                            <tr>
                                                                <td style="border: 1px solid black; text-align: center"
                                                                    rowspan="{{ $rowspanCounts[$electric->location_number][$electric->usage_unit][$createdYear] ?? 1 }}">
                                                                    {{ $index++ }} 
                                                                </td>
                                                                <td style="border: 1px solid black; text-align: start;"
                                                                    rowspan="{{ $rowspanCounts[$electric->location_number][$electric->usage_unit][$createdYear] ?? 1 }}">
                                                                    {{ $electric->usage_unit }}
                                                                </td>
                                                                <td style="border: 1px solid black; text-align: center;"
                                                                    rowspan="{{ $rowspanCounts[$electric->location_number][$electric->usage_unit][$createdYear] ?? 1 }}">
                                                                    {{ $electric->location_number }}
                                                                </td>
                                                                <td style="border: 1px solid black; text-align: center;">
                                                                    {{ \Carbon\Carbon::parse($electric->usage_date)->format('d-m-Y') }}
                                                                </td>
                                                                <td
                                                                    style="border: 1px solid black; text-align: right; padding-right: 32px;">
                                                                    {{ \Carbon\Carbon::parse($electric->usage_start)->format('d-m-Y') }}
                                                                    -
                                                                    {{ \Carbon\Carbon::parse($electric->usage_end)->format('d-m-Y') }}
                                                                </td>
                                                                <td
                                                                    style="border: 1px solid black; text-align: right; padding-right: 32px;">
                                                                    {{ number_format($electric->kilowatt_energy, 0, ' ', ' ') }}
                                                                </td>
                                                                <td style="border: 1px solid black; text-align: center;">
                                                                    {{ number_format($electric->reactive_energy, 0, ' ', ' ') }}
                                                                </td>
                                                                <td
                                                                    style="border: 1px solid black; text-align: right; padding-right: 32px;">
                                                                    {{ number_format($electric->total_amount, 0, ' ', ' ') }}
                                                                </td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td style="border: 1px solid black; text-align: center;">
                                                                    {{ \Carbon\Carbon::parse($electric->usage_date)->format('d-m-Y') }}
                                                                </td>
                                                                <td
                                                                    style="border: 1px solid black; text-align: right; padding-right: 32px;">
                                                                    {{ \Carbon\Carbon::parse($electric->usage_start)->format('d-m-Y') }}
                                                                    -
                                                                    {{ \Carbon\Carbon::parse($electric->usage_end)->format('d-m-Y') }}
                                                                </td>
                                                                <td
                                                                    style="border: 1px solid black; text-align: right; padding-right: 32px;">
                                                                    {{ number_format($electric->kilowatt_energy, 0, ' ', ' ') }}
                                                                </td>
                                                                <td style="border: 1px solid black; text-align: center;">
                                                                    {{ number_format($electric->reactive_energy, 0, ' ', ' ') }}
                                                                </td>
                                                                <td
                                                                    style="border: 1px solid black; text-align: right; padding-right: 32px;">
                                                                    {{ number_format($electric->total_amount, 0, ' ', ' ') }}
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        @php
                                                            $previousLocation = $electric->location_number;
                                                            $previousUsageUnit = $electric->usage_unit;
                                                            $previousCreatedYear = $createdYear;
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-center" style="height: 70px;">
                                    <a href=""
                                        class="btn btn-primary btn-width mr-2 d-flex align-items-center justify-content-center"
                                        style="width: 120px; height: 40px; text-align: center; font-size: 14px;"
                                        data-bs-toggle="tooltip" title="បោះពុម្ភឯកសារ">
                                        <i class="fas fa-print"></i> <span class="ml-2">បោះពុម្ភ</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importModalLabel">Import Excel Data</h5>
                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times" style="color: red;"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="uploadForm" action="" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="excelFile" class="form-label">Choose Excel File</label>
                                            <div class="custom-file-upload">
                                                <input type="file" id="excelFile" name="excel_file"
                                                    accept=".xlsx, .xls" required>
                                                <label for="excelFile" id="fileLabel">
                                                    <i class="fas fa-file-upload"></i> <span id="fileName">No file
                                                        chosen</span>
                                                </label>
                                            </div>
                                            <small id="fileSizeWarning" class="text-danger d-none">File size exceeds 5 MB
                                                limit.</small>
                                            <div id="fileNameDisplay" class="mt-2"></div>
                                        </div>
                                        <div class="mb-3 text-center">
                                            <button type="submit" id="uploadButton" class="btn btn-primary"
                                                style="height: 60px; width: 100%;">
                                                <i class="fas fa-upload" style="margin-right: 8px;"></i> Upload
                                            </button>
                                        </div>
                                        <div id="loadingMessage" class="text-center d-none">
                                            <p id="progressText">Uploading, please wait... 0%</p>
                                        </div>
                                        <div id="successMessage" class="text-center d-none">
                                            <p class="mt-2 text-success">File uploaded successfully!</p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Field Search --}}
                    <form id="filterForm" class="max-w-md mx-auto mt-3" method="GET"
                        action="{{ route('electrics.index') }}" onsubmit="return validateDateField()">
                        <div class="row mb-3">
                            <div class="col-md-12 d-flex">
                                <!-- Search Field -->
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control mb-2" placeholder="ស្វែងរកអង្គភាព និងលេខទីតាំង"
                                    style="width: 240px; height: 40px;">
                                &nbsp;

                                <!-- Start Date -->
                                <input type="date" name="start_date" id="start_date"
                                    value="{{ request('start_date') }}" class="form-control"
                                    style="height: 40px; width: 200px;">
                                &nbsp;

                                <!-- End Date -->
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                    class="form-control" style="height: 40px; width: 200px;">
                            </div>

                            <div class="col-md-12">
                                <div class="input-group">
                                    <!-- Search Button -->
                                    <button type="submit" class="btn btn-primary" style="width: 120px; height: 40px;">
                                        <i class="fas fa-search"></i> ស្វែងរក
                                    </button>
                                    &nbsp;

                                    <!-- Reset Button -->
                                    <button type="button" id="resetBtn" class="btn btn-danger"
                                        style="width: 120px; height: 40px;" onclick="resetForm()">
                                        <i class="fas fa-times-circle"></i> កំណត់ឡើងវិញ
                                    </button>
                                    &nbsp;

                                    <!-- Export to Excel -->
                                    <a href=""
                                        class="btn btn-secondary d-flex align-items-center justify-content-center"
                                        style="width: 120px; height: 40px; text-align: center; font-size: 14px;">
                                        <i class="fas fa-file-excel fa-1x"></i> <span class="ml-2">បម្លែង xls</span>
                                    </a>
                                    &nbsp;

                                    <!-- Print PDF -->
                                    <a href=""
                                        class="btn btn-secondary d-flex align-items-center justify-content-center"
                                        style="width: 120px; height: 40px; text-align: center; font-size: 14px;">
                                        <i class="fas fa-print"></i> <span class="ml-2">បោះពុម្ព</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            @if (Session::has('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ Session::get('success') }}',
                    });
                </script>
            @elseif (Session::has('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '{{ Session::get('error') }}',
                    });
                </script>
            @endif

            {{-- Dropdown for showing number of items per page --}}
            <div class="d-flex justify-content-end mb-2">
                <div style="width: 120px;">
                    <select name="per_page" class="form-control" onchange="window.location.href=this.value;">
                        <option value="{{ url()->current() }}?per_page=25"
                            {{ request('per_page') == 25 ? 'selected' : '' }}>បង្ហាញ 25</option>
                        <option value="{{ url()->current() }}?per_page=50"
                            {{ request('per_page') == 50 ? 'selected' : '' }}>បង្ហាញ 50</option>
                        <option value="{{ url()->current() }}?per_page=100"
                            {{ request('per_page') == 100 ? 'selected' : '' }}>បង្ហាញ 100</option>
                    </select>
                </div>
            </div>

            {{-- Table --}}
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th rowspan="2" style="border: 1px solid black; font-size: 14px; width: 120px;">ល.រ</th>
                        <th rowspan="2" style="border: 1px solid black; font-size: 14px; ">អង្គភាពប្រើប្រាស់</th>
                        <th rowspan="2" style="border: 1px solid black; font-size: 14px; width: 120px;">លេខទីតាំង</th>
                        <th rowspan="2" style="border: 1px solid black; font-size: 14px; width: 160px;">កាលបរិច្ឆេទ
                        </th>
                        <th colspan="2" style="border: 1px solid black; font-size: 14px; width: 160px;">
                            កាលបរិច្ឆេទប្រើប្រាស់</th>

                        <th rowspan="2" style="border: 1px solid black; font-size: 14px; width: 160px;">ថាមពលគីឡូវ៉ាត់
                        </th>
                        <th rowspan="2" style="border: 1px solid black; font-size: 14px; width: 160px;">ថាមពលរ៉េអាក់ទិក
                        </th>
                        <th rowspan="2" style="border: 1px solid black; font-size: 14px; width: 160px;">ប្រាក់សរុបជារៀល
                        </th>
                        <th rowspan="2" style="border: 1px solid black; font-size: 14px; width: 120px;">សកម្មភាព</th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; font-size: 14px; width: 160px;">រយៈពេលចាប់ផ្ដើម</th>
                        <th style="border: 1px solid black; font-size: 14px; width: 160px;">រយៈពេលបញ្ចប់</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($electrics as $index => $electric)
                        <tr>
                            <td style="border: 1px solid black; text-align: center">
                                {{ $index + 1 }}</td>
                            <td style="border: 1px solid black; text-align: start">
                                {{ $electric->usage_unit }}</td>
                            <td style="border: 1px solid black; text-align: center">
                                {{ $electric->location_number }}</td>
                            <td style="border: 1px solid black; text-align: center;">
                                {{ \Carbon\Carbon::parse($electric->usage_date)->format('d-m-Y') }}</td>
                            <td style="border: 1px solid black; text-align: center;">
                                {{ \Carbon\Carbon::parse($electric->usage_start)->format('d-m-Y') }}
                            </td>
                            <td style="border: 1px solid black; text-align: center;">
                                {{ \Carbon\Carbon::parse($electric->usage_end)->format('d-m-Y') }}</td>
                            <td style="border: 1px solid black; text-align: center;">
                                {{ number_format($electric->kilowatt_energy, 0, ' ', ' ') }}</td>
                            <td style="border: 1px solid black; text-align: center;">
                                {{ number_format($electric->reactive_energy, 0, ' ', ' ') }}</td>
                            <td style="border: 1px solid black; text-align: right; padding-right: 32px;">
                                {{ number_format($electric->total_amount, 0, ' ', ' ') }}
                            </td>
                            <td
                                style="border: 1px solid black; text-align: center; justify-content: center; width: 120px;">
                                <form id="delete-form-{{ $electric->id }}"
                                    action="{{ route('electrics.destroy', $electric->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a class="btn btn-primary" href="{{ route('electrics.edit', $electric->id) }}">
                                    <i class="fas fa-edit" title="Edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger"
                                    onclick="confirmDelete({{ $electric->id }})">
                                    <i class="fas fa-trash-alt" title="Delete"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" style="text-align: center;">គ្មានទិន្នន័យ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Custom Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item{{ $electrics->onFirstPage() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $electrics->previousPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $electrics->lastPage(); $i++)
                                <li class="page-item{{ $electrics->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link"
                                        href="{{ $electrics->url($i) }}&per_page={{ request('per_page') }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item{{ !$electrics->hasMorePages() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $electrics->nextPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div>
                    <p class="text-muted">បង្ហាញ {{ $electrics->firstItem() }} ដល់ {{ $electrics->lastItem() }} នៃ
                        {{ $electrics->total() }} លទ្ធផល</p>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('styles')
    {{-- Custom style here --}}
    <style>
        .border-wrapper {
            padding-left: 16px;
            padding-right: 16px;
        }

        .btn-container {
            position: relative;
            display: inline-block;
        }

        h3 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
        }

        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
        }

        .custom-file-upload {
            position: relative;
            display: inline-block;
            cursor: pointer;
            width: 100%;
            height: 100%;
            border: 2px solid #ced4da;
            border-radius: 5px;
            text-align: center;
            line-height: 200px;
        }

        .custom-file-upload input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .btn,
        .form-control,
        /* label, */
        th,
        td {
            border: 1px solid black;
            text-align: center;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
            padding: 6px;
        }

        th,
        td {
            align-content: center;

        }

        #submit-button {
            position: relative;
            padding-right: 50px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 25px;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: red;
            transition: .4s;
            border-radius: 25px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 17px;
            width: 17px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: rgb(2, 119, 252);
        }

        input:checked+.slider:before {
            transform: translateX(24px);
        }

        .custom-select-dropdown {
            height: 40px;
            position: relative;
        }

        .custom-select-dropdown option {
            max-height: 120px;
            overflow-y: auto;
            display: flex;
            justify-content: flex-end;
        }
    </style>

    <style>
        .hover-text {
            position: relative;
            display: inline-block;
        }

        .hover-text:hover::after {
            content: attr(data-hover);
            position: absolute;
            left: 50%;
            top: -30px;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.75);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            white-space: nowrap;
            font-size: 12px;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.3s ease-in-out;
        }

        .hover-text::after {
            opacity: 0;
            visibility: hidden;
        }

        .custom-modal-width {
            width: 90% !important;
            max-width: 90%;
            /* Ensure it doesn't exceed 90% */
        }

        .modal-dialog {
            margin: auto;
            /* Center the modal */
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
            border: 1px solid rgb(133, 131, 131);
            text-align: center;
            padding: 4px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
        }

        /* h2 {
                                                                                                                        font-family: 'Khmer OS Muol Light', sans-serif;
                                                                                                                        font-size: 18px;
                                                                                                                    } */

        h3,
        h4 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
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

        .top-header {
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

        1 .filterable {
            cursor: pointer;
            background-color: #f0f0f0;
        }

        .hidden-row {
            display: none;
        }

        .hover-text {
            display: none;
            position: absolute;
            bottom: 50px;
            background-color: #333;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1;
            transition: opacity 0.3s ease;
        }

        a:hover .hover-text {
            display: block;
            opacity: 1;
        }
    </style>
@endsection

@section('scripts')
    {{-- Include SweetAlert2 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"
        integrity="sha512-nh8KkfWJZK0C0H8z8Z0z8W3R7ZFl8k5Hq9O1O7s9O0P8+Hybz5VQ1cDUNUr+M+4H0ttD5F5lsS4uRUmxT1b4g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('excelFile').addEventListener('change', function() {
            const fileInput = document.getElementById('excelFile');
            const fileNameDisplay = document.getElementById('fileName');
            const fileSizeWarning = document.getElementById('fileSizeWarning');
            const file = fileInput.files[0];

            if (file) {
                fileNameDisplay.textContent = file.name;
                // Check file size (5 MB limit)
                if (file.size > 5 * 1024 * 1024) { // 5 MB
                    fileSizeWarning.classList.remove('d-none');
                } else {
                    fileSizeWarning.classList.add('d-none');
                }
            } else {
                fileNameDisplay.textContent = 'No file chosen';
                fileSizeWarning.classList.add('d-none');
            }
        });


        document.getElementById('uploadButton').addEventListener('click', function() {
            const fileInput = document.getElementById('excelFile');
            const fileSizeWarning = document.getElementById('fileSizeWarning');
            const uploadButton = document.getElementById('uploadButton');
            const loadingMessage = document.getElementById('loadingMessage');
            const successMessage = document.getElementById('successMessage');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');

            // Check file size (5 MB limit)
            const file = fileInput.files[0];
            if (file && file.size > 5 * 1024 * 1024) { // 5 MB in bytes
                fileSizeWarning.classList.remove('d-none');
                return;
            } else {
                fileSizeWarning.classList.add('d-none');
            }

            // Show loading spinner and hide success message
            loadingMessage.classList.remove('d-none');
            successMessage.classList.add('d-none');

            // Create FormData object to send file
            const formData = new FormData(document.getElementById('uploadForm'));

            // Create XMLHttpRequest object
            const xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percentComplete + '%';
                    progressBar.setAttribute('aria-valuenow', percentComplete);
                    progressText.textContent = `Uploading ${percentComplete}%`;
                }
            });

            xhr.addEventListener('load', function() {
                if (xhr.status === 200) {
                    loadingMessage.classList.add('d-none');
                    successMessage.classList.remove('d-none');
                } else {
                    console.error('Error:', xhr.statusText);
                    loadingMessage.classList.add('d-none');
                    // Optionally show an error message
                }
            });

            xhr.addEventListener('error', function() {
                console.error('Error:', xhr.statusText);
                loadingMessage.classList.add('d-none');
                // Optionally show an error message
            });

            xhr.open('POST', '/your-upload-endpoint', true); // Replace with your upload endpoint
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute(
                'content'));
            xhr.send(formData);
        });
    </script>

    {{-- Reset Button --}}
    <script>
        document.getElementById('resetBtn').addEventListener('click', function() {
            // Clear all input fields
            document.querySelectorAll('.form-control').forEach(function(input) {
                input.value = '';
            });

            // Submit the form to reset filters
            document.querySelector('form').submit();
        });

        function resetForm() {
            document.getElementById('filterForm').reset();
            // Optionally clear the search term, date fields, etc.
            document.querySelector('input[name="search"]').value = '';
            document.querySelector('input[name="start_date"]').value = '';
            document.querySelector('input[name="end_date"]').value = '';
            // Optionally submit or reload the page
            document.getElementById('filterForm').submit();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (Session::has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'ជោគជ័យ',
                text: '{{ Session::get('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'តើអ្នកពិតជាចង់លុបមែនទេ?',
                text: 'មិនអាចត្រឡប់វិញបានទេ!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'បាទ/ចាស, លុបវា!',
                cancelButtonText: 'បោះបង់',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

    <script>
        function resetForm() {
            document.getElementById("filterForm").reset();
            window.location.href = "{{ route('electrics.index') }}";
        }

        function validateDateField() {
            var startDate = document.getElementById("start_date").value;
            var endDate = document.getElementById("end_date").value;

            if (startDate && endDate && startDate > endDate) {
                alert("Start date must be before end date.");
                return false;
            }
            return true;
        }
    </script>
@endsection
