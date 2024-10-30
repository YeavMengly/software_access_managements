@extends('layouts.master')

@section('form-certificate-edit')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">កែសម្រួលសលាកបត្រ</h3>
                    <a class="btn btn-primary  d-flex align-items-center justify-content-center" href="{{ route('certificate.index') }}"
                    style="width: 160px; height: 50px;">  <i class="fas fa-arrow-left"></i> &nbsp; ត្រឡប់ក្រោយ</a>
                </div>
            </div>
        </div>

        <div id="alerts-container">
            @if (session('success'))
                <div class="alert alert-success alert-popup show" id="success-alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-popup show" id="error-alert">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <div class="border-wrapper">
            <div class="form-container">
                <form action="{{ route('certificate.update', $certificates->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name_certificate">ឈ្មោះសលាកបត្រ:</label>
                        <input type="text" name="early_balance" id="early_balance" value="{{ old('early_balance', $certificates->early_balance) }}"
                            class="form-control @error('early_balance') is-invalid @enderror">
                        @error('early_balance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-primary ml-auto">បានរក្សាទុក</button>
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

        .alert-popup {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            width: 300px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
            transform: translateY(-20px);
        }

        .alert-popup.show {
            opacity: 1;
            transform: translateY(0);
        }

        .alert-popup .btn-close {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        (function($) {
            "use strict"; // Start of use strict

            // Show and hide alerts
            $(document).ready(function() {
                $('.alert-popup').each(function() {
                    $(this).addClass('show');
                    setTimeout(() => {
                        $(this).removeClass('show');
                    }, 5000); // Hide after 5 seconds
                });

                $('.alert-popup .btn-close').on('click', function() {
                    $(this).parent().removeClass('show');
                });
            });

        })(jQuery); // End of use strict
    </script>
@endsection
