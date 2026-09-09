<x-app-layout>
    @section('title', 'Manage Users')

    <div class="space-y-6">

        @if (session('success'))
            <div class="flex items-center gap-2 p-4 bg-success/10 text-success rounded-lg text-sm">
                <i class="ri-checkbox-circle-line text-lg"></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-[#252B3E] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-white/5 text-left text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="p-4 font-medium">User</th>
                            <th class="p-4 font-medium">Role</th>
                            <th class="p-4 font-medium">Properties</th>
                            <th class="p-4 font-medium">Applications</th>
                            <th class="p-4 font-medium">Joined</th>
                            <th class="p-4 font-medium"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @foreach ($users as $user)
                            <tr>
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-heading font-semibold text-xs shrink-0">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                        <div>
                                            <p class="font-medium">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium capitalize
                                        @class([
                                            'bg-primary/10 text-primary' => $user->role === 'admin',
                                            'bg-success/10 text-success' => $user->role === 'owner',
                                            'bg-gray-100 dark:bg-white/10 text-gray-500 dark:text-gray-400' => $user->role === 'tenant',
                                        ])">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="p-4 text-gray-500 dark:text-gray-400">{{ $user->properties_count }}</td>
                                <td class="p-4 text-gray-500 dark:text-gray-400">{{ $user->applications_count }}</td>
                                <td class="p-4 text-gray-500 dark:text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="p-4">
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                              onsubmit="return confirm('Delete this user? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-gray-400 hover:text-danger">
                                                <i class="ri-delete-bin-line text-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{ $users->links() }}
    </div>
</x-app-layout>