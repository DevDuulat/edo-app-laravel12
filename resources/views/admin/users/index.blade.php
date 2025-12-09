<x-layouts.app :title="__('Пользователи')">
    <div class="flex flex-col flex-1 w-full h-full gap-6">
        <h1 class="text-2xl font-bold">Пользователи</h1>

        <div class="border rounded-xl border-gray-200 bg-white dark:bg-gray-900 shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Имя</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Telegram ID</th>
                    <th class="px-6 py-3 text-left">Токен</th>
                    <th class="px-6 py-3 text-left">Действие</th>
                </tr>
                </thead>

                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">

                        <td class="px-6 py-4">{{ $user->id }}</td>
                        <td class="px-6 py-4">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>

                        <td class="px-6 py-4">
                            {{ $user->telegram_id ?? '—' }}
                        </td>

                        <td class="px-6 py-4">
                            @if($user->telegram_token)
                                <div class="flex items-center gap-2">
                                    <span>{{ $user->telegram_token }}</span>
                                    <button onclick="navigator.clipboard.writeText('{{ $user->telegram_token }}')" class="text-blue-500">копировать</button>
                                </div>
                            @else
                                <span class="text-gray-400">нет</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <form action="{{ route('admin.users.generateTelegramToken', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button class="bg-blue-500 text-white px-3 py-1 rounded">
                                    {{ $user->telegram_token ? 'Перегенерировать' : 'Создать токен' }}
                                </button>
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
