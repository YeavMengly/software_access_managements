@extends('layouts.master')
@section('form-form-mission')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb mb-4 mt-4">
                <div class="d-flex justify-content-between align-items-center"
                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                    <a class="btn btn-danger" href="{{ route('back') }}"
                        style="width: 160px; height: 50px; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-arrow-left"></i>&nbsp;&nbsp;
                    </a>
                    <h3 class="card-title">បញ្ចូលតារាងរបាយការណ៏ចំណាយបេសកកម្មក្នុងប្រទេស ឆ្នាំ២០២៤</h3><span></span>
<<<<<<< HEAD
=======
                    <h3 class="card-title">បញ្ចូលតារាងរបាយការណ៏ចំណាយបេសកកម្មក្នុងប្រទេស ឆ្នាំ២០២៤</h3>
                    <a class="btn btn-danger" href="{{ route('dashboard') }}"><i class="fas fa-arrow-left"></i>
                        ត្រឡប់ក្រោយ</a>
>>>>>>> 291645b93392bf5ef951aecb7229d969c251e878
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
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Whoops!',
                        html: `
                    <ul style="text-align: left;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    });
                });
            </script>
        @endif

        <div class="border-wrapper">
            <div class="form-container">
                <form action="{{ route('mission-cam.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row" style="font-family: 'Khmer OS Siemreap', sans-serif;">
                        <div class="col-md-6">
                            <!-- Number of people -->
                            <div class="form-group">
                                <label for="num_people">ចំនួនមនុស្ស:</label>
                                <select id="num_people" class="form-control centered-text" required>
                                    <option value="">ជ្រើសរើសចំនួនមនុស្ស</option>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div id="rows-container"></div>

                            <!-- Mission letter fields -->
                            <div class="form-group">
                                <label for="mission_letter">លិខិតបញ្ជាបេសកកម្ម:</label>
                                <div class="form-subgroup">
                                    <label for="letter_number">លេខ:</label>
                                    <div class="input-group mx-3">
                                        <!-- Number input -->
                                        <input type="number" name="letter_number" id="letter_number"
                                            class="form-control @error('letter_number') is-invalid @enderror" min="0"
                                            placeholder="Enter number" oninput="updateFullLetterNumber()">

                                        <!-- Format selection dropdown -->
                                        <select id="letter_format" name="letter_format" class="form-select mx-3"
                                            onchange="updateFullLetterNumber()">
                                            <option value=""></option>
                                            <option value=" កប/ល.ប.ក">កប/ល.ប.ក</option>
                                            <option value=" កប/ឧ.ទ.ន">កប/ឧ.ទ.ន</option>
                                            <option value=" កប/ឧ.ទ.ន.ខ.ល">កប/ឧ.ទ.ន.ខ.ល</option>
                                            <option value=" កប/ឧ.ទ.ន.គ.ក.ប">កប/ឧ.ទ.ន.គ.ក.ប</option>
                                        </select>

                                        <!-- Hidden input to store the combined value -->
                                        <input type="hidden" name="full_letter_number" id="full_letter_number">
                                    </div>
                                </div>

                                <div class="form-subgroup">
                                    <label for="letter_date">កាលបរិច្ឆេទ:</label>
                                    <input type="date" name="letter_date" id="letter_date"
                                        class="form-control form-number @error('letter_date') is-invalid @enderror">
                                    @error('letter_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="internal_increase">កម្មវត្ថុនៃការចុះបេសកកម្ម:</label>
                                <textarea name="mission_objective" id="internal_increase" rows="5"
                                    class="form-control @error('internal_increase') is-invalid @enderror"
                                    style="resize: vertical; font-family: 'Khmer OS Siemreap', sans-serif;"></textarea>
                                @error('internal_increase')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="location">ជ្រើសរើសខេត្ត:</label>
                                <select name="location" id="location" class="form-control centered-text">
                                    <option value="">ជ្រើសរើសខេត្ត</option>
                                    <option value="កំពង់ធំ">កំពង់ធំ</option>
                                    <option value="តាកែវ">តាកែវ</option>
                                    <option value="សៀមរាប">សៀមរាប</option>
                                    <option value="កំពង់ចាម">កំពង់ចាម</option>
                                    <option value="បាត់ដំបង">បាត់ដំបង</option>
                                    <option value="ប៉ៃលិន">ប៉ៃលិន</option>
                                    <option value="បន្ទាយមានជ័យ">បន្ទាយមានជ័យ</option>
                                    <option value="ពោធិ៍សាត់">ពោធិ៍សាត់</option>
                                    <option value="ព្រះសីហនុ">ព្រះសីហនុ</option>
                                    <option value="កំពត">កំពត</option>
                                    <option value="កែប">កែប</option>
                                    <option value="ឧត្តរមានជ័យ">ឧត្តរមានជ័យ</option>
                                    <option value="ព្រៃវែង">ព្រៃវែង</option>
                                    <option value="ស្វាយរៀង">ស្វាយរៀង</option>
                                    <option value="ត្បូងឃ្មុំ">ត្បូងឃ្មុំ</option>
                                    <option value="ក្រចេះ">ក្រចេះ</option>
                                    <option value="មណ្ឌលគីរី">មណ្ឌលគីរី</option>
                                    <option value="រតនគីរី">រតនគីរី</option>
                                    <option value="កណ្ដាល">កណ្ដាល</option>
                                    <option value="កោះកុង">កោះកុង</option>
                                    <option value="កំពង់ស្ពឺ">កំពង់ស្ពឺ</option>
                                    <option value="ស្ទឹងត្រែង">ស្ទឹងត្រែង</option>
                                    <option value="ព្រះវិហារ">ព្រះវិហារ</option>
                                    <option value="កំពង់ឆ្នាំង">កំពង់ឆ្នាំង</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="mission_letter">កាលបរិច្ឆេទចុះបេសកកម្ម:</label>
                                <div class="form-subgroup">
                                    <label for="letter_date">ចាប់ផ្ដើម:</label>
                                    <input type="date" name="mission_start_date" id="letter_date"
                                        class="form-control form-number @error('letter_date') is-invalid @enderror">
                                    @error('letter_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-subgroup">
                                    <label for="letter_date">បញ្ចប់:</label>
                                    <input type="date" name="mission_end_date" id="letter_date"
                                        class="form-control form-number @error('letter_date') is-invalid @enderror">
                                    @error('letter_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="font-family: 'Khmer OS Siemreap', sans-serif;">
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

        .form-number {
            margin-left: 25px;
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

        $(document).ready(function() {
            const numPeopleSelect = $('#num_people');
            const rowsContainer = $('#rows-container');

            numPeopleSelect.on('change', function() {
                const numPeople = parseInt($(this).val(), 10);
                rowsContainer.empty(); // Clear previous rows

                for (let i = 0; i < numPeople; i++) {
                    const rowHtml = `
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name_${i + 1}">ឈ្មោះមន្ត្រី ${i + 1}:</label>
                            <input type="text" name="names[]" id="name_${i + 1}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="role_${i + 1}">តួនាទី ${i + 1}:</label>
                            <select name="people[${i}][role]" id="role_${i}" class="form-control centered-text" required>
                                <option value="">ជ្រើសរើសតួនាទី</option>
                                <option value="រដ្ឋមន្រ្តី">រដ្ឋមន្រ្តី</option>
                                <option value="ទីប្រឹក្សាអមក្រសួង">ទីប្រឹក្សាអមក្រសួង</option>
                                <option value="រដ្ឋលេខាធិការ">រដ្ឋលេខាធិការ</option>
                                <option value="អនុរដ្ឋលេខាធិការ">អនុរដ្ឋលេខាធិការ</option>
                                <option value="អគ្កាធិការ">អគ្កាធិការ</option>
                                <option value="អគ្កាធិការរង">អគ្កាធិការរង</option>
                                <option value="អគ្គនាយក">អគ្គនាយក</option>
                                <option value="អគ្គនាយករង">អគ្គនាយករង</option>
                                <option value="អគ្គលេខាធិការ">អគ្គលេខាធិការ</option>
                                <option value="អគ្គលេខាធិការរង">អគ្គលេខាធិការរង</option>
                                <option value="ប្រ.នាយកដ្ឋាន">ប្រ.នាយកដ្ឋាន</option>
                                <option value="អនុ.នាយកដ្ឋាន">អនុ.នាយកដ្ឋាន</option>
                                <option value="ប្រ.ការិយាល័យ">ប្រ.ការិយាល័យ</option>
                                <option value="អនុ.ការិយាល័យ">អនុ.ការិយាល័យ</option>
                                <option value="នាយកវិទ្យាស្ថាន">នាយកវិទ្យាស្ថាន</option>
                                <option value="ប្រធានផ្នែក">ប្រធានផ្នែក</option>
                                <option value="អនុប្រធានផ្នែក">អនុប្រធានផ្នែក</option>
                                <option value="មន្ត្រី">មន្ត្រី</option>
                                <option value="ជំនួយការ">ជំនួយការ</option>
                                <option value="មន្ត្រីជាប់កិច្ចសន្យា">មន្ត្រីជាប់កិច្ចសន្យា</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="position_type_${i + 1}">មុខងារ ${i + 1}:</label>
                            <select name="people[${i}][position_type]" id="position_type_${i}" class="form-control centered-text" required>
                                <option value="">ជ្រើសរើសប្រភេទតួនាទី</option>
                                <option value="ក">ក</option>
                                <option value="ខ១">ខ១</option>
                                <option value="ខ២">ខ២</option>
                                <option value="គ">គ</option>
                                <option value="ឃ">ឃ</option>
                                <option value="ង">ង</option>
                            </select>
                        </div>
                    </div>
                </div>
            `;
                    rowsContainer.append(rowHtml);
                }
            });
            document.getElementById('place').addEventListener('change', updateLocationOptions);
        });
    </script>
    <script>
        function updateFullLetterNumber() {
            const letterNumber = document.getElementById('letter_number').value;
            const letterFormat = document.getElementById('letter_format').value;
            document.getElementById('full_letter_number').value = letterNumber + letterFormat;
        }
    </script>
    @if (session('error'))
        <script>
            // SweetAlert will show the error message
            Swal.fire({
                icon: 'error',
                title: 'ទិន្នន័យដែលបានបញ្ចូលមិនជោគជ័យ',
            });
        </script>
<<<<<<< HEAD
=======
        </script>      
>>>>>>> 291645b93392bf5ef951aecb7229d969c251e878
    @endif
@endsection
