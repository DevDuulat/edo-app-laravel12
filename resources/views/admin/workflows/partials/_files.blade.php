<div id="content-files" class="tab-content">
    <section class="p-6 bg-white rounded-xl border border-gray-200">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Файлы</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название файла</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @forelse($documents as $document)
                @foreach($document->files as $file)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $file->original_name ?? 'Файл ' . $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                            <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                               class="px-3 py-1 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-sm">Открыть</a>
                            <a href="{{ Storage::url($file->file_path) }}" download
                               class="px-3 py-1 bg-green-50 text-green-600 rounded hover:bg-green-100 transition text-sm">Скачать</a>
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="2" class="px-6 py-4 text-gray-500 text-center">Файлы отсутствуют</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
</div>