<x-layouts.app :title="__('Пользователи')">
    <div class="flex flex-col flex-1 w-full h-full gap-4 p-4">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ __('Пользователи') }}</h1>
            <a href="" class="px-4 py-2 bg-gray-600 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-500 dark:hover:bg-gray-600 transition-all duration-200">
                {{ __('Добавить пользователя') }}
            </a>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left">ID</th>
                    <th scope="col" class="px-6 py-3 text-left">Имя</th>
                    <th scope="col" class="px-6 py-3 text-left">Email</th>
                    <th scope="col" class="px-6 py-3 text-left">Роль</th>
                    <th scope="col" class="px-6 py-3 text-left">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="odd:bg-white odd:dark:bg-zinc-900 even:bg-zinc-50 even:dark:bg-zinc-800 border-b dark:border-zinc-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $user->id }}</td>
                        <td class="px-6 py-4">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                        <td class="px-6 py-4 flex gap-2">
                            <!-- Редактировать -->
                            <a href=""
                               class="px-3 py-1 bg-gray-600 dark:bg-gray-700 text-white text-sm font-medium rounded-lg shadow hover:bg-gray-500 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-all duration-200">
                                {{ __('Редактировать') }}
                            </a>

                            <!-- Удалить -->
                            <form action="" method="POST" onsubmit="return confirm('Вы уверены?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1 bg-red-600 dark:bg-red-700 text-white text-sm font-medium rounded-lg shadow hover:bg-red-500 dark:hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 transition-all duration-200">
                                    {{ __('Удалить') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{--            {{ $users->links() }} <!-- Пагинация -->--}}
        </div>
    </div>
</x-layouts.app>
