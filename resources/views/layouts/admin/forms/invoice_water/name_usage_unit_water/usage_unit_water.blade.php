@extends('layouts.master')

@section('content-usage-units-water')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="row">
                <div class="col-lg-12 margin-tb mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="btn btn-danger" href="{{ route('back') }}"
                            style="width: 120px; height: 40px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h3 class="mx-auto" style="font-weight: 500;">តារាងអង្គភារដ្ធករទឹក</h3>
                        <div class="btn-group">

                            <a class="btn btn-secondary d-flex justify-content-center align-items-center" href="#"
                                data-bs-toggle="modal" data-bs-target="#importModal" href=""
                                style="width: 120px; height: 40px; border-radius: 4px;">
                                Import&nbsp;<i class="fas fa-file-import"></i>
                            </a>
                            &nbsp;
                            <!-- Check if the user is an admin -->
                            <a class="btn btn-primary d-flex justify-content-center align-items-center" href=""
                                data-bs-toggle="modal" data-bs-target="#create_usage_unit_water"
                                style="width: 120px; height: 40px; border-radius: 4px;">
                                បញ្ចូលអង្គភាព
                            </a>
                        </div>
                    </div>
                </div>
            </div>

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

            <form id="filterForm" method="GET" action="">
                <div class="row mb-3">
                    <div class="col-md-4 d-flex">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control mb-2"
                            placeholder="ស្វែងរកឈ្មោះអង្គភាព ឬ លេខទីតាំង" style="width: 245px; height: 40px;">
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary mr-2" style="width: 120px; height: 40px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 50 50">
                                    <path
                                        d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z">
                                    </path>
                                </svg>&nbsp;
                                ស្វែងរក</button>
                            <a href="{{ route('usage_units.index') }}" class="btn btn-danger"
                                style="width: 120px; height: 40px;"> <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                    <path
                                        d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm3.646 4.646a.5.5 0 0 1 0 .708L8.707 8l2.939 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.939a.5.5 0 1 1-.708-.708L7.293 8 4.354 5.354a.5.5 0 1 1 .708-.708L8 7.293l2.646-2.647a.5.5 0 0 1 .707 0z" />
                                </svg>&nbsp;កំណត់ឡើងវិញ</a>
                        </div>
                    </div>
                </div>
            </form>

            @include('partials.error-message') <!-- Include the error messages partial -->

            {{-- Modal create --}}
            <div class="modal fade" id="create_usage_unit_water" tabindex="-1" aria-labelledby="importModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="importModalLabel">បង្កើតអង្គភាពប្រើប្រាស់</h3>
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" style="color: red;"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center align-items-center" style="height: 30vh;">
                                <form id="uploadForm" action="{{ route('usage_units_water.store') }}" method="POST"
                                    style="width:100%;">
                                    @csrf
                                    <div class="mb-3 text-center">
                                        <input type="text" name="title_usage_unit_water" id="title_usage_unit_water"
                                            class="form-control mb-2" style="height: 40px;" placeholder="ឈ្មោះអង្គភាព"
                                            required>
                                        <input type="text" name="location_number_water" id="location_number_water"
                                            class="form-control mb-2" style="height: 40px;" placeholder="លេខទីតាំង"
                                            required>
                                        <select name="province_city" id="province_city"
                                            class="form-control mb-2 custom-select-dropdown" required>
                                            <option value="">ជ្រើសរើសរាជធានី-ខេត្ត</option>
                                            @foreach ($provinceCities as $provinceCitie)
                                                <option value="{{ $provinceCitie->province_city }}">
                                                    {{ $provinceCitie->province_city }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 text-center">
                                        <button type="reset" class="btn btn-secondary"
                                            style="height: 40px; width: 100%;">
                                            <i class="fas fa-undo"></i>&nbsp;&nbsp;កំណត់ឡើងវិញ
                                        </button>
                                        <button type="submit" id="uploadButton" class="btn btn-primary mt-2"
                                            style="height: 40px; width: 100%;">បង្កើត</button>
                                        @include('partials.loading-modal')
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
                    {{-- <tr>
                        <th rowspan="2" style="border: 1px solid black; width: 120px; text-align: center;">
                            <span> ល.រ</span>
                        </th>
                        <th rowspan="2" style="border: 1px solid black; ">
                            <span> អង្គភាពប្រើប្រាស់</span>
                        </th>
                        <th rowspan="2" style="border: 1px solid black; ">
                            <span> លេខសម្គាល់
                            </span>
                        </th>
                        <th rowspan="1" colspan="2" style="border: 1px solid black; ">
                            វិក្កយបត្រ
                        </th>

                        <th rowspan="2" style="border: 1px solid black; ">
                            <span> កាលបរិច្ឆេទប្រើប្រាស់</span>
                        </th>
                        <th rowspan="2" style="border: 1px solid black; ">
                            <span> បរិមាណប្រើប្រាស់</span>
                        </th>
                        <th rowspan="2" style="border: 1px solid black; ">
                            <span> ថ្លៃប្រើប្រាស់</span>
                        </th>
                        <th rowspan="2" style="border: 1px solid black;" width="120px">
                            <span> សកម្មភាព</span>
                        </th>
                    </tr> --}}

                    <tr>
                        <th style="border: 1px solid black; width: 120px;">
                            <span> ល.រ</span>
                        </th>
                        <th style="border: 1px solid black; ">
                            <span> អង្គភាពប្រើប្រាស់</span>
                        </th>
                        <th style="border: 1px solid black; ">
                            <span> លេខទីតាំង</span>
                        </th>
                        <th style="border: 1px solid black; ">
                            <span> រាជធានី-ខេត្ត</span>
                        </th>
                        <th style="border: 1px solid black;" width="120px">
                            <span> សកម្មភាព</span>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($usageUnitsWater as $index => $usageUnitWater)
                        <tr>
                            <td style="border: 1px solid black; text-align: center">
                                {{ $index + 1 }}</td>
                            <td style="border: 1px solid black; text-align: start">
                                {{ $usageUnitWater->title_usage_unit_water }}</td>
                            <td style="border: 1px solid black; text-align: center">
                                {{ $usageUnitWater->location_number_water }}</td>
                            <td style="border: 1px solid black; text-align: center">
                                {{ $usageUnitWater->province_city }}
                            </td>
                            <td
                                style="border: 1px solid black; text-align: center; justify-content: center; width: 120px;">
                                <form id="delete-form-{{ $usageUnitWater->id }}"
                                    action="{{ route('usage_units_water.destroy', $usageUnitWater->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a class="btn btn-primary"
                                    href="{{ route('usage_units_water.edit', $usageUnitWater->id) }}">
                                    <i class="fas fa-edit" title="Edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger"
                                    onclick="confirmDelete({{ $usageUnitWater->id }})">
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

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item{{ $usageUnitsWater->onFirstPage() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $usageUnitsWater->previousPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $usageUnitsWater->lastPage(); $i++)
                                <li class="page-item{{ $usageUnitsWater->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link"
                                        href="{{ $usageUnitsWater->url($i) }}&per_page={{ request('per_page') }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item{{ !$usageUnitsWater->hasMorePages() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $usageUnitsWater->nextPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div>
                    <p class="text-muted">បង្ហាញ {{ $usageUnitsWater->firstItem() }} ដល់
                        {{ $usageUnitsWater->lastItem() }} នៃ
                        {{ $usageUnitsWater->total() }} លទ្ធផល</p>
                </div>
            </div>

            {{-- <div class="modal fade" id="editYear{{ $usageUnit->id }}" tabindex="-1" aria-labelledby="editYearModalLabel{{ $usageUnit->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="editYearModalLabel{{ $usageUnit->id }}">កែប្រែឆ្នាំ</h3>
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center align-items-center" style="height: 20vh;">
                                <form action="{{ route('usage_units.update', $usageUnit->id) }}" method="POST" style="width: 30%;">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3 text-center">
                                        <input type="text" name="title_usage_unit" id="title_usage_unit" class="form-control mb-2" style="height: 40px;" placeholder="អង្គភាពប្រើប្រាស់" value="{{ $usageUnit->title_usage_unit }}">
                                    </div>
                                    <div class="mb-3 text-center">
                                        <button type="submit" class="btn btn-primary" style="height: 40px; width: 100%;">កែប្រែ</button>
                                    </div>
                                </form>
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

        /* .modal-title {
                                                font-size: 1.25rem;
                                                font-weight: bold;
                                            } */

        .custom-file-upload {
            position: relative;
            display: inline-block;
            cursor: pointer;
            width: 100%;
            height: 100%;
            border: 2px solid #ced4da;
            border-radius: 5px;
            /* background-color: #3e72a7; */
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
        document.getElementById('uploadForm').addEventListener('submit', function() {
            // Show the loading spinner
            document.getElementById('loading').style.display = 'block';

            // Disable the submit button to prevent multiple submissions
            document.getElementById('uploadButton').disabled = true;
        });
    </script>
@endsection
