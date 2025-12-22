<x-layouts.app :title="__('Шаблоны')">
    {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? null) }}

    @if(session('alert'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <x-alerts.alert :type="session('alert.type')" :message="session('alert.message')" />
        </div>
    @endif

    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Все шаблоны') }}</h1>
            <flux:button
                    href="{{ route('admin.document-templates.create') }}"
                    icon="plus"
                    class="bg-black hover:bg-gray-800 text-white font-semibold rounded-lg shadow-md transition-all duration-200"
            >
                {{ __('Создать шаблон') }}
            </flux:button>
        </div>

        <div class="hidden sm:block border rounded-xl border-gray-300 bg-white shadow-lg w-full overflow-hidden">

        <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                <tr>
                    <th class="p-3">
                        <input type="checkbox" />
                    </th>
                    <th class="px-6 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Название</th>
                    <th class="px-6 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Статус</th>
                    <th class="px-6 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Дата создания</th>
                    <th class="px-6 py-2 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Действия</th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($documents as $template)
                    <tr class="hover:bg-gray-50 transition duration-150" data-document-id="{{ $template->id }}">
                        <td class="w-4 p-3">
                            <label class="flex items-center justify-center w-6 h-6 bg-white cursor-pointer">
                                <input
                                        type="checkbox"
                                        class="w-4 h-4 text-black bg-white border-gray-300 rounded focus:ring-black cursor-pointer"
                                />
                            </label>
                        </td>

                        <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-8 h-8">
                                    <x-icon.template-icon />
                                </span>
                                <a
                                        href="{{ route('admin.document-templates.show', $template->id) }}"
                                        class="font-medium text-gray-900 hover:text-black transition"
                                >
                                    {{ $template->name }}
                                </a>
                            </div>
                        </td>

                        <td class="px-6 py-3 whitespace-nowrap">
                            @if($template->active)
                                <flux:badge color="lime">Активен</flux:badge>
                            @else
                                <flux:badge color="zinc">Не активен</flux:badge>
                            @endif
                        </td>

                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">
                            {{ $template->created_at->format('d.m.Y') }}
                        </td>

                        <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <flux:button
                                        href="{{ route('admin.document-templates.show', $template->id) }}"
                                        icon="eye"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-300 bg-white hover:bg-gray-100 text-gray-700 hover:text-black transition shadow-sm"
                                />
                                <flux:button
                                        href="{{ route('admin.document-templates.edit', $template->id) }}"
                                        icon="pencil"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-300 bg-white hover:bg-gray-100 text-gray-700 hover:text-black transition shadow-sm"
                                />
                                <flux:button
                                        icon="trash"
                                        icon-only
                                        title="Удалить"
                                        class="w-9 h-9 flex items-center justify-center text-red-600 hover:text-red-500"
                                        onclick="
                                        if (!confirm('Вы уверены что хотите удалить?')) return;
                                        fetch('{{ route('admin.document-templates.destroy', $template->id) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Content-Type': 'application/json'
                                            },
                                            body: JSON.stringify({ _method: 'DELETE' })
                                        }).then(() => location.reload());
                                    "
                                />
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="sm:hidden space-y-2">
            @foreach($documents as $template)
                <div class="flex items-center justify-between p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-200">
                    <div class="flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8">
                            <x-icon.template-icon />
                        </span>
                        <div class="flex flex-col">
                            <a
                                    href="{{ route('admin.document-templates.show', $template->id) }}"
                                    class="font-medium text-gray-900 hover:text-black transition"
                            >
                                {{ $template->name }}
                            </a>
                            <span class="text-xs text-gray-500">
                                {{ $template->created_at->format('d.m.Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="p-2 rounded-full hover:bg-gray-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 text-gray-500">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M12 5.92A.96.96 0 1 0 12 4a.96.96 0 0 0 0 1.92m0 7.04a.96.96 0 1 0 0-1.92a.96.96 0 0 0 0 1.92M12 20a.96.96 0 1 0 0-1.92a.96.96 0 0 0 0 1.92"/>
                            </svg>
                        </button>

                        <div
                                x-show="open"
                                @click.away="open = false"
                                class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg z-50"
                        >
                            <a href="{{ route('admin.document-templates.show', $template->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Просмотр</a>
                            <a href="{{ route('admin.document-templates.edit', $template->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Редактировать</a>
                            <button
                                    onclick="
                                    if (!confirm('Вы уверены что хотите удалить?')) return;
                                    fetch('{{ route('admin.document-templates.destroy', $template->id) }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({ _method: 'DELETE' })
                                    }).then(() => location.reload());
                                "
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
                            >
                                Удалить
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 w-full">
            {{ $documents->links() }}
        </div>
    </div>
</x-layouts.app>
