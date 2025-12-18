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


window.deleteResource = function(url, options = {}) {
    const title = options.title || 'Вы уверены?';
    const text = options.text || 'Это действие нельзя будет отменить!';
    const confirmButtonText = options.confirmButtonText || 'Да, удалить!';

    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: confirmButtonText,
        cancelButtonText: 'Отмена'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ _method: 'DELETE' })
            }).then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    location.reload();
                }
            }).catch(error => {
                console.error('Ошибка:', error);
                Swal.fire('Ошибка!', 'Не удалось выполнить удаление.', 'error');
            });
        }
    });
}