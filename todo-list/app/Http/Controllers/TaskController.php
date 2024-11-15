<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function showAllTasks()
    {
        // Retrieve all tasks without any filters applied
        $tasks = Task::with('user')->orderBy('created_at', 'desc')->get();
        
        // Return the view with all tasks
        return view('todo', compact('tasks'));
    }

    public function filterTasks(Request $request)
    {
        // Retrieve the query parameters for filtering
        $priority = $request->query('priority');  // e.g., ?priority=1
        $status = $request->query('status');      // e.g., ?status=true

        // Start the query to retrieve tasks
        $query = Task::query();

        // Apply filters if provided
        if ($priority !== null) {
            $query->where('priority', $priority);
        }

        if ($status !== null) {
            $status = filter_var($status, FILTER_VALIDATE_BOOLEAN);
            $query->where('status', $status);
        }

        // If no filters are applied, order by creation date (default)
        if ($priority === null && $status === null) {
            $query->orderBy('created_at', 'desc');
        }

        // Execute the query and get the tasks
        $tasks = $query->with('user')->get();
        
        // Return the view with the filtered tasks
        return view('todo', compact('tasks'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:1,2,3', // Make sure priority is numeric
        ]);
        
        // Add the user ID to the data
        $validatedData['user_id'] = Auth::id();

        // Assign 'status' as false by default
        $validatedData['status'] = false;

        // Create and save the task directly
        $task = Task::create($validatedData);

        // Redirect back to the todo page with a success message
        return redirect()->route('todo')->with('success', 'Task created successfully.');
    }

    public function destroy($id)
    {
        // Find the task by ID
        $task = Task::findOrFail($id);

        // Check if the logged-in user is the creator of the task
        if ($task->user_id !== Auth::id()) {
            // If the user is not the creator, redirect with an error message
            return redirect()->route('todo')->with('error', 'You are not authorized to delete this task.');
        }

        // Delete the task
        $task->delete();

        // Redirect back with a success message
        return redirect()->route('todo')->with('success', 'Task deleted successfully.');
    }

    /**
     * Update the task details.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Find the task by ID
        $task = Task::findOrFail($id);

        // Ensure the user is the owner of the task
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('todo')->with('error', 'You are not authorized to update this task.');
        }

        // Validate the incoming request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:1,2,3',  // Ensure priority is one of the allowed values
            'status' => 'required|boolean',     // Ensure status is either true or false
        ]);

        // Update the task with validated data
        $task->update($validatedData);

        // Redirect back to the todo page with a success message
        return redirect()->route('todo')->with('success', 'Task updated successfully.');
    }
}
