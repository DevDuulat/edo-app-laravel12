<x-layouts.app :title="__('Документы')">
    {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? null) }}
    @if(session('alert'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <x-alerts.alert :type="session('alert.type')" :message="session('alert.message')" />
        </div>
    @endif

    <div class="flex flex-col flex-1 w-full h-full gap-6">
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold">Все Документы</h1>
                @if($currentFolder)
                    <div class="text-gray-600 mt-1">
                        Текущая папка: {{ $currentFolder->name }}
                    </div>
                @endif
            </div>
            @if (!request()->routeIs(['admin.incoming.workflows', 'admin.outgoing.workflows']))
                <div class="flex gap-2 items-center">
                    @if (!$currentFolder)
                        <flux:modal.trigger name="create-root-folder">
                            <flux:button>Создать папку</flux:button>
                        </flux:modal.trigger>
                    @endif

                    <flux:button href="{{ route('admin.documents.create') }}" icon="plus" variant="primary">
                        Создать документ
                    </flux:button>
                </div>
            @endif
        </header>

        <section class="flex flex-wrap gap-3 items-center justify-between">
            <form method="GET" action="{{ route('admin.documents.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                @if(request('parent_id'))
                    <input type="hidden" name="parent_id" value="{{ request('parent_id') }}">
                @endif

                <flux:input
                        name="search"
                        icon="magnifying-glass"
                        placeholder="Поиск по документам и папкам..."
                        value="{{ request('search') }}"
                        class="w-full md:w-64"
                />
                    <input type="date"
                        name="date"
                        value="{{ request('date') }}"
                        onchange="this.form.submit()"
                        class="p-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors"
                />

                <select
                        name="category_id"
                        onchange="this.form.submit()"
                        value="{{ request('category_id') }}"
                        class="p-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 shadow-sm transition-colors w-full md:w-auto"
                >
                    <option value="">Все категории</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                @if(request('search'))
                    <flux:button type="submit" variant="ghost" icon="magnifying-glass" title="Применить фильтры" />
                @endif
            </form>

            <div class="flex gap-2 p-1 bg-gray-100 dark:bg-zinc-700 rounded-lg shadow-inner">

                @php
                    $activeView = 'grid';

                    $baseClasses = 'p-2 rounded-md transition-colors duration-150 flex items-center justify-center';

                    $activeClasses = 'bg-white text-gray-900 shadow-sm ' .
                                     'dark:bg-zinc-800 dark:text-gray-100 dark:hover:bg-zinc-700 ' .
                                     'hover:bg-gray-50 focus:outline-none';

                    $inactiveClasses = 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-zinc-600 focus:outline-none';
                @endphp

                <a href="#"
                   id="gridViewBtn"
                   title="Сетка"
                   class="{{ $baseClasses }} {{ $activeView === 'grid' ? $activeClasses : $inactiveClasses }}"
                >
                    <x-icon.squares-2x2 class="w-5 h-5" />
                </a>

                <a href="#"
                   id="listViewBtn"
                   title="Список"
                   class="{{ $baseClasses }} {{ $activeView === 'list' ? $activeClasses : $inactiveClasses }}"
                >
                    <x-icon.list-bullet class="w-5 h-5" />

                </a>
            </div>
        </section>

        <div id="foldersContainer"
             x-data="{
                selectedFolders: [],
                selectedDocuments: [],
                users: @js($users),
                folders: @js($folders)
             }"
             class="relative">

            <x-folders.grid :folders="$folders" :documents="$documents" />
            <x-folders.list :folders="$folders" :documents="$documents" />

            @if (!request()->routeIs(['admin.incoming.workflows', 'admin.outgoing.workflows']))
            <div x-show="selectedFolders.length || selectedDocuments.length"
                 class="fixed bottom-6 right-6 bg-white dark:bg-gray-800 shadow-lg rounded-xl px-4 py-3 flex gap-4 items-center border border-gray-200">
                <span class="text-sm text-gray-700">
                    Выбрано: <strong x-text="selectedFolders.length + selectedDocuments.length"></strong>
                </span>

                <flux:modal.trigger name="workflow-modal">
                    <flux:button variant="primary">Создать процесс</flux:button>
                </flux:modal.trigger>
            </div>

            <x-modals.modal-create-workflow :users="$users" :roles="$roles" />
            @endif
        </div>
    </div>

    <x-modals.modal-create-root-folder/>
    <x-modals.modal-create-folder/>
    <x-modals.modal-create-root-document/>
    <x-modals.modal-create-document/>
    <x-modals.modal-share-folder/>
<script>
    const ACTIVE_CLASSES = 'bg-white text-gray-900 shadow-sm dark:bg-zinc-800 dark:text-gray-100 dark:hover:bg-zinc-700';
    const INACTIVE_CLASSES = 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-zinc-600';
    const VIEW_STORAGE_KEY = 'foldersView';

    function setActiveButton(activeBtn, inactiveBtn) {

        inactiveBtn.classList.remove(...ACTIVE_CLASSES.split(' '));
        inactiveBtn.classList.add(...INACTIVE_CLASSES.split(' '));

        activeBtn.classList.remove(...INACTIVE_CLASSES.split(' '));
        activeBtn.classList.add(...ACTIVE_CLASSES.split(' '));
    }

    function showView(viewToShow, viewToHide, activeBtn, inactiveBtn) {
        viewToHide.classList.add('hidden');
        viewToShow.classList.remove('hidden');

        setActiveButton(activeBtn, inactiveBtn);

        localStorage.setItem(VIEW_STORAGE_KEY, viewToShow.id === 'gridView' ? 'grid' : 'list');
    }

    function initFoldersView() {
        const listBtn = document.getElementById('listViewBtn');
        const gridBtn = document.getElementById('gridViewBtn');
        const listView = document.getElementById('listView');
        const gridView = document.getElementById('gridView');

        if (!listBtn || !gridBtn || !listView || !gridView) return;

        const savedView = localStorage.getItem(VIEW_STORAGE_KEY);

        if (savedView === 'list') {
            showView(listView, gridView, listBtn, gridBtn);
        } else if (savedView === 'grid' || savedView === null) {
            showView(gridView, listView, gridBtn, listBtn);
        }

        listBtn.onclick = (e) => {
            e.preventDefault();
            showView(listView, gridView, listBtn, gridBtn);
        };

        gridBtn.onclick = (e) => {
            e.preventDefault();
            showView(gridView, listView, gridBtn, listBtn);
        };
    }

    function initUserMultiSelect() {
        window.userMultiSelect = function(initialUsers) {
            return {
                open: false,
                users: initialUsers || [],
                selected: [],
                search: '',
                get filteredUsers() {
                    if (this.search.trim() === '') return this.users
                    return this.users.filter(u =>
                        u.name.toLowerCase().includes(this.search.toLowerCase())
                    )
                },
                toggleUser(user) {
                    const exists = this.selected.some(u => u.id === user.id)
                    this.selected = exists
                        ? this.selected.filter(u => u.id !== user.id)
                        : [...this.selected, user]
                },
                removeUser(user) {
                    this.selected = this.selected.filter(u => u.id !== user.id)
                }
            }
        }
    }

    function initAll() {
        initFoldersView();
        initUserMultiSelect();
    }

    document.addEventListener('DOMContentLoaded', initAll);
    document.addEventListener('livewire:navigated', initAll);
</script>
</x-layouts.app>