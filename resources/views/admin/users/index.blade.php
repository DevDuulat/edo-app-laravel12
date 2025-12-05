<x-layouts.app :title="__('Пользователи')">
    <div class="flex flex-col flex-1 w-full h-full gap-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Пользователи</h1>
        </div>

        <div class="border rounded-xl border-gray-200 overflow-hidden bg-white dark:bg-gray-900 shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Имя</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Роль</th>
                    <th class="px-6 py-3 text-left">Telegram</th>
                    <th class="px-6 py-3 text-left">Действие</th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $user->id }}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $user->telegram_username ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <button
                                    onclick="document.getElementById('telegram-form-{{ $user->id }}').classList.toggle('hidden')"
                                    class="text-blue-500">Редактировать</button>
                            <form id="telegram-form-{{ $user->id }}" action="{{ route('admin.users.updateTelegram', $user->id) }}" method="POST" class="hidden mt-2">
                                @csrf
                                @method('PATCH')
                                <input type="text" name="telegram_username" placeholder="Telegram username" value="{{ $user->telegram_username }}" class="border rounded px-2 py-1">
                                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Сохранить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-end">
            {{ $users->links() }}
        </div>
    </div>
</x-layouts.app>
