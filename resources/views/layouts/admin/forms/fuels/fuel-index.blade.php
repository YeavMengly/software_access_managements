@extends('layouts.master')

@section('content-fuel')
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
                        <h3 style="font-weight: 500;">បញ្ចូលប្រេងឥន្ធនៈ</h3>
                        <div class="btn-group">

                            <a href="" data-bs-toggle="modal" data-bs-target="#createResultMission"
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
                                href="{{ route('fuels.create') }}" style="width: 120px; height: 40px; border-radius: 4px;">
                                បញ្ចូល
                            </a>
                        </div>
                    </div>

                    <div class="modal fade" id="createResultMission" tabindex="-1" aria-labelledby="importModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content ">
                                <div class="modal-header">

                                    <h3 class="modal-title text-center" id="importModalLabel">
                                        តារាងសរុបប្រេងឥន្ធនៈគ្រប់ប្រភេទ</h3>
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
                                                        <th
                                                            style="border: 1px solid black; font-family: 'Khmer OS Siemreap', sans-serif; font-weight: bold;">
                                                            ឆ្នាំបញ្ចូល</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    {{-- @foreach ($fuelTotalsGrouped as $date => $group)
                                                        @forelse ($group as $index => $fuelTotal)
                                                            <tr>
                                                                <td style="border: 1px solid black; text-align: center;">
                                                                    {{ $index + 1 }}</td>
                                                                <td
                                                                    style="border: 1px solid black; text-align: left; padding-left: 16px;">
                                                                    {{ $fuelTotal->product_name }}
                                                                </td>
                                                                <td style="border: 1px solid black;">លីត្រ</td>
                                                                <td
                                                                    style="border: 1px solid black; text-align: right; padding-right: 16px;">
                                                                    {{ number_format($fuelTotal->quantity, 0, ' ', ' ') }}
                                                                </td>
                                                                <td
                                                                    style="border: 1px solid black; text-align: right;  padding-right: 16px;">
                                                                    {{ number_format($fuelTotal->unit_price, 0, ' ', ' ') }}
                                                                </td>
                                                                <td
                                                                    style="border: 1px solid black; text-align: right;  padding-right: 16px;">
                                                                    {{ number_format($fuelTotal->fuel_total, 0, ' ', ' ') }}
                                                                </td>
                                                                <td style="border: 1px solid black; text-align: center; ">
                                                                    {{ $fuelTotal->company_name }}</td>
                                                                <td style="border: 1px solid black; text-align: center;">
                                                                    {{ \Carbon\Carbon::parse($fuelTotal->created_at)->format('Y') }}
                                                                </td>



                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8" style="text-align: center;">គ្មានទិន្នន័យ
                                                                </td>
                                                            </tr>
                                                        @endforelse

                                                        <tr>
                                                            <td colspan="8"
                                                                style="text-align: center; font-weight: bold;">
                                                                {{ \Carbon\Carbon::parse($date)->format('Y') }}</td>
                                                            <!-- Display grouped date -->
                                                        </tr>
                                                    @endforeach --}}
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

                    {{-- Field Search --}}
                    <form id="filterForm" class="max-w-md mx-auto mt-3" method="GET"
                        action="{{ route('fuels.index') }}" onsubmit="return validateDateField()">
                        <div class="row mb-3">
                            <div class="col-md-12 d-flex">
                                <!-- Search field for title_usage_unit or location_number -->
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control mb-2" placeholder="ស្វែងរកតាមរយៈ បរិយាយ លេខប័ណ្ណបញ្ចេញ"
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
                                    <!-- Search button -->
                                    <button type="submit" class="btn btn-primary mr-2"
                                        style="width: 120px; height: 40px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 50 50">
                                            <path
                                                d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z">
                                            </path>
                                        </svg>
                                        ស្វែងរក
                                    </button>
                                    <!-- Reset button -->
                                    <button type="button" id="resetBtn" class="btn btn-danger"
                                        style="width: 120px; height: 40px;" onclick="resetForm()">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                            <path
                                                d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm3.646 4.646a.5.5 0 0 1 0 .708L8.707 8l2.939 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.939a.5.5 0 1 1-.708-.708L7.293 8 4.354 5.354a.5.5 0 1 1 .708-.708L8 7.293l2.646-2.647a.5.5 0 0 1 .707 0z" />
                                        </svg>
                                        កំណត់ឡើងវិញ
                                    </button>
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
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th rowspan="2" style="border: 1px solid black; font-size: 14px; width: 80px;">ល.រ</th>
                        <th rowspan="2" style="border: 1px solid black; font-size: 14px; width: 120px;">កាលបរិច្ឆេទ
                        </th>
                        <th rowspan="2" style="border: 1px solid black; font-size: 14px; width: 120px;">លេខប័ណ្ណបញ្ចេញ
                        </th>
                        <th rowspan="2" style="border: 1px solid black; font-size: 14px;">បរិយាយ</th>
                        {{-- <th colspan="2" style="border: 1px solid black; font-size: 14px; min-width: 200px;">
                            បរិមាណប្រេងសាំង
                            (EA)</th>
                        <th colspan="2" style="border: 1px solid black; font-size: 14px; min-width: 200px;">
                            បរិមាណប្រេងម៉ាស៊ូត (DO)</th>
                        <th colspan="2" style="border: 1px solid black; font-size: 14px; min-width: 200px;">
                            បរិមាណប្រេងម៉ាស៊ីន (MO)
                        </th> --}}

                        @foreach ($fuelTags as $fuelTag)
                            <th colspan="2" style="border: 1px solid black;">
                                {{ $fuelTag->fuel_tag }}
                            </th>
                        @endforeach

                        <th rowspan="2" style="border: 1px solid black; font-size: 14px; width: 120px;">សកម្មភាព</th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; font-size: 14px; width: 80px;">បញ្ចូល</th>
                        <th style="border: 1px solid black; font-size: 14px; width: 80px;">បញ្ចេញ</th>
                        <th style="border: 1px solid black; font-size: 14px; width: 80px;">បញ្ចូល</th>
                        <th style="border: 1px solid black; font-size: 14px; width: 80px;">បញ្ចេញ</th>
                        <th style="border: 1px solid black; font-size: 14px; width: 80px;">បញ្ចូល</th>
                        <th style="border: 1px solid black; font-size: 14px; width: 80px;">បញ្ចេញ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fuels as $fuel)
                        <tr>
                            <td style="border: 1px solid black;">{{ $loop->iteration }}</td>
                            <td style="border: 1px solid black;">{{ $fuel->date }}</td>
                            <td style="border: 1px solid black;">{{ $fuel->receipt_number }}</td>
                            <td style="border: 1px solid black; text-align: start;">{{ $fuel->description }}</td>

                            {{-- <td style="border: 1px solid black; text-align: start;">{{ $fuel->fuels->id }}</td> --}}
                            @foreach ($fuel->oil_type as $index => $oil)
                                @php
                                    // Initialize the totals array for this oil type if not already set
                                    if (!isset($totals[$oil])) {
                                        $totals[$oil] = [
                                            'quantity' => [],
                                            'quantity_used' => [],
                                        ];
                                    }

                                    // Store the quantities and used quantities for each oil type by index
                                    $totals[$oil]['quantity'][$index] = $fuel->quantity[$index] ?? 0;
                                    $totals[$oil]['quantity_used'][$index] = $fuel->quantity_used[$index] ?? 0;
                                @endphp
                            @endforeach

                            @foreach ($totals as $oil => $data)
                                @php
                                    // Ensure `quantity` is always an array
                                    $quantities = is_array($data['quantity']) ? $data['quantity'] : [$data['quantity']];

                                    // Get the max index from available data to ensure we iterate correctly
                                    $maxIndex = max(array_keys($quantities));
                                @endphp

                                @for ($i = 0; $i <= $maxIndex; $i++)
                                    <td style="border: 1px solid black;">
                                        {{ number_format($quantities[$i] ?? 0, 0, ' ', ' ') }}
                                    </td>

                                    <td style="border: 1px solid black; text-align: right;">
                                        {{ number_format($data['quantity_used'][$i] ?? 0, 0, ' ', ' ') }}
                                    </td>
                                @endfor
                            @endforeach

                            <td style="border: 1px solid black; text-align: center; width: 120px;">
                                <form id="delete-form-{{ $fuel->id }}"
                                    action="{{ route('fuels.destroy', $fuel->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a class="btn btn-primary" href="{{ route('fuels.edit', $fuel->id) }}">
                                    <i class="fas fa-edit" title="Edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger"
                                    onclick="confirmDelete({{ $fuel->id }})">
                                    <i class="fas fa-trash-alt" title="Delete"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Custom Pagination --}}
            {{-- <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item{{ $waters->onFirstPage() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $waters->previousPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $waters->lastPage(); $i++)
                                <li class="page-item{{ $waters->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link"
                                        href="{{ $waters->url($i) }}&per_page={{ request('per_page') }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item{{ !$waters->hasMorePages() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $waters->nextPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div>
                    <p class="text-muted">បង្ហាញ {{ $waters->firstItem() }} ដល់ {{ $waters->lastItem() }} នៃ
                        {{ $waters->total() }} លទ្ធផល</p>
                </div>
            </div> --}}

        </div>
    </div>
@endsection

@section('styles')
    <style>
        h3 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
        }

        .border-wrapper {
            padding-left: 16px;
            padding-right: 16px;
        }

        .custom-file-upload {
            position: relative;
            display: inline-block;
            cursor: pointer;
            width: 100%;
            height: 100%;
            border: 1px solid #ced4da;
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

        .custom-file-upload label {
            display: block;
            cursor: pointer;
            color: #007bff;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .btn,
        .form-control,
        label,
        th,
        td {
            border: 1px solid black;
            text-align: center;
            align-content: center;
            padding: 6px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
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
@endsection
