@extends('layouts.master')

@section('total_card')
    <div class="main-content">
        <div class="container-box animate-box">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('result.index') }}" class="btn btn-custom btn-block animate-button">
                        <i class="fas fa-money-bill-wave"></i> របាយការណ៍សរុបធានាចំណាយ
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('result-total-table') }}" class="btn btn-custom btn-block animate-button">
                        <i class="fas fa-file-alt"></i> របាយការណ៍សកម្មភាព
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('result-total-summaries-table') }}" class="btn btn-custom btn-block animate-button">
                        <i class="fas fa-book"></i> របាយការណ៍សង្ខេប
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('result-applied-table') }}" class="btn btn-custom btn-block animate-button">
                        <i class="fas fa-list"></i> របាយការណ៍អនុវត្ត
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('result-total-general-table') }}" class="btn btn-custom btn-block animate-button">
                        <i class="fas fa-calendar-alt"></i> ផែនការថវិការដ្ឋ
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('result-success') }}" class="btn btn-custom btn-block animate-button">
                        <i class="fas fa-check"></i> លទ្ធផលសម្រេចបាន
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('result-new-loan') }}" class="btn btn-custom btn-block animate-button">
                        <i class="fas fa-briefcase"></i> ឥណទានសុប
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
        /* @import url('https://fonts.googleapis.com/css2?family=Khmer+OS+Siemreap&display=swap'); */

        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
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

        a {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 18px;
        }

        .btn-custom:hover {
            background-color: #33a3ff;
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
