@extends('layouts.master')

@section('content-table-mission-cambodia')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4 mt-4">
            <div class="d-flex justify-content-between align-items-center"
                style="font-family: 'Khmer OS Siemreap', sans-serif;">
                <a class="btn btn-primary" href="{{ route('mission-cam.index') }}">ត្រឡប់ក្រោយ</a>
            </div>
        </div>
    </div>
    <div class="border-wrapper mt-3">
        <div class="result-total-table-container">
            <div class="first-header">
                <h4>ព្រះរាជាណាចក្រកម្ពុជា</h4>
                <h3>ជាតិ សាសនា ព្រះមហាក្សត្រ</h3>
            </div>
            <div class="second-header">
                <h4>ក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</h4>
                <h4>អគ្គនាយកដ្ឋានរដ្ឋបាល និងហិរញ្ញវត្ថុ</h4>
                <h4>នាយកដ្ឋានហិរញ្ញវត្ថុ និងទ្រព្យសម្បត្តិរដ្ឋ</h4>
                <h4>ការិយាល័យហិរញ្ញវត្ថុ</h4>
            </div>
            <div class="third-header">
                <h4>តារាងរបាយការណ៍ចំណាយបេសកកម្មក្នុងប្រទេសឆ្នាំ ២០២៤</h4>
                <h4>របស់អគ្គនាយករដ្ឋបាល និងហិរញ្ញវត្ថុ</h4>
            </div>

            <div class="table-container">
                <table class="table-border ">
                    <thead>
                        <tr style="align-items: center; font-family: 'Khmer OS Muol Light', sans-serif;">
                            <th rowspan="2" style="border: 2px solid black;">
                                អន្តលេខ</th>
                            <th rowspan="2" style="border: 2px solid black;">
                                ឈ្មោះ-ខ្មែរ</th>
                            <th rowspan="2" style="border: 2px solid black;">
                                ឈ្មោះ-ឡាតាំង</th>
                            <th rowspan="2" style="border: 2px solid black;">
                                លេខគណនី</th>
                            <th rowspan="2" style="border: 2px solid black;">
                                ទឹកប្រាក់សរុប</th>
                            <th rowspan="2" style="border: 2px solid black;">
                                សកម្មភាពផ្សេងៗ</th>
                        </tr>

                    </thead>
                    {{-- <tbody style="border: 2px solid black;">
                        <tr>
                            <td colspan="23" style="text-align: left; font-family: 'Khmer OS Siemreap', sans-serif">
                                សម្រាប់កម្មវិធីទី០៥ ចង្កោមសកម្មភាពទី០១ ស្ដីពី ពង្រឹងប្រសិទ្ធភាពនៃការអនុវត្តចំណាយ
                                និងការគ្រប់គ្រងកិច្ចការហិរញ្ញវត្ថុតាមប្រព័ន្ធ FMIS</td>
                        </tr>
                        @foreach ($missions->groupBy('letter_number') as $letterNumber => $group)
                            @foreach ($group as $index => $mission)
                                <tr>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $loop->parent->iteration }}.{{ $index + 1 }}</td>
                                    <td
                                        style="border: 2px solid black; width:180px; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->name }}</td>
                                    <td
                                        style="border: 2px solid black; width: 100px; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->role }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->position_type }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->letter_number }}</td>
                                    <td
                                        style="border: 2px solid black; width: 110px; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->letter_date }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->mission_objective }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->location }}</td>
                                    <td
                                        style="border: 2px solid black; width: 110px; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->mission_start_date }}</td>
                                    <td
                                        style="border: 2px solid black; width: 110px; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->mission_end_date }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->days_count }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ $mission->nights_count }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->travel_allowance, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->pocket_money, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->total_pocket_money, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->meal_money, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->total_meal_money, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->accommodation_money, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->total_accommodation_money, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->other_allowances, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black; font-family: 'Khmer OS Siemreap', sans-serif">
                                        {{ number_format($mission->final_total, 0, '.', ',') }}</td>
                                    <td style="border: 2px solid black;">
                                        <div style="display: flex; gap: 5px;">
                                            <a href="{{ route('missions.edit', $mission->id) }}"
                                                class="btn btn-primary btn-sm">
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
                            <!-- Display the total row for this group -->
                            <tr>
                                <td colspan="12"
                                    style="border: 2px solid black; font-family: 'Khmer OS Muol Light', sans-serif;">
                                    <strong>{{ 'សរុប' }} {{ $loop->index + 1 }}</strong>
                                </td>
                                <td style="border: 2px solid black;">
                                    <strong>{{ number_format($groupedTotals[$letterNumber]['travel_allowance'], 0, '.', ',') }}</strong>
                                </td>
                                <td style="border: 2px solid black;"></td>
                                <td style="border: 2px solid black;">
                                    <strong>{{ number_format($groupedTotals[$letterNumber]['total_pocket_money'], 0, '.', ',') }}</strong>
                                </td>
                                <td style="border: 2px solid black;"></td>
                                <td style="border: 2px solid black;">
                                    <strong>{{ number_format($groupedTotals[$letterNumber]['total_meal_money'], 0, '.', ',') }}</strong>
                                </td>
                                <td style="border: 2px solid black;"></td>
                                <td style="border: 2px solid black;">
                                    <strong>{{ number_format($groupedTotals[$letterNumber]['total_accommodation_money'], 0, '.', ',') }}</strong>
                                </td>
                                <td style="border: 2px solid black;"></td>
                                <td style="border: 2px solid black;">
                                    <strong>{{ number_format($groupedTotals[$letterNumber]['final_total'], 0, '.', ',') }}</strong>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="12"
                                style="border: 2px solid black; font-family: 'Khmer OS Muol Light', sans-serif;">
                                <strong>{{ 'សរុបរួម' }}</strong>
                            </td>
                            <td style="border: 2px solid black;">
                                <strong>{{ number_format($totals['travel_allowance'], 0, '.', ',') }}</strong>
                            </td>
                            <td style="border: 2px solid black;"></td>
                            <td style="border: 2px solid black;">
                                <strong>{{ number_format($totals['total_pocket_money'], 0, '.', ',') }}</strong>
                            </td>
                            <td style="border: 2px solid black;"></td>
                            <td style="border: 2px solid black;">
                                <strong>{{ number_format($totals['total_meal_money'], 0, '.', ',') }}</strong>
                            </td>
                            <td style="border: 2px solid black;"></td>
                            <td style="border: 2px solid black;">
                                <strong>{{ number_format($totals['total_accommodation_money'], 0, '.', ',') }}</strong>
                            </td>
                            <td style="border: 2px solid black;"></td>
                            <td style="border: 2px solid black;">
                                <strong>{{ number_format($totals['final_total'], 0, '.', ',') }}</strong>
                            </td>
                        </tr>
                    </tbody> --}}
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
            max-height: 200vh;
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
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 25px;
        }

        h4 {
            font-family: 'Khmer OS Muol Light', sans-serif;
        }

        .btn-width {
            width: 120px;
        }

        .filterable {
            cursor: pointer;
            background-color: #f0f0f0;
        }

        .hidden-row {
            display: none;
        }

        .first-header {
            text-align: center;
            margin-bottom: 70px;
        }

        .third-header {
            text-align: center;
            padding: 10px;
        }

        .large-checkbox {
            transform: scale(2);
            margin: 7px;
        }
    </style>
@endsection
