<x-layouts.app :title="__('Создать Документ')">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between">
            <nav class="flex px-5 py-3 text-gray-700 rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{route('dashboard')}}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-zinc-800 dark:text-gray-400 dark:hover:text-white">
                            <x-icon.home-icon/>
                            Панель управление
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <x-icon.arrow-breadcrumb-icon/>
                            <a href="{{route('admin.documents.index')}}" class="ms-1 text-sm font-medium text-gray-700 hover:text-zinc-800 md:ms-2 dark:text-gray-400 dark:hover:text-white">{{ __('Документы') }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <x-icon.arrow-breadcrumb-icon/>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Создание Документа</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="px-5 py-5 rounded-xl border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-5 max-w-5xl md:grid-cols-2">
                @csrf
                    <!-- Title Input -->
                    <div class="flex flex-col gap-2">
                        <label for="title" class="text-sm font-medium text-gray-700 dark:text-gray-300">Название документа</label>
                        <input
                                type="text"
                                id="title"
                                name="title"
                                placeholder="Введите название"
                                required
                                class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300"
                        />
                        @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>


                <div class="flex flex-col gap-2">
                    <label for="due_date" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Срок окончания') }}</label>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <x-icon.calendar-icon/>
                        </div>
                        <input datepicker name="due_date" id="default-datepicker" type="text"
                               class="w-full pl-10 px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300"
                               placeholder="Выберите срок">
                    </div>
                </div>


                <div class="flex flex-col gap-2">
                    <label for="comment" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Комментарий') }}
                    </label>
                    <textarea
                            id="comment"
                            name="comment"
                            rows="3"
                            placeholder="Введите комментарий"
                            class="w-full px-4 py-2 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-500 placeholder-gray-400 dark:placeholder-gray-400 transition-all duration-300 resize-none"
                    >{{ old('comment') }}</textarea>
                    @error('comment')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-2">
                    <div class="flex flex-col gap-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Выберите пользователей</label>
                            <div x-data="multiSelect({{ $users->pluck('name') }})" class="w-full relative">
                                <!-- Input -->
                                <div @click="toggle()"
                                     class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm flex items-center cursor-text">
                                    <input
                                            type="text"
                                            x-model="search"
                                            @input="filterItems()"
                                            placeholder="Выберите..."
                                            class="flex-1 bg-transparent border-none outline-none placeholder-gray-400 dark:placeholder-gray-400 text-sm focus:ring-0"
                                    />
                                    <svg class="w-5 h-5 text-gray-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>

                                <!-- Dropdown -->
                                <div x-show="open" @click.away="close()" x-transition
                                     class="absolute z-20 mt-1 w-full bg-white border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg max-h-60 overflow-auto">
                                    <template x-for="item in filtered" :key="item">
                                        <div @click="select(item)"
                                             class="px-4 py-2 cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700 flex items-center justify-between"
                                             :class="selected.includes(item) ? 'bg-blue-100 dark:bg-blue-600 font-semibold' : ''">
                                            <span x-text="item"></span>
                                            <x-icon.check-icon/>
                                        </div>
                                    </template>
                                    <div x-show="filtered.length === 0" class="px-4 py-2 text-gray-400 text-sm">Ничего не найдено</div>
                                </div>

                                <!-- Hidden input для отправки выбранных пользователей -->
                                <input type="hidden" name="users" :value="selected.join(',')">
                            </div>
                        </div>
                    </div>





                <!-- Buttons (span 2 columns) -->
                <div class="flex gap-3 mt-4 md:col-span-2">
                    <button type="submit" class="px-6 py-2 bg-gray-600 dark:bg-gray-700 hover:bg-gray-500 dark:hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md transition-all duration-200">
                        {{ __('Сохранить') }}
                    </button>
                    <a href="{{ route('admin.documents.index') }}" class="px-6 py-2 border border-gray-400 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                        {{ __('Отмена') }}
                    </a>
                </div>
            </form>
        </div>
    </div>


    <script>
        function multiSelect(initialItems = []) {
            return {
                open: false,
                search: '',
                selected: [],
                items: initialItems,
                filtered: initialItems,
                toggle() {
                    this.open = !this.open;
                    this.filtered = this.items;
                },
                close() {
                    this.open = false;
                },
                select(item) {
                    if (this.selected.includes(item)) {
                        this.selected = this.selected.filter(i => i !== item);
                    } else {
                        this.selected.push(item);
                    }
                    this.filterItems();
                },
                filterItems() {
                    const searchLower = this.search.toLowerCase();
                    this.filtered = this.items.filter(item => item.toLowerCase().includes(searchLower));
                    this.open = true;
                }
            }
        }
    </script>
</x-layouts.app>
