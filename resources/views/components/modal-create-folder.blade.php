<div id="createDocumentModal" class="hidden fixed inset-0 bg-white/30 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-lg relative border border-gray-200">
        <button id="closeCreateDocumentModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>

        <h2 class="text-xl font-semibold mb-2 text-grway-900">Создать документ</h2>
        <p class="text-gray-600 mb-4">Введите данные для нового документа.</p>

        <form method="POST" action="{{ route('admin.documents.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="folder_id" id="document_folder_id">

            <input type="text" name="title" placeholder="Название документа" required
                   class="w-full px-3 py-2 border rounded-md border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <input type="date" name="due_date" required
                   class="w-full px-3 py-2 border rounded-md border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <textarea name="comment" placeholder="Описание" rows="3"
                      class="w-full px-3 py-2 border rounded-md border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Создать
                </button>
            </div>
        </form>

    </div>
</div>