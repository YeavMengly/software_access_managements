@extends('layouts.master')

@section('content-certificate')
    <div class="row  mt-4 ml-2 mr-4">
        <div class="col-lg-12 margin-tb mb-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <a class="btn btn-danger" href="{{ url('/card_certificate') }}"> <i class="fas fa-arrow-left"></i>
                    ត្រឡប់ក្រោយ</a>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <h2 style="font-weight: 700;">តារាងទិន្នន័យសលាកបត្រ</h2>
                <a class="btn btn-success" href="{{ route('certificate.create') }}">បញ្ចូលទិន្នន័យ</a>
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

    @if ($message)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($certificates->count() > 0)
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th style="border: 1px solid black; font-size: 14px; width: 180px;">លេខរៀង</th>
                    <th style="border: 1px solid black; font-size: 14px; width:260px;">ឈ្មោះសលាកបត្រ</th>
                    <th style="border: 1px solid black;" width="200px">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($certificates as $certificate)
                    <tr>
                        <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                        <td style="border: 1px solid black; text-align: center;">{{ $certificate->name_certificate }}</td>
                        <td style="border: 1px solid black; text-align: center;">
                            <form id="delete-form-{{ $certificate->id }}"
                                action="{{ route('certificate.destroy', $certificate->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <a class="btn btn-info" href="{{ route('certificate.show', $certificate->id) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-primary" href="{{ route('certificate.edit', $certificate->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $certificate->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- {{ $certificates->appends(request()->query())->links() }} --}}
    @endif
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"
        integrity="sha512-nh8KkfWJZK0C0H8z8Z0z8W3R7ZFl8k5Hq9O1O7s9O0P8+Hybz5VQ1cDUNUr+M+4H0ttD5F5lsS4uRUmxT1b4g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form corresponding to the certificate ID
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
