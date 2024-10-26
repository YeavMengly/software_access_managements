@extends('layouts.master')

@section('content-certificate-amount')
    <div class="row mt-4 ml-4">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <a class="btn btn-danger" href="{{ url('/card_certificate') }}">
                    <i class="fas fa-arrow-left"></i> ត្រឡប់ក្រោយ
                </a>
            </div>
            {{-- <form class="max-w-md mx-auto mt-3" method="GET" action="{{ route('certificate-amount') }}">
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
            </form> --}}
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="border-wrapper ml-4 mr-4">
        <div class="result-total-table-container">
            <h3>តារាងទិន្នន័យសលាកបត្រសរុប</h3>
            <div class="table-container">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="border: 1px solid black; font-size: 14px;">ជំពូក</th>
                            <th style="border: 1px solid black; font-size: 14px;">គណនី</th>
                            <th style="border: 1px solid black; font-size: 14px;">អនុគណនី</th>
                            <th style="border: 1px solid black; font-size: 14px;">
                                <a
                                    href="{{ route('certificate-amount', ['sort_field' => 'report_key', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    លេខសម្គាល់កម្មវិធី
                                </a>
                            </th>

                            {{-- <th style="border: 1px solid black; font-size: 14px;">ឈ្មោះសលាកបត្រ</th> --}}
                            <th style="border: 1px solid black; font-size: 14px;">ចំនួនទឹកប្រាក់</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($totals['code'] as $codeId => $codeTotals)
                            <tr>
                                <td colspan="1" style="border: 1px solid black; text-align: center;">
                                    {{ $codeId }}
                                </td>
                                <td colspan="1" style="border: 1px solid black; text-align: center;"></td>
                                <td colspan="1" style="border: 1px solid black; text-align: center;"></td>
                                <td colspan="1" style="border: 1px solid black; text-align: right;"></td>
                                <td style="border: 1px solid black; text-align: center;">
                                    {{ number_format($codeTotals['value_certificate'], 0, ' ', ' ') }}
                                </td>
                            </tr>

                            @foreach ($totals['accountKey'][$codeId] as $accountKeyId => $accountKeyTotals)
                                <tr>
                                    <td colspan="1" style="border: 1px solid black; text-align: center;"></td>
                                    <td colspan="1" style="border: 1px solid black; text-align: center;">
                                        {{ $accountKeyId }}:
                                    </td>
                                    <td colspan="1" style="border: 1px solid black; text-align: center;"></td>
                                    <td colspan="1" style="border: 1px solid black; text-align: center;"></td>
                                    <td style="border: 1px solid black; text-align: center;">
                                        {{ number_format($accountKeyTotals['value_certificate'], 0, ' ', ' ') }}
                                    </td>
                                </tr>

                                @foreach ($totals['subAccountKey'][$codeId][$accountKeyId] as $subAccountKeyId => $subAccountKeyTotals)
                                    <tr>
                                        <td colspan="1" style="border: 1px solid black; text-align: center;"></td>
                                        <td colspan="1" style="border: 1px solid black; text-align: center;"></td>
                                        <td colspan="1" style="border: 1px solid black; text-align: center;">
                                            {{ $subAccountKeyId }}
                                        </td>
                                        <td colspan="1" style="border: 1px solid black; text-align: right;"></td>
                                        <td style="border: 1px solid black; text-align: center;">
                                            {{ number_format($subAccountKeyTotals['value_certificate'], 0, ' ', ' ') }}
                                        </td>
                                    </tr>

                                    @foreach ($totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId] as $reportKeyId => $reportKeyTotals)
                                        <tr>
                                            <td colspan="1" style="border: 1px solid black; text-align: center;"></td>
                                            <td colspan="1" style="border: 1px solid black; text-align: center;"></td>
                                            <td colspan="1" style="border: 1px solid black; text-align: center;"></td>
                                            <td colspan="1" style="border: 1px solid black; text-align: center;">
                                                {{ $reportKeyId }}
                                            </td>
                                            <td style="border: 1px solid black; text-align: center;">
                                                {{ number_format($reportKeyTotals['value_certificate'], 0, ' ', ' ') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach



                        {{-- Sum Report-Key --}}
                        {{-- @foreach ($totals['total_amount_by_report_key'] as $reportKey => $total)
                            <tr>
                                <td colspan="3" style="border: 1px solid black; text-align: center;">
                                    <strong>សរុប</strong>: ការរាយការណ៍ ({{ $reportKey }})
                                </td>
                                <td style="border: 1px solid black; text-align: center;">
                                    {{ number_format($total, 0, ' ', ' ') }}
                                </td>
                            </tr>
                        @endforeach --}}


                        {{-- Sum Sub-Account-Key --}}
                        {{-- @foreach ($totals['total_amount_by_group'] as $groupSubAccountKey => $subAccountTotals)
                            @foreach ($subAccountTotals as $subAccountKey => $total)
                                <tr>
                                    <td colspan="3" style="border: 1px solid black; text-align: center;">
                                        <strong>សរុប</strong> អនុគណនី({{ $groupSubAccountKey }} - {{ $subAccountKey }})
                                    </td>
                                    <td style="border: 1px solid black; text-align: center;">
                                        {{ number_format($total, 0, ' ', ' ') }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach --}}

                        {{-- Sum Account-Key --}}
                        {{-- @foreach ($totals['total_amount_by_account_key'] as $groupAccountKey => $accountTotals)
                            @foreach ($accountTotals as $accountKey => $total)
                                <tr>
                                    <td colspan="3" style="border: 1px solid black; text-align: center;">
                                        <strong>សរុប</strong> គណនី({{ $groupAccountKey }} - {{ $accountKey }})
                                    </td>
                                    <td style="border: 1px solid black; text-align: center;">
                                        {{ number_format($total, 0, ' ', ' ') }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach --}}

                        {{-- Sum Key --}}
                        {{-- @foreach ($totals['total_amount_by_key'] as $key => $total)
                            <tr>
                                <td colspan="3" style="border: 1px solid black; text-align: center;">
                                    <strong>សរុប</strong>: ជំពូក{{ $key }}
                                </td>
                                <td style="border: 1px solid black; text-align: center;">
                                    {{ number_format($total, 0, ' ', ' ') }}
                                </td>
                            </tr>
                        @endforeach --}}

                        {{-- Sum Total --}}
                        <tr>
                            <td colspan="4" style="border: 1px solid black; text-align: center;">
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
@endsection

@section('styles')
    <style>
        .border-wrapper {
            border: 2px solid black;
            padding: 10px;
        }

        .result-total-table-container {
            margin-top: 20px;
        }

        .table-container {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }

        h3 {
            text-align: center;
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 25px;
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fullscreenButton = document.getElementById('fullscreen-btn');
            const container = document.querySelector('.fullscreen-container');

            function toggleFullscreen() {
                if (document.fullscreenElement) {
                    document.exitFullscreen();
                } else {
                    document.documentElement.requestFullscreen();
                }
            }

            function updateButtonIcon() {
                if (document.fullscreenElement) {
                    fullscreenButton.innerHTML = '<i class="fas fa-compress"></i>'; // Zoom Out icon
                } else {
                    fullscreenButton.innerHTML = '<i class="fas fa-expand"></i>'; // Zoom In icon
                }
            }

            fullscreenButton.addEventListener('click', function() {
                toggleFullscreen();
            });

            // Listen for fullscreen change events to update the button icon
            document.addEventListener('fullscreenchange', updateButtonIcon);
            document.addEventListener('webkitfullscreenchange', updateButtonIcon);
            document.addEventListener('mozfullscreenchange', updateButtonIcon);
            document.addEventListener('MSFullscreenChange', updateButtonIcon);

            // Set initial icon based on fullscreen state
            updateButtonIcon();
        });
    </script>
@endsection
