@extends('layouts.master')

@section('total_card')
    <div class="main-content">
        <div class="container-box animate-box">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('result.index') }}" class="btn btn-custom btn-block animate-button">
                        របាយការណ៍សរុបធានាចំណាយ
                    </a>
                </div>
                
                <div class="col-md-4 mb-3">
                    <a href="{{ route('result-total-summaries-table') }}" class="btn btn-custom btn-block animate-button">
                        របាយការណ៍សង្ខេប
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('result-applied-table') }}" class="btn btn-custom btn-block animate-button">
                        របាយការណ៍អនុវត្ត
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('result-total-general-table') }}" class="btn btn-custom btn-block animate-button">
                        ផែនការថវិការដ្ឋ
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('result-success') }}" class="btn btn-custom btn-block animate-button">
                        លទ្ធផលសម្រេចបាន
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a href="{{ route('result-new-loan') }}" class="btn btn-custom btn-block animate-button">
                        ឥណទានសរុប
                    </a>
                </div>

                <div class="col-md-4 ">
                    <a href="{{ route('mission-cam.index') }}" class="btn btn-custom btn-block animate-button">
                        តារាងបេសកកម្ម
                    </a>
                </div>

                <div class="col-md-4 ">
                    <a href="{{ route('certificate-amount') }}" class="btn btn-custom btn-block animate-button">
                        តារាងសាលាកបត្រ
                    </a>
                </div>

                <div class="col-md-4 ">
                    <a href="{{ route('back') }}" class="btn btn-custom btn-block animate-button">
                        <i class="fas fa-sign-out-alt" style="color: red;"></i>&nbsp;ចាកចេញ
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
            height: 90vh;
            width: 100%;
        }

        .container-box {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease-out;
            max-width: 50%;
        }

        .btn-custom {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60px;
            background-color: #3987ee;
            color: white;
            border-radius: 16px;
            text-align: center;
            transition: background-color 0.3s ease;
            animation: fadeIn 1s ease-out;

        }

        .btn-custom:hover {
            background-color: #94999c;
        }

        .btn {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 16px;
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
