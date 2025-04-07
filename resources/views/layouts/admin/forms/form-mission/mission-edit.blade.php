@extends('layouts.master')

@section('form-form-mission')
    <div class="container-fluid" style="font-family: 'Khmer OS Siemreap', sans-serif;">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="d-flex justify-content-between align-items-center">
                    <a class="btn btn-danger" href="{{ route('mission-cam.index') }} "
                        style="width: 120px; height: 40px; border-radius: 4px; display: flex; align-items: center; justify-content: center; margin-left: 4px;">
                        <i class="fas fa-arrow-left"></i></a>

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

        <div class="d-flex justify-content-center align-items-center mt-4">
            <div class="card shadow-lg" style="width: 90%;">
                <h3 class="card-title text-center mt-4" style="font-weight: 500;">បញ្ចូលរបាយការណ៏ចំណាយបេសកកម្មក្នុងប្រទេស
                </h3>
                <div class="card-body px-5 py-4">
                    <form action="{{ route('missions.update', $mission->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row" style="font-family: 'Khmer OS Siemreap', sans-serif;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">ឈ្មោះ :</label>
                                                <input type="text" name="names[]" id="name" class="form-control"
                                                    required value="{{ $mission->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="role">តួនាទី :</label>
                                                <select name="roles[]" class="form-control" required>
                                                    <option value="">ជ្រើសរើសតួនាទី</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role }}"
                                                            {{ old('roles', $mission->role) == $role ? 'selected' : '' }}>
                                                            {{ $role }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="position_type">មុខងារ :</label>
                                                <select name="position_types[]" class="form-control" required>
                                                    <option value="">ជ្រើសរើសថ្នាក់មុខងារ</option>
                                                    @foreach (['ក', 'ខ១', 'ខ២', 'គ', 'ឃ', 'ង'] as $type)
                                                        <option value="{{ $type }}"
                                                            {{ old('position_types', $mission->position_type) == $type ? 'selected' : '' }}>
                                                            {{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div id="rows-container"></div>
                                <div class="form-group">
                                    {{-- <label for="mission_letter" style="font-weight: bold;">លិខិតបញ្ជាបេសកកម្ម:</label> --}}
                                    <div class="d-flex align-items-center gap-2">

                                        <!-- Label for Letter Number -->
                                        <div style="flex: 1; margin: 2px; padding-top: 8px;">
                                            <label for="letter_number">ចុះលេខ:</label>
                                            <input type="number" name="letter_number" id="letter_number"
                                                class="form-control custom-height" min="0" placeholder="ចុះលេខ"
                                                value="{{ $mission->letter_number }}" style="height: 50px;">
                                        </div>

                                        <!-- Label for Reference Selection -->
                                        <div style="flex: 2; margin: 2px;">
                                            <label for="letter_format">ជ្រើសរើសយោង:</label>
                                            <select id="letter_format" name="letter_format"
                                                class="form-select custom-height" style="height: 50px;">
                                                <option value="">ជ្រើសរើសយោង</option>

                                                <option value="កប/ល.ប.ក"
                                                    {{ old('letter_format', $mission->letter_format) == 'កប/ល.ប.ក' ? 'selected' : '' }}>
                                                    កប/ល.ប.ក</option>

                                                <option value="កប/ឧ.ទ.ន"
                                                    {{ old('letter_format', $mission->letter_format) == 'កប/ឧ.ទ.ន' ? 'selected' : '' }}>
                                                    កប/ឧ.ទ.ន</option>

                                                <option value="កប/ឧ.ទ.ន.ខ.ល"
                                                    {{ old('letter_format', $mission->letter_format) == 'កប/ឧ.ទ.ន.ខ.ល' ? 'selected' : '' }}>
                                                    កប/ឧ.ទ.ន.ខ.ល</option>

                                                <option value="កប/ឧ.ទ.ន.គ.ក.ប"
                                                    {{ old('letter_format', $mission->letter_format) == 'កប/ឧ.ទ.ន.គ.ក.ប' ? 'selected' : '' }}>
                                                    កប/ឧ.ទ.ន.គ.ក.ប</option>

                                                <option value="កប/ឧ.ទ.ន.ហ.ទ.រ"
                                                    {{ old('letter_format', $mission->letter_format) == 'កប/ឧ.ទ.ន.ហ.ទ.រ' ? 'selected' : '' }}>
                                                    កប/ឧ.ទ.ន.ហ.ទ.រ</option>
                                            </select>
                                        </div>

                                        <input type="hidden" name="full_letter_number" id="full_letter_number">

                                        <!-- Label for Program Selection -->
                                        {{-- <div style="flex: 2; margin: 2px;">
                                            <label for="p_format">ជ្រើសរើសកម្មវិធី:</label>
                                            <select id="p_format" name="p_format" class="form-select custom-height"
                                                style="height: 50px;">
                                                <option value="">ជ្រើសរើសកម្មវិធី</option>
                                                <option value="P_1" {{ $mission->p_format == 'P_1' ? 'selected' : '' }}>
                                                    កម្មវិធីទី ១</option>
                                                <option value="P_2" {{ $mission->p_format == 'P_2' ? 'selected' : '' }}>
                                                    កម្មវិធីទី ២</option>
                                                <option value="P_3" {{ $mission->p_format == 'P_3' ? 'selected' : '' }}>
                                                    កម្មវិធីទី ៣</option>
                                                <option value="P_4" {{ $mission->p_format == 'P_4' ? 'selected' : '' }}>
                                                    កម្មវិធីទី ៤</option>
                                            </select>
                                        </div> --}}

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="letter_date">កាលបរិច្ឆេទ:</label>
                                    <input type="date" name="letter_date" id="letter_date"
                                        class="form-control custom-height" value="{{ $mission->letter_date }}">
                                </div>

                                <div class="form-group">
                                    <label>ជ្រើសរើសបញ្ជី:</label>
                                    @foreach ($missionTag as $tag)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="m_tag"
                                                id="m_tag{{ $tag->id }}" value="{{ $tag->id }}"
                                                {{ $mission->m_tag == $tag->id ? 'checked' : '' }} required>
                                            <label class="form-check-label"
                                                for="m_tag{{ $tag->id }}">{{ $tag->m_tag }}</label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="form-group">
                                    <label for="mission_objective">កម្មវត្ថុនៃការចុះបេសកកម្ម:</label>
                                    <textarea name="mission_objective" id="mission_objective" rows="5" class="form-control custom-height"
                                        style="resize: vertical;">{{ $mission->mission_objective }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="location">ជ្រើសរើសខេត្ត:</label>
                                    <select name="location" id="location"
                                        class="form-control centered-text custom-height">
                                        <option value="">ជ្រើសរើសខេត្ត</option>
                                        <option value="រតនគិរី" {{ $mission->location == 'រតនគិរី' ? 'selected' : '' }}>
                                            រតនគិរី</option>
                                        <option value="មណ្ឌលគិរី" {{ $mission->location == 'មណ្ឌលគិរី' ? 'selected' : '' }}>
                                            មណ្ឌលគិរី</option>
                                        <option value="ឧត្តរមានជ័យ" {{ $mission->location == 'ឧត្តរមានជ័យ' ? 'selected' : '' }}>
                                            ឧត្តរមានជ័យ</option>
                                        <option value="បាត់ដំបង" {{ $mission->location == 'បាត់ដំបង' ? 'selected' : '' }}>
                                            បាត់ដំបង</option>
                                        <option value="កណ្ដាល" {{ $mission->location == 'កណ្ដាល' ? 'selected' : '' }}>
                                            កណ្ដាល</option>
                                        <option value="កោះកុង" {{ $mission->location == 'កោះកុង' ? 'selected' : '' }}>
                                            កោះកុង</option>
                                        <option value="កំពង់ចាម" {{ $mission->location == 'កំពង់ចាម' ? 'selected' : '' }}>
                                            កំពង់ចាម</option>
                                        <option value="ស្វាយរៀង" {{ $mission->location == 'ស្វាយរៀង' ? 'selected' : '' }}>
                                            ស្វាយរៀង</option>
                                        <option value="កំពត" {{ $mission->location == 'កំពត' ? 'selected' : '' }}>
                                            កំពត</option>
                                        <option value="ព្រះសីហនុ" {{ $mission->location == 'ព្រះសីហនុ' ? 'selected' : '' }}>
                                            ព្រះសីហនុ</option>
                                        <option value="បន្ទាយមានជ័យ" {{ $mission->location == 'បន្ទាយមានជ័យ' ? 'selected' : '' }}>
                                            បន្ទាយមានជ័យ</option>
                                        <option value="កំពង់ធំ" {{ $mission->location == 'កំពង់ធំ' ? 'selected' : '' }}>
                                            កំពង់ធំ</option>
                                        <option value="កំពង់ស្ពឺ" {{ $mission->location == 'កំពង់ស្ពឺ' ? 'selected' : '' }}>
                                            កំពង់ស្ពឺ</option>
                                        <option value="កែប" {{ $mission->location == 'កែប' ? 'selected' : '' }}>
                                            កែប</option>
                                        <option value="កំពង់ឆ្នាំង" {{ $mission->location == 'កំពង់ឆ្នាំង' ? 'selected' : '' }}>
                                            កំពង់ឆ្នាំង</option>
                                        <option value="ប៉ៃលិន" {{ $mission->location == 'ប៉ៃលិន' ? 'selected' : '' }}>
                                            ប៉ៃលិន</option>
                                        <option value="ក្រចេះ" {{ $mission->location == 'ក្រចេះ' ? 'selected' : '' }}>
                                            ក្រចេះ</option>
                                        <option value="ស្ទឹងត្រែង" {{ $mission->location == 'ស្ទឹងត្រែង' ? 'selected' : '' }}>
                                            ស្ទឹងត្រែង</option>
                                        <option value="ពោធិ៍សាត់" {{ $mission->location == 'ពោធិ៍សាត់' ? 'selected' : '' }}>
                                            ពោធិ៍សាត់</option>
                                        <option value="ព្រះវិហារ" {{ $mission->location == 'ព្រះវិហារ' ? 'selected' : '' }}>
                                            ព្រះវិហារ</option>
                                        <option value="សៀមរាប" {{ $mission->location == 'សៀមរាប' ? 'selected' : '' }}>
                                            សៀមរាប</option>
                                        <option value="ព្រៃវែង" {{ $mission->location == 'ព្រៃវែង' ? 'selected' : '' }}>
                                            ព្រៃវែង</option>
                                        <option value="តាកែវ" {{ $mission->location == 'តាកែវ' ? 'selected' : '' }}>
                                            តាកែវ</option>
                                        <option value="ត្បូងឃ្មុំ" {{ $mission->location == 'ត្បូងឃ្មុំ' ? 'selected' : '' }}>
                                            ត្បូងឃ្មុំ</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>កាលបរិច្ឆេទចុះបេសកកម្ម:</label>
                                    <div class="form-group">
                                        <label for="mission_start_date">ចាប់ផ្ដើម:</label>
                                        <input type="date" name="mission_start_date" id="mission_start_date"
                                            class="form-control custom-height"
                                            value="{{ $mission->mission_start_date }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="mission_end_date">បញ្ចប់:</label>
                                        <input type="date" name="mission_end_date" id="mission_end_date"
                                            class="form-control custom-height" value="{{ $mission->mission_end_date }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-12 text-center">
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i>&nbsp;&nbsp;កំណត់ឡើងវិញ
                                </button>
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
        .form-select {
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

        #rows-container {
            max-height: 360px;
            overflow-x: auto;
            padding: 16px;
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
            // document.getElementById('full_letter_number').value = fullLetterNumber;
        }
    </script>

    {{-- <script>
        $(document).ready(function() {
            const numPeopleSelect = $('#num_people');
            const rowsContainer = $('#rows-container');
            const resetBtn = $('#reset-btn');

            // Example data for editing (this should come from your server-side logic or wherever you store your data)
            const peopleData = [{
                    name: 'Person 1',
                    role: 'រដ្ឋមន្រ្តី',
                    position_type: 'ក'
                },
                {
                    name: 'Person 2',
                    role: 'អគ្គនាយក',
                    position_type: 'ខ១'
                },
                // Add more people data as needed
            ];

            // Pre-fill the form based on existing data
            function populateForm() {
                const numPeople = updateData.length;
                rowsContainer.empty(); // Clear previous rows

                for (let i = 0; i < numPeople; i++) {
                    const person = peopleData[i];
                    const rowHtml = `
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name_${i + 1}">ឈ្មោះ ${i + 1}:</label>
                            <input type="text" name="names[]" id="name_${i + 1}" class="form-control" value="${person.name}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="role_${i + 1}">តួនាទី ${i + 1}:</label>
                            <select name="people[${i}][role]" id="role_${i}" class="form-control" required>
                                <option value="">ជ្រើសរើសតួនាទី</option>
                                <option value="រដ្ឋមន្រ្តី" ${person.role === 'រដ្ឋមន្រ្តី' ? 'selected' : ''}>រដ្ឋមន្រ្តី</option>
                                <option value="ទីប្រឹក្សាអមក្រសួង" ${person.role === 'ទីប្រឹក្សាអមក្រសួង' ? 'selected' : ''}>ទីប្រឹក្សាអមក្រសួង</option>
                                <option value="រដ្ឋលេខាធិការ" ${person.role === 'រដ្ឋលេខាធិការ' ? 'selected' : ''}>រដ្ឋលេខាធិការ</option>
                                <option value="អនុរដ្ឋលេខាធិការ" ${person.role === 'អនុរដ្ឋលេខាធិការ' ? 'selected' : ''}>អនុរដ្ឋលេខាធិការ</option>
                                <option value="អគ្កាធិការ" ${person.role === 'អគ្កាធិការ' ? 'selected' : ''}>អគ្កាធិការ</option>
                                <option value="អគ្កាធិការរង" ${person.role === 'អគ្កាធិការរង' ? 'selected' : ''}>អគ្កាធិការរង</option>
                                <option value="អគ្គនាយក" ${person.role === 'អគ្គនាយក' ? 'selected' : ''}>អគ្គនាយក</option>
                                <option value="អគ្គនាយករង" ${person.role === 'អគ្គនាយករង' ? 'selected' : ''}>អគ្គនាយករង</option>
                                <option value="អគ្គលេខាធិការ" ${person.role === 'អគ្គលេខាធិការ' ? 'selected' : ''}>អគ្គលេខាធិការ</option>
                                <option value="អគ្គលេខាធិការរង" ${person.role === 'អគ្គលេខាធិការរង' ? 'selected' : ''}>អគ្គលេខាធិការរង</option>
                                <option value="ប្រ.នាយកដ្ឋាន" ${person.role === 'ប្រ.នាយកដ្ឋាន' ? 'selected' : ''}>ប្រ.នាយកដ្ឋាន</option>
                                <option value="អនុ.នាយកដ្ឋាន" ${person.role === 'អនុ.នាយកដ្ឋាន' ? 'selected' : ''}>អនុ.នាយកដ្ឋាន</option>
                                <option value="ប្រ.ការិយាល័យ" ${person.role === 'ប្រ.ការិយាល័យ' ? 'selected' : ''}>ប្រ.ការិយាល័យ</option>
                                <option value="អនុ.ការិយាល័យ" ${person.role === 'អនុ.ការិយាល័យ' ? 'selected' : ''}>អនុ.ការិយាល័យ</option>
                                <option value="នាយកវិទ្យាស្ថាន" ${person.role === 'នាយកវិទ្យាស្ថាន' ? 'selected' : ''}>នាយកវិទ្យាស្ថាន</option>
                                <option value="ប្រធានផ្នែក" ${person.role === 'ប្រធានផ្នែក' ? 'selected' : ''}>ប្រធានផ្នែក</option>
                                <option value="អនុប្រធានផ្នែក" ${person.role === 'អនុប្រធានផ្នែក' ? 'selected' : ''}>អនុប្រធានផ្នែក</option>
                                <option value="មន្ត្រី" ${person.role === 'មន្ត្រី' ? 'selected' : ''}>មន្ត្រី</option>
                                <option value="ជំនួយការ" ${person.role === 'ជំនួយការ' ? 'selected' : ''}>ជំនួយការ</option>
                                <option value="មន្ត្រីជាប់កិច្ចសន្យា" ${person.role === 'មន្ត្រីជាប់កិច្ចសន្យា' ? 'selected' : ''}>មន្ត្រីជាប់កិច្ចសន្យា</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="position_type_${i + 1}">មុខងារ ${i + 1}:</label>
                            <select name="people[${i}][position_type]" id="position_type_${i}" class="form-control" required>
                                <option value="">ជ្រើសរើសថ្នាក់មុខងារ</option>
                                <option value="ក" ${person.position_type === 'ក' ? 'selected' : ''}>ក</option>
                                <option value="ខ១" ${person.position_type === 'ខ១' ? 'selected' : ''}>ខ១</option>
                                <option value="ខ២" ${person.position_type === 'ខ២' ? 'selected' : ''}>ខ២</option>
                                <option value="គ" ${person.position_type === 'គ' ? 'selected' : ''}>គ</option>
                                <option value="ឃ" ${person.position_type === 'ឃ' ? 'selected' : ''}>ឃ</option>
                                <option value="ង" ${person.position_type === 'ង' ? 'selected' : ''}>ង</option>
                            </select>
                        </div>
                    </div>
                </div>
            `;
                    rowsContainer.append(rowHtml);
                }
            }

            // Populate form if there is existing data for editing
            populateForm();

            // Reset button functionality
            resetBtn.on('click', function() {
                numPeopleSelect.val(''); // Reset dropdown
                rowsContainer.empty(); // Clear all generated rows
            });
        });
    </script> --}}
@endsection
