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
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $user->id }}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $user->roles->pluck('name')->implode(', ') }}</td>


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
