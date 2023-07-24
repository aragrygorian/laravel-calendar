<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;

class TaskController extends Controller
{

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function calendar(Request $request)
    {
  
        if($request->ajax()) {
       
             $data = Task::whereDate('task_date', '>=', $request->start)
                       ->whereDate('end_date',   '<=', $request->end)
                       ->get(['id','task_description', 'task_date', 'end_date']);

        }
        $users = User::all();
        $tasks = Task::with('user')->get();
        foreach($tasks as $task ){
            $userNames = $task->users->pluck('name')->toArray();
        }
        return view('admin.Task.fullcalender' , compact('users' , 'tasks' , 'userNames'));
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
                  'task_description' => $request->description,
                  'task_type' => $request->task_type,
                  'task_time' => $request->time,
                  'color' => $request->color,
                  'task_date' => $request->start,
                  'end_date' => $request->end,
              ]);


              $event->users()->sync($request->users);

              $users = User::all();

              $modalHTML = <<<'blade'
                <x-primary-button id="editModalBtn{{ $task->id }}" class="hidden" x-data="" x-on:click.prevent="$dispatch('open-modal', 'editModal{{ $task->id }}')"></x-primary-button>

                <x-modal name="editModal{{ $task->id }}" focusable>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-lg font-medium text-gray-900">
                                Edit Task
                            </h1>
                            <x-danger-button type="button" onclick="deleteTask({{ $task->id }})">Delete</x-danger-button>
                        </div>
                        <div class="space-y-6">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Users</label>
                                    <select class="block w-full js-example-basic-single" id="select2{{ $task->id }}" multiple name="user_id[]">
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $task->users->contains($user)? 'selected': '' }}>{{ $user->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
            
                                <div class="col-md-12 mb-3">
                                    <label for="inputPassword4" class="form-label">Task Description</label>
                                    <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="event_description" name="description">{{ $task->task_description }}</textarea>
                                </div>
            
                                <div class="col-md-12 mb-3">
                                    <label for="inputEmail4" class="form-label">Task Type</label>
                                    <select name="task_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="task_type">
                                        <option value="">Select Task Type</option>
                                        <option value="0" {{ $task->task_type == "0"? 'selected': '' }}>Daily</option>
                                        <option value="1" {{ $task->task_type == "1"? 'selected': '' }}>Weekly</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="inputCity" class="form-label">Task Time</label>
                                    <input type="time" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="event_time" name="time" value="{{ $task->task_time }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="inputCity" class="form-label">Task End Date</label>
                                    <input type="date" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="event_end_date" name="end_date" value="{{ $task->end_date }}">
                                </div>
                            </div>
            
                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')" id="closeEditBtn{{ $task->id }}">
                                    {{ __('Cancel') }}
                                </x-secondary-button>
            
                                <x-primary-button type="button" class="ml-3" onclick="submitForm()">
                                    Submit
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                </x-modal>
              blade;

              $modalHTML = htmlspecialchars(Blade::render($modalHTML, ['task' => $event, 'users' => $users]), ENT_QUOTES, 'UTF-8', false);
 
              return response()->json(['event' => $event, 'modalHTML' => $modalHTML]);
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('user')->latest()->get();
    
        return view('admin.Task.index' , compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::get();
        return view('admin.Task.create' , compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'task_type' => 'required',
            'description' => 'required',
            'time' => 'required',
            'date' => 'required'
        ]);

        // Check if there existing task at same date and time 
        $existingTask = Task::where('user_id' ,$request->user_id)
        ->whereDate('task_date' , $request->date)
        ->whereTime('task_time' , $request->time)
        ->first();

        if($existingTask){
            return  redirect()->back()->withErrors(['error' => 'Task already assign.']);
        }

        $task = new Task();
        $task->user_id = $request->user_id;
        $task->task_type = $request->task_type;
        $task->task_description = $request->description;
        $task->task_time = $request->time;
        $task->task_date = $request->date;
        $task->end_date = $request->end_date;
        if($task->save()){
            return redirect()->route('task.index')->with('success' , 'Task Added Successfully.');
        }else{
            return redirect()->route('task.index')->with('error' , 'Failed to Add Task.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $task = Task::find($id);
        $users = User::get();
        return view('admin.Task.edit' , compact('task' , 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->user_id = $request->user_id;
        $task->task_type = $request->task_type;
        $task->task_description = $request->description;
        $task->task_time = $request->time;
        $task->task_date = $request->date;
        $task->end_date = $request->end_date;
        if($task->update()){
            return redirect()->route('task.index')->with('success' , 'Task Updated Successfully.');
        }else{
            return redirect()->route('task.index')->with('error' , 'Failed to update Task.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if($task->destroy($id)){
            return redirect()->route('task.index')->with('success' , 'Task Deleted Successfully.');
        }else{
            return redirect()->route('task.index')->with('error' , 'Failed to  Deleted Task.');
        }
    }

    
}
