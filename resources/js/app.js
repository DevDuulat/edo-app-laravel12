import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import Swal from 'sweetalert2';

window.Pusher = Pusher;
window.Swal = Swal;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

