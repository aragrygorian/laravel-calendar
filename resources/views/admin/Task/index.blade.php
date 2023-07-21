<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assign Task') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-end mb-5">
                        <div class="d-inline-block dropdown">
                          <button  class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <a href="{{ route('task.create') }}">
                              Add Task
                            </a>
                        </button>
                        <button  class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <a href="{{ route('assign-task') }}">
                                Back to Calendar View
                              </a>
                        </button>                          
                        </div>
                      </div>
                      @include('partial.error')
                    <div class="card">
                        <h5 class="card-header">Task List</h5>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        {{-- <th>User Name</th> --}}
                                        <th>Task Type</th>
                                        <th>Task Time</th>
                                        <th>Task Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach($tasks as $task)
                                     <tr>
                                         <td>{{ $loop->iteration }}</td>
                                         
                                        {{-- <td>{{ $task->user_id == $task->user->id ? $task->user->name : '' }}</td> --}}
                                       
                                        <td>
                                            @if($task->task_type == 0)
                                               Daily
                                            @else
                                               Weekly
                                            @endif
                                        </td> 
                                        <td>{{ $task->task_time ?? '' }}</td>
                                        <td>{{ $task->task_date ?? '' }}</td>
                                        <td>
                                           <ul class="nav">
                                                  <li class="nav-item">
                                                    <form  method="GET" action="{{ route('task.edit',$task->id) }}">
                                                    <button  class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                      Edit
                                                  </button>
                                                </form>

                                                  </li>
                                                  <li class="nav-item">
                                                    <form method="POST" action="{{ route('task.destroy',$task->id) }}">
                                                      @csrf
                                                     @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                     Delete
                                                  </button>
                                                </form>
                                                  </li>
                                                </ul>
                                          </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

