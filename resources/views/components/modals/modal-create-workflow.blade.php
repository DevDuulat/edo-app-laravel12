@props(['users', 'roles'])

<flux:modal name="workflow-modal" variant="flyout">
    <form action="{{ route('admin.workflows.store') }}" method="POST" class="space-y-6">
        @csrf

        <flux:heading size="lg">Создать рабочий процесс</flux:heading>

        <template x-for="id in selectedFolders" :key="id">
            <input type="hidden" name="folder_ids[]" x-bind:value="id" />
        </template>
        <template x-for="id in selectedDocuments" :key="id">
            <input type="hidden" name="document_ids[]" x-bind:value="id" />
        </template>

        <flux:input
                type="date"
                name="due_date"
                label="Срок выполнения процесса"
                :value="old('due_date')"
                required
        />

        <div class="space-y-2">
            @foreach($roles as $role)
                <div x-data="{ open: false }" class="border-b py-2">
                    <button type="button" class="w-full text-left flex justify-between items-center" @click="open = !open">
                        <span class="font-medium text-gray-700">{{ $role->label() }}</span>
                        <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="mt-2">
                        <div x-data="userMultiSelect(@js($users))" class="relative w-full">
                            <div
                                    class="flex flex-col gap-2 border border-gray-300 rounded-lg px-2 py-2 cursor-pointer focus-within:ring-2 focus-within:ring-indigo-500"
                                    @click="open = true"
                            >
                                <template x-for="user in selected" :key="user.id">
                                    <span class="flex items-center bg-indigo-100 text-indigo-700 text-sm px-3 py-3 rounded-full">
                                        <span x-text="user.name"></span>
                                        <button type="button" class="ml-1 text-indigo-500 hover:text-indigo-700" @click.stop="removeUser(user)">
                                            &times;
                                        </button>
                                    </span>
                                </template>

                                <input
                                        type="text"
                                        x-model="search"
                                        @focus="open = true"
                                        class="flex-grow border-0 focus:ring-0 text-sm text-gray-700 placeholder-gray-400"
                                        placeholder="Найти пользователей..."
                                />
                            </div>

                            <div
                                    x-show="open"
                                    @click.away="open = false"
                                    class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto"
                            >
                                <template x-for="user in filteredUsers" :key="user.id">
                                    <div
                                            @click="toggleUser(user)"
                                            class="px-3 py-2 flex justify-between items-center hover:bg-indigo-100 cursor-pointer"
                                    >
                                        <span x-text="user.name"></span>
                                        <input
                                                type="checkbox"
                                                class="text-indigo-600 focus:ring-indigo-500 rounded"
                                                :checked="selected.some(u => u.id === user.id)"
                                        />
                                    </div>
                                </template>

                                <div x-show="filteredUsers.length === 0" class="px-3 py-2 text-gray-500 text-sm">
                                    Пользователи не найдены
                                </div>
                            </div>

                            <template x-for="user in selected" :key="user.id">
                                <input type="hidden" :name="'user_ids[{{ $role->slug() }}][]'" :value="user.id">
                            </template>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <flux:textarea name="comment" label="Оставьте комментарий" rows="4" />

        <div class="border-t pt-4 mt-4 text-sm text-gray-600">
            <h4 class="font-semibold mb-2">Проверка перед созданием:</h4>
            <ul class="list-disc pl-5 space-y-1">
                <li>Количество выбранных элементов: <span x-text="selectedFolders.length + selectedDocuments.length"></span></li>
            </ul>
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Создать процесс</flux:button>
        </div>
    </form>
</flux:modal>
