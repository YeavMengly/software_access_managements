@extends('layouts.master')

@section('form-content-loans-upload')
    <div class="border-wrapper">

        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">បង្កើតទិន្នន័យ</h3>
                            <a class="btn btn-danger" href="{{ url('/') }}"> <i class="fas fa-arrow-left"></i>
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
                        <form action="{{ route('loans.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row d-flex justify-content-center ">
                                <!-- First Row -->
                                <div class="col-md-3  d-flex flex-column align-items-center">
                                    <!-- Sub Account Key Input -->
                                    <div class="form-group">
                                        <strong>លេខអនុគណនី:</strong>
                                        <input type="text" id="searchSubAccountKey" class="form-control"
                                            placeholder="ស្វែងរកលេខអនុគណនី..." onkeyup="filterSubAccountKeys(event)"
                                            style="width: 420px; height: 60px; text-align: center;"
                                            oninput="resetSubAccountSelection()">
                                        <p id="resultCount" style="font-weight: bold;">ចំនួន: 0</p>
                                        <select name="sub_account_key" id="subAccountKeySelect" class="form-control"
                                            size="5" onclick="getSelectedValue()"
                                            style="width: 420px; height: 260px;">
                                            @foreach ($subAccountKeys as $subAccountKey)
                                                <option value="{{ $subAccountKey->id }}">
                                                    {{ $subAccountKey->sub_account_key }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3  d-flex flex-column align-items-center">
                                    <!-- Sub Account Key Input -->
                                    <div class="form-group">
                                        <strong>លេខកូដកម្មវិធី:</strong>

                                        <input type="text" id="searchReportKey" class="form-control"
                                            placeholder="ស្វែងរកលេខកូដកម្មវិធី..." onkeyup="filterReportKeys(event)"
                                            style="width: 420px; height: 60px;" oninput="resetReportKeySelection()">
                                        <p id="reportResultCount" style="font-weight: bold;">ចំនួន: 0</p>

                                        <select name="report_key" id="reportKeySelect" class="form-control" size="5"
                                            onclick="getSelectedReportKey()"
                                            style="width: 420px; height: 260px; text-align: left;">
                                            @foreach ($reports as $report)
                                                <option value="{{ $report->id }}">{{ $report->report_key }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="col-md-3  d-flex flex-column align-items-center">
                                    <!-- Internal Increase Input -->
                                    <div class="form-group">
                                        <strong>កើនផ្ទៃក្នុង:</strong>
                                        <input type="number" name="internal_increase" id="internal_increase"
                                            class="form-control @error('internal_increase') is-invalid @enderror"
                                            style="width: 420px; height: 60px;" min="0" oninput="formatNumber(this)">
                                        @error('internal_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <strong>មិនបានគ្រោងទុក:</strong>
                                        <input type="number" name="unexpected_increase" id="unexpected_increase"
                                            class="form-control @error('unexpected_increase') is-invalid @enderror"
                                            style="width: 420px; height: 60px;" min="0" oninput="formatNumber(this)">
                                        @error('unexpected_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <strong>បំពេញបន្ថែម</strong>
                                        <input type="number" name="additional_increase" id="additional_increase"
                                            class="form-control @error('additional_increase') is-invalid @enderror"
                                            style="width: 420px; height: 60px;" min="0" oninput="formatNumber(this)">
                                        @error('additional_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-md-3  d-flex flex-column align-items-center">
                                    <!-- Report Key Input -->
                                    <div class="form-group">
                                        <strong>ថយ</strong>
                                        <input type="number" name="decrease" id="decrease"
                                            class="form-control @error('decrease') is-invalid @enderror" min="0"
                                            style="width: 420px; height: 60px;" oninput="formatNumber(this)">
                                        @error('decrease')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <strong>វិចារណកម្ម</strong>
                                        <input type="number" name="editorial" id="editorial"
                                            class="form-control @error('editorial') is-invalid @enderror" min="0"
                                            style="width: 420px; height: 60px;" oninput="formatNumber(this)">
                                        @error('editorial')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <!-- Second Row -->
                                <div class="col-md-4">
                                    <!-- Unexpected Increase Input -->

                                </div>

                                <div class="col-md-4">
                                    <!-- Additional Increase Input -->

                                </div>

                                <div class="col-md-4">
                                    <!-- Decrease Input -->

                                </div>

                                <div class="col-md-4">
                                    <!-- Editorial Input -->

                                </div>
                            </div>


                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn btn-primary ml-auto">
                                    <i class="fas fa-save"></i> បានរក្សាទុក
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('styles')
    {{-- Custom style here --}}

    <style>
        .border-wrapper {
            border: 2px solid black;
            padding: 10px;
        }

        .container-fluid {
            padding: 16px;
        }

        #subAccountKeySelect {
            text-align: left;
        }

        .btn,
        .form-control,
        th,
        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 16px;
        }
    </style>
@endsection

@section('scripts')
    {{-- Include SweetAlert2 --}}
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
        function updateCurrentLoan(finLawInput) {
            const finLawValue = parseFloat(finLawInput.value) || 0;
            const currentLoanInput = document.getElementById('current_loan');
            currentLoanInput.value = finLawValue;
        }

        function formatNumber(input) {
            // Optional: You can add formatting logic if necessary
            const value = input.value;
            input.value = value.replace(/\D/g, ''); // This example strips non-numeric characters
        }
    </script>
    <script>
        let selectedIndex = -1;

        // Function to filter sub-account keys
        function filterSubAccountKeys(event) {
            var input = document.getElementById('searchSubAccountKey').value.toLowerCase();
            var select = document.getElementById('subAccountKeySelect');
            var options = select.options;
            var count = 0;

            // Loop through options to filter them
            for (var i = 0; i < options.length; i++) {
                var optionText = options[i].textContent.toLowerCase();
                if (optionText.includes(input)) {
                    options[i].style.display = ''; // Show matching option
                    count++;
                } else {
                    options[i].style.display = 'none'; // Hide non-matching option
                }
            }

            // Update the result count
            document.getElementById('resultCount').innerText = 'ចំនួន: ' + count;

            // Handle arrow key navigation
            if (event.key === 'ArrowDown') {
                if (selectedIndex < options.length - 1) {
                    selectedIndex++;
                    while (options[selectedIndex].style.display === 'none') {
                        selectedIndex++;
                        if (selectedIndex >= options.length) {
                            selectedIndex = options.length - 1;
                            break;
                        }
                    }
                    options[selectedIndex].selected = true;
                    updateSubAccountInputField();
                }
            } else if (event.key === 'ArrowUp') {
                if (selectedIndex > 0) {
                    selectedIndex--;
                    while (options[selectedIndex].style.display === 'none') {
                        selectedIndex--;
                        if (selectedIndex < 0) {
                            selectedIndex = 0;
                            break;
                        }
                    }
                    options[selectedIndex].selected = true;
                    updateSubAccountInputField();
                }
            } else if (event.key === 'Enter') {
                updateSubAccountInputField();
            }
        }

        // Function to reset the selection if input changes
        function resetSubAccountSelection() {
            selectedIndex = -1;
            var select = document.getElementById('subAccountKeySelect');
            select.selectedIndex = -1; // Deselect any selected option
        }

        // Function to update input field with the selected dropdown value
        function updateSubAccountInputField() {
            var select = document.getElementById('subAccountKeySelect');
            var selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                document.getElementById('searchSubAccountKey').value = selectedOption.textContent;
            }
        }

        // Function to handle selection
        function getSelectedValue() {
            updateSubAccountInputField();
        }
    </script>

    <script>
        let reportSelectedIndex = -1;

        // Function to filter report keys
        function filterReportKeys(event) {
            var input = document.getElementById('searchReportKey').value.toLowerCase();
            var select = document.getElementById('reportKeySelect');
            var options = select.options;
            var count = 0;

            // Loop through options to filter them
            for (var i = 0; i < options.length; i++) {
                var optionText = options[i].textContent.toLowerCase();
                if (optionText.includes(input)) {
                    options[i].style.display = ''; // Show matching option
                    count++;
                } else {
                    options[i].style.display = 'none'; // Hide non-matching option
                }
            }

            // Update the result count
            document.getElementById('reportResultCount').innerText = 'ចំនួន: ' + count;

            // Handle arrow key navigation
            if (event.key === 'ArrowDown') {
                if (reportSelectedIndex < options.length - 1) {
                    reportSelectedIndex++;
                    while (options[reportSelectedIndex].style.display === 'none') {
                        reportSelectedIndex++;
                        if (reportSelectedIndex >= options.length) {
                            reportSelectedIndex = options.length - 1;
                            break;
                        }
                    }
                    options[reportSelectedIndex].selected = true;
                    updateReportKeyInputField();
                }
            } else if (event.key === 'ArrowUp') {
                if (reportSelectedIndex > 0) {
                    reportSelectedIndex--;
                    while (options[reportSelectedIndex].style.display === 'none') {
                        reportSelectedIndex--;
                        if (reportSelectedIndex < 0) {
                            reportSelectedIndex = 0;
                            break;
                        }
                    }
                    options[reportSelectedIndex].selected = true;
                    updateReportKeyInputField();
                }
            } else if (event.key === 'Enter') {
                updateReportKeyInputField();
            }
        }

        // Function to reset the selection if input changes
        function resetReportKeySelection() {
            reportSelectedIndex = -1;
            var select = document.getElementById('reportKeySelect');
            select.selectedIndex = -1; // Deselect any selected option
        }

        // Function to update input field with the selected dropdown value
        function updateReportKeyInputField() {
            var select = document.getElementById('reportKeySelect');
            var selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                document.getElementById('searchReportKey').value = selectedOption.textContent;
            }
        }

        // Function to handle selection from dropdown
        function getSelectedReportKey() {
            updateReportKeyInputField();
        }
    </script>
@endsection