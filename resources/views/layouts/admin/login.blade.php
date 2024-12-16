<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            /* background: #fff; */
            /* background: #929090; */
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .first-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        .logo-mlvt {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-text {
            margin-left: 10px;
        }

        .header-text h1 {
            font-size: 16px;
            font-weight: 700;
            font-family: 'Khmer OS Muol Light', sans-serif;
            color: #007bff;
            margin: 0;
        }
    </style>
    <style>
        .input-group .form-control {
            border-right: 0;
        }

        .input-group .btn {
            border-left: 0;
        }

        .toggle-password {
            background: #868788;
            border: none;
            cursor: pointer;
        }

        .toggle-password i {
            pointer-events: none;
        }
    </style>
    <style>
        /* Logo Animation Styles */
        .logo-mlvt {
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .logo-mlvt img {
            width: 80px;
            height: 80px;
            border-radius: 5px;
            transition: transform 0.3s ease-in-out;
        }

        /* Hover Effect */
        .logo-mlvt:hover img {
            transform: scale(1.2);
            /* Scale the logo */
        }

        .logo-mlvt:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            /* Add shadow on hover */
        }

        .header-text h1 {
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            color: #007bff;
            animation: fadeIn 1s ease-in-out;
        }

        /* Optional Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>


</head>

<body>
    <div class="login-container">
        <!-- Header Section with Logo -->
        <div class="first-header d-flex flex-column align-items-center text-center">
            <a class="sidebar-brand d-flex flex-column align-items-center text-decoration-none" href="#">
                <div class="logo-mlvt mb-2">
                    <img src="/img/MLVT.png" alt="MLVT Logo" style="width: 80px; height: 80px; border-radius: 5px;">
                </div>
                <div class="header-text">
                    <h1>នាយកដ្ឋានហិរញ្ញវត្ថុ និងទ្រព្យសម្បត្តិរដ្ឋ</h1>
                </div>
            </a>
        </div>

        @if ($errors->has('phone_number'))
            <div class="alert alert-danger">
                {{ $errors->first('phone_number') }}
            </div>
        @endif


        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">ឈ្មោះ</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="ចុះឈ្មោះរបស់អ្នក"
                    required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">លេខទូរស័ព្ធ</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number"
                    placeholder="ចុះលេខទូរស័ព្ទ" required pattern="[0-9]+" title="Please enter only numeric values.">
                @error('phone_number')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3 position-relative">
                <label for="password" class="form-label">លេខសម្ងាត់</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="ចុះលេខកូដសម្ងាត់" required>
                    <button type="button" class="btn btn-outline-secondary toggle-password" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');

            // Toggle password field type
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>
