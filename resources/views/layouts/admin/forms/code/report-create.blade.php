@extends('layouts.master')

@section('form-report-upload')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">បង្កើតទិន្នន័យ</h3>
                    <a class="btn btn-primary" href="{{ route('codes.index') }}">ត្រឡប់ក្រោយ</a>
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
                <form action="{{ route('codes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>លេខអនុគណនី:</strong>
                                <select name="sub_account_key_id" class="form-control">
                                    @foreach ($subAccountKeys as $subAccountKey)
                                        <option value="{{ $subAccountKey->id }}">
                                            {{ $subAccountKey->accountKey->key->code }} - {{ $subAccountKey->accountKey->account_key }} - {{ $subAccountKey->sub_account_key }} 
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            

                            <div class="form-group">
                                <label for="report_key">លេខកូដកម្មវិធី:</label>
                                <input type="text" name="report_key" id="report_key"
                                    class="form-control @error('destination') is-invalid @enderror">
                                @error('report_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name_report_key">ចំណាត់ថ្នាក់:</label>
                                <input type="text" name="name_report_key" id="name_report_key"
                                    class="form-control @error('name_report_key') is-invalid @enderror">
                                @error('name_report_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                  
                            <div class="form-group">
                                <label for="fin_law">ច្បាប់ហិរញ្ញវត្ថុ:</label>
                                <input type="number" name="fin_law" id="fin_law"
                                    class="form-control @error('fin_law') is-invalid @enderror"
                                    oninput="formatNumber(this)">
                                @error('fin_law')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="current_loan">ឥណទានបច្ចុប្បន្ន:</label>
                                <input type="number" name="current_loan" id="current_loan"
                                    class="form-control @error('current_loan') is-invalid @enderror"
                                    oninput="formatNumber(this)">

                                @error('current_loan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="internal_increase">កើនផ្ទៃក្នុង:</label>
                                <input type="number" name="internal_increase" id="internal_increase"
                                    class="form-control @error('internal_increase') is-invalid @enderror"
                                    oninput="formatNumber(this)">
                                @error('internal_increase')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="unexpected_increase">មិនបានគ្រោងទុក:</label>
                                <input type="number" name="unexpected_increase" id="unexpected_increase"
                                    class="form-control @error('unexpected_increase') is-invalid @enderror" 
                                    oninput="formatNumber(this)">
                                @error('unexpected_increase')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="additional_increase">បំពេញបន្ថែម:</label>
                                <input type="number" name="additional_increase" id="additional_increase"
                                    class="form-control @error('additional_increase') is-invalid @enderror"
                                    oninput="formatNumber(this)">
                                @error('additional_increase')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="decrease">ថយ:</label>
                                <input type="number" name="decrease" id="decrease"
                                    class="form-control @error('decrease') is-invalid @enderror"
                                    oninput="formatNumber(this)">
                                @error('decrease')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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

    {{-- <script>
        function formatNumber(input) {
            // Remove all non-numeric characters
            let value = input.value.replace(/\D/g, '');

            // Add spaces every three digits
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

            // Update the input value
            input.value = value;
        }
    </script> --}}
@endsection
