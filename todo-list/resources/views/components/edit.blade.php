<!-- resources/views/components/edit.blade.php -->
<div id="editTaskModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-semibold mb-4">Edit Task</h2>
        <form id="editTaskForm" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')  <!-- Specify the PUT method here -->
            
            <input type="hidden" id="task_id" name="task_id">  <!-- Hidden field for task ID -->
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" id="title" name="title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required></textarea>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    <option value="0">Pending</option>
                    <option value="1">Completed</option>
                </select>
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
                <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Update Task</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Function to open the edit modal and populate it with the task details
    function openEditModal(taskId, title, description, status, priority) {
        document.getElementById('task_id').value = taskId;
        document.getElementById('title').value = title;
        document.getElementById('description').value = description;

        // Set the correct status and priority values in the select fields
        document.getElementById('status').value = status ? "1" : "0";  // Ensure value is set as string "1" or "0"
        document.getElementById('priority').value = priority;
        
        // Set the action URL of the form to the correct route
        document.getElementById('editTaskForm').action = '/todo/' + taskId;

        // Show the modal
        document.getElementById("editTaskModal").classList.remove("hidden");
    }

    // Close the modal
    function closeEditModal() {
        document.getElementById("editTaskModal").classList.add("hidden");
    }
</script>
