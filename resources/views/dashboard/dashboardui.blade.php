@extends('layouts.master')

@section('dashboardui')
    <div class="container-fluid fullscreen-container d-flex flex-column pt-4"
        style="font-family: 'Khmer OS Siemreap', sans-serif;">
        <!-- Main content which should scroll if necessary -->
        <div class="main-content flex-grow-1">
            <div class="row justify-content-center d-flex align-items-center">
                <div class="col-md-10 col-lg-8">
                    <div class="container-box animate-box mt-3">
                        <!-- Two-Column Layout for Buttons -->
                        <div class="row">
                            <!-- Your buttons here -->

                            <div class="col-md-6 mb-3">
                                <a href="{{route('codes.create')}}" class="btn btn-custom btn-block animate-button">
                                    បញ្ចូលឥណទានអនុម័តដើមឆ្នាំ​ នឹងផែនការរជ្ជទេយ្យ
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('programs') }}" class="btn btn-custom btn-block animate-button">
                                    កែសម្រួល ជំពូក គណនី អនុគណនី
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('loans.create') }}" class="btn btn-custom btn-block animate-button">
                                    ចុះបញ្ជីនិយ័តភាពថវិកា
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{route('codes.index')}}" class="btn btn-custom btn-block animate-button">
                                    កែសម្រួលមាតិកាកម្មវិធី 

                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="#" class="btn btn-custom btn-block animate-button">
                                    បញ្ចូលអាណត្តិ
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('certificate-data.index') }}" class="btn btn-custom btn-block animate-button">
                                   កែសម្រួល អណត្តិ​ សលាកបត្រ
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('certificate-data.create') }}" class="btn btn-custom btn-block animate-button">
                                    ចុះបញ្ជីសលាកប័ត្រចំណាយថវិកា
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('total_card') }}" class="btn btn-custom btn-block animate-button">
                                    ពិនិត្យរបាយការណ៍
                                </a>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button class="btn btn-custom btn-block animate-button" onclick="openAndCloseWindow()">
                                    ចាកចេញពីកម្មវិធី <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </div>

                            <!-- Other buttons... -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer content -->

        <div class="footer-section text-center text-center justify-content-center align-items-center">
            <p> @២០២៤ រក្សាសិទ្ធគ្រប់យ៉ាងដោយ នាយកដ្ឋានហិរញ្ញវត្ថុ និងទ្រព្យសម្បត្តិរដ្ឋ</p>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        html,
        body {
            height: 100vh;
            margin: 0;
        }

        .fullscreen-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .main-content {
            flex: 1;
            margin-top: 8%;
            overflow: auto;
        }

        .footer-section {
            background-color: #3987ee;
            padding: 10px;
            color: white;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-custom {
            background-color: #3987ee;
            color: white;
            border-radius: 5px;
            padding: 15px 20px;
            text-align: center;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #FF5733;
        }

        .btn,
        p {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 18px;
        }

        .container-box {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            max-width: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 576px) {
            .btn-custom {
                font-size: 16px;
                padding: 10px 15px;
            }

            .container-box {
                padding: 15px;
            }
        }
    </style>
@endsection

@section('scripts')
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

            function updateButtonIcon() {
                if (document.fullscreenElement) {
                    fullscreenButton.innerHTML = '<i class="fas fa-compress"></i>'; // Zoom Out icon
                } else {
                    fullscreenButton.innerHTML = '<i class="fas fa-expand"></i>'; // Zoom In icon
                }
            }

            fullscreenButton.addEventListener('click', function() {
                toggleFullscreen();
            });

            document.addEventListener('fullscreenchange', updateButtonIcon);
            document.addEventListener('webkitfullscreenchange', updateButtonIcon);
            document.addEventListener('mozfullscreenchange', updateButtonIcon);
            document.addEventListener('MSFullscreenChange', updateButtonIcon);

            updateButtonIcon();
        });
    </script>

    <script>
        function openAndCloseWindow() {
            // This will attempt to close the current window
            if (window.close) {
                window.close();
            } else {
                alert("This window cannot be closed programmatically.");
            }
        }
    </script>
@endsection
