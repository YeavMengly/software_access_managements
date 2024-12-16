@extends('layouts.master')

@section('form-form-mission')
    <div class="container-fluid" style="font-family: 'Khmer OS Siemreap', sans-serif;">
        <div class="row">
            <div class="col-lg-12 margin-tb mb-4 mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">កែប្រែទម្រង់បេសកកម្ម</h3>
                    <a class="btn btn-primary" href="{{ route('mission-cam.index') }}">ត្រឡប់ក្រោយ</a>
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
                <form action="{{ route('missions.update', $missions->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div id="rows-container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">ឈ្មោះមន្ត្រី:</label>
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name', $missions->name) }}"
                                                oninput="updateCurrentLoan(this)">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="role">តួនាទី:</label>
                                            <select name="role" id="role" class="form-control centered-text"
                                                required>
                                                <option value="">ជ្រើសរើសតួនាទី</option>
                                                <option value="រដ្ឋមន្រ្តី"
                                                    {{ old('role', $missions->role ?? '') == 'រដ្ឋមន្រ្តី' ? 'selected' : '' }}>
                                                    រដ្ឋមន្រ្តី</option>
                                                <option value="ទីប្រឹក្សាអមក្រសួង"
                                                    {{ old('role', $missions->role ?? '') == 'ទីប្រឹក្សាអមក្រសួង' ? 'selected' : '' }}>
                                                    ទីប្រឹក្សាអមក្រសួង</option>
                                                <option value="រដ្ឋលេខាធិការ"
                                                    {{ old('role', $missions->role ?? '') == 'រដ្ឋលេខាធិការ' ? 'selected' : '' }}>
                                                    រដ្ឋលេខាធិការ</option>
                                                <option value="អនុរដ្ឋលេខាធិការ"
                                                    {{ old('role', $missions->role ?? '') == 'អនុរដ្ឋលេខាធិការ' ? 'selected' : '' }}>
                                                    អនុរដ្ឋលេខាធិការ</option>
                                                <option value="អគ្កាធិការ"
                                                    {{ old('role', $missions->role ?? '') == 'អគ្កាធិការ' ? 'selected' : '' }}>
                                                    អគ្កាធិការ</option>
                                                <option value="អគ្កាធិការរង"
                                                    {{ old('role', $missions->role ?? '') == 'អគ្កាធិការរង' ? 'selected' : '' }}>
                                                    អគ្កាធិការរង</option>
                                                <option value="អគ្គនាយក"
                                                    {{ old('role', $missions->role ?? '') == 'អគ្គនាយក' ? 'selected' : '' }}>
                                                    អគ្គនាយក</option>
                                                <option value="អគ្គនាយករង"
                                                    {{ old('role', $missions->role ?? '') == 'អគ្គនាយករង' ? 'selected' : '' }}>
                                                    អគ្គនាយករង</option>
                                                <option value="អគ្គលេខាធិការ"
                                                    {{ old('role', $missions->role ?? '') == 'អគ្គលេខាធិការ' ? 'selected' : '' }}>
                                                    អគ្គលេខាធិការ</option>
                                                <option value="អគ្គលេខាធិការរង"
                                                    {{ old('role', $missions->role ?? '') == 'អគ្គលេខាធិការរង' ? 'selected' : '' }}>
                                                    អគ្គលេខាធិការរង</option>
                                                <option value="ប្រ.នាយកដ្ឋាន"
                                                    {{ old('role', $missions->role ?? '') == 'ប្រ.នាយកដ្ឋាន' ? 'selected' : '' }}>
                                                    ប្រ.នាយកដ្ឋាន</option>
                                                <option value="អនុ.នាយកដ្ឋាន"
                                                    {{ old('role', $missions->role ?? '') == 'អនុ.នាយកដ្ឋាន' ? 'selected' : '' }}>
                                                    អនុ.នាយកដ្ឋាន</option>
                                                <option value="ប្រ.ការិយាល័យ"
                                                    {{ old('role', $missions->role ?? '') == 'ប្រ.ការិយាល័យ' ? 'selected' : '' }}>
                                                    ប្រ.ការិយាល័យ</option>
                                                <option value="អនុ.ការិយាល័យ"
                                                    {{ old('role', $missions->role ?? '') == 'អនុ.ការិយាល័យ' ? 'selected' : '' }}>
                                                    អនុ.ការិយាល័យ</option>
                                                <option value="នាយកវិទ្យាស្ថាន"
                                                    {{ old('role', $missions->role ?? '') == 'នាយកវិទ្យាស្ថាន' ? 'selected' : '' }}>
                                                    នាយកវិទ្យាស្ថាន</option>
                                                <option value="ប្រធានផ្នែក"
                                                    {{ old('role', $missions->role ?? '') == 'ប្រធានផ្នែក' ? 'selected' : '' }}>
                                                    ប្រធានផ្នែក</option>
                                                <option value="អនុប្រធានផ្នែក"
                                                    {{ old('role', $missions->role ?? '') == 'អនុប្រធានផ្នែក' ? 'selected' : '' }}>
                                                    អនុប្រធានផ្នែក</option>
                                                <option value="មន្រ្តី"
                                                    {{ old('role', $missions->role ?? '') == 'មន្រ្តី' ? 'selected' : '' }}>
                                                    មន្ត្រី</option>
                                                <option value="ជំនួយការ"
                                                    {{ old('role', $missions->role ?? '') == 'ជំនួយការ' ? 'selected' : '' }}>
                                                    ជំនួយការ</option>
                                                <option value="មន្ត្រីជាប់កិច្ចសន្យា"
                                                    {{ old('role', $missions->role ?? '') == 'មន្ត្រីជាប់កិច្ចសន្យា' ? 'selected' : '' }}>
                                                    មន្ត្រីជាប់កិច្ចសន្យា</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="position_type">មុខងារ:</label>
                                            <select name="position_type" id="position_type"
                                                class="form-control centered-text" required>
                                                <option value="">ជ្រើសរើសប្រភេទតួនាទី</option>
                                                <option value="ក"
                                                    {{ old('position_type', $missions->position_type ?? '') == 'ក' ? 'selected' : '' }}>
                                                    ក</option>
                                                <option value="ខ១"
                                                    {{ old('position_type', $missions->position_type ?? '') == 'ខ១' ? 'selected' : '' }}>
                                                    ខ១</option>
                                                <option value="ខ២"
                                                    {{ old('position_type', $missions->position_type ?? '') == 'ខ២' ? 'selected' : '' }}>
                                                    ខ២</option>
                                                <option value="គ"
                                                    {{ old('position_type', $missions->position_type ?? '') == 'គ' ? 'selected' : '' }}>
                                                    គ</option>
                                                <option value="ឃ"
                                                    {{ old('position_type', $missions->position_type ?? '') == 'ឃ' ? 'selected' : '' }}>
                                                    ឃ</option>
                                                <option value="ង"
                                                    {{ old('position_type', $missions->position_type ?? '') == 'ង' ? 'selected' : '' }}>
                                                    ង</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mission letter fields -->
                            <div class="form-group">
                                <label for="mission_letter">លិខិតបញ្ជាបេសកកម្ម:</label>
                                <div class="form-subgroup">
                                    <label for="letter_number">លេខ:</label>
                                    <div class="input-group mx-3">
                                        <!-- Number input -->
                                        <input type="number" name="letter_number" id="letter_number"
                                            class="form-control @error('letter_number') is-invalid @enderror" min="0"
                                            placeholder="Enter number" oninput="updateFullLetterNumber()"
                                            value="{{ old('letter_number', $missions->letter_number ?? '') }}">

                                        <!-- Format selection dropdown -->

                                        <select id="letter_format" name="letter_format" class="form-select mx-3"
                                            onchange="updateFullLetterNumber()">
                                            <option value=""></option>
                                            <option value="កប/ល.ប.ក"
                                                {{ old('letter_format', $missions->letter_format ?? '') == 'កប/ល.ប.ក' ? 'selected' : '' }}>
                                                កប/ល.ប.ក
                                            </option>
                                            <option value="កប/ឧ.ទ.ន"
                                                {{ old('letter_format', $missions->letter_format ?? '') == 'កប/ឧ.ទ.ន' ? 'selected' : '' }}>
                                                កប/ឧ.ទ.ន
                                            </option>
                                            <option value="កប/ឧ.ទ.ន.ខ.ល"
                                                {{ old('letter_format', $missions->letter_format ?? '') == 'កប/ឧ.ទ.ន.ខ.ល' ? 'selected' : '' }}>
                                                កប/ឧ.ទ.ន.ខ.ល
                                            </option>
                                            <option value="កប/ឧ.ទ.ន.គ.ក.ប"
                                                {{ old('letter_format', $missions->letter_format ?? '') == 'កប/ឧ.ទ.ន.គ.ក.ប' ? 'selected' : '' }}>
                                                កប/ឧ.ទ.ន.គ.ក.ប
                                            </option>
                                        </select>

                                        <!-- Hidden input for combined value -->
                                        <input type="hidden" name="full_letter_number" id="full_letter_number"
                                            value="{{ old('full_letter_number', ($missions->letter_number ?? '') . ' ' . ($missions->letter_format ?? '')) }}">
                                    </div>
                                    @error('letter_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-subgroup">
                                    <label for="letter_date">កាលបរិច្ឆេទ:</label>
                                    <input type="date" name="letter_date" id="letter_date"
                                        class="form-control @error('letter_date') is-invalid @enderror"
                                        value="{{ old('letter_date', $missions->letter_date) }}"
                                        oninput="formatNumber(this)">
                                    @error('letter_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="travel_allowance">សោហ៊ុយធ្វើដំណើរ:</label>
                                <input type="number" name="travel_allowance" id="travel_allowance"
                                    class="form-control @error('travel_allowance') is-invalid @enderror"
                                    value="{{ old('travel_allowance', $missions->travel_allowance) }}">
                                @error('travel_allowance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mission_objective">កម្មវត្ថុនៃការចុះបេសកកម្ម:</label>
                                <input type="text" name="mission_objective" id="mission_objective"
                                    class="form-control @error('mission_objective') is-invalid @enderror"
                                    value="{{ old('mission_objective', $missions->mission_objective) }}"
                                    oninput="updateCurrentLoan(this)">
                                @error('mission_objective')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="location">ជ្រើសរើសខេត្ត:</label>
                                <select name="location" id="location" class="form-control centered-text">
                                    <option value="">ជ្រើសរើសខេត្ត</option>
                                    <option value="កំពង់ធំ"
                                        {{ old('location', $missions->location ?? '') == 'កំពង់ធំ' ? 'selected' : '' }}>
                                        កំពង់ធំ</option>
                                    <option value="តាកែវ"
                                        {{ old('location', $missions->location ?? '') == 'តាកែវ' ? 'selected' : '' }}>តាកែវ
                                    </option>
                                    <option value="សៀមរាប"
                                        {{ old('location', $missions->location ?? '') == 'សៀមរាប' ? 'selected' : '' }}>
                                        សៀមរាប</option>
                                    <option value="កំពង់ចាម"
                                        {{ old('location', $missions->location ?? '') == 'កំពង់ចាម' ? 'selected' : '' }}>
                                        កំពង់ចាម</option>
                                    <option value="បាត់ដំបង"
                                        {{ old('location', $missions->location ?? '') == 'បាត់ដំបង' ? 'selected' : '' }}>
                                        បាត់ដំបង</option>
                                    <option value="ប៉ៃលិន"
                                        {{ old('location', $missions->location ?? '') == 'ប៉ៃលិន' ? 'selected' : '' }}>
                                        ប៉ៃលិន</option>
                                    <option value="បន្ទាយមានជ័យ"
                                        {{ old('location', $missions->location ?? '') == 'បន្ទាយមានជ័យ' ? 'selected' : '' }}>
                                        បន្ទាយមានជ័យ</option>
                                    <option value="ពោធិ៍សាត់"
                                        {{ old('location', $missions->location ?? '') == 'ពោធិ៍សាត់' ? 'selected' : '' }}>
                                        ពោធិ៍សាត់</option>
                                    <option value="ព្រះសីហនុ"
                                        {{ old('location', $missions->location ?? '') == 'ព្រះសីហនុ' ? 'selected' : '' }}>
                                        ព្រះសីហនុ</option>
                                    <option value="កំពត"
                                        {{ old('location', $missions->location ?? '') == 'កំពត' ? 'selected' : '' }}>កំពត
                                    </option>
                                    <option value="កែប"
                                        {{ old('location', $missions->location ?? '') == 'កែប' ? 'selected' : '' }}>កែប
                                    </option>
                                    <option value="ឧត្តរមានជ័យ"
                                        {{ old('location', $missions->location ?? '') == 'ឧត្តរមានជ័យ' ? 'selected' : '' }}>
                                        ឧត្តរមានជ័យ</option>
                                    <option value="ព្រៃវែង"
                                        {{ old('location', $missions->location ?? '') == 'ព្រៃវែង' ? 'selected' : '' }}>
                                        ព្រៃវែង</option>
                                    <option value="ស្វាយរៀង"
                                        {{ old('location', $missions->location ?? '') == 'ស្វាយរៀង' ? 'selected' : '' }}>
                                        ស្វាយរៀង</option>
                                    <option value="ត្បូងឃ្មុំ"
                                        {{ old('location', $missions->location ?? '') == 'ត្បូងឃ្មុំ' ? 'selected' : '' }}>
                                        ត្បូងឃ្មុំ</option>
                                    <option value="ក្រចេះ"
                                        {{ old('location', $missions->location ?? '') == 'ក្រចេះ' ? 'selected' : '' }}>
                                        ក្រចេះ</option>
                                    <option value="មណ្ឌលគីរី"
                                        {{ old('location', $missions->location ?? '') == 'មណ្ឌលគីរី' ? 'selected' : '' }}>
                                        មណ្ឌលគីរី</option>
                                    <option value="រតនគីរី"
                                        {{ old('location', $missions->location ?? '') == 'រតនគីរី' ? 'selected' : '' }}>
                                        រតនគីរី</option>
                                    <option value="កណ្ដាល"
                                        {{ old('location', $missions->location ?? '') == 'កណ្ដាល' ? 'selected' : '' }}>
                                        កណ្ដាល</option>
                                    <option value="កោះកុង"
                                        {{ old('location', $missions->location ?? '') == 'កោះកុង' ? 'selected' : '' }}>
                                        កោះកុង</option>
                                    <option value="កំពង់ស្ពឺ"
                                        {{ old('location', $missions->location ?? '') == 'កំពង់ស្ពឺ' ? 'selected' : '' }}>
                                        កំពង់ស្ពឺ</option>
                                    <option value="ស្ទឹងត្រែង"
                                        {{ old('location', $missions->location ?? '') == 'ស្ទឹងត្រែង' ? 'selected' : '' }}>
                                        ស្ទឹងត្រែង</option>
                                    <option value="ព្រះវិហារ"
                                        {{ old('location', $missions->location ?? '') == 'ព្រះវិហារ' ? 'selected' : '' }}>
                                        ព្រះវិហារ</option>
                                    <option value="កំពង់ឆ្នាំង"
                                        {{ old('location', $missions->location ?? '') == 'កំពង់ឆ្នាំង' ? 'selected' : '' }}>
                                        កំពង់ឆ្នាំង</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="mission_letter">កាលបរិច្ឆេទចុះបេសកកម្ម:</label>
                                <div class="form-subgroup">
                                    <label for="mission_start_date">ចាប់ផ្ដើម:</label>
                                    <input type="date" name="mission_start_date" id="mission_start_date"
                                        class="form-control @error('mission_start_date') is-invalid @enderror"
                                        value="{{ old('mission_start_date', $missions->mission_start_date) }}"
                                        oninput="formatNumber(this)">
                                    @error('mission_start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-subgroup">
                                    <label for="mission_end_date">បញ្ចប់:</label>
                                    <input type="date" name="mission_end_date" id="mission_end_date"
                                        class="form-control @error('mission_end_date') is-invalid @enderror"
                                        value="{{ old('mission_end_date', $missions->mission_end_date) }}"
                                        oninput="formatNumber(this)">
                                    @error('mission_end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-primary ml-auto" id="submitButton">បញ្ចូល</button>
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

        .form-control {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            display: block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-subgroup {
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .centered-text {
            appearance: none;
            padding: 10px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-number {
            margin-left: 25px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('submitButton').addEventListener('click', function(event) {
            event.preventDefault();

            // Show SweetAlert
            Swal.fire({
                title: 'ជោគជ័យ',
                text: 'ទិន្នន័យរបស់អ្នកបានកែប្រែជោគជ័យ។',
                icon: 'success',
                confirmButtonText: 'យល់ព្រម',
                customClass: {
                    confirmButton: 'btn-primary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form after the user clicks "OK"
                    this.closest('form').submit();
                }
            });
        });

        $(function() {
            $("#letter_date").datepicker({
                dateFormat: "yy-mm-dd"
            });
        });

        (function($) {
            "use strict";

            //Troggle the side navigation
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

        })(jQuery);
    </script>
    <script>
        function updateFullLetterNumber() {
            var letterNumber = document.getElementById('letter_number').value;
            var letterFormat = document.getElementById('letter_format').value;
            var fullLetterNumber = letterNumber + ' ' + letterFormat;
            document.getElementById('full_letter_number').value = fullLetterNumber;
        }
    </script>
@endsection
