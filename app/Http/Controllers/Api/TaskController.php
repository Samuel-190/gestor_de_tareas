<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate ([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date'
        ]);

        $task = Task::create($data);

        return response()->json($task, 201);
    }

    public function markComplete(Task $task) {
         $task->update(['is_completed' => true]);

         return response()->json($task, 200);
    }
}
