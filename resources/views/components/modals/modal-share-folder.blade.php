<div id="share-modal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white p-6 rounded-2xl shadow-2xl w-full max-w-sm space-y-5 relative transform transition-all duration-300 scale-95">
        <button class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition"
                onclick="closeShareModal()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
            </svg>
        </button>

        <div class="text-xl font-bold text-gray-800 border-b pb-3 mb-2">
            Поделиться папкой
        </div>

        <div class="space-y-3">
            <label class="block text-gray-700 font-medium">Пользователи</label>
            <input type="text" id="share-users" placeholder="Введите email или имя пользователя"
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300" />

            <label class="block text-gray-700 font-medium">Права доступа</label>
            <select id="share-permissions"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                <option value="read">Только просмотр</option>
                <option value="edit">Редактирование</option>
                <option value="owner">Полный доступ</option>
            </select>

            <label class="block text-gray-700 font-medium">Сообщение</label>
            <textarea id="share-message" placeholder="Добавьте комментарий (необязательно)"
                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"></textarea>
        </div>

        <div class="pt-2 border-t mt-4 space-y-2">
            <button class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out"
                    onclick="submitShare()">
                Отправить
            </button>

            <button class="w-full py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-150 ease-in-out"
                    onclick="closeShareModal()">
                Закрыть
            </button>
        </div>
    </div>
</div>
