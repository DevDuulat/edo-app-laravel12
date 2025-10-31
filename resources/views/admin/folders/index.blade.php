<x-layouts.app :title="__('Departments')">
    @if(session('alert'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <x-alerts.alert :type="session('alert.type')" :message="session('alert.message')" />
        </div>
    @endif
    <div class="flex flex-col flex-1 w-full h-full gap-4">
        <div class="flex items-center justify-between mb-4">
            <nav class="flex px-5 py-3 text-gray-700 bg-gray-50 rounded-lg dark:bg-gray-800 dark:text-gray-400" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">

                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.folders.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-white">
                            Домашняя папка
                        </a>
                    </li>

                    @if($currentFolder)
                        @php
                            $ancestors = $currentFolder->ancestors()->get();
                        @endphp

                        @foreach($ancestors as $ancestor)
                            <li class="inline-flex items-center">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path>
                                    </svg>
                                    <a href="{{ route('admin.folders.index', ['parent_id' => $ancestor->id]) }}" class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400 hover:text-blue-600">
                                        {{ $ancestor->name }}
                                    </a>
                                </div>
                            </li>
                        @endforeach

                        <li aria-current="page" class="inline-flex items-center">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $currentFolder->name }}</span>
                            </div>
                        </li>
                    @endif

                </ol>
            </nav>

            <div class="flex gap-2 items-center">
                <flux:button id="listViewBtn" icon="bars-3" variant="ghost" title="Список" />
                <flux:button id="gridViewBtn" icon="squares-2x2" variant="ghost" title="Сетка" />
                @if (!$currentFolder)
                    <flux:modal.trigger name="create-root-folder">
                        <flux:button>Создать папку</flux:button>
                    </flux:modal.trigger>
                    <flux:modal.trigger name="create-root-document">
                        <flux:button>Создать документ</flux:button>
                    </flux:modal.trigger>
                @endif
            </div>

        </div>
        <div id="foldersContainer" class="transition-all relative overflow-x-auto">
            <div x-data="{
                    selectedFolders: [],
                    selectedDocuments: [],
                    users: @js($users),
                    folders: @js($folders) }">
                <x-folders.list :folders="$folders" :documents="$documents" />
                <x-modals.modal-create-workflow :users="$users" />
            </div>
            <x-folders.grid :folders="$folders" :documents="$documents" />
        </div>
    </div>

    <x-modals.modal-create-root-folder/>
    <x-modals.modal-create-folder/>
    <x-modals.modal-create-root-document/>
    <x-modals.modal-create-document/>
    <x-modals.modal-share-folder/>

</x-layouts.app>
