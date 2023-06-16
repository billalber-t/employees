<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderBy('priority','asc')->get();
        return response([
            'message' => 'Tasks found!',
            'data' => TaskResource::collection($tasks)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            't_name' => 'required | string',
            'priority' => 'nullable | integer'
        ]);

        $task = Task::create([
            't_name' => $data['t_name'],
            'priority' => $data['priority']
        ]);

        return response([
            'message' => 'Building Created!',
            'data' =>  new TaskResource($task)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $task = Task::findOrFail($id);
        return response([
            'message' => 'Task found!',
            'data' => new TaskResource($task)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $tasks = $request->all();

        //updates each individual task's priority
        foreach ($tasks as $task) {
            Task::findOrFail($task['id'])->update([
                'priority' => $task['priority']
            ]);
        }

        $tasks = Task::orderBy('priority', 'asc')->get();

        return response([
            'message' => 'Task found!',
            'data' => TaskResource::collection($tasks)
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        $task->delete();

        return response([
            'message' => 'Task deleted successfully!',
            'data' => new TaskResource($task)
        ], 200);
    }
}
