@extends('layouts.master')

@section('form-key-upload')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <a class="btn btn-danger" href="{{ route('keys.index') }}"
                                style="width: 160px; height: 50px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-arrow-left"></i>&nbsp;&nbsp;ត្រឡប់ក្រោយ
                            </a>
                            <h3 class="card-title">បង្កើតលេខជំពូក</h3>
                            <span></span>
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
                        <form action="{{ route('keys.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- Column 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code">លេខជំពូក:</label>
                                        <input type="number" name="code" id="code"
                                            class="form-control @error('code') is-invalid @enderror"
                                            style="width: 320px; height: 60px;">

                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Column 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">ចំណាត់ថ្នាក់:</label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            style="width: 320px; height: 60px;">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit"
                                        class="btn btn-primary ml-auto"style="width: 300px; height: 60px;">
                                        <i class="fas fa-save"></i>&nbsp;&nbsp;បានរក្សាទុក</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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

        .container-fluid {
            padding: 16px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        (function($) {
            "use strict"; // Start of use strict

            // Smooth transition for success alert
            function showAlert(message, type) {
                var alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>`;
                $('#alert-container').html(alertHtml);
                $('.alert').addClass('show');
                setTimeout(function() {
                    $('.alert').removeClass('show');
                }, 3000); // Adjust duration as needed
            }

            // Handle form submission via AJAX
            $('#key-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        showAlert(response.message, 'success');
                        $('#key-form')[0].reset(); // Reset form fields if needed
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml =
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Whoops!</strong> There were some problems with your input.<br><ul>';
                        $.each(errors, function(key, value) {
                            errorHtml += `<li>${value[0]}</li>`;
                        });
                        errorHtml +=
                            '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        $('#alert-container').html(errorHtml);
                        $('.alert').addClass('show');
                    }
                });
            });

        })(jQuery); // End of use strict
    </script>
@endsection
