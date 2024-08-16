@extends('layouts.master')

@section('content-certificate-amount')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <form class="max-w-md mx-auto mt-3" method="GET" action="{{ route('certificate-amount') }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group my-3" style="width: 70%;">
                            <input type="search" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="ស្វែងរកទិន្នន័យ" aria-label="Search Address">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 50 50">
                                    <path
                                        d="M21 3C11.621094 3 4 10.621094 4 20C4 29.378906 11.621094 37 21 37C24.710938 37 28.140625 35.804688 30.9375 33.78125L44.09375 46.90625L46.90625 44.09375L33.90625 31.0625C36.460938 28.085938 38 24.222656 38 20C38 10.621094 30.378906 3 21 3ZM21 5C29.296875 5 36 11.703125 36 20C36 28.296875 29.296875 35 21 35C12.703125 35 6 28.296875 6 20C6 11.703125 12.703125 5 21 5Z">
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

    <div class="border-wrapper">
        <div class="result-total-table-container">
            <h3>តារាងទិន្នន័យសលាកបត្រសរុប</h3>
            <div class="table-container">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="border: 1px solid black; font-size: 14px; max-width: 120px;">លេខរៀង</th>
                            <th style="border: 1px solid black; font-size: 14px; max-width: 120px;">
                                <a
                                    href="{{ route('certificate-amount', ['sort_field' => 'report_key', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    លេខសម្គាល់កម្មវិធី
                                </a>
                            </th>
                            <th style="border: 1px solid black; font-size: 14px; max-width:260px;">ឈ្មោះសលាកបត្រ</th>
                            <th style="border: 1px solid black; font-size: 14px; max-width:260px;">ចំនួនទឹកប្រាក់</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($certificatesData as $certificateData)
                            <tr>
                                <td style="border: 1px solid black; text-align: center;">
                                    {{ $loop->iteration }}</td>
                                <td style="border: 1px solid black; text-align: center;">
                                    {{ $certificateData->report->subAccountKey->accountKey->key->code }} >
                                    {{ $certificateData->report->subAccountKey->accountKey->account_key }} >
                                    {{ $certificateData->report->subAccountKey ? $certificateData->report->subAccountKey->sub_account_key : 'N/A' }}>
                                    {{ $certificateData->report ? $certificateData->report->report_key : 'N/A' }}
                                </td>
                                <td style="border: 1px solid black; text-align: center;">
                                    {{ $certificateData->certificate ? $certificateData->certificate->name_certificate : 'N/A' }}
                                </td>
                                <td style="border: 1px solid black; text-align: center;">
                                    {{ number_format($certificateData->value_certificate, 0, ' ', ' ') }}
                                </td>
                            </tr>
                        @endforeach

                        @foreach ($totals['total_amount_by_group'] as $groupKey => $subAccountTotals)
                            @foreach ($subAccountTotals as $subAccountKey => $total)
                                <tr>
                                    <td colspan="3" style="border: 1px solid black; text-align: center;">
                                        <strong>សរុប</strong> ({{ $groupKey }} - {{ $subAccountKey }})
                                    </td>
                                    <td style="border: 1px solid black; text-align: center;">
                                        {{ number_format($total, 0, ' ', ' ') }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach

                        <tr>
                            <td colspan="3" style="border: 1px solid black; text-align: center;">
                                <strong>សរុបទាំងអស់</strong>
                            </td>
                            <td style="border: 1px solid black; text-align: center;">
                                {{ number_format($totals['total_amount_overall'], 0, ' ', ' ') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- {{ $certificatesData->appends(request()->query())->links() }} --}}
@endsection

@section('styles')
    <style>
        .border-wrapper {
            border: 2px solid black;
            padding: 10px;
        }

        .result-total-table-container {
            max-height: 600px;
            overflow-y: auto;
        }

        .table-container {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }

        h3 {
            text-align: center;
            font-family: 'OS Moul', sans-serif;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.js"></script>
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
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
