@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ __($error) }}</li> <!-- Translate error messages to Khmer -->
            @endforeach
        </ul>
    </div>

    <script>
        // Automatically hide the error alert and reset the form after 5 seconds
        setTimeout(function() {
            document.querySelector('.alert-danger').style.display = 'none'; // Hide the alert
            document.getElementById('uploadForm').reset(); // Reset the form
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>
@endif
