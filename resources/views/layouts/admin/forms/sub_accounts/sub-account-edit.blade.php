@extends('layouts.master')

@section('form-sub-account-edit')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">កែប្រែលេខអនុគណនី</h3>
                            <a class="btn btn-danger" href="{{ route('sub-account.index') }}">
                                <i class="fas fa-arrow-left"></i> ត្រឡប់ក្រោយ
                            </a>
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
                        <form action="{{ route('sub-account.update', $subAccountKey->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <strong>លេខគណនី:</strong>
                                <select name="account_key" class="form-control">
                                    @foreach ($accountKeys as $accountKey)
                                        <option value="{{ $accountKey->id }}" {{ $accountKey->id == $subAccountKey->account_key ? 'selected' : '' }}>
                                            {{ $accountKey->key->code }} < {{ $accountKey->account_key }} 
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sub_account_key">លេខអនុគណនី:</label>
                                <input type="number" name="sub_account_key" id="sub_account_key"
                                    class="form-control @error('sub_account_key') is-invalid @enderror"
                                    value="{{ old('sub_account_key', $subAccountKey->sub_account_key) }}">
                                @error('sub_account_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name_sub_account_key">ចំណាត់ថ្នាក់:</label>
                                <input type="text" name="name_sub_account_key" id="name_sub_account_key"
                                    class="form-control @error('name_sub_account_key') is-invalid @enderror"
                                    value="{{ old('name_sub_account_key', $subAccountKey->name_sub_account_key) }}">
                                @error('name_sub_account_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn btn-primary ml-auto">បញ្ចូល</button>
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
