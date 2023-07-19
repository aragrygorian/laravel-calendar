<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>
    <div class="container">
    <div class="card mt-5">
        <div class="card-body ">
            <div class="d-flex justify-content-end mb-5">
                <div class="d-inline-block dropdown">
                    <button  class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <a href="{{ route('task.index') }}">
                          Back
                        </a>
                    </button>
                </div>
              </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-8">
                    <form class="row g-3" method="POST" action="{{ route('task.update',$task->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Name</label>
                            <select name="user_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                <option value="">Select user</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{$task->user_id == $user->id ? 'selected' : ''}}>{{ $user->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Task Type</label>
                            <select name="task_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                <option value="">Select Task Type</option>
                                <option value="0" {{ $task->task_type == 0 ? 'selected' : '' }}>Daily</option>
                                <option value="1" {{ $task->task_type == 1 ? 'selected' : '' }}>Weekly</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">Task Description</label>
                            <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="inputPassword4" name="description" >
                                {{$task->task_description ?? ''}}
                            </textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label">Task Time</label>
                            <input type="time" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="inputCity" name="time" value="{{$task->task_time ?? ''}}">
                        </div>
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label">Task Date</label>
                            <input type="date" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="inputCity" name="date" value="{{$task->task_date ?? ''}}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
          
        </div>
    </div>
</div>

</x-app-layout>