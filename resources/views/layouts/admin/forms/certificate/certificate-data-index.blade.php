@extends('layouts.master')

@section('content-certificate-data')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="d-flex justify-content-between align-items-center">
                <a class="btn btn-danger d-flex align-items-center justify-content-center" href="{{ route('back') }}"
                    style="width: 120px; height: 40px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h3 style="font-weight: 500;">តារាងទិន្នន័យសលាកបត្រ</h3>

                <a id="submit-button" class="btn btn-primary d-flex align-items-center justify-content-center"
                    href="{{ route('certificate-data.create') }}" style="width: 120px; height: 40px; border-radius: 4px;">
                    បញ្ចូល

                </a>
            </div>

            <form class="max-w-md mx-auto mt-2" method="GET" action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group my-3" style="width: 180px; display: flex; align-items: center;">
                            <!-- Search Input -->
                            <input type="search" name="search" value="{{ request('search') }}"
                                class="form-control" placeholder="ស្វែងរកអនុគណនី" aria-label="Search Sub Account Key"
                                style="flex-grow: 1; height: 40px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                            <!-- Search Button -->
                            <button type="submit" class="btn btn-primary"
                                style="width: 40px; height: 40px; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 50 50" fill="white">
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

    <div class="border-wrapper ml-2 mr-2">
        <div class="d-flex justify-content-end">
            <div class="btn-group mb-3" role="group" aria-label="Mission Type Filter">
                <!-- Show 'All' Button -->
                <a href="{{ route('certificate-data.index') }}"
                    class="btn btn-outline-primary {{ !$selectedMissionType ? 'active' : '' }}">
                    ទាំងអស់
                </a>

                <!-- Generate Buttons Dynamically for Each Mission Type -->
                @foreach ($missionTypes as $type)
                    <a href="{{ route('certificate-data.index', ['mission_type' => $type->id]) }}"
                        class="btn btn-outline-primary {{ $selectedMissionType == $type->id ? 'active' : '' }}">
                        {{ $type->mission_type }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="result-total-table-container">

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
            <table class="table table-striped table-hover ">
                <thead>
                    <tr>
                        <th style="border: 1px solid black; width: 120px;">អនុគណនី</th>
                        <th style="border: 1px solid black; width: 120px;">កម្មវិធី</th>
                        <th style="border: 1px solid black;">ថវិកា</th>
                        <th style="border: 1px solid black; width: 120px;">ប្រភេទ</th>
                        <th style="border: 1px solid black; width: 120px;">ថ្ងៃខែឆ្នាំ</th>
                        <th style="border: 1px solid black;">ឯកសារភ្ជាប់</th>
                        <th style="border: 1px solid black; width: 120px;">ស្ថានភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($certificatesData->isEmpty())
                        <tr>
                            <td colspan="8" style="text-align: center; border: 1px solid black; font-size: 16px;">
                                គ្មានទិន្ន័យ
                            </td>
                        </tr>
                    @else
                        @foreach ($certificatesData as $index => $certificateData)
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    {{ $certificateData->report && $certificateData->report->subAccountKey ? $certificateData->report->subAccountKey->sub_account_key : 'N/A' }}
                                </td>
                                <td style="border: 1px solid black; text-align: center;">
                                    {{ $certificateData->report ? $certificateData->report->report_key : 'N/A' }}
                                </td>

                                <td style="border: 1px solid black; text-align: center;">
                                    {{ number_format($certificateData->value_certificate, 0, ' ', ' ') }}
                                </td>
                                <td style="border: 1px solid black;">
                                    {{ $certificateData->missionType->mission_type ?? 'N/A' }}</td>
                                <td style="border: 1px solid black;">
                                    {{ $certificateData->date_certificate ?? 'N/A' }}</td>
                                <td style="border: 1px solid black;">
                                    @if ($certificateData->attachments)
                                        <div style="margin-top: 5px;">
                                            @foreach (json_decode($certificateData->attachments) as $attachment)
                                                <a href="{{ Storage::url($attachment) }}" target="_blank"
                                                    class="btn btn-info btn-sm">
                                                    📄PDF
                                                </a>
                                                <br>
                                            @endforeach
                                        </div>
                                    @else
                                        <span>No attachment available</span>
                                    @endif
                                </td>

                                <td style="border: 1px solid black; text-align: center; width: 120px;">
                                    <div style="display: flex; justify-content: center; gap: 5px;">
                                        <form id="delete-form-{{ $certificateData->id }}"
                                            action="{{ route('certificate-data.destroy', $certificateData->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a class="btn btn-primary btn-sm"
                                            href="{{ route('certificate-data.edit', $certificateData->id) }}">
                                            <i class="fas fa-edit" title="Edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $certificateData->id }})">
                                            <i class="fas fa-trash-alt" title="Delete"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr style="background:  rgb(86, 227, 245);">
                        <td colspan="3" style="border: 1px solid black; text-align: center;"><strong>សរុបថវិកា</strong>
                        </td>
                        <td style="border: 1px solid black;">
                            <strong>{{ number_format($totalAmount, 0, ' ', ' ') }}</strong>
                        </td>
                        <td colspan="4" style="border: 1px solid black;"></td>
                    </tr>
                </tfoot>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <!-- Custom Pagination Links -->
                <div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item{{ $certificatesData->onFirstPage() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $certificatesData->previousPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $certificatesData->lastPage(); $i++)
                                <li class="page-item{{ $certificatesData->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link"
                                        href="{{ $certificatesData->url($i) }}&per_page={{ request('per_page') }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item{{ !$certificatesData->hasMorePages() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $certificatesData->nextPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div>
                    <p class="text-muted">បង្ហាញ {{ $certificatesData->firstItem() }} ដល់
                        {{ $certificatesData->lastItem() }}
                        នៃ
                        {{ $certificatesData->total() }} លទ្ធផល</p>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('styles')
    <style>
        .border-wrapper {
            padding-left: 16px;
            padding-right: 16px;
        }

        .description {
            height: 220px;
            overflow-y: auto;
        }

        .table-container {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
        .wrap-text {
            white-space: nowrap;
        }
    </style>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.js"></script>
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
    </script>
@endsection
