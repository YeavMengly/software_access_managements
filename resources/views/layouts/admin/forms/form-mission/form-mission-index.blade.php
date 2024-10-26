@extends('layouts.master')
@section('content-mission')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4 ">
            <div class="col-lg-12 margin-tb mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 style="font-weight: 700;">តារាងរបាយការណ៏ចំណាយបេសកកម្ម​ ឆ្នាំ២០២៤</h2>
                    <a class="btn btn-success" href="{{ route('missions.create') }}">បញ្ចូលទិន្នន័យ</a>
                </div>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-container">
        <table class="table-border">
            <thead>
                <tr>
                    <th rowspan="2" style="border: 2px solid black; align-items: center;">ល.រ</th>
                    <th rowspan="2" style="border: 2px solid black;">គោត្តនាម​​ និងនាម</th>
                    <th rowspan="2" style="border: 2px solid black;">តួនាទី</th>
                    <th rowspan="2" style="border: 2px solid black;">ប្រភេទមុខតំណែង</th>
                    <th colspan="2" style="border: 2px solid black;">លិខិតបញ្ជាបេសកកម្ម</th>
                    <th rowspan="2" style="border: 2px solid black;">កម្មវត្ថុនៃការចុះបេសកកមម្ម</th>
                    <th rowspan="2" style="border: 2px solid black;">ទីកន្លែង</th>
                    <th colspan="2" style="border: 2px solid black;">កាលបរិច្ឆេទចុះបេសកកម្ម</th>
                    <th rowspan="2" style="border: 2px solid black;">ចំនួនថ្ងៃ</th>
                    <th rowspan="2" style="border: 2px solid black;">ចំនួនយប់</th>
                    <th rowspan="2" style="border: 2px solid black;">សោហ៊ុយធ្វើដំណើរ</th>
                    <th colspan="2" style="border: 2px solid black;">ប្រាក់ហោប៉ៅ</th>
                    <th colspan="2" style="border: 2px solid black;">ប្រាក់ហូបចុក</th>
                    <th colspan="2" style="border: 2px solid black;">ប្រាក់ស្នាក់នៅ</th>
                    <th rowspan="2" style="border: 2px solid black;">សោហ៊ុយផ្សេងៗ</th>
                    <th rowspan="2" style="border: 2px solid black;">ទឹកប្រាក់សរុប</th>
                    <th rowspan="2" style="border: 2px solid black;">Actions</th>
                </tr>
                <tr>
                    <th style="border: 2px solid black;">លេខ</th>
                    <th style="border: 2px solid black;">កាលបរិច្ឆេទ</th>
                    <th style="border: 2px solid black;">ចាប់ផ្ដើម</th>
                    <th style="border: 2px solid black;">ត្រឡប់</th>
                    <th style="border: 2px solid black;">របប</th>
                    <th style="border: 2px solid black;">សរុប</th>
                    <th style="border: 2px solid black;">របប</th>
                    <th style="border: 2px solid black;">សរុប</th>
                    <th style="border: 2px solid black;">របប</th>
                    <th style="border: 2px solid black;">សរុប</th>
                </tr>
            </thead>
            <tbody style="border: 2px solid black;">
                @php
                    $currentPersonId = null;
                @endphp
                @foreach ($missions as $index => $mission)
                    <tr>
                        <td style="border: 2px solid black;">{{ $index + 1 }}</td>
                        <td style="border: 2px solid black; width:180px;">{{ $mission->name }}</td>
                        <td style="border: 2px solid black; width: 100px;">{{ $mission->role }}</td>
                        <td style="border: 2px solid black;">{{ $mission->position_type }}</td>

                        <td style="border: 2px solid black;">{{ $mission->letter_number }}</td>
                        <td style="border: 2px solid black; width: 110px;">{{ $mission->letter_date }}</td>
                        <td style="border: 2px solid black;">{{ $mission->mission_objective }}</td>

                        <td style="border: 2px solid black;">{{ $mission->location }}</td>
                        <td style="border: 2px solid black; width: 110px;">{{ $mission->mission_start_date }}</td>
                        <td style="border: 2px solid black; width: 110px;">{{ $mission->mission_end_date }}</td>
                        <td style="border: 2px solid black;">{{ $mission->days_count }}</td>
                        <td style="border: 2px solid black;">{{ $mission->nights_count }}</td>
                        <td style="border: 2px solid black;">{{ number_format($mission->travel_allowance, 0, '.', ',') }}
                        </td>
                        <td style="border: 2px solid black;">{{ number_format($mission->pocket_money, 0, '.', ',') }}</td>
                        <td style="border: 2px solid black;">{{ number_format($mission->total_pocket_money, 0, '.', ',') }}
                        </td>
                        <td style="border: 2px solid black;">{{ number_format($mission->meal_money, 0, '.', ',') }}</td>
                        <td style="border: 2px solid black;">{{ number_format($mission->total_meal_money, 0, '.', ',') }}
                        </td>
                        <td style="border: 2px solid black;">
                            {{ number_format($mission->accommodation_money, 0, '.', ',') }}</td>
                        <td style="border: 2px solid black;">
                            {{ number_format($mission->total_accommodation_money, 0, '.', ',') }}</td>
                        <td style="border: 2px solid black;">{{ number_format($mission->other_allowances, 0, '.', ',') }}
                        </td>
                        <td style="border: 2px solid black;">{{ number_format($mission->final_total, 0, '.', ',') }}</td>
                        <td style="border: 2px solid black;">
                            <div style="display: flex; gap: 5px;">
                                <a href="{{ route('missions.edit', $mission->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>  
                                <form id="delete-form-{{ $mission->id }}"
                                    action="{{ route('missions.delete', $mission->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete({{ $mission->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="10" style="border: 2px solid black; font-family: 'Khmer OS Muol Light', sans-serif;">
                        {{ 'សរុប' }}</td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;">{{ number_format($totals['travel_allowance'], 0, '.', ',') }}</td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;">{{ number_format($totals['total_pocket_money'], 0, '.', ',') }}
                    </td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;">{{ number_format($totals['total_meal_money'], 0, '.', ',') }}
                    </td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;">
                        {{ number_format($totals['total_accommodation_money'], 0, '.', ',') }}</td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;">{{ number_format($totals['final_total'], 0, '.', ',') }}</td>
                </tr>
            </tbody>
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
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true, 
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + missionId).submit();
                }
            });
        }
    </script>
@endsection
