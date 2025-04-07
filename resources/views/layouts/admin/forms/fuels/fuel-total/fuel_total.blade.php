@extends('layouts.master')

@section('content-fuel-edit')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="row">
                <div class="col-lg-12 margin-tb mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="btn btn-danger" href="{{ route('back') }}"
                            style="width: 120px; height: 40px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h3 class="mx-auto" style="font-weight: 500;">តារាងប្រេងឥន្ធនៈគ្រប់ប្រភេទ</h3>
                        <div class="btn-group">
                            <a href="" data-bs-toggle="modal" data-bs-target="#createResultFuelTotal"
                                class="btn btn-info btn-width d-flex align-items-center justify-content-center"
                                style="text-align: center; color: rgb(245, 245, 245); border-radius: 4px;"
                                data-bs-toggle="tooltip" title="បង្ហាញលទ្ធផលថ្មី">
                                <i class="fas fa-file-alt"></i>
                            </a>
                            &nbsp;
                            <a class="btn btn-secondary d-flex justify-content-center align-items-center" href="#"
                                data-bs-toggle="modal" data-bs-target="#importModal"
                                style="width: 120px; height: 40px; border-radius: 4px;" data-bs-toggle="tooltip"
                                title="នាំចូលឯកសារ">
                                Import&nbsp;<i class="fas fa-file-import"></i>
                            </a>
                            &nbsp;
                            <a class="btn btn-primary d-flex justify-content-center align-items-center" href=""
                                data-bs-toggle="modal" data-bs-target="#create_fuel"
                                style="width: 120px; height: 40px; border-radius: 4px;" data-bs-toggle="tooltip"
                                title="បញ្ចូលព័ត៌មានថ្មី">
                                បញ្ចូល
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Tabel FuelTotal -->
            {{-- <div class="modal fade" id="createResultFuelTotal" tabindex="-1" aria-labelledby="importModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content ">
                        <div class="modal-header">

                            <h3 class="modal-title text-center" id="importModalLabel">តារាងសរុបប្រេងឥន្ធនៈគ្រប់ប្រភេទ</h3>
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
                                                <th
                                                    style="border: 1px solid black; align-items: center; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                                    ល.រ</th>
                                                <th
                                                    style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                                    រាយមុខទំនិញ</th>
                                                <th
                                                    style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                                    ឯកតា</th>
                                                <th
                                                    style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                                    បរិមាណ</th>
                                                <th
                                                    style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                                    តម្លៃឯកតា</th>
                                                <th
                                                    style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                                    តម្លៃសរុប</th>
                                                <th
                                                    style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                                    ប្រភព</th>
                                                <th style="border: 1px solid black; ">
                                                    <span> លេខបញ្ចូលឃ្លាំង</span>
                                                </th>
                                                <th style="border: 1px solid black; ">
                                                    <span> អ្នកបញ្ចូល</span>
                                                </th>
                                                <th
                                                    style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                                    ឆ្នាំបញ្ចូល</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $printedDescriptions = [];
                                            @endphp
                                            @foreach ($fuelTotalsGrouped as $date => $group)
                                                @foreach ($group as $index => $fuelTotal)
                                                    @php
                                                        $createdYear = \Carbon\Carbon::parse(
                                                            $fuelTotal->created_at,
                                                        )->format('Y');

                                                        $desc = $fuelTotal->description;
                                                        $warehouseEntry = $fuelTotal->warehouse_entry_number;
                                                        $companyName = $fuelTotal->company_name;
                                                        $refers = $fuelTotal->refers;
                                                        $releaseDate = $fuelTotal->release_date;
                                                        $warehouse = $fuelTotal->warehouse;

                                                        $key =
                                                            $createdYear .
                                                            '|' .
                                                            $desc .
                                                            '|' .
                                                            $warehouseEntry .
                                                            '|' .
                                                            $companyName .
                                                            '|' .
                                                            $refers .
                                                            '|' .
                                                            $releaseDate .
                                                            '|' .
                                                            $warehouse;

                                                    @endphp

                                                    @php
                                                        // Determine the maximum number of rows required for this entry
                                                        $maxRows = max(
                                                            count($fuelTotal->product_name ?? []),
                                                            count($fuelTotal->quantity ?? []),
                                                            count($fuelTotal->unit_price ?? []),
                                                            count($fuelTotal->fuel_total ?? []),
                                                        );
                                                    @endphp
                                                    @for ($i = 0; $i < $maxRows; $i++)
                                                        <tr>
                                                            <td style="border: 1px solid black; text-align: center;">
                                                                {{ $index + 1 }}</td>
                                                            <td style="border: 1px solid black; text-align: start;">
                                                                {{ $fuelTotal->product_name[$i] ?? '' }}
                                                            </td>
                                                            <td style="border: 1px solid black;">លីត្រ</td>
                                                            <td
                                                                style="border: 1px solid black;text-align: right; padding-right: 16px;">
                                                                {{ number_format($fuelTotal->quantity[$i] ?? 0, 0, ' ', ' ') }}
                                                            </td>
                                                            <td
                                                                style="border: 1px solid black;text-align: right; padding-right: 16px;">
                                                                {{ number_format($fuelTotal->unit_price[$i] ?? 0, 0, ' ', ' ') }}
                                                            </td>
                                                            <td
                                                                style="border: 1px solid black;text-align: right; padding-right: 16px;">
                                                                {{ number_format($fuelTotal->fuel_total[$i] ?? 0, 0, ' ', ' ') }}
                                                            </td>
                                                            @if (!isset($printedDescriptions[$key]))
                                                                <td style="border: 1px solid black;"
                                                                    rowspan="{{ $descriptionRowspanCounts[$key] }}">
                                                                    {{ $companyName }}
                                                                </td>
                                                                <td style="border: 1px solid black;"
                                                                    rowspan="{{ $descriptionRowspanCounts[$key] }}">
                                                                    {{ $warehouseEntry }}
                                                                </td>
                                                                <td style="border: 1px solid black;"
                                                                    rowspan="{{ $descriptionRowspanCounts[$key] }}">
                                                                    {{ $desc }}
                                                                </td>

                                                                @php $printedDescriptions[$key] = true; @endphp
                                                            @endif


                                                            @if (!isset($seenYears[$createdYear]))
                                                                <td style="border: 1px solid black; text-align: center;"
                                                                    rowspan="{{ $rowspanCounts[$createdYear] }}">
                                                                    {{ $createdYear }}
                                                                </td>
                                                                @php $seenYears[$createdYear] = true; @endphp
                                                            @endif
                                                        </tr>
                                                    @endfor
                                                @endforeach
                                                @php
                                                    $year = \Carbon\Carbon::parse($date)->format('d-m-Y');
                                                @endphp
                                                @php
                                                    $previousCreatedYear = null;
                                                    // Sort the waters by created year, with 2025 first, then 2024
                                                    $sortedWaters = $fuelTotals->sortByDesc(function ($fuelTotal) {
                                                        return \Carbon\Carbon::parse($fuelTotal->created_at)->format(
                                                            'Y',
                                                        );
                                                    });
                                                @endphp
                                                @if (isset($yearlyTotals[$year]))
                                                    <tr style="background-color: #73ade7;">
                                                        <td colspan="3"
                                                            style="text-align: center; border: 1px solid black;">
                                                            {{ $year }}
                                                        </td>
                                                        <td
                                                            style="border: 1px solid black; text-align: right;  padding-right: 16px;">
                                                            {{ number_format($yearlyTotals[$year]['total_quantity'], 0, ' ', ' ') }}
                                                        </td>
                                                        <td
                                                            style="border: 1px solid black; text-align: right;  padding-right: 16px;">
                                                            {{ number_format($yearlyTotals[$year]['total_unit_price'], 0, ' ', ' ') }}
                                                        </td>
                                                        <td
                                                            style="border: 1px solid black; text-align: right;  padding-right: 16px;">
                                                            {{ number_format($yearlyTotals[$year]['total_fuel_total'], 0, ' ', ' ') }}
                                                        </td>
                                                        <td colspan="4"
                                                            style="border: 1px solid black; text-align: right;  padding-right: 16px;">
                                                        </td>
                                                    </tr>
                                                @endif
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
            </div> --}}

            {{-- Modal Import --}}
            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="importModalLabel">Import Excel Data</h3>
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="uploadForm" action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="excelFile" class="form-label">Choose Excel File</label>
                                    <div class="custom-file-upload">
                                        <input type="file" id="excelFile" name="excel_file" accept=".xlsx, .xls"
                                            required>
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

            {{-- Modal Search --}}
            <form id="filterForm" method="GET" action="">
                <div class="row mb-3">
                    <div class="col-md-4 d-flex">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control mb-2"
                            placeholder="ស្វែងរក" style="text-align: left; width: 245px; height: 40px;"> &nbsp;
                        <!-- Start Date -->
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="form-control" style="height: 40px; width: 200px;">
                        &nbsp;
                        <!-- End Date -->
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="form-control" style="height: 40px; width: 200px;">
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary mr-2" style="width: 120px; height: 40px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 50 50">
                                    <path
                                        d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z">
                                    </path>
                                </svg>&nbsp;
                                ស្វែងរក</button>
                            <a href="{{ route('fuel-totals.index') }}" class="btn btn-danger"
                                style="width: 120px; height: 40px;"> <svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" class="bi bi-x-circle"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm3.646 4.646a.5.5 0 0 1 0 .708L8.707 8l2.939 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.939a.5.5 0 1 1-.708-.708L7.293 8 4.354 5.354a.5.5 0 1 1 .708-.708L8 7.293l2.646-2.647a.5.5 0 0 1 .707 0z" />
                                </svg>&nbsp;កំណត់ឡើងវិញ</a>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Include the error messages partial -->
            @include('partials.error-message')

            {{-- Modal create --}}
            <div class="modal fade" id="create_fuel" tabindex="-1" aria-labelledby="importModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 40%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="importModalLabel">បង្កើតប្រេងឥន្ធនៈគ្រប់ប្រភេទ</h3>
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" style="color: red;"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center align-items-center" style="height: 40%;">

                                <form id="uploadForm" action="{{ route('fuel-totals.store') }}" method="POST"
                                    style="width:100%;">
                                    @csrf

                                    <!-- Company Details -->
                                    <div class="mb-3 align-items-center">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="company_name">ឈ្មោះក្រុមហ៊ុន</label>
                                                <input type="text" class="form-control" name="company_name"
                                                    id="company_name" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="release_date">កាលបរិច្ឆេទបញ្ចូល</label>
                                                <input type="date" class="form-control" name="release_date"
                                                    id="release_date" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="warehouse">ឃ្លាំងប្រគល់</label>
                                                <input type="text" class="form-control" name="warehouse"
                                                    id="warehouse" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 align-items-center">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="description">អ្នកបញ្ចូល</label>
                                                <input type="text" class="form-control" name="description"
                                                    id="description" required>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="warehouse_entry_number">លេខបញ្ចូលឃ្លាំង</label>
                                                <input type="text" class="form-control" name="warehouse_entry_number"
                                                    id="warehouse_entry_number" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 align-items-center">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="refers">យោង</label>
                                                <textarea name="refers" id="refers" cols="30" rows="10"
                                                    style="height: 120px; text-align: left; width: 100%;" placeholder="សូមបញ្ចូលយោង..."></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dynamic Product List -->
                                    <div id="itemList">
                                        <div class="row item-row">
                                            <div class="col-md-4">
                                                <label for="product_name[]">ឈ្មោះទំនិញ</label>
                                                {{-- <input type="text" class="form-control" name="product_name[]"
                                                    required> --}}

                                                <select name="product_name[]" class="form-control"
                                                    style="height: 35px; width: 100%;" required>
                                                    <option value="" disabled selected>ជ្រើសរើសទំនិញ</option>
                                                    @foreach ($fuelTags as $tag)
                                                        <option value="{{ $tag->fuel_tag }}" style="text-align: start;">
                                                            {{ $tag->fuel_tag }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="quantity[]">បរិមាណ</label>
                                                <input type="number" class="form-control" name="quantity[]" required
                                                    min="1">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="unit_price[]">តម្លៃឯកតា</label>
                                                <input type="number" class="form-control" name="unit_price[]" required
                                                    min="0">
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end justify-content-end">
                                                <button type="button" class="btn btn-danger removeRow">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add Button -->
                                    <button type="button" class="btn btn-primary mt-3" id="addRow">
                                        <i class="fas fa-plus"></i> បន្ថែម
                                    </button>

                                    <!-- Submit Buttons -->
                                    <div class="row justify-content-center mt-4">
                                        <div class="col-12 text-center">
                                            <button type="reset" class="btn btn-secondary">
                                                <i class="fas fa-undo"></i>&nbsp;&nbsp;កំណត់ឡើងវិញ
                                            </button>
                                            <button type="submit" class="btn btn-primary ml-3">
                                                <i class="fas fa-save"></i>&nbsp;&nbsp;រក្សាទុក
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Edit --}}
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

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="border: 1px solid black; width: 40px;">
                            <span> ល.រ</span>
                        </th>
                        <th style="border: 1px solid black; ">
                            <span> ឈ្មោះក្រុមហ៊ុន</span>
                        </th>
                        <th style="border: 1px solid black; ">
                            <span> លេខបញ្ចូលឃ្លាំង</span>
                        </th>

                        <th style="border: 1px solid black; ">
                            <span> អ្នកបញ្ចូល</span>
                        </th>
                        <th style="border: 1px solid black; ">
                            <span> យោង</span>
                        </th>
                        <th style="border: 1px solid black; ">
                            <span> កាលបរិច្ឆេទបញ្ចូល</span>
                        </th>
                        <th style="border: 1px solid black; ">
                            <span>ឈ្មោះឃ្លាំង</span>
                        </th>
                        <th style="border: 1px solid black; ">
                            <span> រាយមុខទំនិញ</span>
                        </th>
                        <th style="border: 1px solid black; ">
                            <span> ឯកតា</span>
                        </th>
                        <th style="border: 1px solid black; ">
                            <span> បរិមាណ</span>
                        </th>
                        <th style="border: 1px solid black; ">
                            <span>តម្លៃឯកតា</span>
                        </th>
                        <th
                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                            តម្លៃសរុប</th>
                        <th style="border: 1px solid black;" width="80px">
                            <span> សកម្មភាព</span>
                        </th>
                    </tr>
                </thead>

                {{-- <tbody>
                    @php $printedDescriptions = []; @endphp

                    @foreach ($fuelTotalsGrouped as $date => $group)
                        @php $year = \Carbon\Carbon::parse($date)->format('d-m-Y'); @endphp

                        @foreach ($group as $index => $fuelTotal)
                            @php
                                $createdYear = \Carbon\Carbon::parse($fuelTotal->created_at)->format('Y');
                                $desc = $fuelTotal->description;
                                $warehouseEntry = $fuelTotal->warehouse_entry_number;
                                $companyName = $fuelTotal->company_name;
                                $refers = $fuelTotal->refers;
                                $releaseDate = $fuelTotal->release_date;
                                $warehouse = $fuelTotal->warehouse;

                                $key = "$createdYear|$desc|$warehouseEntry|$companyName|$refers|$releaseDate|$warehouse";
                            @endphp
                            @php

                                $maxRows = max(
                                    count($fuelTotal->product_name ?? []),
                                    count($fuelTotal->quantity ?? []),
                                    count($fuelTotal->unit_price ?? []),
                                    count($fuelTotal->fuel_total ?? []),
                                );
                            @endphp

                            @for ($i = 0; $i < $maxRows; $i++)
                                <tr>
                                    @if ($i === 0)
                                        <td style="border: 1px solid black; text-align: center;"
                                            rowspan="{{ $maxRows }}">{{ $index + 1 }}</td>

                                        @if (!isset($printedDescriptions[$key]))


                                            <td rowspan="{{ count($fuelTotal->product_name) == 1 ? 1 : (count($fuelTotal->product_name) == 2 ? 2 : 3) }}"
                                                style="border: 1px solid black;">
                                                {{ $companyName }}
                                            </td>


                                            <td rowspan="{{ count($fuelTotal->product_name) == 1 ? 1 : (count($fuelTotal->product_name) == 2 ? 2 : 3) }}"
                                                style="border: 1px solid black;">
                                                {{ $warehouseEntry }}
                                            </td>
                                            <td rowspan="{{ count($fuelTotal->product_name) == 1 ? 1 : (count($fuelTotal->product_name) == 2 ? 2 : 3) }}"
                                                style="border: 1px solid black;">
                                                {{ $desc }}
                                            </td>
                                            <td rowspan="{{ count($fuelTotal->product_name) == 1 ? 1 : (count($fuelTotal->product_name) == 2 ? 2 : 3) }}"
                                                style="border: 1px solid black;">
                                                {{ $refers }}
                                            </td>
                                            <td rowspan="{{ count($fuelTotal->product_name) == 1 ? 1 : (count($fuelTotal->product_name) == 2 ? 2 : 3) }}"
                                                style="border: 1px solid black;">
                                                {{ $releaseDate }}
                                            </td>
                                            <td rowspan="{{ count($fuelTotal->product_name) == 1 ? 1 : (count($fuelTotal->product_name) == 2 ? 2 : 3) }}"
                                                style="border: 1px solid black;">
                                                {{ $warehouse }}
                                            </td>
                                            @php $printedDescriptions[$key] = true; @endphp
                                        @endif
                                    @endif

                                    <td style="border: 1px solid black; text-align: start;">
                                        {{ $fuelTotal->product_name[$i] ?? '' }}
                                    </td>
                                    <td style="border: 1px solid black;text-align: right; ">លីត្រ</td>
                                    <td style="border: 1px solid black;text-align: right;">
                                        {{ number_format($fuelTotal->quantity[$i] ?? 0, 0, ' ', ' ') }}
                                    </td>

                                    <td style="border: 1px solid black;text-align: right;">
                                        {{ number_format($fuelTotal->unit_price[$i] ?? 0, 0, ' ', ' ') }}
                                    </td>

                                    <td style="border: 1px solid black;text-align: right;">
                                        {{ number_format($fuelTotal->fuel_total[$i] ?? 0, 0, ' ', ' ') }}
                                    </td>


                                    @if ($i === 0)
                                        <td style="border: 1px solid black; text-align: center;"
                                            rowspan="{{ $maxRows }}">

                                            <a class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#edit_fuel">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form id="delete-form-{{ $fuelTotal->id }}"
                                                action="{{ route('fuel-totals.destroy', $fuelTotal->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete({{ $fuelTotal->id }})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endfor
                        @endforeach

                        @if (isset($yearlyTotals[$year]))
                            <tr style="background-color: #73ade7;">
                                <td colspan="9" style="border: 1px solid black; text-align: center;">
                                    {{ $year }}</td>
                                <td style="border: 1px solid black; text-align: right;  ">
                                    {{ number_format($yearlyTotals[$year]['total_quantity'], 0, ' ', ' ') }}
                                </td>
                                <td style="border: 1px solid black; text-align: right; ">
                                    {{ number_format($yearlyTotals[$year]['total_unit_price'], 0, ' ', ' ') }}
                                </td>
                                <td style="border: 1px solid black;text-align: right;  ">
                                    {{ number_format($yearlyTotals[$year]['total_fuel_total'], 0, ' ', ' ') }}
                                </td>
                                <td style="border: 1px solid black;text-align: right;  "></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody> --}}

                <tbody>

                    {{-- @dd($fuelTotals) --}}

                    @foreach ($fuelTotals as $index => $fuelTotal)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $fuelTotal->company_name }}</td>
                            <td>{{ $fuelTotal->warehouse_entry_number }}</td>
                            <td>{{ $fuelTotal->description }}</td>
                            <td>{{ $fuelTotal->refers }}</td>
                            <td>{{ $fuelTotal->release_date }}</td>
                            <td>{{ $fuelTotal->warehouse }}</td>
                            <td>{{ $fuelTotal->product_name }}</td>
                            <td>លីត្រ</td>
                            <td>{{ $fuelTotal->quantity }}</td>
                            <td>{{ number_format($fuelTotal->unit_price, 0) }}</td>
                            <td>{{ number_format($fuelTotal->fuel_total, 0) }}</td>
                            <td style="border: 1px solid black; text-align: center;">

                                <a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_fuel">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form id="delete-form-{{ $fuelTotal->id }}"
                                    action="{{ route('fuel-totals.destroy', $fuelTotal->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete({{ $fuelTotal->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>


            </table>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item{{ $fuelTotals->onFirstPage() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $fuelTotals->previousPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $fuelTotals->lastPage(); $i++)
                                <li class="page-item{{ $fuelTotals->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link"
                                        href="{{ $fuelTotals->url($i) }}&per_page={{ request('per_page') }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item{{ !$fuelTotals->hasMorePages() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $fuelTotals->nextPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div>
                    <p class="text-muted">បង្ហាញ {{ $fuelTotals->firstItem() }} ដល់
                        {{ $fuelTotals->lastItem() }} នៃ
                        {{ $fuelTotals->total() }} លទ្ធផល</p>
                </div>
            </div>

            {{-- Modal Edit --}}
            {{-- <div class="modal fade" id="edit_fuel" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 50%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="importModalLabel">បង្កើតប្រេងឥន្ធនៈគ្រប់ប្រភេទ</h3>
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" style="color: red;"></i>
                            </button>

                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center align-items-center" style="height: 40%;">

                             
                                @if (isset($fuelTotal))
                                    <form id="editForm" action="{{ route('fuel-totals.update', $fuelTotal->id) }}"
                                        method="POST" style="width:80%;">
                                        @csrf
                                        @method('PUT')
                             
                                        <div class="mb-3 align-items-center">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="company_name">ឈ្មោះក្រុមហ៊ុន</label>
                                                    <input type="text" class="form-control" name="company_name"
                                                        id="company_name" value="{{ $fuelTotal->company_name }}"
                                                        required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="release_date">កាលបរិច្ឆេទបញ្ចូល</label>
                                                    <input type="date" class="form-control" name="release_date"
                                                        id="release_date"
                                                        value="{{ \Carbon\Carbon::parse($fuelTotal->release_date)->format('Y-m-d') }}"
                                                        required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="warehouse">ឃ្លាំងប្រគល់</label>
                                                    <input type="text" class="form-control" name="warehouse"
                                                        id="warehouse" value="{{ $fuelTotal->warehouse }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 align-items-center">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="description">អ្នកបញ្ចូល</label>
                                                    <input type="text" class="form-control" name="description"
                                                        id="description" value="{{ $fuelTotal->description }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="warehouse_entry_number">លេខបញ្ចូលឃ្លាំង</label>
                                                    <input type="text" class="form-control"
                                                        name="warehouse_entry_number" id="warehouse_entry_number"
                                                        value="{{ $fuelTotal->warehouse_entry_number }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 align-items-center">
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="refers">យោង</label>
                                                    <textarea name="refers" id="refers" cols="30" rows="4"
                                                        style="height: 120px; text-align: left; width: 100%;" placeholder="សូមបញ្ចូលយោង...">{{ $fuelTotal->refers }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                               
                                        <div id="itemList">
                                            @foreach ($fuelTotal->product_name as $index => $product)
                                                <div class="row item-row">
                                                    <div class="col-md-4">
                                                        <label for="product_name[]">ឈ្មោះទំនិញ</label>
                                                        <select name="product_name[]" class="form-control" required>
                                                            <option value="" disabled>ជ្រើសរើសទំនិញ</option>
                                                            @foreach ($fuelTags as $tag)
                                                                <option value="{{ $tag->fuel_tag }}"
                                                                    {{ $product == $tag->fuel_tag ? 'selected' : '' }}>
                                                                    {{ $tag->fuel_tag }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="quantity[]">បរិមាណ</label>
                                                        <input type="number" class="form-control" name="quantity[]"
                                                            required min="1"
                                                            value="{{ isset($fuelTotal->quantity[$index]) ? $fuelTotal->quantity[$index] : '' }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="unit_price[]">តម្លៃឯកតា</label>
                                                        <input type="number" class="form-control" name="unit_price[]"
                                                            required min="0"
                                                            value="{{ isset($fuelTotal->unit_price[$index]) ? $fuelTotal->unit_price[$index] : '' }}">
                                                    </div>
                                                    <div class="col-md-1 d-flex align-items-end justify-content-end">
                                                        <button type="button" class="btn btn-danger removeRow">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>

                  
                                        <button type="button" class="btn btn-primary mt-3" id="addRow">
                                            <i class="fas fa-plus"></i> បន្ថែម
                                        </button>

                     
                                        <div class="row justify-content-center mt-4">
                                            <div class="col-12 text-center">
                                                <button type="reset" class="btn btn-secondary">
                                                    <i class="fas fa-undo"></i>&nbsp;&nbsp;កំណត់ឡើងវិញ
                                                </button>
                                                <button type="submit" class="btn btn-primary ml-3">
                                                    <i class="fas fa-save"></i>&nbsp;&nbsp;រក្សាទុក
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
@endsection

@section('styles')
    {{-- Insclude style here --}}

    <style>
        .border-wrapper {
            padding-left: 16px;
            padding-right: 16px;
        }

        .btn-container {
            position: relative;
            display: inline-block;
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
        th,
        td {
            border: 1px solid black;
            text-align: center;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
            padding: 6px;
            align-content: center;
        }

        th,
        td {}

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

        h3 {
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

        /* Hide number input arrows in Chrome, Safari, Edge, and Opera */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Hide number input arrows in Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endsection

@section('scripts')
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        $(document).ready(function() {
            $('#editForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission (for testing)

                let formData = $(this).serialize();
                console.log(formData); // Check if data is being collected correctly

                // If everything looks good, you can enable form submission:
                this.submit();
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-status').forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const yearId = this.getAttribute('data-id');
                    const isChecked = this.checked;

                    fetch(`/years/${yearId}/toggle-status`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status) {
                                // Update status text
                                const statusText = this.closest('tr').querySelector(
                                    '.status-text');
                                const statusClass = data.status === 'active' ?
                                    'text-success' :
                                    (data.status === 'inactive' ? 'text-danger' :
                                        'text-warning');

                                statusText.textContent = data.status.charAt(0).toUpperCase() +
                                    data.status.slice(1);
                                statusText.className = `status-text ${statusClass}`;
                            } else {
                                alert('Failed to update the status. Please try again.');
                                // Revert the toggle switch if the update fails
                                this.checked = !isChecked;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Revert the toggle switch in case of an error
                            this.checked = !isChecked;
                        });
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function() {
            // Show the loading spinner
            document.getElementById('loading').style.display = 'block';

            // Disable the submit button to prevent multiple submissions
            document.getElementById('uploadButton').disabled = true;
        });

        var editFuelModal = document.getElementById('edit_fuel');
        editFuelModal.addEventListener('hidden.bs.modal', function() {
            // Reset the form inside the modal
            var form = editFuelModal.querySelector('form');
            if (form) {
                form.reset();
            }
        });

        // $('#edit_fuel').on('hidden.bs.modal', function() {
        //     $(this).find('form')[0].reset();
        // });
    </script>

    <script>
        $(document).ready(function() {
            // Add New Row
            $("#addRow").click(function() {
                let newRow = `
                 &nbsp;
                <div class="row item-row">
                    <div class="col-md-4">
                    <label for="product_name[]">ឈ្មោះទំនិញ</label>
                        <select name="product_name[]" class="form-control" style="height: 35px; width: 100%;" required>
                            <option value="" disabled selected>ជ្រើសរើសទំនិញ</option>
                            @foreach ($fuelTags as $tag)
                                <option value="{{ $tag->fuel_tag }}" style="text-align: start;">{{ $tag->fuel_tag }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                          <label for="quantity[]">បរិមាណ</label>
                        <input type="number" class="form-control" name="quantity[]" required min="1">
                    </div>
                    <div class="col-md-3">
                         <label for="unit_price[]">តម្លៃឯកតា</label>
                        <input type="number" class="form-control" name="unit_price[]" required min="0">
                    </div>
                    <div class="col-md-1 d-flex align-items-end justify-content-end">
                        <button type="button" class="btn btn-danger removeRow">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>`;
                $("#itemList").append(newRow);
            });

            // Remove Row
            $(document).on("click", ".removeRow", function() {
                $(this).closest(".row").remove();
            });

            // Validate Before Submit
            $("#uploadForm").on("submit", function(event) {
                let valid = true;
                $(this).find("input").each(function() {
                    if ($(this).val().trim() === "") {
                        $(this).addClass("is-invalid");
                        valid = false;
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });

                if (!valid) {
                    event.preventDefault(); // Stop form submission
                    alert("សូមបំពេញព័ត៌មានទាំងអស់!"); // Alert user to fill in required fields
                }
            });
        });
    </script>
@endsection
