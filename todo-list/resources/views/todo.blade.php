<x-app-layout>
    <div class="py-4">
        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded-md mb-4 w-[96%] mx-auto">
            {{ session('success') }}
        </div>
        @endif

        <!-- Task List Container -->
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-semibold">{{ __("To Do List") }}</h2>

                        <!-- Filter Section -->
                        <form action="{{ route('tasks.filter') }}" method="GET" class="flex space-x-4">
                            <!-- Filter by Status -->
                            <select name="status" class="px-4 py-2 border rounded-lg w-40" onchange="this.form.submit()">
                                <option value="">Status</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Completed</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pending</option>
                            </select>

                            <!-- Filter by Priority -->
                            <select name="priority" class="px-4 py-2 border rounded-lg w-40" onchange="this.form.submit()">
                                <option value="">Priority</option>
                                <option value="1" {{ request('priority') == 1 ? 'selected' : '' }}>Low</option>
                                <option value="2" {{ request('priority') == 2 ? 'selected' : '' }}>Medium</option>
                                <option value="3" {{ request('priority') == 3 ? 'selected' : '' }}>High</option>
                            </select>
                        </form>

                        <!-- Button to Open Modal for Creating Task -->
                        <button onclick="openCreateModal()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 text-sm font-semibold">
                            Create Task
                        </button>
                    </div>

                    <!-- Task Table -->
                    <div class="mt-4">
                        <!-- Display tasks or message if empty -->
                        @if(isset($tasks) && $tasks->isEmpty())
                            <p class="text-center text-gray-600">No tasks available.</p>
                        @elseif(isset($tasks))
                            <div class="overflow-x-auto bg-gray-50 shadow rounded-lg">
                                <!-- Task Table Head and Body -->
                                <table class="min-w-full table-auto">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <!-- Columns -->
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">User</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Title</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Description</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Status</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Priority</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Created At</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Updated At</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Populate rows with tasks -->
                                        @foreach ($tasks as $task)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="px-4 py-2 text-sm text-gray-700">
                                                    {{ $task->user ? $task->user->name : 'No user' }}
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-700">{{ $task->title }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-700">{{ $task->description }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-700">
                                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                                                        {{ $task->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} ">
                                                        {{ $task->status ? 'Completed' : 'Pending' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-700">
                                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                                                        @if ($task->priority == 1)
                                                            bg-blue-100 text-blue-800
                                                        @elseif ($task->priority == 2)
                                                            bg-yellow-100 text-yellow-800
                                                        @elseif ($task->priority == 3)
                                                            bg-red-100 text-red-800
                                                        @endif">
                                                        @if ($task->priority == 1)
                                                            Low
                                                        @elseif ($task->priority == 2)
                                                            Medium
                                                        @elseif ($task->priority == 3)
                                                            High
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-700">{{ $task->created_at->format('Y-m-d H:i:s') }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-700">{{ $task->updated_at->format('Y-m-d H:i:s') }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-700">
                                                    <div class="flex flex-col items-start space-y-2">
                                                        @if(Auth::check() && Auth::id() === $task->user_id)
                                                            <a href="#" onclick="openEditModal({{ $task->id }}, '{{ $task->title }}', '{{ $task->description }}', '{{ $task->status }}', '{{ $task->priority }}')" class="text-blue-500 hover:text-blue-700 text-xs font-semibold">Edit</a>
                                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center text-gray-600">Tasks data is not available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-edit />
    <x-create />
</x-app-layout>
