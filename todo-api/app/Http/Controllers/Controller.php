<?php

use App\Models\Task;
use Illuminate\Http\Request;

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
        return Task::destroy($id);
    }
}

