@extends('layouts.master')

@section('card_certificate')
    <div class="main-content">
        <div class="container-box animate-box">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('certificate-amount') }}" class="btn btn-custom btn-block animate-button">
                        <i class="fas fa-table"></i> តារាងចំនួនសរុបសលាកប័ត្រ
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('certificate.index') }}" class="btn btn-custom btn-block animate-button">
                        <i class="fas fa-plus-circle"></i> បញ្ចូលឈ្មោះសលាកប័ត្រ
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('certificate-data.index') }}" class="btn btn-custom btn-block animate-button">
                        <i class="fas fa-edit"></i> បញ្ចូលទិន្ន័យថវិការ
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('mission-cam.index') }}" class="btn btn-custom btn-block animate-button">
                        <i class="fas fa-briefcase"></i> តារាងបេសកម្ម
                    </a>
                </div>
                


                <div class="col-md-4 mb-3">
                    <a href="{{ url('/') }}" class="btn btn-custom btn-block animate-button">
                        <i class="fas fa-sign-out-alt"></i> ចាកចេញ
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100vw;
            background-color: #f0f0f0;
            /* Optional background color */
        }

        .container-box {
            background-color: #3987ee;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease-out;
            max-width: 70%;
        }

        .btn-custom {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 180px;
            background-color: #67a6ee;
            color: white;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            transition: background-color 0.3s ease;
            animation: fadeIn 1s ease-out;
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 28px;
            /* Updated font size */
            font-weight: bold;
            /* Optional: make text bold */
        }

        .btn-custom:hover {
            background-color: #33a3ff;
        }

        a {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 18px;
        }

        .animate-button {
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
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

        @media (min-width: 768px) {
            .header-text {
                display: block;
            }

            .logo-mlvt {
                display: block;
            }
        }
    </style>
@endsection
