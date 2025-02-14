@extends('layouts.master')

@section('content-import-data')

        <div class="border-wrapper">
            <div class="result-total-table-container">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 margin-tb mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">ដាក់ឯកសារជា FILE </h3>
                                <a class="btn btn-danger" href="{{ route('reports.index') }}"> <i class="fas fa-arrow-left"></i>
                                    ត្រឡប់ក្រោយ</a>
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
                            <form action="#" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="file">file:</label>
                                    <input type="file" name="file" id="file"
                                        class="form-control @error('file') is-invalid @enderror" >
                                    @error('file')
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
            "use strict"; 
            function showAlert(message, type) {
                var alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>`;
                $('#alert-container').html(alertHtml);
                $('.alert').addClass('show');
                setTimeout(function() {
                    $('.alert').removeClass('show');
                }, 3000); 
            }

            $('#key-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        showAlert(response.message, 'success');
                        $('#key-form')[0].reset(); 
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

        })(jQuery); 
    </script>
@endsection
