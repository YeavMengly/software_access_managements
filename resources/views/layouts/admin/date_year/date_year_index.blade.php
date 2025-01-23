@extends('layouts.master')

@section('content-date-year')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="row">
                <div class="col-lg-12 margin-tb mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="btn btn-danger" href="{{ route('back') }}"
                            style="width: 120px; height: 40px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-arrow-left"></i>&nbsp;&nbsp;
                        </a>

                        <h3 class="mx-auto" style="font-weight: 700;">តារាងឆ្នាំ</h3>

                        <div class="btn-group">
                            @if (auth()->check() && auth()->user()->role == 'admin')
                                <!-- Check if the user is an admin -->
                                <a class="btn btn-primary d-flex justify-content-center align-items-center" href=""
                                    data-bs-toggle="modal" data-bs-target="#createYear"
                                    style="width: 120px; height: 40px; border-radius: 4px;">
                                   បញ្ចូល
                                </a>
                            @else
                                <span></span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="modal fade" id="createYear" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="importModalLabel">បង្កើតឆ្នាំ</h3>
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center align-items-center" style="height: 20vh;">
                                <form id="uploadForm" action="{{ route('years.store') }}" method="POST"
                                    style="width: 30%;">
                                    @csrf
                                    <div class="mb-3 text-center">
                                        <input type="text" name="date_year" id="date_year" class="form-control mb-2"
                                            style="height: 40px;" placeholder="ឆ្នាំចាប់ផ្ដើម">
                                    </div>
                                    <div class="mb-3 text-center">
                                        <button type="submit" id="uploadButton" class="btn btn-primary"
                                            style="height: 40px; width: 100%;">
                                            បង្កើត
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
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
                        <th style="border: 1px solid black; width: 120px;">
                            <span> ល.រ</span>
                        </th>
                        <th style="border: 1px solid black;">
                            <span> ឆ្នាំ</span>
                        </th>
                        <th style="border: 1px solid black;">
                            <span> ស្ថានភាព</span>
                        </th>

                        @if (auth()->check() && auth()->user()->role == 'admin')
                            <th style="border: 1px solid black;">
                                <span> បិទ/បើក</span>
                            </th>
                        @else
                        @endif
                        @if (auth()->check() && auth()->user()->role == 'admin')
                            <th style="border: 1px solid black;" width="120px">
                                <span> សកម្មភាព</span>
                            </th>
                        @else
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($years as $year)
                        <tr>
                            @if (auth()->check() || auth()->user()->role === 'user')
                                <td>{{ $year->id }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($year->date_year)->format('Y') }} <!-- Display year only -->
                                </td>
                                <td>
                                    <span
                                        class="status-text {{ $year->status === 'active' ? 'text-success' : ($year->status === 'inactive' ? 'text-danger' : 'text-warning') }}">
                                        {{ ucfirst($year->status) }}
                                    </span>
                                </td>
                            @else
                                <span></span>
                            @endif
                            @if (auth()->check() && auth()->user()->role == 'admin')
                                <td>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-status" type="checkbox" role="switch"
                                                id="flexSwitchCheck{{ $year->id }}" data-id="{{ $year->id }}"
                                                style="height: 24px; width: 48px;"
                                                {{ $year->status === 'active' ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-primary {{ $year->status !== 'active' ? 'disabled' : '' }}"
                                        href="{{ route('years.edit', $year->id) }}">
                                        <i class="fas fa-edit" title="Edit"></i>
                                    </a>
                                    <form id="delete-form-{{ $year->id }}"
                                        action="{{ route('years.destroy', $year->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="btn btn-danger {{ $year->status !== 'active' ? 'disabled' : '' }}"
                                            onclick="confirmDelete({{ $year->id }})">
                                            <i class="fas fa-trash-alt" title="Delete"></i>
                                        </button>
                                    </form>
                                </td>
                            @else
                                <span></span>
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>
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
@endsection
