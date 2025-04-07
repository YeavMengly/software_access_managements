<!-- resources/views/partials/loading-modal.blade.php -->
<div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 200px;">
        <div class="modal-content d-flex flex-column align-items-center justify-content-center p-4">
            <div class="spinner-border text-primary mb-3" role="status" style="width: 24px; height: 24px;">
                <span class="sr-only">Loading...</span>
            </div>
            <h5 class="mb-2 fw-bold text-dark">កំពុងដំណើរការ...</h5>
        </div>
    </div>
</div>

{{-- Action Loading Modal --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form'); 
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));

        if (form) {
            form.addEventListener('submit', function() {
                loadingModal.show(); // Show the loading modal when form is submitted
            });
        }
    });
</script>
