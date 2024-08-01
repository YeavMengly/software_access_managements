@extends('layouts.master')

@section('content-account')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2 style="font-weight: 700;">តារាងលេខកូដគណនី</h2>
                <a class="btn btn-success" href="{{ route('accounts.create') }}">បញ្ចូលទិន្នន័យ</a>
            </div>
            <form class="max-w-md mx-auto mt-3" method="GET" action="{{ route('accounts.index') }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group my-3" style="width: 70%;">
                            <input type="search" name="search" value="{{ request('search') }}" class="form-control"
                                   placeholder="ស្វែងរកទិន្នន័យ" aria-label="Search Account Key">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 50 50">
                                    <path d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z"></path>
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
                    <a href="{{ route('accounts.index', ['sort_by' => 'key.code', 'sort_order' => $sortBy === 'key.code' && $sortOrder === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="text-decoration-none">
                        លេខជំពូក
                        @if ($sortBy === 'key.code')
                            @if ($sortOrder === 'asc')
                                <span>&#9650;</span>
                            @else
                                <span>&#9660;</span>
                            @endif
                        @endif
                    </a>
                </th>
                <th style="border: 1px solid black;">
                    <a href="{{ route('accounts.index', ['sort_by' => 'account_key', 'sort_order' => $sortBy === 'account_key' && $sortOrder === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="text-decoration-none">
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
                    <a href="{{ route('accounts.index', ['sort_by' => 'name_account_key', 'sort_order' => $sortBy === 'name_account_key' && $sortOrder === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="text-decoration-none">
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
            @foreach ($accountKeys as $accountKey)
                <tr>
                    <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $accountKey->key->code }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $accountKey->account_key }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $accountKey->name_account_key }}</td>
                    <td style="border: 1px solid black; width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <form action="{{ route('accounts.destroy', $accountKey->id) }}" method="POST">
                            <a class="btn btn-info" href="{{ route('accounts.show', $accountKey->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('accounts.edit', $accountKey->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this account key?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $accountKeys->appends(request()->query())->links() }}
@endsection
