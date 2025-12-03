<x-layouts.app :title="__('Категории')">
    <div x-data="archiveTable([])">
        <select x-model="type" @change="loadItems" class="border rounded p-2 mb-4">
            <option value="">Все</option>
            <option value="folders">Папки</option>
            <option value="documents">Документы</option>
            <option value="categories">Категории</option>
        </select>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="p-4">
                    <input type="checkbox" @click="toggleSelectAll" :checked="allSelected" class="w-4 h-4 accent-blue-500 rounded cursor-pointer">
                </th>
                <th class="px-6 py-3 text-left">Название</th>
                <th class="px-6 py-3 text-left">Статус</th>
                <th class="px-6 py-3 text-left">Дата создания</th>
                <th class="px-6 py-3 text-left">Действия</th>
            </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
            <template x-for="item in items" :key="item.id">
                <tr class="hover:bg-gray-50 transition">
                    <td class="w-4 p-4">
                        <input type="checkbox" :value="item.id" x-model="selected" class="accent-blue-500 w-4 h-4 rounded cursor-pointer">
                    </td>
                    <td class="px-6 py-4 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8">
                            <x-icon.folder-icon />
                        </span>
                        <span x-text="item.name"></span>
                    </td>
                    <td class="px-6 py-4">
                        <span x-text="item.status_label"></span>
                    </td>
                    <td class="px-6 py-4">
                        <span x-text="new Date(item.created_at).toLocaleDateString('ru-RU')"></span>
                    </td>
                    <td class="px-6 py-4">
                        <button @click="open(item.id)" class="text-blue-600 hover:underline">Открыть</button>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>

    <script>
        function archiveTable(initialItems) {
            return {
                type: '',
                items: initialItems,
                selected: [],
                get allSelected() {
                    return this.items.length && this.selected.length === this.items.length
                },
                loadItems() {
                    fetch(`/admin/archive?type=${this.type}`)
                        .then(res => res.json())
                        .then(data => {
                            this.items = data.map(i => ({
                                ...i,
                                status_label: i.status_label || i.status
                            }))
                            this.selected = []
                        })
                },
                toggleSelectAll() {
                    this.selected = this.allSelected ? [] : this.items.map(i => i.id)
                },
                open(id) {},
                archive(id) {},
                deleteItem(id) {}
            }
        }
    </script>
</x-layouts.app>
