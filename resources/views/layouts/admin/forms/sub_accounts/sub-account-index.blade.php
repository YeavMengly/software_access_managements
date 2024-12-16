@extends('layouts.master')

@section('content-sub-account')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="row">
                <div class="col-lg-12 margin-tb mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="btn btn-danger" href="{{ route('programs') }}"
                            style="width: 160px; height: 50px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-arrow-left"></i>&nbsp;&nbsp;ត្រឡប់ក្រោយ
                        </a>
                        <h2 class="mx-auto" style="font-weight: 700;">តារាងលេខកូដអនុគណនី</h2>
                        <a class="btn btn-success" href="{{ route('sub-account.create') }}"
                            style="width: 160px; height: 50px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                            បញ្ចូលទិន្នន័យ&nbsp;&nbsp;<i class="fas fa-plus" style="margin-left: 8px;"></i>
                        </a>
                    </div>

                    {{-- Field Search --}}
                    <form class="max-w-md mx-auto mt-3" method="GET" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group my-3" style="width: 35%;">
                                    <input type="search" name="search" value="{{ request('search') }}"
                                        class="form-control" placeholder="ស្វែងរកទិន្នន័យ" aria-label="Search Address"
                                        style="width: 180px; height: 60px;">
                                    <button type="submit" class="btn btn-primary" style="width: 60px">
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
                        <th style="border: 1px solid black;">
                            <a
                                href="{{ route('sub-account.index', ['sort' => 'sub_account_key', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                                លេខអនុគណនី
                                @if (request('sort') === 'sub_account_key')
                                    <span>{{ request('direction') === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </a>
                        </th>
                        <th style="border: 1px solid black;">ចំណាត់ថ្នាក់</th>
                        <th style="border: 1px solid black;" width="200px">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subAccountKeys as $subAccountKey)
                        <tr>
                            <td style="border: 1px solid black; text-align: center;">{{ $subAccountKey->sub_account_key }}
                            </td>
                            <td style="border: 1px solid black; text-align: start; padding-left: 2%;">
                                {{ $subAccountKey->name_sub_account_key }}</td>
                            <td style="border: 1px solid black; text-align: center; justify-content: center">
                                <form id="delete-form-{{ $subAccountKey->id }}"
                                    action="{{ route('sub-account.destroy', $subAccountKey->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a class="btn btn-primary" href="{{ route('sub-account.edit', $subAccountKey->id) }}">
                                    <i class="fas fa-edit" title="Edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger"
                                    onclick="confirmDelete({{ $subAccountKey->id }})">
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
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        @if ($subAccountKeys->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $subAccountKeys->previousPageUrl() }}&per_page={{ request('per_page', 10) }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                        @endif

                        @for ($i = 1; $i <= $subAccountKeys->lastPage(); $i++)
                            <li class="page-item {{ $i == $subAccountKeys->currentPage() ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $subAccountKeys->url($i) }}&per_page={{ request('per_page', 10) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($subAccountKeys->hasMorePages())
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $subAccountKeys->nextPageUrl() }}&per_page={{ request('per_page', 10) }}"
                                    aria-label="Next">
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
                    <p class="text-muted">បង្ហាញ {{ $subAccountKeys->firstItem() }} ដល់ {{ $subAccountKeys->lastItem() }}
                        នៃ {{ $subAccountKeys->total() }} លទ្ធផល</p>
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

        .btn-link {
            font-size: 1.5rem;
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
