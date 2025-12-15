<x-layouts.app :title="__('Создать Департамент')">
    {{ Breadcrumbs::render(Route::currentRouteName(), $category ?? null) }}
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between py-4 max-w-lg mx-auto w-full">
            <h3 class="mb-2 text-2xl leading-none tracking-tight text-center text-gray-900">
                Создание департамента
            </h3>
        </div>
        <div class="px-5 py-5 rounded-xl border border-gray-200 bg-white max-w-lg mx-auto w-full shadow-lg">
            <form action="{{ route('admin.departments.store') }}" method="POST" class="grid gap-5">
                @csrf
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-sm font-medium text-gray-900">
                        {{ __('Название') }}
                    </label>
                    <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            required
                            placeholder="Введите название департамента"
                            class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-500 transition-all duration-300"
                    />
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="location" class="text-sm font-medium text-gray-900">
                        {{ __('Локация') }}
                    </label>
                    <input
                            type="text"
                            name="location"
                            id="location"
                            value="{{ old('location') }}"
                            placeholder="Введите локацию"
                            class="w-full px-4 py-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-500 transition-all duration-300"
                    />
                    @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 mt-4">
                    <button type="submit"
                            class="px-6 py-2 bg-black hover:bg-gray-800 text-white font-semibold rounded-lg shadow-md transition-all duration-200">
                        {{ __('Сохранить') }}
                    </button>
                    <a href="{{ route('admin.departments.index') }}"
                       class="px-6 py-2 border border-gray-400 text-gray-900 rounded-lg hover:bg-gray-100 transition-all duration-200">
                        {{ __('Отмена') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>