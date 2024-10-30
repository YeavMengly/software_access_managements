@extends('layouts.master')

@section('content-loans')
    <div class="border-wrapper">

        @if (isset($connectionError) && $connectionError)
            <div class="alert alert-danger" role="alert">
                <strong>No internet connection:</strong> Please check your network settings and try again.
            </div>
        @else
            <!-- Existing content -->
            <div class="result-total-table-container">
                <div class="row">
                    <!-- Your existing form, table, and pagination code -->
                </div>
            </div>
        @endif

        <div class="result-total-table-container">
            <div class="row">
                <div class="col-lg-12 margin-tb">

                    <div class="d-flex justify-content-between align-items-center">
                        <a class="btn btn-danger" href="{{ url('/') }}">
                            <i class="fas fa-arrow-left"></i> ត្រឡប់ក្រោយ
                        </a>
                        <h2 style="font-weight: 700;">តារាងរបាយការណ៍បញ្ចូលឥណទានដើមឆ្នាំ</h2>
                        <div class="btn-group">
                            <a class="btn btn-success mr-2" href="#" data-bs-toggle="modal"
                                data-bs-target="#importModal" style="border-radius: 4px;">
                                Import <i class="fas fa-file-import" style="margin-left: 8px;"></i>
                            </a>
                            <a class="btn btn-success" href="{{ route('loans.create') }}" style="border-radius: 4px;">
                                បញ្ចូលទិន្នន័យ <i class="fas fa-plus" style="margin-left: 8px;"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Import Modal --}}
                    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importModalLabel">Import Excel Data</h5>
                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="uploadForm" action="{{ route('loans.import') }}" method="POST"
                                        enctype="multipart/form-data">
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
                                            <!-- Display chosen file name here -->
                                        </div>
                                        <div class="mb-3 text-center">
                                            <button type="submit" id="uploadButton" class="btn btn-primary">
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
                    <form class="max-w-md mx-auto mt-4" method="GET" action="{{ url()->current() }}">
                        <div class="row">

                            <div class="col-md-3">
                                <input type="text" name="sub_account_key_id" value="{{ request('sub_account_key_id') }}"
                                    class="form-control mb-2" placeholder="លេខអនុគណនី">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="report_key" value="{{ request('report_key') }}"
                                    class="form-control mb-2" placeholder="លេខកូដកម្មវិធី">
                            </div>

                            <div class="col-md-12">
                                <div class="input-group my-3">
                                    <button type="submit" class="btn btn-primary mr-2" style="width: 150px; height: 40px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 50 50">
                                            <path
                                                d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z">
                                            </path>
                                        </svg>
                                        ស្វែងរក
                                    </button>
                                    <button type="button" id="resetBtn" class="btn btn-danger"
                                        style="width: 150px; height: 40px;">
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
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="border: 1px solid black; font-size: 14px; max-width: 50px;">លេខអនុគណនី</th>
                        <th style="border: 1px solid black; font-size: 14px; max-width: 60px;">លេខកូដកម្មវិធី</th>
                        <th style="border: 1px solid black; font-size: 14px; max-width: 80px;">កើនផ្ទៃក្នុង</th>
                        <th style="border: 1px solid black; font-size: 14px; max-width: 80px;">មិនបានគ្រោងទុក</th>
                        <th style="border: 1px solid black; font-size: 14px; max-width: 80px;">បំពេញបន្ថែម</th>
                        <th style="border: 1px solid black; font-size: 14px; max-width: 80px;">សរុប</th>
                        <th style="border: 1px solid black; font-size: 14px; max-width: 80px;">ថយ</th>
                        <th style="border: 1px solid black; font-size: 14px; max-width: 80px;">វិចារណកម្ម</th>
                        <th style="border: 1px solid black; font-size: 14px; max-width: 80px;">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr>
                            <td style="border: 1px solid black; max-width: 80px; text-align: center">
                                {{ $loan->subAccountKey->sub_account_key }}</td>
                                @if ($loan->reportKey && $loan->reportKey->subAccountKey)
                                    {{ $loan->reportKey->subAccountKey->sub_account_key }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td style="border: 1px solid black; max-width: 80px; text-align: center">
                                {{ $loan->reportKey->report_key }}</td>
                            <td style="border: 1px solid black; max-width: 80px; text-align: center">
                                {{ number_format($loan->internal_increase, 0, ' ', ' ') }}</td>
                            <td style="border: 1px solid black; max-width: 80px; text-align: center">
                                {{ number_format($loan->unexpected_increase, 0, ' ', ' ') }}</td>
                            <td style="border: 1px solid black; max-width: 80px; text-align: center">
                                {{ number_format($loan->additional_increase) }}</td>
                                <td style="border: 1px solid black; max-width: 80px; text-align: center">
                                    {{ number_format($loan->total_increase) }}</td>
                            <td style="border: 1px solid black; max-width: 80px; text-align: center">
                                {{ number_format($loan->decrease, 0, ' ', ' ') }}</td>
                                <td style="border: 1px solid black; max-width: 80px; text-align: center">
                                    {{ number_format($loan->editorial, 0, ' ', ' ') }}</td>
                            <td style="border: 1px solid black; max-width: 80px; text-align: center">
                                {{ number_format($loan->total_increase) }}</td>
                            <td style="border: 1px solid black; max-width: 80px; text-align: center">
                                {{ number_format($loan->decrease, 0, ' ', ' ') }}</td>
                            <td style="border: 1px solid black; max-width: 80px; text-align: center">
                                {{ number_format($loan->editorial, 0, ' ', ' ') }}</td>

                            <td style="border: 1px solid black; text-align: center; justify-content: center">
                                <form id="delete-form-{{ $loan->id }}"
                                    action="{{ route('loans.destroy', $loan->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a class="btn btn-primary" href="{{ route('loans.edit', $loan->id) }}">
                                    <i class="fas fa-edit" title="Edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger"
                                    onclick="confirmDelete({{ $loan->id }})">
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
                        {{-- <ul class="pagination">
                            <li class="page-item{{ $reports->onFirstPage() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $reports->previousPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $reports->lastPage(); $i++)
                                <li class="page-item{{ $reports->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link"
                                        href="{{ $reports->url($i) }}&per_page={{ request('per_page') }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item{{ !$reports->hasMorePages() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $reports->nextPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul> --}}
                    </nav>
                </div>
                <div>
                    {{-- <p class="text-muted">បង្ហាញ {{ $reports->firstItem() }} ដល់ {{ $reports->lastItem() }} នៃ
                        {{ $reports->total() }} លទ្ធផល</p> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    {{-- Custom style here --}}

    <style>
        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .border-wrapper {
            padding: 32px;
        }

        .description {
            height: 220px;
            overflow-y: auto;
        }

        .table-container {
            width: 100%;
        }

        .btn-link {
            font-size: 1.5rem;
        }

        .custom-file-upload {
            position: relative;
            display: inline-block;
            cursor: pointer;
            width: 100%;
            height: 250px;
            border: 2px solid #ced4da;
            border-radius: 5px;
            background-color: #f8f9fa;
            text-align: center;
            line-height: 250px;
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

        .custom-file-upload label i {
            margin-right: 8px;
        }

        .btn,
        .form-control,
        label,
        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 16px;
        }

        .btn-primary {
            border-radius: 5px;
            font-weight: bold;
        }

        #loadingMessage {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .progress {
            height: 20px;
            margin-top: 10px;
            width: 100%;
        }

        .progress-bar {
            transition: width 0.4s ease;
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
