<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {
  
        if($request->ajax()) {
       
             $data = Task::whereDate('task_date', '>=', $request->start)
                       ->whereDate('end_date',   '<=', $request->end)
                       ->get(['id','task_description', 'task_date', 'end_date']);

        }
        $users = User::all();
        $tasks = Task::all();
        return view('admin.Task.fullcalender' , compact('users' , 'tasks'));
    }
 
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function ajax(Request $request)
    {
 
        switch ($request->type) {
           case 'add':
            //dd($request->user_id);
              $event = Task::create([
                  'user_id' => (int)$request->user_id,
                  'task_description' => $request->description,
                  'task_type' => $request->task_type,
                  'task_time' => $request->time,
                  'task_date' => $request->start,
                  'end_date' => $request->end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'update':
         
              $event = Task::find($request->id)->update([
                  'task_description' => $request->description,
                  'task_date' => $request->task_date,
                  'end_date' => $request->end_date,
              ]);
 
              return response()->json($event);
             break;
  
           case 'delete':
              $event = Task::find($request->id)->delete();
  
              return response()->json($event);
             break;
             
           default:
             # code...
             break;
        }
    }

    public function getTask(){

        $assignTask = Task::with('user')->where('user_id' ,auth()->user()->id)->get();
        return view('admin.Task.viewtask' , compact('assignTask'));

    }







    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index()
    // {
    //     $tasks = Task::with('user')->latest()->get();
    //     return view('admin.Task.index' , compact('tasks'));
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     $users = User::get();
    //     return view('admin.Task.create' , compact('users'));
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required',
    //         'task_type' => 'required',
    //         'description' => 'required',
    //         'time' => 'required',
    //         'date' => 'required'
    //     ]);

    //     // Check if there existing task at same date and time 
    //     $existingTask = Task::where('user_id' ,$request->user_id)
    //     ->whereDate('task_date' , $request->date)
    //     ->whereTime('task_time' , $request->time)
    //     ->first();

    //     if($existingTask){
    //         return  redirect()->back()->withErrors(['error' => 'Task already assign.']);
    //     }

    //     $task = new Task();
    //     $task->user_id = $request->user_id;
    //     $task->task_type = $request->task_type;
    //     $task->task_description = $request->description;
    //     $task->task_time = $request->time;
    //     $task->task_date = $request->date;
    //     $task->end_date = $request->end_date;
    //     if($task->save()){
    //         return redirect()->route('task.index')->with('success' , 'Task Added Successfully.');
    //     }else{
    //         return redirect()->route('task.index')->with('error' , 'Failed to Add Task.');
    //     }

    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Task $task)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit($id)
    // {
    //     $task = Task::find($id);
    //     $users = User::get();
    //     return view('admin.Task.edit' , compact('task' , 'users'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, $id)
    // {
    //     $task = Task::find($id);
    //     $task->user_id = $request->user_id;
    //     $task->task_type = $request->task_type;
    //     $task->task_description = $request->description;
    //     $task->task_time = $request->time;
    //     $task->task_date = $request->date;
    //     $task->end_date = $request->end_date;
    //     if($task->update()){
    //         return redirect()->route('task.index')->with('success' , 'Task Updated Successfully.');
    //     }else{
    //         return redirect()->route('task.index')->with('error' , 'Failed to update Task.');
    //     }
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy($id)
    // {
    //     $task = Task::find($id);
    //     if($task->destroy($id)){
    //         return redirect()->route('task.index')->with('success' , 'Task Deleted Successfully.');
    //     }else{
    //         return redirect()->route('task.index')->with('error' , 'Failed to  Deleted Task.');
    //     }
    // }

    
}
