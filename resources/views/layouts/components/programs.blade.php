@extends('layouts.master')

@section('programs')
    <div class="main-content">
        <div class="container-box animate-box">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('keys.index') }}" class="btn btn-custom btn-block animate-button">
                        បញ្ចូលជំពូក
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('accounts.index') }}" class="btn btn-custom btn-block animate-button">
                        បញ្ចូលគណនី
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('sub-account.index') }}" class="btn btn-custom btn-block animate-button">
                        បញ្ចូលអនុគណនី
                    </a>
                </div>
                <div class="col-md-4 mb-3">
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
        @import url('https://fonts.googleapis.com/css2?family=Khmer+OS+Siemreap&display=swap');


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
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease-out;
            max-width: 70%;
        }

        .btn-custom {
            background-color: #3987ee;
            color: white;
            border-radius: 16px;
            padding: 15px 20px;
            text-align: center;
            transition: background-color 0.3s ease;
            font-family: 'Khmer OS Siemreap', sans-serif;
        }

        a {
            font-family: 'Khmer OS Siemreap', sans-serif;
            font-size: 18px;
        }

        .btn-custom:hover {
            background-color: #94999c;
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
