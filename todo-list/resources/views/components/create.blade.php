<!-- resources/views/components/create.blade.php -->
<div id="createTaskModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-semibold mb-4">Create New Task</h2>
        <form id="createTaskForm" method="POST" action="{{ route('tasks.store') }}" class="space-y-4">
            @csrf
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" id="title" name="title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required></textarea>
            </div>
        
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                <select id="priority" name="priority" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    <option value="1">Low</option>
                    <option value="2">Medium</option>
                    <option value="3">High</option>
                </select>
            </div>

            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeCreateModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Create Task</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Function to open the create modal
    function openCreateModal() {
        document.getElementById("createTaskModal").classList.remove("hidden");
    }

    // Function to close the create modal
    function closeCreateModal() {
        document.getElementById("createTaskModal").classList.add("hidden");
    }
</script>
