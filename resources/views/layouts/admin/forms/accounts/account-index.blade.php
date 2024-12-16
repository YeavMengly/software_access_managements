@extends('layouts.master')

@section('content-account')

    <div class="border-wrapper">

        <div class="result-total-table-container">
            <div class="row">

                <div class="col-lg-12 margin-tb mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="btn btn-danger" href="{{ route('programs') }}"
                            style="width: 160px; height: 50px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">

                            <i class="fas fa-arrow-left"></i> &nbsp;&nbsp;ត្រឡប់ក្រោយ
                        </a>
                        <h2 class="mx-auto" style="font-weight: 700;">តារាងលេខកូដគណនី</h2>
                        <a class="btn btn-success" href="{{ route('accounts.create') }}"   style="width: 160px; height: 50px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">

                            បញ្ចូលទិន្នន័យ &nbsp;&nbsp;<i class="fas fa-plus"></i>
                        </a>
                    </div>

                    {{-- Field Search --}}
                    <form class="max-w-md mx-auto mt-3" method="GET" action="{{ route('accounts.index') }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group my-3" style="width: 25%;">
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
                            <a href="{{ route('accounts.index', ['sort_by' => 'account_key', 'sort_order' => $sortBy === 'account_key' && $sortOrder === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}"
                                class="text-decoration-none">
                                លេខគណនី
                                @if ($sortBy === 'account_key')
                                    @if ($sortOrder === 'asc')
                                        <span>&#9650;</span>
                                    @else
                                        <span>&#9660;</span>
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th style="border: 1px solid black;">
                            <a href="{{ route('accounts.index', ['sort_by' => 'name_account_key', 'sort_order' => $sortBy === 'name_account_key' && $sortOrder === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}"
                                class="text-decoration-none">
                                ចំណាត់ថ្នាក់
                                @if ($sortBy === 'name_account_key')
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
                    @forelse ($accountKeys as $accountKey)
                        <tr>
                            <td style="border: 1px solid black; text-align: center;">{{ $accountKey->account_key }}</td>
                            <td style="border: 1px solid black; text-align: start; padding-left: 2%;">
                                {{ $accountKey->name_account_key }}
                            </td>
                            <td style="border: 1px solid black; text-align: center; justify-content: center">
                                <form id="delete-form-{{ $accountKey->id }}"
                                    action="{{ route('accounts.destroy', $accountKey->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a class="btn btn-primary" href="{{ route('accounts.edit', $accountKey->id) }}">
                                    <i class="fas fa-edit" title="Edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger"
                                    onclick="confirmDelete({{ $accountKey->id }})">
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
                            <li class="page-item{{ $accountKeys->onFirstPage() ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $accountKeys->previousPageUrl() }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $accountKeys->lastPage(); $i++)
                                <li class="page-item{{ $accountKeys->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link" href="{{ $accountKeys->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item{{ !$accountKeys->hasMorePages() ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $accountKeys->nextPageUrl() }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div>
                    <p class="text-muted">បង្ហាញ {{ $accountKeys->firstItem() }} ដល់ {{ $accountKeys->lastItem() }} នៃ
                        {{ $accountKeys->total() }} លទ្ធផល</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    {{-- Insclude style here --}}
    <style>
        .border-wrapper {
            padding: 32px;
        }

        .pagination {
            justify-content: flex-end;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .pagination .page-link {
            color: #007bff;
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

        .pagination .page-link:hover {
            color: #0056b3;
            text-decoration: none;
        }

        .results-info {
            margin-left: 16px;
            font-size: 14px;
            color: #555;
        }

        .pagination a {
            padding: 8px 12px;
            border-radius: 4px;
            margin-right: 4px;
            border: 1px solid #ddd;
            color: #007bff;
            text-decoration: none;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }

        .pagination .active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
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
