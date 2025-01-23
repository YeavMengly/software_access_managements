@extends('layouts.master')

@section('form-key-edit')
    <div class="border-wrapper">
        <div class="result-total-table-container">

            <div class="row">
                <div class="col-lg-12 margin-tb mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <a class="btn btn-danger" href="{{ route('keys.index') }}" style="width: 120px; height: 40px;">
                            <i class="fas fa-arrow-left"></i></a>
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

            <div class="d-flex justify-content-center align-items-center  ">
                <div class="card shadow-lg w-65" style="max-width: 900px;">
                    <h3 class="card-title text-center mt-4" style="font-weight: 500;">កែទិន្នន័យ</h3>
                    <div class="form-container px-5 py-4">
                        <form action="{{ route('keys.update', $key->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <!-- Column 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code" class="form-label"><strong>លេខជំពូក:</strong></label>
                                        <input type="number" name="code" id="code"
                                            value="{{ old('code', $key->code) }}" style="width: 230px; height: 40px;"
                                            class="form-control @error('code') is-invalid @enderror">
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Column 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label"><strong>ចំណាត់ថ្នាក់:</strong></label>
                                        <input type="text" name="name" id="name_account_key"
                                            value="{{ old('name', $key->name) }}" style="width: 230px; height: 40px;"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="row">
                                <div class="col-12 text-center">
                                    <!-- Reset Button -->
                                    <button type="reset" class="btn btn-secondary">
                                        <i class="fas fa-undo"></i>&nbsp;កំណត់ឡើងវិញ
                                    </button>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-primary ml-3">
                                        <i class="fas fa-save"></i>&nbsp;រក្សាទុក
                                    </button>
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
            padding-left: 16px;
            padding-right: 16px;
        }

        h3 {
            font-family: 'Khmer OS Muol Light', sans-serif;
            font-size: 16px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        (function($) {
            "use strict"; // Start of use strict

            // Toggle the side navigation
            $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
                if ($(".sidebar").hasClass("toggled")) {
                    $('.sidebar .collapse').collapse('hide');
                }
            });

            // Close any open menu accordions when window is resized below 768px
            $(window).resize(function() {
                if ($(window).width() < 768) {
                    $('.sidebar .collapse').collapse('hide');
                }

                // Toggle the side navigation when window is resized below 480px
                if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
                    $("body").addClass("sidebar-toggled");
                    $(".sidebar").addClass("toggled");
                    $('.sidebar .collapse').collapse('hide');
                }
            });

            // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
            $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
                if ($(window).width() > 768) {
                    var e0 = e.originalEvent,
                        delta = e0.wheelDelta || -e0.detail;
                    this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                    e.preventDefault();
                }
            });

            // Scroll to top button appear
            $(document).on('scroll', function() {
                var scrollDistance = $(this).scrollTop();
                if (scrollDistance > 100) {
                    $('.scroll-to-top').fadeIn();
                } else {
                    $('.scroll-to-top').fadeOut();
                }
            });

            // Smooth scrolling using jQuery easing
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
