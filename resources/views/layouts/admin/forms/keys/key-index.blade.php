@extends('layouts.master')

@section('content-key')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2 style="font-weight: 700;">តារាងលេខជំពូក</h2>
                <a class="btn btn-success" href="{{ route('keys.create') }}">បញ្ចូលទិន្នន័យ</a>
            </div>

            <form class="max-w-md mx-auto mt-3" method="GET" action="{{ route('keys.index') }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group my-3" style="width: 70%;">
                            <input type="search" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="ស្វែងរកទិន្នន័យ" aria-label="Search Address">
                            <button type="submit" class="btn btn-primary">
                                <!-- SVG for search icon -->
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

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
            @php
                $count = 1; // Initialize the count variable
            @endphp
            @foreach ($keys as $key)
                <tr>
                    <td style="border: 1px solid black; text-align: center;">{{ $count }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $key->code }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $key->name }}</td>
                    <td style="border: 1px solid black; width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <form action="{{ route('keys.destroy', $key->id) }}" method="POST">
                            <a class="btn btn-info" href="{{ route('keys.show', $key->id) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-primary" href="{{ route('keys.edit', $key->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this location?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @php
                    $count++; // Increment count after each row
                @endphp
            @endforeach
        </tbody>
    </table>

    <!-- Pagination links -->
    <div class="demo">
        <nav class="pagination-outer" aria-label="Page navigation">
            {{-- {{ $keys->links('vendor.pagination.custom') }} --}}
        </nav>
    </div>
@endsection

@section('styles')
    <style>
        .pagination-outer {
            text-align: center;
        }

        .pagination {
            font-family: 'Manrope', sans-serif;
            display: inline-flex;
            position: relative;
        }

        .pagination li a.page-link {
            color: #555;
            background: #eee;
            font-size: 16px;
            font-weight: 700;
            text-align: center;
            line-height: 32px;
            height: 32px;
            width: 32px;
            padding: 0;
            margin: 0 6px;
            border: none;
            border-radius: 0;
            display: block;
            position: relative;
            z-index: 1;
            transition: all 0.5s ease 0s;
        }

        .pagination li:first-child a.page-link,
        .pagination li:last-child a.page-link {
            font-size: 23px;
            line-height: 28px;
        }

        .pagination li a.page-link:hover,
        .pagination li a.page-link:focus,
        .pagination li.active a.page-link:hover,
        .pagination li.active a.page-link {
            color: #c31db3;
            background: transparent;
            box-shadow: 0 0 0 1px #c31db3;
            border-radius: 5px;
        }

        .pagination li a.page-link:before,
        .pagination li a.page-link:after {
            content: '';
            background-color: #c31db3;
            height: 10px;
            width: 10px;
            opacity: 0;
            position: absolute;
            left: 0;
            top: 0;
            z-index: -2;
            transition: all 0.3s ease 0s;
        }

        .pagination li a.page-link:after {
            right: 0;
            bottom: 0;
            top: auto;
            left: auto;
        }

        .pagination li a.page-link:hover:before,
        .pagination li a.page-link:focus:before,
        .pagination li.active a.page-link:hover:before,
        .pagination li.active a.page-link:before,
        .pagination li a.page-link:hover:after,
        .pagination li a.page-link:focus:after,
        .pagination li.active a.page-link:hover:after,
        .pagination li.active a.page-link:after {
            opacity: 1;
        }

        .pagination li a.page-link:hover:before,
        .pagination li a.page-link:focus:before,
        .pagination li.active a.page-link:hover:before,
        .pagination li.active a.page-link:before {
            left: -3px;
            top: -3px;
        }

        .pagination li a.page-link:hover:after,
        .pagination li a.page-link:focus:after,
        .pagination li.active a.page-link:hover:after,
        .pagination li.active a.page-link:after {
            right: -3px;
            bottom: -3px;
        }

        @media only screen and (max-width: 767px) {
            .pagination li:first-child a.page-link,
            .pagination li:last-child a.page-link {
                font-size: 16px;
                line-height: 28px;
            }
        }
    </style>
@endsection
