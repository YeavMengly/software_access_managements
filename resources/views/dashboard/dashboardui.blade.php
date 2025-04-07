@extends('layouts.master')

@section('dashboardui')
    <div class="container-fluid fullscreen-container d-flex flex-column pt-4"
        style="font-family: 'Khmer OS Siemreap', sans-serif;">
        <div class="main-content flex-grow-1">
            <div class="row justify-content-center d-flex align-items-center">
                <div class="col-md-10 col-lg-8">
                    <div class="container-box animate-box mt-3">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('codes.create') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    បញ្ចូលឥណទានអនុម័តដើមឆ្នាំ​ {{ now()->year }}
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('years.index') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    កំណត់ឆ្នាំចាប់ផ្ដើម
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{route('fuel-totals.index')}}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    បញ្ចូលអត្រាប្រេងឥន្ធនៈសរុប
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{route('fuels.create')}}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    បញ្ចូលអត្រាប្រេងឥន្ធនៈអង្គភាព
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{ route('usage_units.index') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    បញ្ចូលអង្គភាពអគ្គិសនី
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{route('usage_units_water.index')}}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    បញ្ចូលអង្គភាពទឹក
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{ route('loans.create') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    ចុះបញ្ជីនិយ័តភាពថវិកា សម្រាប់សលាកបត្រ
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{ route('loan-mandates.create') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    ចុះបញ្ជីនិយ័តភាពថវិកា​ សម្រាប់អាណត្តិ
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{ route('programs') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    កែសម្រួល ជំពូក គណនី អនុគណនី
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{ route('mandates.create') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    បញ្ចូលអាណត្តិ
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{ route('electrics.index') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    បញ្ចូលអគ្គិសនី
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{ route('waters.create') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    បញ្ចូលទឹក
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{ route('codes.index') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    កែសម្រួលឥណទានអនុម័តដើមឆ្នាំ​
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{ route('certificate-data.create') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    បញ្ចូលសលាកប័ត្រ
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{ route('loans.index') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    កែសម្រួលនិយ័តភាពថវិកា
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{ route('certificate-data.index') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    កែសម្រួល អាណត្តិ​ សលាកបត្រ
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{ route('mission-cam.create') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    បញ្ចូលបេសកម្ម
                                </a>
                            </div>

                            <div class="col-md-6 mb-3">
                                <a href="{{ route('total_card') }}"
                                    class="btn btn-custom btn-block animate-button submit-button">
                                    ពិនិត្យរបាយការណ៍
                                </a>
                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-custom btn-block animate-button" onclick="openAndCloseWindow()">
                                    ចាកចេញពីកម្មវិធី <i class="fas fa-sign-out-alt" style="color: red"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Loading Modal --}}
                        @include('partials.loading-modal')

                    </div>
                </div>
            </div>
        </div>
        <div class="footer-section text-center text-center justify-content-center align-items-center ">
            <p> @២០២៤ រក្សាសិទ្ធគ្រប់យ៉ាងដោយ នាយកដ្ឋានហិរញ្ញវត្ថុ និងទ្រព្យសម្បត្តិរដ្ឋ</p>
        </div>

        {{-- Include Loading Modal --}}
        @include('partials.loading-modal')


    </div>
@endsection

@section('styles')
    <style>
        html,
        body {
            height: 50vh;
            margin: 0;
        }

        .fullscreen-container {
            display: flex;
            flex-direction: column;
            height: 90vh;
            overflow: hidden;
        }

        .main-content {
            flex: 1;
            /* margin-top: 8px; */
            overflow: hidden;
        }

        .footer-section {
            background-color: #3987ee;
            padding: 8px;
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
            border-radius: 16px;
            padding: 15px 20px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #94999c;
        }

        .btn,
        p {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 16px;
        }

        .container-box {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 576px) {
            .btn-custom {
                font-size: 14px;
                padding: 10px 16px;
            }

            .container-box {
                padding: 16px;
            }
        }

        h5 {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 14px;
        }

        .wrap-text {
            white-space: nowrap;
        }
    </style>
@endsection

@section('scripts')
    {{-- <script>
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
    </script> --}}

    <script>
        function openAndCloseWindow() {
            const confirmed = confirm("តើអ្នកពិតជាចង់ចាកចេញពីកម្មវិធីមែនទេ?");
            if (confirmed) {
                // Send the user logout request (assuming you have a route to handle logout)
                fetch('/exit', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // CSRF token for security
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            // Redirect to the home page or login page after logout
                            window.location.href = "http://172.28.3.184:8005/"; // Redirect to the home page
                        } else {
                            alert("Logout failed. Please try again.");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert("An error occurred during logout.");
                    });
            }
        }
    </script>

    {{-- Loading Modal --}}
    {{-- <script>
        document.querySelectorAll('.submit-button').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent immediate navigation

                // Show the loading modal
                var loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
                loadingModal.show();

                // Proceed to the route after a slight delay
                setTimeout(() => {
                    if (this.tagName === 'A') {
                        window.location.href = this.href; // Redirect if it's a link
                    } else if (this.tagName === 'BUTTON' && this.getAttribute('onclick')) {
                        eval(this.getAttribute('onclick')); // Execute button's onclick if present
                    }
                }, 1000); // Adjust delay as needed
            });
        });
    </script> --}}

    {{-- <script>
        document.querySelectorAll('.submit-button').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                var loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
                loadingModal.show();

                let undoClicked = false; // Track undo action

                // Undo Button Listener
                document.getElementById('undoButton').onclick = function() {
                    undoClicked = true;
                    loadingModal.hide();
                };

                // Simulate loading with connectivity check
                setTimeout(() => {
                    if (!undoClicked) {
                        if (navigator.onLine) { // Check for internet connection
                            if (button.tagName === 'A') {
                                window.location.href = button.href;
                            } else if (button.tagName === 'BUTTON' && button.getAttribute(
                                'onclick')) {
                                eval(button.getAttribute('onclick'));
                            }
                        } else {
                            alert('No internet connection. Please check your network.');
                            loadingModal.hide();
                        }
                    }
                }, 3000); // 3-second delay before action
            });
        });
    </script> --}}
@endsection
