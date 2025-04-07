@extends('layouts.master')

@section('content-table-mission-cambodia')
    <div class="result-total-table-container">

        <div class="col-lg-12 margin-tb mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <a class="btn btn-danger" href="{{ route('total_card') }}"
                    style="width: 120px; height: 40px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-arrow-left"></i>&nbsp;
                </a>
                <a class="btn btn-primary d-flex justify-content-center align-items-center"
                    href="{{ route('mission-cam.create') }}" style="width: 120px; height: 40px; border-radius: 4px;">
                    បញ្ចូល
                </a>
            </div>
            <form class="max-w-md mx-auto " method="GET" action="{{route('mission-cam.index')}}">
                <div class="row">
                    <div class="col-md-2 ">
                        <form method="GET" action="{{ route('mission-cam.index') }}">
                            <div class="input-group my-3"
                                style="width: 180px; font-family: 'Khmer OS Siemreap', sans-serif">
                                <input type="search" name="search" value="{{ request('search') }}" class="form-control"
                                    placeholder="ស្វែងរកទិន្នន័យ" aria-label="Search Address">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <form method="GET" action="{{ route('mission-cam.index') }}">
                            <div class="input-group my-3" style="width: 100%; font-family: 'Khmer OS Siemreap', sans-serif">
                                <!-- Year Selection -->
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                        style="background-color: #007bff; color: white;">ឆ្នាំ</span>
                                </div>
                                <select name="year" class="form-control" onchange="this.form.submit()">
                                    <option value="" disabled>ជ្រើសរើសឆ្នាំ</option>
                                    @for ($year = date('Y'); $year >= 2022; $year--)
                                        <option value="{{ $year }}"
                                            {{ request('year', date('Y')) == $year ? 'selected' : '' }}>
                                            {{ convertToKhmerNumber($year) }}
                                        </option>
                                    @endfor
                                </select>

                                <!-- Month Selection -->
                                @php
                                    $khmerMonths = [
                                        1 => 'មករា',
                                        2 => 'កុម្ភៈ',
                                        3 => 'មិនា',
                                        4 => 'មេសា',
                                        5 => 'ឧសភា',
                                        6 => 'មិថុនា',
                                        7 => 'កក្កដា',
                                        8 => 'សីហា',
                                        9 => 'កញ្ញា',
                                        10 => 'តុលា',
                                        11 => 'វិច្ឆិកា',
                                        12 => 'ធ្នូ',
                                    ];
                                @endphp
                                <div class="input-group-prepend ml-2">
                                    <span class="input-group-text"
                                        style="background-color: #007bff; color: white;">ខែ</span>
                                </div>
                                <select name="month" class="form-control" onchange="this.form.submit()">
                                    <option value="" disabled selected>ជ្រើសរើសខែ</option>
                                    @for ($month = 1; $month <= 12; $month++)
                                        <option value="{{ $month }}"
                                            {{ request('month', now()->month) == $month ? 'selected' : '' }}>
                                            {{ $khmerMonths[$month] }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    {{-- <button type="submit" class="btn btn-primary ml-3"
                        style="background-color: #007bff;
                     height: 40px;
                        font-size: 14px; 
                        width: 120px;
                        font-family: 'Khmer OS Siemreap', sans-serif; 
                        transition: background-color 0.3s ease, transform 0.3s ease; 
                        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);" >
                        ស្វែងរក
                    </button> --}}
                    <!-- Clear Button -->
                    <button type="button" class="btn btn-secondary ml-3" onclick="clearSearch()"
                        style="
                        font-size: 14px;
                           height: 40px;
                        width: 120px;
                        font-family: 'Khmer OS Siemreap', sans-serif;
                        background-color: #6c757d;
                        transition: background-color 0.3s ease;">
                        សម្អាតទិន្នន័យ
                    </button>
                    <!-- Report Mission -->
                    {{-- <button type="button" class="btn btn-secondary ml-3"
                        onclick="window.location.href='{{ route('reports-missions.index') }}'"
                        style="
                        font-size: 14px; 
                           height: 40px;
                        font-family: 'Khmer OS Siemreap', sans-serif;
                        background-color: #df5bad;
                        width: 120px;
                        transition: background-color 0.3s ease;">
                        តារាងទូទាត់
                    </button> --}}
                </div>

                <div class="d-flex justify-content-end">
                    <div class="btn-group mb-3" role="group" aria-label="Mission Type Filter">
                        <!-- Show 'All' Button -->
                        <a href="{{ route('mission-cam.index') }}"
                            class="btn btn-outline-primary {{ request('m_tag') ? '' : 'active' }}">
                            ទាំងអស់
                        </a>

                        <!-- Check if $missionTag is not empty -->
                        @if ($missionTag->isNotEmpty())
                            @foreach ($missionTag as $tag)
                                <a href="{{ route('mission-cam.index', ['m_tag' => $tag->id]) }}"
                                    class="btn btn-outline-primary {{ request('m_tag') == $tag->id ? 'active' : '' }}">
                                    {{ $tag->m_tag }}
                                </a>
                            @endforeach
                        @else
                            <span class="text-muted">No mission tags available</span>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <div class="btn-group mb-3" role="group" aria-label="Program Format Filter">
                        <!-- Show 'All Programs' Button -->
                        <a href="{{ route('mission-cam.index') }}" 
                           class="btn btn-outline-primary {{ request('p_format') ? '' : 'active' }}">
                            ទាំងអស់
                        </a>
                
                        <!-- Program Format Buttons -->
                        @php
                            $programs = [
                                'P_1' => 'កម្មវិធីទី ១',
                                'P_2' => 'កម្មវិធីទី ២',
                                'P_3' => 'កម្មវិធីទី ៣',
                                'P_4' => 'កម្មវិធីទី ៤'
                            ];
                        @endphp
                
                        @foreach ($programs as $key => $label)
                            <a href="{{ route('mission-cam.index', ['p_format' => $key]) }}" 
                               class="btn btn-outline-primary {{ request('p_format') == $key ? 'active' : '' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="mission-table" class="border-wrapper mr-4 ml-4">
        <div class="result-total-table-container">
            <div class="top-header">
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
                <h4>តារាងរបាយការណ៍ចំណាយបេសកកម្មក្នុងប្រទេសឆ្នាំ {{ convertToKhmerNumber(request('year', date('Y'))) }}
                    @if (request('m_tag'))
                        @php
                            $selectedTag = $missionTag->firstWhere('id', request('m_tag'));
                        @endphp
                        @if ($selectedTag)
                            - {{ $selectedTag->m_tag }}
                        @endif
                    @endif
                </h4>
                <h4>របស់អគ្គនាយករដ្ឋបាល និងហិរញ្ញវត្ថុ</h4>
            </div>

            <div class="table-container">
                <table class="table-border ">
                    <thead>
                        <tr>
                            <th rowspan="2">
                                ល.រ</th>
                            <th rowspan="2">
                                គោត្តនាម​​ និងនាម</th>
                            <th rowspan="2">
                                តួនាទី</th>
                            <th rowspan="2">
                                ប្រភេទមុខតំណែង</th>
                            <th colspan="2">
                                លិខិតបញ្ជាបេសកកម្ម</th>
                            <th rowspan="2">
                                កម្មវត្ថុនៃការចុះបេសកកម្ម</th>
                            <th rowspan="2">
                                ទីកន្លែង</th>
                            <th colspan="2">
                                កាលបរិច្ឆេទចុះបេសកកម្ម</th>
                            <th rowspan="2">
                                ចំនួនថ្ងៃ</th>
                            <th rowspan="2">
                                ចំនួនយប់</th>
                            <th rowspan="2">
                                សោហ៊ុយធ្វើដំណើរ</th>
                            <th colspan="2">
                                ប្រាក់ហោប៉ៅ</th>
                            <th colspan="2">
                                ប្រាក់ហូបចុក</th>
                            <th colspan="2">
                                ប្រាក់ស្នាក់នៅ</th>
                            <th rowspan="2">
                                សោហ៊ុយផ្សេងៗ</th>
                            <th rowspan="2">
                                ទឹកប្រាក់សរុប</th>
                            <th rowspan="2">
                                សកម្មភាព</th>

                        </tr>

                        <tr>
                            <th>លេខ
                            </th>
                            <th>
                                កាលបរិច្ឆេទ
                            </th>
                            <th>
                                ចាប់ផ្ដើម</th>
                            <th>ត្រឡប់
                            </th>
                            <th>របប
                            </th>
                            <th>សរុប
                            </th>
                            <th>របប
                            </th>
                            <th>សរុប
                            </th>
                            <th>របប
                            </th>
                            <th>សរុប
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="23">
                                សម្រាប់កម្មវិធីទី០៥ ចង្កោមសកម្មភាពទី០១ ស្ដីពី ពង្រឹងប្រសិទ្ធភាពនៃការអនុវត្តចំណាយ
                                និងការគ្រប់គ្រងកិច្ចការហិរញ្ញវត្ថុតាមប្រព័ន្ធ FMIS</td>
                        </tr>
                        @php
                            $totalIndexCounter = 1;
                        @endphp
                        @foreach ($missions->groupBy('letter_format') as $letterFormat => $groupedByFormat)
                            @foreach ($groupedByFormat->groupBy('letter_number') as $letterNumber => $group)
                                @foreach ($group as $index => $mission)
                                    <tr>
                                        <td>
                                            {{ $totalIndexCounter }}.{{ $index + 1 }}
                                        </td>
                                        <td style="width:180px; ">
                                            {{ $mission->name }}
                                        </td>
                                        <td style=" width: 100px;">
                                            {{ $mission->role }}
                                        </td>
                                        <td>
                                            {{ $mission->position_type }}
                                        </td>
                                        <td>
                                            {{ $mission->letter_number }} {{ $mission->letter_format }}
                                        </td>
                                        <td>
                                            {{ $mission->letter_date }}
                                        </td>
                                        <td>
                                            {{ $mission->mission_objective }}
                                        </td>
                                        <td>
                                            {{ $mission->location }}
                                        </td>
                                        <td style="width: 110px;">
                                            {{ $mission->mission_start_date }}
                                        </td>
                                        <td style="width: 110px; ">
                                            {{ $mission->mission_end_date }}
                                        </td>
                                        <td>
                                            {{ $mission->days_count }}
                                        </td>
                                        <td>
                                            {{ $mission->nights_count }}
                                        </td>
                                        <td>
                                            {{ number_format($mission->travel_allowance, 0, '.', ',') }}
                                        </td>
                                        <td>
                                            {{ number_format($mission->pocket_money, 0, '.', ',') }}
                                        </td>
                                        <td>
                                            {{ number_format($mission->total_pocket_money, 0, '.', ',') }}
                                        </td>
                                        <td>
                                            {{ number_format($mission->meal_money, 0, '.', ',') }}
                                        </td>
                                        <td>
                                            {{ number_format($mission->total_meal_money, 0, '.', ',') }}
                                        </td>
                                        <td>
                                            {{ number_format($mission->accommodation_money, 0, '.', ',') }}
                                        </td>
                                        <td>
                                            {{ number_format($mission->total_accommodation_money, 0, '.', ',') }}
                                        </td>
                                        <td>
                                            {{ number_format($mission->other_allowances, 0, '.', ',') }}
                                        </td>
                                        <td>
                                            {{ number_format($mission->final_total, 0, '.', ',') }}
                                        </td>
                                        <td style="border: 1px solid black;">
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

                                <!-- Display the total row for this letter_number group -->
                                <tr>
                                    <td colspan="12"
                                        >
                                        <strong>{{ 'សរុប' }} {{ $totalIndexCounter }}</strong>
                                    </td>

                                    <td >
                                        <strong>{{ number_format($group->sum('travel_allowance'), 0, '.', ',') }}</strong>
                                    </td>

                                    <td ></td>
                                    <td >
                                        <strong>{{ number_format($group->sum('total_pocket_money'), 0, '.', ',') }}</strong>
                                    </td>

                                    <td ></td>
                                    <td style="border:   1px solid black;">
                                        <strong>{{ number_format($group->sum('total_meal_money'), 0, '.', ',') }}</strong>
                                    </td>

                                    <td ></td>
                                    <td >
                                        <strong>{{ number_format($group->sum('total_accommodation_money'), 0, '.', ',') }}</strong>
                                    </td>
                                    <td ></td>

                                    <td >
                                        <strong>{{ number_format($group->sum('final_total'), 0, '.', ',') }}</strong>
                                    </td>
                                    <td></td>
                                </tr>
                                @php
                                    $totalIndexCounter++;
                                @endphp
                            @endforeach
                        @endforeach
                        <tr>
                            <td colspan="12">
                                <strong>{{ 'សរុបរួម' }}</strong>
                            </td>
                            <td>
                                <strong>{{ number_format($totals['travel_allowance'], 0, '.', ',') }}</strong>
                            </td>

                            <td></td>
                            <td>
                                <strong>{{ number_format($totals['total_pocket_money'], 0, '.', ',') }}</strong>
                            </td>

                            <td></td>
                            <td>
                                <strong>{{ number_format($totals['total_meal_money'], 0, '.', ',') }}</strong>
                            </td>

                            <td></td>
                            <td>
                                <strong>{{ number_format($totals['total_accommodation_money'], 0, '.', ',') }}</strong>
                            </td>

                            <td></td>
                            <td>
                                <strong>{{ number_format($totals['final_total'], 0, '.', ',') }}</strong>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="d-flex justify-content-end mt-3 mb-2">
            <a href="{{ route('table-mission-cambodia', [
                'search' => request('search'),
                'start_date' => request('start_date'),
                'end_date' => request('end_date') ?? '',
            ]) }}"
                class="btn btn-danger  btn-width d-flex align-items-center justify-content-center"
                style="width: 120px;
                height: 40px;">Export</a>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .border-wrapper {
            border: 1px solid black;
            padding-left: 16px;
            padding-right: 16px;
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
            border: 1px solid rgb(133, 131, 131);
            text-align: center;
            padding: 4px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
        }

        h3,
        h4 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
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

        .top-header {
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

@section('scripts')
    <script>
        function confirmDelete(missionId) {
            Swal.fire({
                title: 'ពិតជាចង់លុបទិន្នន័យមែនឬទេ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'ត្រឡប់ក្រោយ',
                confirmButtonText: 'លុបទិន្នន័យ!',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + missionId).submit();
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.getElementById('reportTable');
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            const filterableCells = table.querySelectorAll('.filterable');

            let filtersToShow = [];
            let allRows = rows; // Keep reference to all rows for double-click reset

            function showFilteredRows(filterValue) {
                // Hide all rows first
                rows.forEach(row => {
                    row.classList.add('hidden-row');
                });

                // Show rows that match the filter value in any filterable cell
                rows.forEach(row => {
                    const cellValue = row.querySelector(`td.filterable[data-filter="${filterValue}"]`);
                    if (cellValue) {
                        row.classList.remove('hidden-row');
                    }
                });
            }

            filterableCells.forEach(cell => {
                cell.addEventListener('click', function() {
                    const filterValue = this.getAttribute('data-filter');
                    filtersToShow.push(filterValue);

                    // Check if the filterValue is unique and adjust the display accordingly
                    const filteredRows = rows.filter(row => {
                        return row.querySelector(
                            `td.filterable[data-filter="${filterValue}"]`);
                    });

                    if (filteredRows.length > 0) {
                        showFilteredRows(filterValue);
                    }
                });

                cell.addEventListener('dblclick', function() {
                    filtersToShow = [];
                    rows.forEach(row => {
                        row.classList.remove('hidden-row');
                    });
                });
            });
        });
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
                    fullscreenButton.innerHTML = '<i class="fas fa-compress"></i>';
                } else {
                    fullscreenButton.innerHTML = '<i class="fas fa-expand"></i>';
                }
            }

            fullscreenButton.addEventListener('click', function() {
                toggleFullscreen();
            });

            document.addEventListener('fullscreenchange', updateButtonIcon);
            document.addEventListener('webkitfullscreenchange', updateButtonIcon);
            document.addEventListener('mozfullscreenchange', updateButtonIcon);
            document.addEventListener('MSFullscreenChange', updateButtonIcon);

            updateButtonIcon();
        });
    </script>
    <script>
        function clearSearch() {
            // Reset the form
            document.querySelector('form').reset();

            // Reload the page without query parameters
            window.location.href = "{{ url()->current() }}";
        }


        if (!function_exists('convertToKhmerNumber')) {
            function convertToKhmerNumber($number) {
                $khmerDigits = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
                return str_replace(range(0, 9), $khmerDigits, $number);
            }
        }
    </script>
@endsection
