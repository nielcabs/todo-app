<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TaskController extends Controller
{
    public function index() {
        return Task::all();
    }

    public function show($id) {
        return Task::findOrFail($id);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'priority' => 'in:low,medium,high',
            'category' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        return Task::create($validated);
    }

    public function update(Request $request, $id) {
        $task = Task::findOrFail($id);
        $task->update($request->all());

        return $task;
    }

    public function destroy($id) {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }
}
