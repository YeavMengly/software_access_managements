@extends('layouts.master')

@section('dashboardui')
    <div class="container-fluid fullscreen-container vh-100 d-flex flex-column justify-content-between">
        <!-- Main content which should scroll if necessary -->
        <div class="main-content mt-5">
            <div class="row justify-content-center flex-grow-1 d-flex align-items-center">
                <div class="col-md-6">
                    <div class="container-box animate-box">
                        <!-- Form Group with Khmer Labels -->

                        {{-- Result --}}
                        <div class="input-group mt-3 mb-3 d-flex align-items-center">
                            <a href="{{ route('result.index') }}" class="btn btn-custom btn-block animate-button">
                                បញ្ចូលឥណទានអនុម័តដើមឆ្នាំ​ នឹងផែនការរជ្ជទេយ្យ
                            </a>
                        </div>
                        <div class="input-group mt-3 mb-3 d-flex align-items-center">
                            <a href="{{ route('programs') }}" class="btn btn-custom btn-block animate-button">
                                បញ្ចូល ឬកែសម្រួលមាតិការកម្មវិធី
                            </a>
                        </div>

                        <div class="input-group mt-3 mb-3 d-flex align-items-center">
                            <a href="#" class="btn btn-custom btn-block animate-button">
                                បញ្ចូល ឬកែសម្រួលអង្គភាពថវិកា
                            </a>
                        </div>
                        <div class="input-group mt-3 mb-3 d-flex align-items-center">
                            <a href="{{ route('reports.index') }}" class="btn btn-custom btn-block animate-button">
                                ចុះបញ្ជីនិយ័តភាពថវិកា
                            </a>
                        </div>
                        <div class="input-group mt-3 mb-3 d-flex align-items-center">
                            <a href="{{ route('card_certificate') }}" class="btn btn-custom btn-block animate-button">
                                ចុះបញ្ជីសលាកប័ត្រចំណាយថវិកា
                            </a>
                        </div>
                        <div class="input-group mt-3 mb-3 d-flex align-items-center">
                            <a href="{{ route('result.index') }}" class="btn btn-custom btn-block animate-button">
                                ចុះបញ្ជីអាណត្តិបើកប្រាក់
                            </a>
                        </div>
                        <div class="input-group mt-3 mb-3 d-flex align-items-center">
                            <a href="{{ route('total_card') }}" class="btn btn-custom btn-block animate-button">
                                ពិនិត្យរបាយការណ៍
                            </a>
                        </div>
                        <div class="input-group mb-3 d-flex align-items-center">
                            <button class="btn btn-custom btn-block animate-button"
                                onclick="openAndCloseWindow()">ចាកចេញពីកម្មវិធី</button>
                        </div>

                        <div class="input-group mb-3 d-flex align-items-center">
                            <button id="fullscreen-btn" class="btn btn-custom btn-block animate-button">បើកពេញ</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Footer content -->
        
    </div>

    {{-- <div class="footer-section text-center mt-5">
        <p> នាយកដ្ឋានហិរញ្ញវត្ថុ និងទ្រព្យសម្បត្តិរដ្ឋ</p>
    </div> --}}
@endsection
@section('styles')
    <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Khmer+OS+Siemreap&display=swap'); */


        html,
        body {
            height: 100vh;
            margin: 0;
            overflow: hidden;
            /* To prevent scrollbars if not needed */
        }

        .footer-section {
            background-color: #3987ee;
            padding: 10px;
            color: white;
            animation: fadeInUp 1s ease-out;
            justify-content: center;
            position: sticky;
            bottom: 0;
            width: 100%;
            margin-top: auto;
        
        }


        /* Add fullscreen mode styles */
        .fullscreen-container.fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: #fff;
            /* or any background color you prefer */
            z-index: 9999;
        }

        .fullscreen .header-section,
        .fullscreen .footer-section {
            display: none;
        }

        .fullscreen .btn-custom {
            font-size: 24px;
            /* Adjust font size if needed */
        }


        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group-prepend {
            margin-right: 10px;
            /* Adjust spacing as needed */
        }

        .btn-custom {
            margin-left: auto;
            /* Push the button to the far right */
            flex: 1;
            /* Allow button to grow and take available space */
            text-align: center;
            /* Center text inside button */
        }

        .btn-custom.btn-block {
            width: auto;
            /* Override full width for better alignment */
        }

        .container-fluid {
            height: 100vh;
            /* Full viewport height */
            display: flex;
            flex-direction: column;
        }

        .side-fright-header {
            /* padding: 16px; */


        }

        .btn-custom {
            background-color: #C1440E;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            text-align: center;
            font-size: 24px;
            /* Set the font size to 24px */
            transition: background-color 0.3s ease;
            animation: fadeIn 1s ease-out;
        }

        .btn-custom:hover {
            background-color: #FF5733;
        }


        .first-header h4,
        .first-header h3,
        .sidebar-brand-text h5 {
            font-family: 'Khmer OS Siemreap', sans-serif;
            margin: : 16px
        }

        .logo-mlvt img {
            width: 120px;
            height: 120px;
        }

        .sidebar-brand-text {
            font-size: 12px;
            font-family: 'Khmer OS Siemreap', sans-serif;
        }

        .first-header h4,
        .first-header h3 {
            margin: 0;
            font-family: 'Khmer OS Siemreap', sans-serif;
        }

        .header-section {
            background-color: #3987ee;
            padding: 26px;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-weight: 700
        }

        .header-section h1 {
            font-size: 2rem;
            color: #ffffff;
            margin: 0;
            animation: fadeInDown 1s ease-out;
            font-family: 'Khmer OS Siemreap', sans-serif;
        }

        .container-box {
            background-color: #3987ee;
            border-radius: 10px;
            padding: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease-out;
        }

        .input-group-text {
            background-color: #f1e96d;
            border: none;
            font-weight: bold;
            animation: fadeInLeft 1s ease-out;
            font-family: 'Khmer OS Siemreap', sans-serif;
        }

        .form-control {
            animation: fadeInRight 1s ease-out;
            font-family: 'Khmer OS Siemreap', sans-serif;
        }

        .btn-custom {
            background-color: #67a6ee;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
            animation: fadeIn 1s ease-out;
        }

        .btn-custom:hover {
            background-color: #33a3ff;
        }

        /* .footer-section {
            background-color: #3987ee;
            padding: 10px;
            color: white;
            animation: fadeInUp 1s ease-out;
            justify-content: center;
        } */

        .first-header.text-right h4,
        .first-header.text-right h3 {
            text-align: right;
        }

        .logo-mlvt img {
            display: block;
        }

        .animate-header {
            font-size: 24px;
            color: #cf0707;
            animation: fadeInDown 1.5s ease-in-out;
        }


        /* Keyframes for animations */
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 767px) {
            .header-text {
                display: none;
            }

            .logo-mlvt {
                display: block;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .btn-custom {
                font-size: 18px;
                /* Smaller font size for smaller screens */
                padding: 8px 16px;
                /* Adjust padding for smaller screens */
            }

            .container-box {
                padding: 15px;
                /* Reduce padding on smaller screens */
            }

            .fullscreen .btn-custom {
                font-size: 20px;
                /* Adjust font size in fullscreen mode */
            }

            .footer-section {
                padding: 8px;
                /* Adjust footer padding on smaller screens */
            }
        }

        /* Flexbox adjustments for better alignment */
        @media (max-width: 768px) {
            .fullscreen-container {
                flex-direction: column;
                /* Stack content vertically on smaller screens */
            }

            .btn-custom.btn-block {
                width: 100%;
                /* Ensure buttons take full width on smaller screens */
            }
        }
    </style>
@endsection


@section('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function navigateTo(url) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    // Assuming you are updating a specific part of the page
                    document.querySelector('.main-content').innerHTML = response;
                },
                error: function(xhr) {
                    console.error('Request failed with status:', xhr.status);
                }
            });
        }
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fullscreenButton = document.getElementById('fullscreen-btn');
            const container = document.querySelector('.fullscreen-container');

            function toggleFullscreen() {
                if (document.fullscreenElement) {
                    document.exitFullscreen();
                } else {
                    document.documentElement.requestFullscreen();
                }
            }

            function updateButtonText() {
                if (document.fullscreenElement) {
                    fullscreenButton.textContent = 'បង្រួម'; // Exit fullscreen
                } else {
                    fullscreenButton.textContent = 'បើកពេញ'; // Fullscreen
                }
            }

            fullscreenButton.addEventListener('click', function() {
                toggleFullscreen();
            });

            // Listen for fullscreen change events to update the button text
            document.addEventListener('fullscreenchange', updateButtonText);
            document.addEventListener('webkitfullscreenchange', updateButtonText);
            document.addEventListener('mozfullscreenchange', updateButtonText);
            document.addEventListener('MSFullscreenChange', updateButtonText);
        });
    </script>
@endsection
