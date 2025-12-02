<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {

        return $request->user()
            ->projects()
            ->with('tasks')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $project = $request->user()->projects()->create($data);

        return response()->json($project, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project) {

        $this->authorizeProject($project);

        return $project->load('tasks');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project) {

        $this->authorizeProject($project);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_archived' => 'boolean'
        ]);

        $project->update($data);

        return response()->json($project, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project) {

        $this->authorizeProject($project);

        $project->delete();

        return response()->json(null, 204);
    }
}
