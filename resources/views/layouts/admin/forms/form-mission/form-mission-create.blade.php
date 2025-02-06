@extends('layouts.master')
@section('form-form-mission')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb ">
                <div class="d-flex justify-content-between align-items-center"
                    style="font-family: 'Khmer OS Siemreap', sans-serif;">
                    <a class="btn btn-danger" href="{{ route('back') }}"
                        style="width: 120px; height: 40px; border-radius: 4px; display: flex; align-items: center; justify-content: center; margin-left: 4px;">
                        <i class="fas fa-arrow-left"></i>
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
        <div class="d-flex justify-content-center align-items-center  mt-4">
            <div class="card shadow-lg" style="width: 90%;"> <!-- Adjusted width to 1080px -->

                <h3 class="card-title text-center mt-4" style="font-weight: 500;">បញ្ចូលរបាយការណ៏ចំណាយបេសកកម្មក្នុងប្រទេស
                </h3> <!-- Moved h3 out of the card-body -->
                <div class="card-body px-5 py-4">
                    <form action="{{ route('mission-cam.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row" style="font-family: 'Khmer OS Siemreap', sans-serif;">
                            <!-- Column 1 -->
                            <div class="col-md-6">
                                <!-- Number of people -->
                                <div class="form-group">
                                    <label for="num_people">ជ្រើសរើសចំនួនៈ</label>
                                    <select id="num_people" class="form-control centered-text custom-height" required >
                                        <option value="">ជ្រើសរើស</option>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div id="rows-container"></div>

                                <!-- Mission Letter -->
                                <div class="form-group">
                                    <label for="mission_letter">លិខិតបញ្ជាបេសកកម្ម:</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="number" name="letter_number" id="letter_number"
                                            class="form-control custom-height" min="0" placeholder="ចុះលេខ"
                                            oninput="updateFullLetterNumber()" style="flex: 1; height: 50px; margin: 2px;">
                                        <select id="letter_format" name="letter_format" class="form-select custom-height"
                                            onchange="updateFullLetterNumber()" style="flex: 2; height: 50px;">
                                            <option value=""></option>
                                            <option value=" កប/ល.ប.ក">កប/ល.ប.ក</option>
                                            <option value=" កប/ឧ.ទ.ន">កប/ឧ.ទ.ន</option>
                                            <option value=" កប/ឧ.ទ.ន.ខ.ល">កប/ឧ.ទ.ន.ខ.ល</option>
                                            <option value=" កប/ឧ.ទ.ន.គ.ក.ប">កប/ឧ.ទ.ន.គ.ក.ប</option>
                                        </select>
                                        <input type="hidden" name="full_letter_number" id="full_letter_number">
                                    </div>
                                </div>

                            </div>

                            <!-- Column 2 -->
                            {{-- <div class="col-md-3">
                               
                            </div> --}}

                            <!-- Column 3 -->
                            <div class="col-md-3">

                                 <!-- Mission Letter Date -->
                                 <div class="form-group">
                                    <label for="letter_date">កាលបរិច្ឆេទ:</label>
                                    <input type="date" name="letter_date" id="letter_date"
                                        class="form-control custom-height">
                                </div>

                                <!-- Mission Level -->
                                <div class="form-group">
                                    <label>ជ្រើសរើសបញ្ជី:</label>
                                    @foreach ($missionTag as $tag)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="m_tag" id="m_tag{{ $tag->id }}" 
                                                   value="{{ $tag->id }}" required>
                                            <label class="form-check-label" for="m_tag{{ $tag->id }}">{{ $tag->m_tag }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Mission Objective -->
                                <div class="form-group">
                                    <label for="mission_objective">កម្មវត្ថុនៃការចុះបេសកកម្ម:</label>
                                    <textarea name="mission_objective" id="mission_objective" rows="5" class="form-control custom-height"
                                        style="resize: vertical;"></textarea>
                                </div>
                            </div>

                            <!-- Column 4 -->
                            <div class="col-md-3">
                                <!-- Location -->
                                <div class="form-group">
                                    <label for="location">ជ្រើសរើសខេត្ត:</label>
                                    <select name="location" id="location" class="form-control centered-text custom-height">
                                        <option value="">ជ្រើសរើសខេត្ត</option>
                                        <option value="កំពង់ធំ">កំពង់ធំ</option>
                                        <option value="តាកែវ">តាកែវ</option>
                                        
                                    </select>
                                </div>

                                <!-- Mission Dates -->
                                <div class="form-group">
                                    <label>កាលបរិច្ឆេទចុះបេសកកម្ម:</label>
                                    <div class="form-group">
                                        <label for="mission_start_date">ចាប់ផ្ដើម:</label>
                                        <input type="date" name="mission_start_date" id="mission_start_date"
                                            class="form-control custom-height">
                                    </div>
                                    <div class="form-group">
                                        <label for="mission_end_date">បញ្ចប់:</label>
                                        <input type="date" name="mission_end_date" id="mission_end_date"
                                            class="form-control custom-height">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-12 text-center">
                                <!-- Reset Button -->
                                <button type="reset" class="btn btn-secondary ">
                                    <i class="fas fa-undo"></i>&nbsp;&nbsp;កំណត់ឡើងវិញ
                                </button>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary ml-3">
                                    <i class="fas fa-save"></i>&nbsp;&nbsp;រក្សាទុក
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .border-wrapper {
            border: 1px solid black;
            padding-left: 16px;
            padding-right: 16px;
        }

        .custom-height {
            height: 50px;
        }
   
        .form-control {
            width: 100%;
            height: 50px;
            padding: 10px;
            margin: 5px 0 15px 0;
            display: block;
            border: 1px solid #000000;
            border-radius: 4px;
            box-sizing: border-box;
        }
.form-check-input,
        .form-select{
            border: 1px solid #000000;
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
            text-align: center;
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
                            <label for="name_${i + 1}">ឈ្មោះ ${i + 1}:</label>
                            <input type="text" name="names[]" id="name_${i + 1}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="role_${i + 1}">តួនាទី ${i + 1}:</label>
                            <select name="people[${i}][role]" id="role_${i}" class="form-control centered text-align-items-start" required >
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
                            <select name="people[${i}][position_type]" id="position_type_${i}" class="form-control centered-text text-align-items-start" required>
                                <option value="">ជ្រើសរើសថ្នាក់មុខងារ</option>
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
    @endif
@endsection
