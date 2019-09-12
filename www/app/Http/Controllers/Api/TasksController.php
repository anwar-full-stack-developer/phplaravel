<?php

namespace App\Http\Controllers\Api;

use App\Task;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

DB::enableQueryLog();

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errorMessage = [
            'parent_id.exists' => 'The parent_id does not exists in the database',
            'user_id.required' => 'The user_id field is required',
            'user_id.exists' => 'The user_id does not exists in the database',
            'title.required' => 'The title field is required',
            'points.required' => 'The points field is required',
            'points.integer' => 'The points field must be integer value',
            'points.min' => 'The points field must be grater than 0 (One)',
            'points.max' => 'The points field must be less than 10 (Ten)',

            'is_done.required' => 'The is_done field is required',
            'is_done.integer' => 'The is_done field must be integer value',
            'is_done.min' => 'The is_done field must be grater than 0 (Zero)',
            'is_done.max' => 'The is_done field must be less than 1 (One)',
        ];

        $validator = Validator::make($request->all(), [
            'parent_id' => [
                'nullable',
                'exists' => Rule::exists('tasks', 'id')
            ],
            'user_id' => [
                'required',
                'exists' => Rule::exists('users', 'id'),
            ],
            'title' => 'required',
            'points' => 'required|integer|min:1|max:10',
            'is_done' => 'required|integer|min:0|max:1',
        ], $errorMessage);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $task = new Task;
            $task->fill($request->all());
            $task->save();
            Task::updatePoints($task->parent_id);
            Task::updateDone($task->id, $task->is_done, $task->parent_id);
            return response()->json($task->toArray(), 200);
        }
        catch (\Exception $exception){
            return response()->json("Something went wrong", 200);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['id'] = $id;

        $errorMessage = [
            'id.required' => 'The task id is required',
            'id.exists' => 'The task id does not exists in the database',
            'parent_id.exists' => 'The parent_id does not exists in the database',
            'user_id.required' => 'The user_id field is required',
            'user_id.exists' => 'The user_id does not exists in the database',
            'title.required' => 'The title field is required',
            'points.required' => 'The points field is required',
            'points.integer' => 'The points field must be integer value',
            'points.min' => 'The points field must be grater than 0 (One)',
            'points.max' => 'The points field must be less than 10 (Ten)',

            'is_done.required' => 'The is_done field is required',
            'is_done.integer' => 'The is_done field must be integer value',
            'is_done.min' => 'The is_done field must be grater than 0 (Zero)',
            'is_done.max' => 'The is_done field must be less than 1 (One)',
        ];

        $validator = Validator::make($data, [
            'id' => 'required|exists:tasks',
            'parent_id' => [
                'nullable',
                'exists' => Rule::exists('tasks', 'id')
            ],
            'user_id' => [
                'required',
                'exists' => Rule::exists('users', 'id'),
            ],
            'title' => 'required',
            'points' => 'required|integer|min:1|max:10',
            'is_done' => 'required|integer|min:0|max:1',
        ], $errorMessage);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $task =  Task::where('id', $id)->first();
            $task->fill($request->all());
            $task->save();
            Task::updatePoints($task->parent_id);
            Task::updateDone($task->id, $task->is_done, $task->parent_id);
            return response()->json($task->toArray(), 200);
        }
        catch (\Exception $exception) {
            return response()->json("Something went wrong", 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
