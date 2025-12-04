<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    @include('partials.head')
</head>

<body class="min-h-screen">
<flux:sidebar sticky collapsible class="border-e z-40 border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.header class="pb-2">
        <flux:sidebar.brand
                href="{{ route('dashboard') }}"
                logo="{{ config('app.logo_light') }}"
                logo:dark="{{ config('app.logo_dark') }}"
                name="{{ config('app.name') }}"
        />
        <flux:sidebar.collapse />
    </flux:sidebar.header>

    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <flux:sidebar.nav>
        <flux:sidebar.item icon="link" :href="route('sso.base')" target="_blank" class="py-1">
            Перейти в Кут База
        </flux:sidebar.item>

        @canany(['edo-hr-department', 'edo-employee-list'])
            <flux:sidebar.group expandable heading="Менеджмент" class="grid gap-1">
                @can('edo-hr-department')
                    <flux:sidebar.item icon="building-office" :href="route('admin.departments.index')" wire:navigate class="py-1">
                        Департаменты
                    </flux:sidebar.item>
                @endcan
                @can('edo-employee-list')
                    <flux:sidebar.item icon="users" :href="route('admin.employees.index')" wire:navigate class="py-1">
                        Сотрудники
                    </flux:sidebar.item>
                @endcan
            </flux:sidebar.group>
        @endcanany


        <flux:sidebar.group expandable heading="Документы" class="grid gap-1">
            <flux:sidebar.item icon="rectangle-stack" :href="route('admin.categories.index')" wire:navigate class="py-1">
                Категории
            </flux:sidebar.item>
            <flux:sidebar.item icon="document-text" :href="route('admin.document-templates.index')" wire:navigate class="py-1">
                Шаблоны
            </flux:sidebar.item>
            {{--Все документы--}}
            {{--Это “база” всех созданных документов — черновики, утверждённые, в процессе и т.д.--}}
            <flux:sidebar.item icon="document-duplicate" :href="route('admin.documents.index')" wire:navigate class="py-1">
                Все документы
            </flux:sidebar.item>

            {{--Входящие рабочие процессы--}}
            <flux:sidebar.item
                    icon="document-arrow-down"
                    :badge="$incomingCount"
                    :href="route('admin.incoming.workflows')"
                    wire:navigate
                    class="py-1">
                Входящие
            </flux:sidebar.item>

            {{--Исходящие рабочие процессы--}}
            <flux:sidebar.item icon="document-arrow-up" :href="route('admin.outgoing.workflows')" wire:navigate class="py-1">
                Исходящие
            </flux:sidebar.item>

            <flux:sidebar.item icon="archive-box" :href="route('admin.archive.index')"  wire:navigate class="py-1">
                Архив
            </flux:sidebar.item>

            <flux:sidebar.item icon="trash" :href="route('admin.trash.index')"   wire:navigate class="py-1">
                Корзина
            </flux:sidebar.item>
        </flux:sidebar.group>
    </flux:sidebar.nav>
    <flux:spacer />

    <flux:dropdown position="top" align="start" class="max-lg:hidden">
        <flux:profile
                :initials="auth()->user()->initials()"
                icon-trailing="chevron-down"
                name="{{ auth()->user()->name }}"
        />
        <flux:menu>
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-1 px-1 py-1 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>
            <flux:menu.separator />

            <flux:menu.radio.group>
                <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate class="py-1">
                    {{ __('Настройки') }}
                </flux:menu.item>
            </flux:menu.radio.group>
            <flux:menu.separator />
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full py-1">
                    {{ __('Выйти') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>

</flux:sidebar>

<flux:header class="lg:hidden">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
    <flux:spacer />
    <flux:dropdown position="top" align="end">
        <flux:profile
                :initials="auth()->user()->initials()"
                icon-trailing="chevron-down"
        />

        <flux:menu>
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-1 px-1 py-1 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <flux:menu.radio.group>
                <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate class="py-1">
                    {{ __('Настройки') }}
                </flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full py-1">
                    {{ __('Выйти') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:header>

{{ $slot }}
@fluxScripts
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/photoswipe@5.4.4/dist/photoswipe.css" />
<link rel="stylesheet" href="https://unpkg.com/photoswipe-dynamic-caption-plugin/photoswipe-dynamic-caption-plugin.css" />
<link rel="stylesheet" href="https://unpkg.com/photoswipe@5.4.4/dist/photoswipe.css" />
<link rel="stylesheet" href="https://unpkg.com/photoswipe-dynamic-caption-plugin/photoswipe-dynamic-caption-plugin.css" />

<script src="{{ asset('flux/flux.js') }}"></script>
@livewireScripts
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('foldersList', () => ({
            draggedFolderId: null,

            dragStart(event, folderId) {
                this.draggedFolderId = folderId
                event.dataTransfer.effectAllowed = 'move'
            },

            dropFolder(event, targetFolderId) {
                if (this.draggedFolderId === targetFolderId) return

                // Отправляем на бэкенд запрос на перемещение
                fetch(`/admin/folders/move/${this.draggedFolderId}`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ parent_id: targetFolderId })
                }).then(res => res.json())
                    .then(data => {
                        if (data.success) location.reload()
                    })

                this.draggedFolderId = null
            }
        }))
    })
    async function requestAction(url, method = 'PATCH', body = null) {
        const options = {
            method,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }

        if (method === 'POST' || method === 'PATCH') {
            options.headers['Content-Type'] = 'application/json'
            options.body = body ? JSON.stringify(body) : '{}'
        }

        const res = await fetch(url, options)
        return res.json()
    }

    async function moveFolder(id) {
        const parentId = prompt('Введите ID новой родительской папки (оставьте пустым для корня)');
        const data = await requestAction(`/admin/folders/move/${id}`, 'PATCH', { parent_id: parentId || null });
        if (data.success) {
            location.reload();
        }
    }

    function removeItemFromUI(selector) {
        const el = document.querySelector(selector);
        if (el) el.remove();
    }

    function openShareModal(slug) {
        shareUrl = `${window.location.origin}/folders/${slug}`
        navigator.clipboard.writeText(shareUrl)
        const modal = document.getElementById('share-modal')
        modal.style.display = 'flex'
        modal.classList.remove('hidden')
    }

    function closeShareModal() {
        const modal = document.getElementById('share-modal')
        modal.style.display = 'none'
        modal.classList.add('hidden')
    }

    async function copyFolder(id) {
        const data = await requestAction(`/admin/folders/${id}/copy`, 'POST');
        if (data.success) {
            location.reload();
        }
    }

    async function renameFolder(id) {
        const name = prompt('Новое имя папки')
        if (!name) return

        const data = await requestAction(`/admin/folders/${id}/rename`, 'PATCH', { name })

        if (data.success) {
            const el = document.querySelector(`[data-folder-id="${id}"] .folder-name`)
            if (el) el.textContent = data.name
            location.reload()
        }
    }

    async function archiveFolder(folderId) {
        const data = await requestAction(`/admin/folders/${folderId}/archive`);
        if (data.success) {
            removeItemFromUI(`[data-folder-id="${folderId}"]`);
        }
    }

    async function unarchiveFolder(folderId) {
        const data = await requestAction(`/admin/folders/${folderId}/unarchive`);
        if (data.success) {
            removeItemFromUI(`[data-folder-id="${folderId}"]`);
        }
    }

    async function trashFolder(folderId) {
        const data = await requestAction(`/admin/folders/${folderId}/trash`);
        if (data.success) {
            removeItemFromUI(`[data-folder-id="${folderId}"]`);
        }
    }

    async function restoreFolder(folderId) {
        const data = await requestAction(`/admin/folders/${folderId}/restore`);
        if (data.success) {
            removeItemFromUI(`[data-folder-id="${folderId}"]`);
        }
    }

    async function forceDeleteFolder(folderId) {
        const data = await requestAction(`/admin/folders/${folderId}/force-delete`, 'DELETE');
        if (data.success) {
            removeItemFromUI(`[data-folder-id="${folderId}"]`);
        }
    }

    //     Document

    async function copyDocument(id) {
        const data = await requestAction(`/admin/documents/${id}/copy`, 'POST');
        if (data.success) {
            location.reload();
        }
    }

    async function moveDocument(id) {
        const folderId = prompt('ID новой папки (пусто = корень)')
        const data = await requestAction(`/admin/documents/move/${id}`, 'PATCH', {
            folder_id: folderId || null
        })
        if (data.success) location.reload()
    }

    async function renameDocument(id) {
        const title = prompt('Новое имя документа')
        if (!title) return

        const data = await requestAction(`/admin/documents/${id}/rename`, 'PATCH', { title })

        if (data.success) {
            const el = document.querySelector(`[data-document-id="${id}"] .document-name`)
            if (el) el.textContent = data.title
            location.reload()
        }
    }

    async function archiveDocument(documentId) {
        const data = await requestAction(`/admin/documents/${documentId}/archive`);
        if (data.success) {
            removeItemFromUI(`[data-document-id="${documentId}"]`);
        }
    }

    async function unarchiveDocument(documentId) {
        const data = await requestAction(`/admin/documents/${documentId}/unarchive`);
        if (data.success) {
            removeItemFromUI(`[data-document-id="${documentId}"]`);
        }
    }

    async function trashDocument(documentId) {
        const data = await requestAction(`/admin/documents/${documentId}/trash`);
        if (data.success) {
            removeItemFromUI(`[data-document-id="${documentId}"]`);
        }
    }

    async function restoreDocument(documentId) {
        const data = await requestAction(`/admin/documents/${documentId}/restore`);
        if (data.success) {
            removeItemFromUI(`[data-document-id="${documentId}"]`);
        }
    }

    async function forceDeleteDocument(documentId) {
        const data = await requestAction(`/admin/documents/${documentId}/force-delete`, 'DELETE');
        if (data.success) {
            removeItemFromUI(`[data-document-id="${documentId}"]`);
        }
    }

</script>
</body>
</html>
