@extends('layouts.master')

@section('content-certificate')
    <div class="row  mt-4 ml-4 mr-4">
        <div class="col-lg-12 margin-tb mb-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <a class="btn btn-danger  d-flex align-items-center justify-content-center"
                    href="{{ url('/card_certificate') }}" style="width: 160px; height: 50px;"> <i
                        class="fas fa-arrow-left"></i>
                    &nbsp; ត្រឡប់ក្រោយ</a>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="flex-grow-1 text-center" style="font-weight: 700;">តារាងដើមគ្រា</h2>
                <div class="btn-container">
                    <a id="submit-button" class="btn btn-success  d-flex align-items-center justify-content-center"
                        href="{{ route('certificate.create') }}" style="width: 160px; height: 50px;">
                       បញ្ចូលទិន្ន័យ &nbsp;
                        <i id="plus-icon" class="fas fa-plus"></i>
                        <div id="loader" class="loader" style="display: none;"></div>
                    </a>

                </div>
            </div>

            <form class="max-w-md mx-auto mt-3" method="GET" action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group my-3" style="width: 70%;">
                            <input type="search" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="ស្វែងរកទិន្នន័យ" aria-label="Search Address">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 50 50">
                                    <path
                                        d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="border-wrapper ml-4 mr-4">
        <div class="result-total-table-container">
            <div class="d-flex justify-content-end mb-2">
                <!-- Dropdown for showing number of items per page -->
                <div style="width: 120px;">
                    <select name="per_page" class="form-control" onchange="window.location.href=this.value;">
                        <option value="{{ url()->current() }}?per_page=25"
                            {{ request('per_page') == 25 ? 'selected' : '' }}>
                            បង្ហាញ 25</option>
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
                        <!-- Index Column -->
                        <th style="border: 1px solid black; font-size: 14px; width: 180px;">
                            លេខរៀង
                        </th>
                        <th style="border: 1px solid black; font-size: 14px; width: 180px;">
                            អនុគណនី​
                        </th>
                        <th style="border: 1px solid black; font-size: 14px; width: 180px;">
                            កូដកម្មវិធី
                        </th>

                        <!-- Sort by Name Certificate -->
                        <th style="border: 1px solid black; font-size: 14px; width:260px;">
                            <a
                                href="{{ route('certificate.index', [
                                    'search' => request('search'), // Preserve the search query
                                    'per_page' => request('per_page'), // Preserve items per page
                                    'sort_field' => 'name_certificate',
                                    'sort_direction' => $sortField === 'name_certificate' && $sortDirection === 'asc' ? 'desc' : 'asc',
                                ]) }}">
                                ទឹកប្រាក់ដើមគ្រា
                                <!-- Display sort icon based on current sort direction -->
                                @if ($sortField === 'name_certificate')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>

                        <!-- Action Column -->
                        <th style="border: 1px solid black;" width="200px">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($certificates as $certificate)
                        <tr>
                            <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                            <td style="border: 1px solid black; text-align: center;">
                                {{ $certificate->report && $certificate->report->subAccountKey ? $certificate->report->sub_account_key : 'N/A' }}
                            </td>
                            <td style="border: 1px solid black; text-align: center;">
                                {{ $certificate->report ? $certificate->report->report_key : 'N/A' }}
                            </td>
                            <td style="border: 1px solid black; text-align: center;">
                                {{ number_format($certificate->early_balance, 0, ' ', ' ') }}
                            </td>
                            <td style="border: 1px solid black; text-align: center;">
                                <form id="delete-form-{{ $certificate->id }}"
                                    action="{{ route('certificate.destroy', $certificate->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a class="btn btn-primary" href="{{ route('certificate.edit', $certificate->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger"
                                    onclick="confirmDelete({{ $certificate->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">គ្មានទិន្នន័យ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


            <div class="d-flex justify-content-between align-items-center mt-4">
                <!-- Custom Pagination Links -->
                <div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item{{ $certificates->onFirstPage() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $certificates->previousPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $certificates->lastPage(); $i++)
                                <li class="page-item{{ $certificates->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link"
                                        href="{{ $certificates->url($i) }}&per_page={{ request('per_page') }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item{{ !$certificates->hasMorePages() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $certificates->nextPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div>
                    <p class="text-muted">បង្ហាញ {{ $certificates->firstItem() }} ដល់ {{ $certificates->lastItem() }}
                        នៃ
                        {{ $certificates->total() }} លទ្ធផល</p>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('styles')
    <style>
        .border-wrapper {
            /* border: 2px solid black; */
            padding: 10px;
        }

        /* .result-total-table-container {
                        max-height: 100vh;
                        overflow-y: auto;
                    } */

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

        .btn-container {
            position: relative;
            display: inline-block;
        }

        #submit-button {
            position: relative;
            padding-right: 48px;
            /* Make space for the loader */
        }



        #loader {
            display: none;
            /* Hide loader by default */
            position: absolute;
            justify-content: center;
            align-content: center;
            top: 25%;
            right: 10px;
            /* Adjust position as needed */
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 3px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 3px solid #fff;
            /* Adjust loader color if needed */
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"
        integrity="sha512-nh8KkfWJZK0C0H8z8Z0z8W3R7ZFl8k5Hq9O1O7s9O0P8+Hybz5VQ1cDUNUr+M+4H0ttD5F5lsS4uRUmxT1b4g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Include SweetAlert2 -->
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

    {{-- Request process  --}}
    <script>
        // Confirm Delete
        document.getElementById('submit-button').addEventListener('click', function() {
            var loader = document.getElementById('loader');
            var plusIcon = document.getElementById('plus-icon');

            // Show loader and hide plus icon
            loader.style.display = 'inline-block';
            plusIcon.style.display = 'none';

            // Simulate form submission delay
            setTimeout(function() {
                // Hide loader and show plus icon again
                loader.style.display = 'none';
                plusIcon.style.display = 'inline-block';
            }, 2000); // Change 2000 to match your form submission time
        });

        function handleLongRequest() {
            setTimeout(() => {
                const loader = document.getElementById('loader');
                if (loader.style.display === 'block') {
                    alert('The request is taking too long. Please try again later.');
                    window.location.href = '/404'; // Redirect to a 404 page or another error page
                }
            }, 10000); // 10 seconds timeout
        }

        document.getElementById('submit-button').addEventListener('click', function() {
            handleLongRequest();
        });
    </script>
@endsection
