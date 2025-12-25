<flux:modal name="create-root-folder" class="md:w-96">
        <form method="POST" action="{{ route('admin.folders.store') }}" class="space-y-4">
            @csrf
            <div>
                <flux:heading size="lg">Создать папку</flux:heading>
            </div>
            <input type="text" name="name" placeholder="Название папки" required
                   class="w-full px-3 py-2 border rounded-md border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <div class="flex justify-end space-x-2">
                <flux:button type="button" modal:close variant="ghost">Отмена</flux:button>
                <flux:button type="submit" variant="primary">Создать</flux:button>
            </div>
        </form>
</flux:modal>
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const firstErrorMessage = "{{ $errors->first() }}";

                Swal.fire({
                    icon: "error",
                    title: firstErrorMessage,
                    text: "Пожалуйста, проверьте данные и попробуйте снова.",
                    confirmButtonText: "Исправить",
                    confirmButtonColor: "#000000",
                    customClass: {
                        popup: 'rounded-xl',
                    }
                }).then((result) => {
                    if (typeof $flux !== 'undefined') {
                        $flux.show('create-root-folder');
                    }
                });
            });
        </script>
    @endif