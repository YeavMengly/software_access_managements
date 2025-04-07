@extends('layouts.master')

@section('form-mandate-index')

    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="d-flex justify-content-between align-items-center">
                <a class="btn btn-danger d-flex justify-content-center align-items-center" href="{{ route('back') }}"
                    style="width: 120px; height: 40px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h3 style="font-weight: 500;">តារាងអាណត្តិ</h3>
                <div class="btn-group">
                    <a id="submit-button" class="btn btn-primary d-flex justify-content-center align-items-center"
                        href="{{ route('mandates.create') }}" style="width: 120px; height: 40px; border-radius: 4px;">
                        បញ្ចូល
                    </a>


                    {{-- Include Loading Modal --}}
                    @include('partials.loading-modal')
                </div>
            </div>


            <form id="filterForm" class="max-w-md mx-auto mt-3" method="GET" action="{{ route('mandates.index') }}"
                onsubmit="return validateDateField()">
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
                                ស្វែងរក
                            </button>
                            <button type="button" id="resetBtn" class="btn btn-danger" style="width: 120px; height: 40px;"
                                onclick="resetForm()">
                                កំណត់ឡើងវិញ
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

    <div class="border-wrapper ml-2 mr-2">
        <div class="d-flex justify-content-end ">
            <div class="btn-group mb-3" role="group" aria-label="Mission Type Filter">
                <!-- Show 'All' Button -->
                <a href="{{ route('mandates.index') }}"
                    class="btn btn-outline-primary {{ !$selectedMissionType ? 'active' : '' }}">
                    ទាំងអស់
                </a>

                <!-- Generate Buttons Dynamically for Each Mission Type -->
                @foreach ($missionTypes as $type)
                    <a href="{{ route('mandates.index', ['mission_type' => $type->id]) }}"
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

            <table class="table-border">
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


                <tbody style="border: 1px solid black;">
                    @if ($mandates->isEmpty())
                        <tr>
                            <td colspan="8" style="text-align: center; border: 1px solid black; font-size: 16px;">
                                គ្មានទិន្ន័យ
                            </td>
                        </tr>
                    @else
                        @foreach ($mandates as $index => $md)
                            <tr>

                                <td style="border: 1px solid black; text-align: center;">
                                    {{ ($mandates->currentPage() - 1) * $mandates->perPage() + $index + 1 }}

                                </td>

                                <td style="border: 1px solid black; text-align: center;">
                                    {{ $md->dataMandate && $md->dataMandate->subAccountKey ? $md->dataMandate->subAccountKey->sub_account_key : 'N/A' }}
                                </td>
                                <td style="border: 1px solid black; text-align: center;">
                                    {{ $md->dataMandate ? $md->dataMandate->report_key : 'N/A' }}
                                </td>

                                <td style="border: 1px solid black;">{{ number_format($md->value_mandate, 0, ' ', ' ') }}
                                </td>
                                <td style="border: 1px solid black;">
                                    {{ $md->missionType->mission_type ?? 'គ្មានទិន្នន័យ' }}
                                </td>
                                <td style="border: 1px solid black;">{{ $md->date_mandate ?? 'គ្មានទិន្នន័យ' }}</td>

                                <td style="border: 1px solid black;">
                                    @if ($md->attachments)
                                        <div style="margin-top: 5px;">
                                            @foreach (json_decode($md->attachments) as $attachment)
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

                                <td style="border: 1px solid black; text-align: center;">
                                    <div style="display: flex; justify-content: center; gap: 5px;">
                                        <a href="{{ route('mandates.edit', $md->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form id="delete-form-{{ $md->id }}"
                                            action="{{ route('mandates.destroy', $md->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete({{ $md->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
                <tfoot>
                    <tr style="background:  rgb(86, 227, 245);">
                        <td colspan="3" style="border: 1px solid black; text-align: center;">
                            <strong>សរុបថវិកា</strong>
                        </td>
                        <td style="border: 1px solid black;"><strong>{{ number_format($totalAmount, 2) }}</strong></td>
                        <td colspan="4" style="border: 1px solid black;"></td>
                    </tr>
                </tfoot>
            </table>


            <div class="d-flex justify-content-between align-items-center mt-4">
                <!-- Custom Pagination Links -->
                <div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item{{ $mandates->onFirstPage() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $mandates->previousPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $mandates->lastPage(); $i++)
                                <li class="page-item{{ $mandates->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link"
                                        href="{{ $mandates->url($i) }}&per_page={{ request('per_page') }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item{{ !$mandates->hasMorePages() ? ' disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $mandates->nextPageUrl() }}&per_page={{ request('per_page') }}"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>

                        </ul>
                    </nav>
                </div>
                <div>
                    <p class="text-muted">បង្ហាញ {{ $mandates->firstItem() }} ដល់
                        {{ $mandates->lastItem() }}
                        នៃ
                        {{ $mandates->total() }} លទ្ធផល</p>
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
    <script>
        function confirmDelete(missionId) {
            Swal.fire({
                title: 'តើអ្នកពិតជាចង់លុបមែនទេ?',
                text: "អ្នកមិនអាចស្តារវិញបានទេ!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'បាទ/ចាស, លុប!',
                cancelButtonText: 'បោះបង់',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + missionId).submit();
                }
            });
        }
    </script>
    <script>
        function resetForm() {
            // Clear all form input fields
            document.querySelectorAll('#filterForm input').forEach(input => input.value = '');

            // Optionally reload the page to reset filters in the URL
            window.location.href = "{{ route('mandates.index') }}";
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

    <script>
        function validateDateField() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate && startDate > endDate) {
                alert("ថ្ងៃចាប់ផ្តើម មិនអាចធំជាង ថ្ងៃបញ្ចប់បានទេ!");
                return false;
            }
            return true;
        }
    </script>

    <script>
        function resetForm() {
            // Clear all input fields
            document.querySelector('input[name="sub_account_key_id"]').value = '';
            document.querySelector('input[name="report_key"]').value = '';
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';

            // Optionally, submit the form to reset the query
            document.getElementById('filterForm').submit();
        }
    </script>
@endsection
