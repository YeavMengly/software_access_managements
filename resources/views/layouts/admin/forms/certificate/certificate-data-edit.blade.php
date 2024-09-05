@extends('layouts.master')

@section('form-certificate-data-edit')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">កែសម្រួលសលាកបត្រ</h3>
                    <a class="btn btn-primary" href="{{ route('certificate-data.index') }}">ត្រឡប់ក្រោយ</a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="border-wrapper">
            <div class="form-container">
                <form action="{{ route('certificate-data.update', $certificateData->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <strong>លេខកូដកម្មវិធី:</strong>
                        <select name="report_key" class="form-control">
                            @foreach ($reports as $report)
                                <option value="{{ $report->id }}" {{ $report->id == $certificateData->report_key ? 'selected' : '' }}>
                                    {{ $report->subAccountKey->accountKey->key->code }} >
                                    {{ $report->subAccountKey->accountKey->account_key }} >
                                    {{ $report->subAccountKey->sub_account_key }} >
                                    {{ $report->report_key }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <strong>ឈ្មោះសលាកបត្រ:</strong>
                        <select name="name_certificate" class="form-control">
                            @foreach ($certificates as $certificate)
                                <option value="{{ $certificate->id }}" {{ $certificate->id == $certificateData->name_certificate ? 'selected' : '' }}>
                                    {{ $certificate->name_certificate }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="value_certificate">ចំនួនទឹកប្រាក់:</label>
                        <input type="number" name="value_certificate" id="value_certificate" value="{{ $certificateData->value_certificate }}"
                            class="form-control @error('value_certificate') is-invalid @enderror">
                        @error('value_certificate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-primary ml-auto">រក្សាទុក</button>
                    </div>
                </form>
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
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
