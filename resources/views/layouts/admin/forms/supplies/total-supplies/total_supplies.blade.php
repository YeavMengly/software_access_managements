@extends('layouts.master')

@section('content-total-supplie')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="row">
                <div class="col-lg-12 margin-tb mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="btn btn-danger" href="{{ route('back') }}"
                            style="width: 120px; height: 40px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h3 class="mx-auto" style="font-weight: 500;">តារាងគ្រប់គ្រងសម្ភារគ្រប់ប្រភេទ</h3>
                        <div class="btn-group">
                            <a href="" data-bs-toggle="modal" data-bs-target="#createTotalSupplie"
                                class="btn btn-info btn-width d-flex align-items-center justify-content-center"
                                style="text-align: center; color: rgb(245, 245, 245); border-radius: 4px;"
                                data-bs-toggle="tooltip" title="បង្ហាញលទ្ធផលថ្មី">
                                <i class="fas fa-file-alt"></i>
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
            <div class="modal fade" id="createTotalSupplie" tabindex="-1" aria-labelledby="importModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content ">
                        <div class="modal-header">

                            <h3 class="modal-title text-center" id="importModalLabel">តារាងសម្ភារគ្រប់ប្រភេទ</h3>
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" style="color: red;"></i>
                            </button>
                        </div>
                        <div class="modal-body custom-scrollable">
                            <div class="result-total-table-container">
                                <div class="table-container">
                                    <table class="table table-striped table-hover">
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
                                                <th
                                                    style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                                    ឆ្នាំផលិត</th>
                                            </tr>
                                        </thead>
                                        @foreach ($totalSuppliesGrouped as $date => $group)
                                            @php $year = \Carbon\Carbon::parse($date)->format('d-m-Y'); @endphp
                                            @foreach ($group as $index => $totalSupplie)
                                                <tr>
                                                    <td style="width: 40px;">{{ $index + 1 }}</td>

                                                    <td style="text-align: start; max-height: 60px; max-width: 120px;">
                                                        <div style="overflow-y: auto; height: 120px;">
                                                            {{ $totalSupplie->product_name }}
                                                        </div>
                                                    </td>
                                                    <td style="width: 60px;">{{ $totalSupplie->unit }}</td>
                                                    <td style="width: 80px;">{{ $totalSupplie->quantity }}</td>
                                                    <td style="width: 120px;">
                                                        {{ number_format($totalSupplie->unit_price, 0) }}</td>
                                                    <td style="width: 120px;">
                                                        {{ number_format($totalSupplie->total_price, 0) }}</td>
                                                    <td style="width: 80px;">{{ $totalSupplie->source }}</td>
                                                    <td style="width: 80px;">
                                                        {{ \Carbon\Carbon::parse($totalSupplie->production_year)->format('Y') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @if (isset($yearlyTotals[$year]))
                                                <tr style="background-color: #73ade7;">
                                                    <td colspan="3" style="border: 1px solid black; text-align: center;">
                                                        {{ $year }}</td>
                                                    <td style="border: 1px solid black; text-align: center;  ">
                                                        {{ number_format($yearlyTotals[$year]['amount_quantity'], 0, ' ', ' ') }}
                                                    </td>
                                                    <td style="border: 1px solid black; text-align: center;  ">
                                                        {{ number_format($yearlyTotals[$year]['amount_unit_price'], 0, ' ', ' ') }}
                                                    </td>

                                                    <td style="border: 1px solid black; text-align: center;  ">
                                                        {{ number_format($yearlyTotals[$year]['amount_supplie'], 0, ' ', ' ') }}
                                                    </td>

                                                    <td colspan="3"
                                                        style="border: 1px solid black;text-align: center;  "></td>
                                                </tr>
                                            @endif
                                        @endforeach
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
                            <a href="{{ route('supplie-totals.index') }}" class="btn btn-danger"
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

                                <form id="uploadForm" action="{{ route('supplie-totals.store') }}" method="POST"
                                    style="width:100%;">
                                    @csrf

                                    <!-- Company Details -->
                                    <div class="mb-3 align-items-center">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="company_name">ឈ្មោះក្រុមហ៊ុន</label>
                                                <input type="text" class="form-control" name="company_name"
                                                    id="company_name" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="release_date">កាលបរិច្ឆេទបញ្ចូល</label>
                                                <input type="date" class="form-control" name="release_date"
                                                    id="release_date" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="warehouse">ឃ្លាំងប្រគល់</label>
                                                <input type="text" class="form-control" name="warehouse"
                                                    id="warehouse" required>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="description">អ្នកបញ្ចូល</label>
                                                <input type="text" class="form-control" name="description"
                                                    id="description" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 align-items-center">
                                        <div class="row mb-3">
                                            <div class="col-md-12">

                                                <div class="mb-3 align-items-center">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label for="refers">យោង</label>
                                                            <textarea name="refers" id="refers" rows="3" style="width: 100%; margin-bottom: 10px;"
                                                                placeholder="សូមបញ្ចូលយោង..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label for="product_name">រាយមុខទំនិញ</label>
                                                <textarea name="product_name" id="product_name" cols="30" rows="10"
                                                    style="height: 120px; text-align: left; width: 100%;" placeholder="សូមបញ្ចូលរាយមុខទំនិញ..."></textarea>
                                                {{-- <label for="product_name_editor">រាយមុខទំនិញ</label>
                                                <div id="toolbar"></div>
                                                <div id="product_name_editor" style="height: 200px; background: white;"
                                                    placeholder="សូមបញ្ចូលរាយមុខទំនិញ..."></div>
                                                <input type="hidden" name="product_name" id="product_name"> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 align-items-center">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="unit">ឯកតា</label>
                                                <input type="text" class="form-control" name="unit" id="unit"
                                                    required>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="quantity">បរិមាណ</label>
                                                <input type="text" class="form-control" name="quantity"
                                                    id="quantity" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="unit_price">តម្លៃឯកតា</label>
                                                <input type="text" class="form-control" name="unit_price"
                                                    id="unit_price" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">ប្រភព</label>
                                                <input type="text" class="form-control" name="source" id="source"
                                                    required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">ឆ្នាំផលិត</label>
                                                <input type="date" class="form-control" name="production_year"
                                                    id="production_year" required>
                                            </div>
                                        </div>
                                    </div>



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
                        <th
                            style="border: 1px solid black; align-items: center; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                            ល.រ</th>
                        <th
                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;  max-width:120px;">
                            ក្រុមហ៊ុន</th>
                        <th
                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;  max-width:120px;">
                            កាលបរិច្ឆេទបញ្ចូល</th>
                        <th
                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;  max-width:120px;">
                            យោង</th>
                        <th
                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;max-width:120px;">
                            អ្នកបញ្ចូល</th>
                        <th
                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;max-width:120px;">
                            ឃ្លាំងប្រគល់</th>
                        <th
                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;max-width:120px;">
                            រាយមុខទំនិញ</th>
                        <th
                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;max-width:120px;">
                            ឯកតា</th>
                        <th
                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;max-width:120px;">
                            បរិមាណ</th>
                        <th
                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;max-width:120px;">
                            តម្លៃឯកតា</th>
                        <th
                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold; max-width:120px;">
                            តម្លៃសរុប</th>
                        <th
                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold; max-width:120px;">
                            ប្រភព</th>
                        <th
                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold; max-width:120px;">
                            ឆ្នាំផលិត</th>
                        <th
                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold; max-width:120px;">
                            សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($totalSuppliesGrouped as $date => $group)
                        @php $year = \Carbon\Carbon::parse($date)->format('d-m-Y'); @endphp
                        @foreach ($group as $index => $totalSupplie)
                            <tr>
                                <td style="width: 40px;">{{ $index + 1 }}</td>
                                <td style="width: 120px;">{{ $totalSupplie->company_name }}</td>
                                <td style="width: 120px;">{{ $totalSupplie->release_date }}</td>
                                <td style="max-width: 120px; text-align: start;">{{ $totalSupplie->refers }}</td>
                                <td style="width: 120px;">{{ $totalSupplie->description }}</td>
                                <td style="width: 120px;">{{ $totalSupplie->warehouse }}</td>
                                <td style="text-align: start; max-width: 120px;">
                                    <div style="overflow-y: unset; max-height: 80px; padding-right: 5%;">
                                        {{ $totalSupplie->product_name }}
                                    </div>
                                </td>
                                <td style="width: 60px;">{{ $totalSupplie->unit }}</td>
                                <td style="width: 80px;">{{ $totalSupplie->quantity }}</td>
                                <td style="width: 120px;">{{ number_format($totalSupplie->unit_price, 0) }}</td>
                                <td style="width: 120px;">{{ number_format($totalSupplie->total_price, 0) }}</td>
                                <td style="width: 80px;">{{ $totalSupplie->source }}</td>
                                <td style="width: 80px;">
                                    {{ \Carbon\Carbon::parse($totalSupplie->production_year)->format('Y') }}</td>
                                <td style="border: 1px solid black; text-align: center; width: 80px;">

                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('supplie-totals.edit', $totalSupplie->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form id="delete-form-{{ $totalSupplie->id }}"
                                        action="{{ route('supplie-totals.destroy', $totalSupplie->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $totalSupplie->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if (isset($yearlyTotals[$year]))
                            <tr style="background-color: #73ade7;">
                                <td colspan="8" style="border: 1px solid black; text-align: center;">
                                    {{ $year }}</td>
                                <td style="border: 1px solid black; text-align: center;  ">
                                    {{ number_format($yearlyTotals[$year]['amount_quantity'], 0, ' ', ' ') }}
                                </td>
                                <td style="border: 1px solid black; text-align: center;  ">
                                    {{ number_format($yearlyTotals[$year]['amount_unit_price'], 0, ' ', ' ') }}
                                </td>

                                <td style="border: 1px solid black; text-align: center;  ">
                                    {{ number_format($yearlyTotals[$year]['amount_supplie'], 0, ' ', ' ') }}
                                </td>

                                <td colspan="3" style="border: 1px solid black;text-align: center;  "></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item{{ $totalSupplies->onFirstPage() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $totalSupplies->previousPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $totalSupplies->lastPage(); $i++)
                                <li class="page-item{{ $totalSupplies->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link"
                                        href="{{ $totalSupplies->url($i) }}&per_page={{ request('per_page') }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item{{ !$totalSupplies->hasMorePages() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $totalSupplies->nextPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div>
                    <p class="text-muted">បង្ហាញ {{ $totalSupplies->firstItem() }} ដល់
                        {{ $totalSupplies->lastItem() }} នៃ
                        {{ $totalSupplies->total() }} លទ្ធផល</p>
                </div>
            </div>

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
            /* text-align: center; */
            padding: 4px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
            overflow-y: auto;
            white-space: normal;
            word-wrap: break-word;
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

        /* Change style for many text  */

        label {
            font-family: "Khmer OS Siemreap", sans-serif;
            font-size: 14px;
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        #product_name {
            border: 1px solid #ccc;
            padding: 10px;
        }
    </style>
@endsection

@section('scripts')
    <!-- Include Quill -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

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

    {{-- For editor --}}
    {{-- <script>
        var toolbarOptions = [
            ['bold', 'italic', 'underline'],
            [{
                'font': []
            }, {
                'size': []
            }],
            [{
                'color': []
            }, {
                'background': []
            }],
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            [{
                'align': []
            }],
            ['link', 'image', 'video'],
            ['code-block'],
            ['clean']
        ];

        var quill = new Quill('#product_name', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
    </script> --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toolbarOptions = [
                ['bold', 'italic', 'underline'],
                [{
                    'font': []
                }, {
                    'size': []
                }],
                [{
                    'color': []
                }, {
                    'background': []
                }],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'align': []
                }],
                ['link', 'image', 'video'],
                ['code-block'],
                ['clean']
            ];

            var quill = new Quill('#product_name_editor', {
                modules: {
                    toolbar: toolbarOptions
                },
                theme: 'snow'
            });

            // Sync data to hidden input before form submit
            // document.querySelector('form').addEventListener('submit', function() {
            //     const html = quill.root.innerHTML.trim();

            //     // Remove default <p><br></p> value from Quill (empty)
            //     if (html === '<p><br></p>') {
            //         document.querySelector('#product_name').value = '';
            //     } else {
            //         document.querySelector('#product_name').value = html;
            //     }
            // });

            document.querySelector('form').addEventListener('submit', function() {
                const html = quill.root.innerHTML.trim();

                // If it's empty (just a blank <p><br></p>), clear the value
                if (html === '<p><br></p>' || !html) {
                    document.querySelector('#product_name').value = '';
                } else {
                    document.querySelector('#product_name').value = html;
                }
            });


        });
    </script> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quill = new Quill('#product_name_editor', {
                theme: 'snow',
                placeholder: 'សូមបញ្ចូលរាយមុខទំនិញ...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{
                            'font': []
                        }, {
                            'size': []
                        }],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        [{
                            'align': []
                        }],
                        ['link', 'image', 'video'],
                        ['code-block'],
                        ['clean']
                    ]
                }
            });

            const form = document.getElementById('uploadForm');
            const hiddenInput = document.getElementById('product_name');

            form.addEventListener('submit', function() {
                const content = quill.getText().trim();

                if (content === '') {
                    hiddenInput.value = '';
                } else {
                    hiddenInput.value = quill.root.innerHTML;

                    // Or use: hiddenInput.value = quill.root.innerHTML; // for HTML
                }
            });
        });
    </script> --}}




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
@endsection
