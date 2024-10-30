@extends('layouts.master')
@section('content-mission')
    <div class="row">
        <div class="col-lg-6 margin-tb mb-4 mt-4">
            <div class="d-flex justify-content-between align-items-center"
                style="font-family: 'Khmer OS Siemreap', sans-serif;">
                <a class="btn btn-danger" href="{{ route('reports-missions.index') }}"><i class="fas fa-arrow-left"></i>
                    ត្រឡប់ក្រោយ</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="border-wrapper">
            <div class="form-container">
                <form action="{{ route('mission-cam.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row" style="font-family: 'Khmer OS Siemreap', sans-serif;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mission_letter">អត្តលេខ:</label>
                                <div class="form-subgroup">
                                    <input type="number" name="letter_number" id="letter_number"
                                        class="form-control form-number @error('letter_number') is-invalid @enderror"
                                        min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    @error('letter_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="khmer-name">ឈ្មោះ-ខ្មែរ:</label>
                                <div class="form-subgroup">
                                    <input type="text" name="khmer-name" id="khmer-name"
                                        class="form-control form-number @error('khmer-name') is-invalid @enderror"
                                        oninput="removeNonKhmerCharacters(this)">
                                    @error('khmer-name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latin-name">ឈ្មោះ-ឡាតាំង:</label>
                                <div class="form-subgroup">
                                    <input type="text" name="latin-name" id="latin-name"
                                        class="form-control form-number @error('latin-name') is-invalid @enderror"
                                        oninput="allowOnlyLatinCharacters(this)">
                                    @error('latin-name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mission_letter">លេខគណនី:</label>
                                <div class="form-subgroup">
                                    <input type="number" name="letter_number" id="letter_number"
                                        class="form-control form-number @error('letter_number') is-invalid @enderror"
                                        min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    @error('letter_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="font-family: 'Khmer OS Siemreap', sans-serif;">
                        <button type="submit" class="btn btn-primary ml-auto">បានរក្សាទុក</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <style>
        .border-wrapper {
            border: 2px solid black;
            padding: 10px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            display: block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
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
    </style>
@endsection
@section('scripts')
    <script>
        function removeNonKhmerCharacters(input) {
            // Allow only Khmer Unicode range characters (U+1780–U+17FF)
            input.value = input.value.replace(/[^\u1780-\u17FF\s]/g, '');
        }

        function allowOnlyLatinCharacters(input) {
            // Allow only Latin alphabet (a-z, A-Z) and spaces
            input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
        }
    </script>
@endsection
