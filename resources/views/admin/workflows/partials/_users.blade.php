<div class="flex-1 overflow-y-auto flex flex-col gap-6 p-6" id="usersContainer">
    <section class="p-6 bg-white rounded-xl border border-gray-200">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Пользователи в процессе утверждения</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Пользователь
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Роль</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Действие
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $workflowUser)
                    @php
                        $user = $workflowUser->user;
                        $status = $workflowUser->status;
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <x-user-avatar :user="$user" size="10"/>
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-800">{{ $user->name }}</span>
                                    <span class="text-gray-500 text-sm truncate">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $workflowUser->role->label() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $status = $workflowUser->status;
                                $colors = [
                                    'pending' => 'amber',
                                    'approved' => 'green',
                                    'rejected' => 'red',
                                    'redirected' => 'cyan',
                                ];
                                $color = $colors[$status->slug()] ?? 'zinc';
                            @endphp
                            <flux:badge color="{{ $color }}">
                                {{ $status->label() }}
                            </flux:badge>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($workflowUser->acted_at)
                                <span class="text-gray-600">{{ $workflowUser->acted_at->format('d.m.Y H:i') }}</span>
                            @else
                                <span class="text-gray-500">Ожидает действия</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>