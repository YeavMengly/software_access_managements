@extends('layouts.master')

@section('form-account-upload')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <a class="btn btn-danger" href="{{ route('accounts.index') }}"
                                style="width: 160px; height: 50px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-arrow-left"></i>
                                &nbsp;&nbsp;ត្រឡប់ក្រោយ</a>
                            <h3 class="card-title">បង្កើតលេខកូដគណនី</h3>
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
                        <form action="{{ route('accounts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- Column 1 -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <strong>លេខជំពូក:</strong>
                                        <select name="code" class="form-control" style="width: 420px; height: 60px;">
                                            @foreach ($keys as $key)
                                                <option value="{{ $key->id }}">{{ $key->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Column 2 -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="account_key">លេខគណនី:</label>
                                        <input type="number" name="account_key" id="account_key"
                                            class="form-control @error('account_key') is-invalid @enderror"
                                            style="width: 420px; height: 60px;">
                                        @error('account_key')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Column 3 -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name_account_key">ចំណាត់ថ្នាក់:</label>
                                        <input type="text" name="name_account_key" id="name_account_key"
                                            class="form-control @error('name_account_key') is-invalid @enderror"
                                            style="width: 420px; height: 60px;">
                                        @error('name_account_key')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary" style="width: 300px; height: 60px;"><i
                                            class="fas fa-save"></i>&nbsp;&nbsp;បានរក្សាទុក</button>
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
    <script>
        (function($) {
            "use strict"; // Start of use strict

            $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
                if ($(".sidebar").hasClass("toggled")) {
                    $('.sidebar .collapse').collapse('hide');
                }
            });

            $(window).resize(function() {
                if ($(window).width() < 768) {
                    $('.sidebar .collapse').collapse('hide');
                }

                if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
                    $("body").addClass("sidebar-toggled");
                    $(".sidebar").addClass("toggled");
                    $('.sidebar .collapse').collapse('hide');
                }
            });

            $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
                if ($(window).width() > 768) {
                    var e0 = e.originalEvent,
                        delta = e0.wheelDelta || -e0.detail;
                    this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                    e.preventDefault();
                }
            });

            $(document).on('scroll', function() {
                var scrollDistance = $(this).scrollTop();
                if (scrollDistance > 100) {
                    $('.scroll-to-top').fadeIn();
                } else {
                    $('.scroll-to-top').fadeOut();
                }
            });


            $(document).on('click', 'a.scroll-to-top', function(e) {
                var $anchor = $(this);
                $('html, body').stop().animate({
                    scrollTop: ($($anchor.attr('href')).offset().top)
                }, 1000, 'easeInOutExpo');
                e.preventDefault();
            });

        })(jQuery); // End of use strict
    </script>
@endsection
