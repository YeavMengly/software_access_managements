@extends('layouts.master')

@section('content-certificate')
    <div class="row  mt-4 ml-4 mr-4">
        <div class="col-lg-12 margin-tb mb-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <a class="btn btn-danger" href="{{ url('/card_certificate') }}"> <i class="fas fa-arrow-left"></i>
                    ត្រឡប់ក្រោយ</a>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <h2 style="font-weight: 700;">តារាងឈ្មោះសលាកបត្រ</h2>
                <div class="btn-container">
                    <a id="submit-button" class="btn btn-success" href="{{ route('certificate.create') }}">
                        បញ្ចូលទិន្នន័យ
                    </a>
                    <div id="loader" class="loader m-2"></div>
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

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- @if ($certificates->count() > 0) --}}
    <div class="border-wrapper ml-4 mr-4">
        <div class="result-total-table-container">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="border: 1px solid black; font-size: 14px; width: 180px;">លេខរៀង</th>
                        <th style="border: 1px solid black; font-size: 14px; width:260px;">ឈ្មោះសលាកបត្រ</th>
                        <th style="border: 1px solid black;" width="200px">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($certificates as $certificate)
                        <tr>
                            <td style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                            <td style="border: 1px solid black; text-align: center;">
                                {{ $certificate->name_certificate }}</td>
                            <td style="border: 1px solid black; text-align: center; justify-content: center;">
                                <form id="delete-form-{{ $certificate->id }}"
                                    action="{{ route('certificate.destroy', $certificate->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                {{-- <a class="btn btn-info" href="{{ route('certificate.show', $certificate->id) }}">
                                <i class="fas fa-eye"></i>
                            </a> --}}
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
                            <td colspan="13" style="text-align: center;">គ្មានទិន្នន័យ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Custom Pagination Links -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    @if ($certificates->onFirstPage())
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $certificates->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                    @endif

                    @for ($i = 1; $i <= $certificates->lastPage(); $i++)
                        <li class="page-item {{ $i == $certificates->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $certificates->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($certificates->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $certificates->nextPageUrl() }}" aria-label="Next">
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
        </div>
    </div>
@endsection


@section('styles')
    <style>
        .border-wrapper {
            /* border: 2px solid black; */
            padding: 10px;
        }

        .result-total-table-container {
            max-height: 100vh;
            overflow-y: auto;
        }

        .btn-container {
            position: relative;
            display: inline-block;
        }

        #submit-button {
            position: relative;
            padding-right: 50px;
           


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
    </style>
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

    {{-- Request process  --}}
    <script>
        // Confirm Delete
        document.getElementById('submit-button').addEventListener('click', function() {
            const loader = document.getElementById('loader');
            loader.style.display = 'block'; // Show the loader
            this.innerHTML = 'កំពុងដំណើរការ... <div id="loader" class="loader"></div>'; // Change button text

            // Optionally, you can handle the redirect or form submission here
            setTimeout(() => {
                // Redirect or handle form submission
                window.location.href = this.getAttribute('href'); // Example redirect
            }, 1000); // Adjust the delay as needed
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
