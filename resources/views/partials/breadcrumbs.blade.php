<flux:breadcrumbs class="text-sm text-gray-500 dark:text-gray-400 mb-4" aria-label="Breadcrumb">
    <ol class="flex space-x-2">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" class="hover:text-gray-700 dark:hover:text-gray-200 transition">
            Панель
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('admin.categories.index') }}" class="hover:text-gray-700 dark:hover:text-gray-200 transition">
            Категории
        </flux:breadcrumbs.item>
        @if(isset($category))
            <flux:breadcrumbs.item class="font-medium text-gray-900 dark:text-gray-100">
                {{ $category->name }}
            </flux:breadcrumbs.item>
        @endif
    </ol>
</flux:breadcrumbs>
