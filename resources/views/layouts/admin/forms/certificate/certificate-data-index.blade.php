@extends('layouts.master')

@section('content-certificate-data')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="d-flex justify-content-between align-items-center">
                <a class="btn btn-danger d-flex align-items-center justify-content-center" href="{{ route('back') }}"
                    style="width: 120px; height: 40px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h3 style="font-weight: 500;">តារាងសលាកបត្រ</h3>
                <a id="submit-button" class="btn btn-primary d-flex align-items-center justify-content-center"
                    href="{{ route('certificate-data.create') }}" style="width: 120px; height: 40px; border-radius: 4px;">
                    បញ្ចូល
                </a>

                {{-- Include Loading Modal --}}
                @include('partials.loading-modal')

            </div>

            <form id="filterForm" class="max-w-md mx-auto mt-3" method="GET"
                action="{{ route('certificate-data.index') }}" onsubmit="return validateDateField()">
                <div class="row mb-3">
                    <div class="col-md-2 d-flex">
                        <input type="text" name="sub_account_key_id" value="{{ request('sub_account_key_id') }}"
                            class="form-control mb-2" placeholder="អនុគណនី" style="width: 120px; height: 40px;">
                        &nbsp;
                        <input type="text" name="report_key" value="{{ request('report_key') }}"
                            class="form-control mb-2" placeholder="កូដកម្មវិធី" style="width: 120px; height: 40px;">
                        &nbsp;
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="form-control" style="height: 40px; width: 200px;">
                        &nbsp;
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="form-control" style="height: 40px; width: 200px;">
                    </div>

                    <div class="col-md-12">
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary mr-2" style="width: 120px; height: 40px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 50 50">
                                    <path d="..."></path>
                                </svg>
                                ស្វែងរក
                            </button>
                            <button type="button" id="resetBtn" class="btn btn-danger" style="width: 120px; height: 40px;"
                                onclick="resetForm()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-x-circle" viewBox="0 0 16 16">
                                    <path d="..."></path>
                                </svg>
                                កំណត់ឡើងវិញ
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="border-wrapper ml-2 mr-2">
        <div class="d-flex justify-content-end">
            {{-- <div class="btn-group mb-3" role="group" aria-label="Mission Type Filter">
                <a href="{{ route('certificate-data.index') }}"
                    class="btn btn-outline-primary {{ !$selectedMissionType ? 'active' : '' }}">
                    ទាំងអស់
                </a>
                @foreach ($missionTypes as $type)
                    <a href="{{ route('certificate-data.index', ['mission_type' => $type->id]) }}"
                        class="btn btn-outline-primary {{ $selectedMissionType == $type->id ? 'active' : '' }}">
                        {{ $type->mission_type }}
                    </a>
                @endforeach
            </div> --}}
            <div class="btn-group mb-3" role="group" aria-label="Mission Type Filter">
                <a href="{{ route('certificate-data.index', array_merge(request()->all(), ['mission_type' => ''])) }}"
                    class="btn btn-outline-primary {{ empty($selectedMissionType) ? 'active' : '' }}">
                    ទាំងអស់
                </a>
                @foreach ($missionTypes as $type)
                    <a href="{{ route('certificate-data.index', array_merge(request()->all(), ['mission_type' => $type->id])) }}"
                        class="btn btn-outline-primary {{ $selectedMissionType == $type->id ? 'active' : '' }}">
                        {{ $type->mission_type }}
                    </a>
                @endforeach
            </div>

        </div>
        <div class="result-total-table-container">
            <div class="d-flex justify-content-end mb-2">
                <div style="width: 120px;">
                    <select name="per_page" class="form-control" onchange="window.location.href = this.value;">
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 25]) }}"
                            {{ request('per_page') == 25 ? 'selected' : '' }}>បង្ហាញ 25</option>
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}"
                            {{ request('per_page') == 50 ? 'selected' : '' }}>បង្ហាញ 50</option>
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 100]) }}"
                            {{ request('per_page') == 100 ? 'selected' : '' }}>បង្ហាញ 100</option>
                    </select>
                </div>

            </div>
            <table class="table table-striped table-hover ">
                <thead>
                    <tr>
                        <th style="border: 1px solid black; width: 120px;">ល.រ</th>
                        <th style="border: 1px solid black; width: 120px;">អនុគណនី</th>
                        <th style="border: 1px solid black; width: 120px;">កម្មវិធី</th>
                        <th style="border: 1px solid black;">ថវិកា</th>
                        <th style="border: 1px solid black; width: 120px;">ប្រភេទ</th>
                        <th style="border: 1px solid black; width: 120px;">កាលបរិច្ឆេទ</th>
                        <th style="border: 1px solid black; ">ឯកសារភ្ជាប់</th>
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
                                    {{ ($certificatesData->currentPage() - 1) * $certificatesData->perPage() + $index + 1 }}
                                </td>

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
                                                    class="btn btn-light btn-sm" style="margin-bottom: 5px;"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Open File">
                                                    <i class="fa fa-folder-open"></i>
                                                </a>

                                                <a href="{{ Storage::url($attachment) }}" download
                                                    class="btn btn-success btn-sm" style="margin-bottom: 5px;"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Download File">
                                                    <i class="fa fa-download"></i>
                                                </a>

                                                <br>
                                            @endforeach
                                        </div>
                                    @else
                                        <span>គ្មានឯកសារ</span>
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
                        <td colspan="5" style="border: 1px solid black;"></td>
                    </tr>
                </tfoot>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <!-- Existing Pagination Code -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            {{-- Previous Button --}}
                            <li class="page-item{{ $certificatesData->onFirstPage() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $certificatesData->previousPageUrl() ? request()->fullUrlWithQuery(array_merge(request()->query(), ['page' => $certificatesData->currentPage() - 1])) : '#' }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>

                            {{-- Page Numbers --}}
                            @for ($i = 1; $i <= $certificatesData->lastPage(); $i++)
                                <li class="page-item{{ $certificatesData->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link"
                                        href="{{ request()->fullUrlWithQuery(array_merge(request()->query(), ['page' => $i])) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            {{-- Next Button --}}
                            <li class="page-item{{ !$certificatesData->hasMorePages() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $certificatesData->nextPageUrl() ? request()->fullUrlWithQuery(array_merge(request()->query(), ['page' => $certificatesData->currentPage() + 1])) : '#' }}"
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

        h5 {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
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
        function resetForm() {
            // Clear all form input fields
            document.querySelectorAll('#filterForm input').forEach(input => input.value = '');

            // Optionally reload the page to reset filters in the URL
            window.location.href = "{{ route('certificate-data.index') }}";
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
