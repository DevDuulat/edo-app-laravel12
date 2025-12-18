@if (Session::has('alert.sweetalert'))
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
                Swal.fire({!! Session::pull('alert.sweetalert') !!});
        });
    </script>
@endif