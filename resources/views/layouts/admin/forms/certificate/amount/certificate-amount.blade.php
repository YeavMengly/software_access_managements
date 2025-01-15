@extends('layouts.master')

@section('content-certificate-amount')
    <div class="row mt-4 ml-4">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <a class="btn btn-danger" href="{{ url('/card_certificate') }}">
                    <i class="fas fa-arrow-left"></i> ត្រឡប់ក្រោយ
                </a>
            </div>
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
