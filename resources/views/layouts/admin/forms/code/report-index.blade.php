@extends('layouts.master')

@section('content-report')
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="col-lg-12 margin-tb mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 style="font-weight: 700;">តារាងរបាយការណ៍បញ្ចូល</h2>
                    <a class="btn btn-success" href="{{ route('codes.create') }}"> បញ្ចូលទិន្នន័យ</a>
                </div>

                <form class="max-w-md mx-auto mt-3" method="GET" action="">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="code_id" value="{{ request('code_id') }}" class="form-control mb-2" placeholder="លេខជំពូក">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="account_key_id" value="{{ request('account_key_id') }}" class="form-control mb-2" placeholder="លេខគណនី">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="sub_account_key_id" value="{{ request('sub_account_key_id') }}" class="form-control mb-2" placeholder="លេខអនុគណនី">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="report_key" value="{{ request('report_key') }}" class="form-control mb-2" placeholder="លេខកូដកម្មវិធី">
                        </div>
                        <div class="col-md-12">
                            <div class="input-group my-3">
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 50 50">
                                        <path d="M 21 3 C 11.621094 3 4 10.621094 4 20 C 4 29.378906 11.621094 37 21 37 C 24.710938 37 28.140625 35.804688 30.9375 33.78125 L 44.09375 46.90625 L 46.90625 44.09375 L 33.90625 31.0625 C 36.460938 28.085938 38 24.222656 38 20 C 38 10.621094 30.378906 3 21 3 Z M 21 5 C 29.296875 5 36 11.703125 36 20 C 36 28.296875 29.296875 35 21 35 C 12.703125 35 6 28.296875 6 20 C 6 11.703125 12.703125 5 21 5 Z"></path>
                                    </svg>
                                    ស្វែងរកទិន្នន័យ
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p>{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th style="border: 1px solid black; font-size: 14px; max-width: 20px;">ល.រ</th>
                <th style="border: 1px solid black; font-size: 14px; max-width: 40px;">ល.ជំពូក</th>
                <th style="border: 1px solid black; font-size: 14px; max-width: 50px;">ល.គណនី</th>
                <th style="border: 1px solid black; font-size: 14px; max-width: 50px;">ល.អនុគណនី</th>
                <th style="border: 1px solid black; font-size: 14px; max-width: 60px;">ល.កូដកម្មវិធី</th>
                <th style="border: 1px solid black; font-size: 14px; max-width: 80px;">ចំណាត់ថ្នាក់</th>
                <th style="border: 1px solid black; font-size: 14px; max-width: 80px;">ច្បាប់ហិរញ្ញវត្ថុ</th>
                <th style="border: 1px solid black; font-size: 14px; max-width: 80px;">ឥណទានបច្ចុប្បន្ន</th>
                <th style="border: 1px solid black; font-size: 14px; max-width: 80px;">កើនផ្ទៃក្នុង</th>
                <th style="border: 1px solid black; font-size: 14px; max-width: 80px;">មិនបានគ្រោងទុក</th>
                <th style="border: 1px solid black; font-size: 14px; max-width: 80px;">បំពេញបន្ថែម</th>
                <th style="border: 1px solid black; font-size: 14px; max-width: 80px;">ថយ</th>
                <th style="border: 1px solid black; width: 200px; font-size: 12px;">សកម្មភាព</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reports as $report)
                <tr>
                    <td style="border: 1px solid black; max-width: 20px; text-align: center">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid black; max-width: 80px; text-align: center">{{ $report->subAccountKey->accountKey->key->code }}</td>
                    <td style="border: 1px solid black; max-width: 80px; text-align: center">{{ $report->subAccountKey->accountKey->account_key }}</td>
                    <td style="border: 1px solid black; max-width: 80px; text-align: center">{{ $report->subAccountKey->sub_account_key }}</td>
                    <td style="border: 1px solid black; max-width: 80px; text-align: center">{{ $report->report_key }}</td>
                    <td style="border: 1px solid black; max-width: 220px;">{{ $report->name_report_key }}</td>
                    <td style="border: 1px solid black; max-width: 80px; text-align: center">{{ number_format($report->fin_law, 0, ' ', ' ') }}</td>
                    <td style="border: 1px solid black; max-width: 80px; text-align: center">{{ number_format($report->current_loan, 0, ' ', ' ') }}</td>
                    <td style="border: 1px solid black; max-width: 80px; text-align: center">{{ number_format($report->internal_increase, 0, ' ', ' ') }}</td>
                    <td style="border: 1px solid black; max-width: 80px; text-align: center">{{ number_format($report->unexpected_increase, 0, ' ', ' ') }}</td>
                    <td style="border: 1px solid black; max-width: 80px; text-align: center">{{ $report->additional_increase }}</td>
                    <td style="border: 1px solid black; max-width: 80px; text-align: center">{{ number_format($report->decrease, 0, ' ', ' ') }}</td>
                    <td style="border: 1px solid black; max-width: 90px; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <div class="form-container">
                            <form action="{{ route('codes.destroy', $report->id) }}" method="POST">
                                <a class="btn btn-info" href="{{ route('keys.show', $report->id) }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-primary" href="{{ route('codes.edit', $report->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this report?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="13" style="text-align: center;">គ្មានទិន្នន័យ</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

@section('styles')
    <style>
        .description {
            height: 220px;
            overflow-y: auto;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-nh8KkfWJZK0C0H8z8Z0z8W3R7ZFl8k5Hq9O1O7s9O0P8+Hybz5VQ1cDUNUr+M+4H0ttD5F5lsS4uRUmxT1b4g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
