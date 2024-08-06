@extends('layouts.master')

@section('form-form-mission')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 margin-tb mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">បញ្ចូលតារាងរបាយការណ៏ចំណាយបេសកកម្មក្នុងប្រទេស ឆ្នាំ២០២៤</h3>
                <a class="btn btn-primary" href="{{ route('missions.index') }}">ត្រឡប់ក្រោយ</a>
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
    
        <div class="border-wrapper">
            <div class="form-container">
                <form action="{{ route('missions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mission_letter">គោត្តនាម​​ និងនាម:</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <strong>តួនាទី:</strong>
                                <select name="role" class="form-control centered-text">
                                    <option value="">ជ្រើសរើសតួនាទី</option>
                                    <option value="អគ្កាធិការរង">អគ្កាធិការរង</option>
                                    <option value="អគ្គនាយករង">អគ្គនាយករង</option>
                                    <option value="អគ្គលេខាធិការរង">អគ្គលេខាធិការរង</option>
                                    <option value="រដ្ឋលេខាធិការ">រដ្ឋលេខាធិការ</option>
                                    <option value="អនុរដ្ឋលេខាធិការ">អនុរដ្ឋលេខាធិការ</option>
                                    <option value="ប្រ.ការិយាល័យ">ប្រ.ការិយាល័យ</option>
                                    <option value="អនុ.ការិយាល័យ">អនុ.ការិយាល័យ</option>
                                    <option value="អនុប្រធានផ្នែក">អនុប្រធានផ្នែក</option>
                                    <option value="មន្រ្តី">មន្ត្រី</option>
                                    <option value="ជំនួយការ">ជំនួយការ</option>     
                                </select>
                            </div>
                            

                            <div class="form-group">
                                <label for="position_type">ប្រភេទមុខតំណែង:</label>
                                <select name="position_type" id="position_type" class="form-control centered-text">
                                    <option value="">ជ្រើសរើសប្រភេទតួនាទី</option>
                                    <option value="ក">ក</option>
                                    <option value="ខ១">ខ១</option>
                                    <option value="ខ២">ខ២</option>
                                    <option value="គ">គ</option>
                                    <option value="ឃ">ឃ</option>
                                    <option value="ង">ង</option>
                                </select>
                            </div>                            

                            <div class="form-group">
                                <label for="mission_letter">លិខិតបញ្ជាបេសកកម្ម:</label>
                                <div class="form-subgroup">
                                    <label for="letter_number">លេខ:</label>
                                    <input type="text" name="letter_number" id="letter_number" class="form-control form-number @error('letter_number') is-invalid @enderror">
                                    @error('letter_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-subgroup">
                                    <label for="letter_date">កាលបរិច្ឆេទ:</label>
                                    <input type="date" name="letter_date" id="letter_date" class="form-control form-number @error('letter_date') is-invalid @enderror">
                                    @error('letter_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="internal_increase">កម្មវត្ថុនៃការចុះបេសកកម្ម:</label>
                                <input type="text" name="mission_objective" id="internal_increase"
                                    class="form-control @error('internal_increase') is-invalid @enderror">
                                @error('internal_increase')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="place">ទីកន្លែង:</label>
                                <select name="place" id="place" class="form-control centered-text">
                                    <option value="">ជ្រើសរើសទីកន្លែង</option>
                                    <option value="within_country">ក្នុងប្រទេស</option>
                                    <option value="abroad">ក្រៅប្រទេស</option>
                                </select>
                            </div>
                        
                            <div class="form-group">
                                <label for="location">ជ្រើសរើសខេត្ត ឬ ប្រទេស:</label>
                                <select name="location" id="location" class="form-control centered-text">
                                    <option value="">ជ្រើសរើសខេត្ត ឬ ប្រទេស</option>
                                </select>
                            </div>
                             
                           <div class="form-group">
                                <label for="mission_letter">កាលបរិច្ឆេទចុះបេសកកម្ម:</label>
                                <div class="form-subgroup">
                                    <label for="letter_date">ចាប់ផ្ដើម:</label>
                                    <input type="date" name="mission_start_date" id="letter_date" class="form-control form-number @error('letter_date') is-invalid @enderror">
                                    @error('letter_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-subgroup">
                                    <label for="letter_date">បញ្ចប់:</label>
                                    <input type="date" name="mission_end_date" id="letter_date" class="form-control form-number @error('letter_date') is-invalid @enderror">
                                    @error('letter_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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
        .form-number{
            margin-left: 25px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>

const locations = {
        'កំពង់ធំ': 268800, 'តាកែវ': 123200, 'សៀមរាប': 499200, // Add other provinces
    };

    const countries = [
        'អាមេរិក', 'កាណាដា', 'ឡាវ', 'វៀតណាម', 'ថៃ', // Add other countries
    ];

    function updateLocationOptions() {
        const placeSelect = document.getElementById('place');
        const locationSelect = document.getElementById('location');
        const placeValue = placeSelect.value;

        // Clear previous options
        locationSelect.innerHTML = '<option value="">ជ្រើសរើសខេត្ត ឬ ប្រទេស</option>';

        if (placeValue === 'within_country') {
            Object.keys(locations).forEach(location => {
                const option = document.createElement('option');
                option.value = location;
                option.textContent = location;
                locationSelect.appendChild(option);
            });
        } else if (placeValue === 'abroad') {
            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country;
                option.textContent = country;
                locationSelect.appendChild(option);
            });
        }
    }
    
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

        $(function() {
            // Populate location dropdown based on place selection
            $("#place").change(function() {
                var place = $(this).val();
                var locationSelect = $("#location");
                locationSelect.empty(); // Clear existing options

                if (place === "within_country") {
                    locationSelect.append('<option value="">ជ្រើសរើសខេត្ត</option>');
                    locationSelect.append('<option value="កំពង់ធំ">កំពង់ធំ</option>');
                    locationSelect.append('<option value="តាកែវ">តាកែវ</option>');
                    locationSelect.append('<option value="សៀមរាប">សៀមរាប</option>');
                    locationSelect.append('<option value="កំពង់ចាម">កំពង់ចាម</option>');
                    locationSelect.append('<option value="បាត់ដំបង">បាត់ដំបង</option>');
                    locationSelect.append('<option value="ប៉ៃលិន">ប៉ៃលិន</option>');
                    locationSelect.append('<option value="បន្ទាយមានជ័យ">បន្ទាយមានជ័យ</option>');
                    locationSelect.append('<option value="ពោធិ៍សាត់">ពោធិ៍សាត់</option>');
                    locationSelect.append('<option value="ព្រះសីហនុ">ព្រះសីហនុ</option>');
                    locationSelect.append('<option value="កំពត">កំពត</option>');
                    locationSelect.append('<option value="កែប">កែប</option>');
                    locationSelect.append('<option value="ឧត្តរមានជ័យ">ឧត្តរមានជ័យ</option>');
                    locationSelect.append('<option value="ព្រៃវែង">ព្រៃវែង</option>');
                    locationSelect.append('<option value="ស្វាយរៀង">ស្វាយរៀង</option>');
                    locationSelect.append('<option value="ត្បូងឃ្មុំ">ត្បូងឃ្មុំ</option>');
                    locationSelect.append('<option value="ក្រចេះ">ក្រចេះ</option>');
                    locationSelect.append('<option value="មណ្ឌលគីរី">មណ្ឌលគីរី</option>');
                    locationSelect.append('<option value="រតនគីរី">រតនគីរី</option>');
                    locationSelect.append('<option value="កណ្ដាល">កណ្ដាល</option>');
                    locationSelect.append('<option value="កោះកុង">កោះកុង</option>');
                    locationSelect.append('<option value="កំពង់ស្ពី">កំពង់ស្ពី</option>');
                    locationSelect.append('<option value="ស្ទឹងត្រែង">ស្ទឹងត្រែង</option>');
                    locationSelect.append('<option value="ព្រះវិហារ">ព្រះវិហារ</option>');
                    locationSelect.append('<option value="កំពង់ឆ្នាំង">កំពង់ឆ្នាំង</option>');
                } else if (place === "abroad") {
                    locationSelect.append('<option value="">ជ្រើសរើសប្រទេស</option>');
                    locationSelect.append('<option value="អាមេរិក">អាមេរិក</option>');
                    locationSelect.append('<option value="កាណាដា">កាណាដា</option>');
                    locationSelect.append('<option value="ឡាវ">ឡាវ</option>');
                    locationSelect.append('<option value="វៀតណាម">វៀតណាម</option>');
                    locationSelect.append('<option value="ថៃ">ថៃ</option>');
                    locationSelect.append('<option value="ចិន">ចិន</option>');
                    locationSelect.append('<option value="កូរ៉េ">កូរ៉េ</option>');
                    locationSelect.append('<option value="ជប៉ុន">ជប៉ុន</option>');
                    locationSelect.append('<option value="មីយ៉ាន់ម៉ា">មីយ៉ាន់ម៉ា</option>');
                    locationSelect.append('<option value="អឺរ៉ុប">អឺរ៉ុប</option>');
                } else{
                    locationSelect.append('<option value="">ជ្រើសរើសខេត្ត ឬ ប្រទេស</option>');
                } 
            });
        });
    </script>

@endsection
