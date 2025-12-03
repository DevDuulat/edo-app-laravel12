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
        </header>

        <section class="flex flex-wrap gap-3 items-center">
            <form method="GET" action="{{ route('admin.documents.index') }}" class="flex items-center gap-3 w-full md:w-auto">
                @if(request('parent_id'))
                    <input type="hidden" name="parent_id" value="{{ request('parent_id') }}">
                @endif
                @if(request('category_id'))
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                @endif

                <flux:input
                        name="search"
                        icon="magnifying-glass"
                        placeholder="Поиск по документам и папкам..."
                        value="{{ request('search') }}"
                        class="w-full md:w-64"
                />

            </form>

            <form method="GET" action="{{ route('admin.documents.index') }}" class="flex items-center gap-3">
                @if(request('parent_id'))
                    <input type="hidden" name="parent_id" value="{{ request('parent_id') }}">
                @endif
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                    <flux:select
                            name="category_id"
                            size="sm"
                            onchange="this.form.submit()"
                            value="{{ request('category_id') }}"
                    >
                        <flux:select.option value="">Все категории</flux:select.option>
                        @foreach($categories as $category)
                            <flux:select.option value="{{ $category->id }}">
                                {{ $category->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
            </form>
            <flux:button id="listViewBtn" icon="bars-3" variant="ghost" title="Список" />
            <flux:button id="gridViewBtn" icon="squares-2x2" variant="ghost" title="Сетка" />
        </section>

        <div id="foldersContainer"
             x-data="{
                selectedFolders: [],
                selectedDocuments: [],
                users: @js($users),
                folders: @js($folders)
             }"
             class="relative">

            <x-folders.list :folders="$folders" :documents="$documents" />
            <x-folders.grid :folders="$folders" :documents="$documents" />

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
        </div>
    </div>

    <x-modals.modal-create-root-folder/>
    <x-modals.modal-create-folder/>
    <x-modals.modal-create-root-document/>
    <x-modals.modal-create-document/>
    <x-modals.modal-share-folder/>

</x-layouts.app>