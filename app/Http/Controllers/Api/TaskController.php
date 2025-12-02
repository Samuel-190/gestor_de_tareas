<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    public function store(Request $request) {

        $data = $request->validate([
            'project_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date'
        ]);

        $project = Project::where('id', $data['project_id'])
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $task = $project->tasks()->create([
            'title' => $data['title'],
            'due_date' => $data['due_date'] ?? null
        ]);

        return response()->json($task, 201);
    }

    public function markComplete(Task $task) {

        abort_if(
            $task->project->user_id !== auth()->id(),
            403,
            'No autorizado'
        );

        $task->update(['is_completed' => true]);

        return response()->json($task, 200);
    }
}
