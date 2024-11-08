@extends('layouts.master')

@section('form-report-upload')
    <div class="border-wrapper">

        <div class="result-total-table-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 margin-tb mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span></span>
                            <h3 class="card-title" style="font-weight: 700;">បង្កើតទិន្នន័យ</h3>
                            <div class="d-flex">
                                <a class="btn btn-danger d-flex justify-content-center align-items-center mr-2"
                                    href="{{ url('/') }}" style="width: 160px; height: 50px;">
                                    <i class="fas fa-arrow-left"></i> &nbsp; ត្រឡប់ក្រោយ
                                </a>
                            </div>
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
                        <form action="{{ route('codes.store') }}" method="POST" enctype="multipart/form-data"
                            onsubmit="validateForm(event)">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="searchSubAccountKey"
                                                    class="font-weight-bold"><strong>លេខអនុគណនី:</strong></label>
                                                <input type="text" id="searchSubAccountKey"
                                                    class="form-control text-center" placeholder="ស្វែងរកលេខអនុគណនី..."
                                                    onkeyup="filterSubAccountKeys(event)"
                                                    oninput="resetSubAccountSelection()"
                                                    style="width: 420px; height: 60px; justify-content: center; align-content: center;">
                                                <p id="resultCount" style="font-weight: bold; margin-top: 8px;">ចំនួន: 0</p>
                                                <select name="sub_account_key" id="subAccountKeySelect" class="form-control"
                                                    size="5" onclick="getSelectedValue()"
                                                    style="height: 170px; width: 420px;">
                                                    @foreach ($subAccountKeys as $subAccountKey)
                                                        <option value="{{ $subAccountKey->id }}">
                                                            {{ $subAccountKey->sub_account_key }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span id="subAccountKeyError" class="text-danger"
                                                    style="display: none;">បញ្ជាក់ទិន្នន័យ</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="report_key"><strong>លេខកូដកម្មវិធី:</strong></label>
                                                <input type="number" name="report_key" id="report_key"
                                                    class="form-control @error('report_key') is-invalid @enderror"
                                                    style="width: 420px; height: 60px;">
                                                @error('report_key')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <span id="reportKeyError" class="text-danger"
                                                    style="display: none;">បញ្ជាក់ទិន្នន័យ</span>
                                            </div>

                                            <div class="form-group">
                                                <label for="fin_law"><strong>ច្បាប់ហិរញ្ញវត្ថុ:</strong></label>
                                                <input type="number" name="fin_law" id="fin_law"
                                                    class="form-control @error('fin_law') is-invalid @enderror"
                                                    style="width: 420px; height: 60px;" min="0"
                                                    oninput="updateCurrentLoan(this); formatNumber(this)">
                                                @error('fin_law')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <span id="finLawError" class="text-danger"
                                                    style="display: none;">បញ្ជាក់ទិន្នន័យ</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="current_loan"><strong>ឥណទានបច្ចុប្បន្ន:</strong></label>
                                                <input type="number" name="current_loan" id="current_loan"
                                                    class="form-control @error('current_loan') is-invalid @enderror"
                                                    style="width: 420px; height: 60px;" min="0">
                                                @error('current_loan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <span id="currentLoanError" class="text-danger"
                                                    style="display: none;">បញ្ជាក់ទិន្នន័យ</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name_report_key"><strong>ចំណាត់ថ្នាក់:</strong></label>
                                        <textarea name="name_report_key" id="name_report_key"
                                            class="form-control @error('name_report_key') is-invalid @enderror" style="height: 270px; text-align: left;"
                                            placeholder="សូមបញ្ចូលចំណាត់ថ្នាក់នៅនេះ..."></textarea>
                                        @error('name_report_key')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <span id="nameReportKeyError" class="text-danger"
                                            style="display: none;">បញ្ជាក់ទិន្នន័យ</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn btn-primary ml-auto"
                                    style="width: 300px; height: 60px;">
                                    <i class="fas fa-save"></i> រក្សាទុក
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        (function($) {
            "use strict";
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

        })(jQuery);
    </script>

    <script>
        function updateCurrentLoan(finLawInput) {
            const finLawValue = parseFloat(finLawInput.value) || 0;
            const currentLoanInput = document.getElementById('current_loan');
            currentLoanInput.value = finLawValue;
        }

        function formatNumber(input) {

            const value = input.value;
            input.value = value.replace(/\D/g, '');
        }
    </script>

    <script>
        let selectedIndex = -1;


        function filterSubAccountKeys(event) {
            var input = document.getElementById('searchSubAccountKey').value.toLowerCase();
            var select = document.getElementById('subAccountKeySelect');
            var options = select.options;
            var count = 0;


            for (var i = 0; i < options.length; i++) {
                var optionText = options[i].textContent.toLowerCase();
                if (optionText.includes(input)) {
                    options[i].style.display = '';
                    count++;
                } else {
                    options[i].style.display = 'none';
                }
            }

            document.getElementById('resultCount').innerText = 'ចំនួន: ' + count;

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

        function resetSubAccountSelection() {
            selectedIndex = -1;
            var select = document.getElementById('subAccountKeySelect');
            select.selectedIndex = -1;
        }

        function updateSubAccountInputField() {
            var select = document.getElementById('subAccountKeySelect');
            var selectedOption = select.options[select.selectedIndex];

            if (selectedOption) {
                document.getElementById('searchSubAccountKey').value = selectedOption.textContent;
            }
        }

        function getSelectedValue() {
            updateSubAccountInputField();
        }
    </script>
    <script>
        function validateForm(event) {
            let isValid = true;

            // Reset all error messages
            document.getElementById('subAccountKeyError').style.display = 'none';
            document.getElementById('reportKeyError').style.display = 'none';
            document.getElementById('finLawError').style.display = 'none';
            document.getElementById('currentLoanError').style.display = 'none';
            document.getElementById('nameReportKeyError').style.display = 'none';

            // Check if 'sub_account_key' is empty
            if (document.getElementById('subAccountKeySelect').value === "") {
                isValid = false;
                document.getElementById('subAccountKeyError').style.display = 'inline'; // Show error message
            }

            // Check if 'report_key' is empty
            if (document.getElementById('report_key').value === "") {
                isValid = false;
                document.getElementById('reportKeyError').style.display = 'inline'; // Show error message
            }

            // Check if 'fin_law' is empty
            if (document.getElementById('fin_law').value === "") {
                isValid = false;
                document.getElementById('finLawError').style.display = 'inline'; // Show error message
            }

            // Check if 'current_loan' is empty
            if (document.getElementById('current_loan').value === "") {
                isValid = false;
                document.getElementById('currentLoanError').style.display = 'inline'; // Show error message
            }

            // Check if 'name_report_key' is empty
            if (document.getElementById('name_report_key').value.trim() === "") {
                isValid = false;
                document.getElementById('nameReportKeyError').style.display = 'inline'; // Show error message
            }

            if (!isValid) {
                event.preventDefault();
            }
        }
    </script>
@endsection
