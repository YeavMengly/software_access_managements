@extends('layouts.master')
@section('content-mission')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4 ">
            <div class="col-lg-12 margin-tb mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 style="font-weight: 700;">តារាងរបាយការណ៏ចំណាយបេសកកម្ម​ ឆ្នាំ២០២៤</h2>
                    <a class="btn btn-success" href="{{ route('missions.create') }}">បញ្ចូលទិន្នន័យ</a>
                </div>

                {{-- <form class="max-w-md mx-auto mt-3" method="GET" action="{{ route('missions.index') }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group my-3" style="width: 70%;">
                                <input type="search" name="search" value="{{ request('search') }}" class="form-control"
                                    placeholder="ស្វែងរកទិន្នន័យ" aria-label="Search Address">
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 50 50">
                                        <path
                                            d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form> --}}
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
                    </tr>
                @endforeach
                <tr>
                    <td colspan="10" style="border: 2px solid black; font-family: 'Khmer OS Muol Light', sans-serif;">
                        {{ 'សរុប' }}</td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;">
                        {{ number_format($totals['travel_allowance'], 0, '.', ',') }}</td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;">
                        {{ number_format($totals['total_pocket_money'], 0, '.', ',') }}</td>
                    <td style="border: 2px solid black;"></td>
                    <td style="border: 2px solid black;">
                        {{ number_format($totals['total_meal_money'], 0, '.', ',') }}</td>
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
