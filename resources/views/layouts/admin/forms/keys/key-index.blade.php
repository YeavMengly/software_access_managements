@extends('layouts.master')

@section('content-key')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="row">
                <div class="col-lg-12 margin-tb mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="btn btn-danger" href="{{ route('programs') }}">
                            <i class="fas fa-arrow-left"></i> ត្រឡប់ក្រោយ
                        </a>
                        <h2 style="font-weight: 700;">តារាងលេខជំពូក</h2>

                        <a id="submit-button" class="btn btn-success" href="{{ route('keys.create') }}">
                            បញ្ចូលទិន្ន័យ
                            <i id="plus-icon" class="fas fa-plus" style="margin-left: 0px;"></i>
                            <div id="loader" class="loader" style="display: none;"></div>
                        </a>

                    </div>

                    <form class="max-w-md mx-auto mt-3" method="GET" action="{{ route('keys.index') }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group my-3" style="width: 70%;">
                                    <input type="search" name="search" value="{{ request('search') }}"
                                        class="form-control" placeholder="ស្វែងរកទិន្នន័យ" aria-label="Search Address">
                                    <button type="submit" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 50 50">
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

            <div class="d-flex justify-content-end mb-2">
                <!-- Dropdown for showing number of items per page -->
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
                        <th style="border: 1px solid black;">លេខរៀង</th>
                        <th style="border: 1px solid black;">
                            <a href="{{ route('keys.index', ['sort_by' => 'code', 'sort_order' => $sortOrder === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}"
                                class="text-decoration-none">
                                លេខជំពូក
                                @if ($sortBy === 'code')
                                    @if ($sortOrder === 'asc')
                                        <span>&#9650;</span>
                                    @else
                                        <span>&#9660;</span>
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th style="border: 1px solid black;">
                            <a href="{{ route('keys.index', ['sort_by' => 'name', 'sort_order' => $sortOrder === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}"
                                class="text-decoration-none">
                                ចំណាត់ថ្នាក់
                                @if ($sortBy === 'name')
                                    @if ($sortOrder === 'asc')
                                        <span>&#9650;</span>
                                    @else
                                        <span>&#9660;</span>
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th style="border: 1px solid black;" width="200px">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($keys->isEmpty())
                        <tr>
                            <td colspan="4" style="text-align: center; border: 1px solid black;">គ្មានទិន្ន័យ</td>
                        </tr>
                    @else
                        @php
                            $count = 1; // Initialize the count variable
                        @endphp
                        @forelse ($keys as $key)
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">{{ $count }}</td>
                                <td style="border: 1px solid black; text-align: center;">{{ $key->code }}</td>
                                <td style="border: 1px solid black; text-align: center;">{{ $key->name }}</td>
                                <td style="border: 1px solid black; text-align: center; justify-content: center">
                                    <form id="delete-form-{{ $key->id }}"
                                        action="{{ route('keys.destroy', $key->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a class="btn btn-primary" href="{{ route('keys.edit', $key->id) }}">
                                        <i class="fas fa-edit" title="Edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger"
                                        onclick="confirmDelete({{ $key->id }})">
                                        <i class="fas fa-trash-alt" title="Delete"></i>
                                    </button>
                                </td>
                            </tr>
                            @php
                                $count++; // Increment count after each row
                            @endphp
                        @empty
                            <tr>
                                <td colspan="13" style="text-align: center;">គ្មានទិន្ន័យ</td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>

            <!-- Custom Pagination Links -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        @if ($keys->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $keys->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                        @endif

                        @for ($i = 1; $i <= $keys->lastPage(); $i++)
                            <li class="page-item {{ $i == $keys->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $keys->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($keys->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $keys->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
                <div>
                    <p class="text-muted">បង្ហាញ {{ $keys->firstItem() }} ដល់ {{ $keys->lastItem() }}
                        នៃ
                        {{ $keys->total() }} លទ្ធផល</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- Include any additional styles here -->
    <style>
        .border-wrapper {
            /* border: 2px solid black; */
            padding: 32px;
        }

        .btn-container {
            position: relative;
            display: inline-block;
        }

        .btn, .form-control, label, th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 16px;
        }
        
        #submit-button {
            position: relative;
            padding-right: 50px;
        }

        #plus-icon {
            margin-left: 16px;
        }

        #loader {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            border: 3px solid #f3f3f3;
            /* Light grey */
            border-top: 3px solid #3498db;
            /* Blue */
            border-radius: 50%;
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
@endsection
