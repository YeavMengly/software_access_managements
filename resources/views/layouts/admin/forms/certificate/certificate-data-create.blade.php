@extends('layouts.master')

@section('form-certificate-data-upload')
    <div class="border-wrapper">
        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">បង្កើតសលាកបត្រ</h3>
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
                        <form action="{{ route('certificate-data.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <strong>លេខកូដកម្មវិធី:</strong>
                                <input type="text" id="searchReportKey" class="form-control"
                                    placeholder="ស្វែងរកលេខកូដកម្មវិធី...">
                                <p id="resultCount" style="font-weight: bold;">ចំនួន: 0</p>

                                <select name="report_key" id="reportKeySelect" class="form-control" size="5"
                                    onclick="getSelectedReportValue()">
                                    @foreach ($reports as $report)
                                        <option value="{{ $report->id }}">
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
                                        <option value="{{ $certificate->id }}">{{ $certificate->name_certificate }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="value_certificate">ចំនួនទឹកប្រាក់:</label>
                                <input type="number" name="value_certificate" id="value_certificate"
                                    class="form-control @error('value_certificate') is-invalid @enderror">
                                @error('value_certificate')
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

        .result-total-table-container {
            max-height: 100vh;
            overflow-y: auto;
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

    <script>
        document.getElementById('searchReportKey').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let select = document.getElementById('reportKeySelect');
            let options = select.getElementsByTagName('option');
            let count = 0;

            // Loop through all options and hide those that don't match the search term
            for (let i = 0; i < options.length; i++) {
                let optionText = options[i].textContent || options[i].innerText;
                if (optionText.toLowerCase().indexOf(filter) > -1) {
                    options[i].style.display = '';
                    count++;
                } else {
                    options[i].style.display = 'none';
                }
            }

            // Update result count
            document.getElementById('resultCount').textContent = 'ចំនួន: ' + count;
        });

        function getSelectedReportValue() {
            const select = document.getElementById('reportKeySelect');
            const selectedValue = select.options[select.selectedIndex].text;

            Swal.fire({
                title: 'Selected Value',
                text: `You selected: ${selectedValue}`,
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    </script>
@endsection
