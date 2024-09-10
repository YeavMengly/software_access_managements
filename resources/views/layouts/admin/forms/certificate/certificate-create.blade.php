@extends('layouts.master')

@section('form-certificate-upload')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">បង្កើតសលាកបត្រ</h3>
                            <a class="btn btn-primary" href="{{ route('certificate.index') }}">ត្រឡប់ក្រោយ</a>
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
                        <form action="{{ route('certificate.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="report_key">ឈ្មោះសលាកបត្រ:</label>
                                <input type="text" name="name_certificate" id="name_certificate"
                                    class="form-control @error('name_certificate') is-invalid @enderror">
                                @error('name_certificate')
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

        .result-total-table-container {
            max-height: 100vh;
            overflow-y: auto;
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
