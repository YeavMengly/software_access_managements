@extends('layouts.master')
@section('form-plans-upload')
    <div class="d-flex justify-content-between align-items-center p-3">
        <a class="btn btn-danger d-flex justify-content-center align-items-center" href="{{ route('back') }}"
            style="width: 160px; height: 50px;">
            <i class="fas fa-arrow-left"></i>&nbsp;&nbsp;
        </a>
        <h3 style="font-weight: 700;">តារាងបេសកកម្មចំណាយ</h3>
        <div class="btn-group">

            <a class="btn btn-success d-flex justify-content-center align-items-center"
                href="{{ route('mission-planning.create') }}" style="width: 160px; height: 50px; border-radius: 4px;">
                បញ្ចូលទិន្នន័យ &nbsp;<i class="fas fa-plus" style="margin-left: 8px;"></i>
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif



    <div class="table-container p-3">
        <div class="d-flex justify-content-end mb-3">
            <div class="btn-group mb-3" role="group" aria-label="Mission Type Filter">
                <!-- Show 'All' Button -->
                <a href="{{ route('mission-planning.index') }}"
                    class="btn btn-outline-primary {{ !$selectedMissionType ? 'active' : '' }}">
                    ទាំងអស់
                </a>

                <!-- Generate Buttons Dynamically for Each Mission Type -->
                @foreach ($missionTypes as $type)
                    <a href="{{ route('mission-planning.index', ['mission_type' => $type->id]) }}"
                        class="btn btn-outline-primary {{ $selectedMissionType == $type->id ? 'active' : '' }}">
                        {{ $type->mission_type }}
                    </a>
                @endforeach
            </div>
        </div>

        <table class="table-border">
            <thead>
                <tr>
                    <th style="border: 1px solid black; align-items: center;">ល.រ</th>
                    <th style="border: 1px solid black;">លេខអនុគណនី</th>
                    <th style="border: 1px solid black;">លេខកូដកម្មវិធី</th>
                    <th style="border: 1px solid black;">ចំណាយបេសកកម្ម</th>
                    <th style="border: 1px solid black;">ប្រភេទបេសកកម្ម</th>
                    <th style="border: 1px solid black;">ស្ថានភាព</th>
                </tr>
            </thead>
            <tbody style="border: 1px solid black;">
                @foreach ($missionPlannings as $index => $mp)
                    <tr>
                        <td style="border: 1px solid black;">{{ $index + 1 }}</td>
                        <td style="border: 1px solid black;">{{ $mp->report->subAccountKey->sub_account_key }}</td>
                        <td style="border: 1px solid black;">{{ $mp->report->report_key ?? 'N/A' }}</td>
                        <td style="border: 1px solid black;">{{ number_format($mp->pay_mission, 0, ' ', ' ') }}</td>

                        <td style="border: 1px solid black;">{{ $mp->missionType->mission_type ?? 'N/A' }}</td>
                        <td style="border: 1px solid black; text-align: center;">
                            <div style="display: flex; justify-content: center; gap: 5px;">
                                <a href="{{ route('mission-planning.edit', $mp->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form id="delete-form-{{ $mp->id }}"
                                    action="{{ route('mission-planning.destroy', $mp->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete({{ $mp->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <!-- Total Row -->
            <tfoot>
                <tr style="background:  rgb(181, 245, 86);">
                    <td colspan="3" style="border: 1px solid black; text-align: center;"><strong>សរុបថវិកា</strong></td>
                    <td style="border: 1px solid black;"><strong>{{ number_format($totalAmount, 0, ' ', ' ') }}</strong></td>
                    <td colspan="2" style="border: 1px solid black;"></td>
                </tr>
            </tfoot>
        </table>

    </div>
@endsection

@section('styles')
    <style>
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

        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
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
@endsection
