@extends('layouts.master')

@section('form-report-upload')
    <div class="border-wrapper">

        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">បង្កើតទិន្នន័យ</h3>
                            <a class="btn btn-danger" href="{{ route('codes.index') }}"> <i class="fas fa-arrow-left"></i>
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
                        <form action="{{ route('codes.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Sub Account Key Input -->
                                    <div class="form-group">
                                        <strong>លេខអនុគណនី:</strong>
                                        <input type="text" id="searchSubAccountKey" class="form-control"
                                            placeholder="ស្វែងរកលេខអនុគណនី...">
                                        <p id="resultCount" style="font-weight: bold;">ចំនួន: 0</p>

                                        <select name="sub_account_key" id="subAccountKeySelect" class="form-control "
                                            size="5" onclick="getSelectedValue()">
                                            @foreach ($subAccountKeys as $subAccountKey)
                                                <option value="{{ $subAccountKey->id }}">
                                                    {{ $subAccountKey->sub_account_key }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <!-- Report Key Input -->
                                    <div class="form-group">
                                        <label for="report_key">លេខកូដកម្មវិធី:</label>
                                        <input type="number" name="report_key" id="report_key"
                                            class="form-control @error('destination') is-invalid @enderror">
                                        @error('report_key')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Name Report Key Input -->
                                    <div class="form-group">
                                        <label for="name_report_key">ចំណាត់ថ្នាក់:</label>
                                        <input type="text" name="name_report_key" id="name_report_key"
                                            class="form-control @error('name_report_key') is-invalid @enderror">
                                        @error('name_report_key')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Financial Law Input -->
                                    <div class="form-group">
                                        <label for="fin_law">ច្បាប់ហិរញ្ញវត្ថុ:</label>
                                        <input type="number" name="fin_law" id="fin_law"
                                            class="form-control @error('fin_law') is-invalid @enderror" min="0"
                                            oninput="updateCurrentLoan(this); formatNumber(this)">
                                        @error('fin_law')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>




                                    <!-- Current Loan Input (readonly) -->
                                    <div class="form-group">
                                        <label for="current_loan">ឥណទានបច្ចុប្បន្ន:</label>
                                        <input type="number" name="current_loan" id="current_loan"
                                            class="form-control @error('current_loan') is-invalid @enderror" readonly>
                                        @error('current_loan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- Internal Increase Input -->
                                    <div class="form-group">
                                        <label for="internal_increase">កើនផ្ទៃក្នុង:</label>
                                        <input type="number" name="internal_increase" id="internal_increase"
                                            class="form-control @error('internal_increase') is-invalid @enderror"
                                            min="0" oninput="formatNumber(this)">
                                        @error('internal_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Unexpected Increase Input -->
                                    <div class="form-group">
                                        <label for="unexpected_increase">មិនបានគ្រោងទុក:</label>
                                        <input type="number" name="unexpected_increase" id="unexpected_increase"
                                            class="form-control @error('unexpected_increase') is-invalid @enderror"
                                            min="0" oninput="formatNumber(this)">
                                        @error('unexpected_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Additional Increase Input -->
                                    <div class="form-group">
                                        <label for="additional_increase">បំពេញបន្ថែម:</label>
                                        <input type="number" name="additional_increase" id="additional_increase"
                                            class="form-control @error('additional_increase') is-invalid @enderror"
                                            min="0" oninput="formatNumber(this)">
                                        @error('additional_increase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Decrease Input -->
                                    <div class="form-group">
                                        <label for="decrease">ថយ:</label>
                                        <input type="number" name="decrease" id="decrease"
                                            class="form-control @error('decrease') is-invalid @enderror" min="0"
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

        #subAccountKeySelect {
            text-align: left;
        }

        .btn,
        .form-control,
        /* label, */
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
        let currentIndex = -1; // Initialize to -1 so no item is selected initially

        document.getElementById('searchSubAccountKey').addEventListener('input', function() {
            const filter = this.value.toUpperCase();
            const select = document.getElementById('subAccountKeySelect');
            const options = select.getElementsByTagName('option');
            let resultCount = 0;

            // Reset selection index when search input changes
            currentIndex = -1;

            for (let i = 0; i < options.length; i++) {
                const optionText = options[i].textContent || options[i].innerText;
                if (optionText.toUpperCase().indexOf(filter) > -1) {
                    options[i].style.display = '';
                    resultCount++;
                } else {
                    options[i].style.display = 'none';
                }
            }

            document.getElementById('resultCount').textContent = `ចំនួន: ${resultCount}`;
        });

        // Event listener for pressing "Enter", "ArrowUp", and "ArrowDown" keys
        document.getElementById('searchSubAccountKey').addEventListener('keydown', function(event) {
            const select = document.getElementById('subAccountKeySelect');
            const options = select.getElementsByTagName('option');
            const visibleOptions = Array.from(options).filter(option => option.style.display !== 'none');

            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent default action (form submission)
                if (visibleOptions.length > 0 && currentIndex >= 0) {
                    // Select the current highlighted option when pressing "Enter"
                    select.selectedIndex = Array.from(options).indexOf(visibleOptions[currentIndex]);
                    getSelectedValue(); // Show the selected value in SweetAlert
                }
            } else if (event.key === 'ArrowDown') {
                event.preventDefault();
                // Move down through the visible options
                if (currentIndex < visibleOptions.length - 1) {
                    currentIndex++;
                    highlightOption(visibleOptions[currentIndex]);
                }
            } else if (event.key === 'ArrowUp') {
                event.preventDefault();
                // Move up through the visible options
                if (currentIndex > 0) {
                    currentIndex--;
                    highlightOption(visibleOptions[currentIndex]);
                }
            }
        });

        function highlightOption(option) {
            const select = document.getElementById('subAccountKeySelect');
            const options = select.getElementsByTagName('option');

            // Remove highlight from all options
            for (let i = 0; i < options.length; i++) {
                options[i].style.backgroundColor = ''; // Remove highlight
            }

            // Highlight the currently selected option
            option.style.backgroundColor = '#d1e7dd'; // You can choose any highlight color
        }

        function getSelectedValue() {
            const select = document.getElementById('subAccountKeySelect');
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
