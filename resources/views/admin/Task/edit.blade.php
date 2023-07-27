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
                            <select name="task_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="task_type">
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
                        <div class="col-md-6" style="display:none" id="due-date-field">
                            <label for="inputCity" class="form-label">Due Date</label>
                            <input type="date" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="inputCity" name="end_date" value="{{ $task->end_date ?? '' }}">
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

<script>
    $(document).ready(function(){
        function toggleDueDateField(){
            const selectedValue = $('#task_type').val();
           console.log(selectedValue)
            if(selectedValue == "1"){
                $('#due-date-field').show();
            }else{
                $('#due-date-field').hide();
            }
        }
        toggleDueDateField();
        $('#task_type').on('change' , function(){
            toggleDueDateField();
        })
        
    })
    
    </script>
</x-app-layout>







 <!-- The Edit modal -->
 @foreach ($tasks as $task)
 <x-primary-button id="editModalBtn" class="hidden" x-data="" x-on:click.prevent="$dispatch('open-modal', 'editModal"></x-primary-button>

 <x-modal name="editModal" focusable id="editModal">
     <div class="p-6">
         <div class="flex items-center justify-between mb-4">
             <h1 class="text-lg font-medium text-gray-900">
                 Edit Task
             </h1>
             <x-danger-button type="button" onclick="deleteTask()">Delete</x-danger-button>
         </div>
         <div class="space-y-6">
             <div class="row">
                 <div class="col-md-12 mb-3">
                     <label>Users</label>
                     <select class="block w-full js-example-basic-single" multiple name="user_id[]">
                         @foreach($users as $user)
                         <option value="{{ $user->id }}" {{ $task->users->contains($user)? 'selected': '' }}>{{ $user->name ?? '' }}</option>
                         @endforeach
                     </select>
                 </div>

                 <div class="col-md-12 mb-3">
                     <label for="inputPassword4" class="form-label">Task Description</label>
                     <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="event_description" name="description" >{{ $task->task_description }}</textarea>
                 </div>

                 <div class="col-md-12 mb-3">
                     <label for="inputEmail4" class="form-label">Task Type</label>
                     <select name="task_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="task_type">
                         <option value="">Select Task Type</option>
                         <option value="0" {{ $task->task_type == "0"? 'selected': '' }}>Daily</option>
                         <option value="1" {{ $task->task_type == "1"? 'selected': '' }}>Weekly</option>
                         <option value="1" {{ $task->task_type == "2"? 'selected': '' }}>Monthly</option>
                         <option value="1" {{ $task->task_type == "3"? 'selected': '' }}>Day</option>
                     </select>
                 </div>

                 <div class="col-md-12 mb-3" x-data="{option: 'end_date', s: ''}">
                     <div class="row">
                         <div class="col-md-8">
                             <label for="inputCity" class="form-label" x-text="option === 'end_date'? 'End Date': 'Duration'">End Date</label>
                             <input x-show="option === 'end_date'" type="date" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="event_end_date" name="end_date" value="{{ $task->end_date ?? '' }}">
                             <div class="flex items-center gap-2">
                                 <input x-show="option !== 'end_date'" x-on:input="s = $event.target.value > 1? 's': ''" type="number" id="date_duration" name="date_duration" placeholder="Duration" class="grow border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                 <select x-show="option !== 'end_date'" id="date_duration_unit" name="date_duration_unit" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                     <option value="day" x-text="'day' + s"></option>
                                     <option value="week" x-text="'week' + s"></option>
                                     <option value="month" x-text="'month' + s"></option>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-4">
                             <label class="block form-label" x-text="option === 'end_date'? 'Change to Duration': 'Change to End Date'">Option</label>
                             <select x-on:change="option = $event.target.value" id="date_option" name="date_option" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-2.5 block w-full">
                                 <option value="end_date">End Date</option>
                                 <option value="duration">Duration</option>
                             </select>
                         </div>
                     </div>
                 </div>

                 <div class="col-md-12 mb-3" x-data="{option: '{{ $task->duration !== null ? ('duration') : ('time') }}' , s: ''}">
                     <div class="row">
                         <div x-show="option === 'time'" class="col-md-4">
                             <label for="inputCity" class="form-label">Start Time</label>
                             <input type="time" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="event_time" name="time" value="{{ $task->task_time ?? '' }}">
                         </div>
                         <div x-show="option === 'time'" class="col-md-4">
                             <label for="inputCity" class="form-label">End Time</label>
                             <input type="time" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="event_end_time" name="end_time" value="{{ $task->end_time ?? '' }}">
                         </div>
                         <div x-show="option !== 'time'" class="col-md-8">
                             <label for="inputCity" class="form-label">Time Duration</label>
                             <div class="flex items-center gap-2">
                                 <input type="number" x-on:input="s = $event.target.value > 1? 's': ''" name="time_duration" id="time_duration" placeholder="Duration" class="grow border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" value="{{ $task->duration ?? '' }}">
                                 <select name="time_duration_unit" id="time_duration_unit" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                     <option value="{{ $task->duration_unit == 'min' ? 'selected' : '' }}" x-text="'minute' + s"></option>
                                     <option value="{{ $task->duration_unit == 'hr' ? 'selected' : '' }}" x-text="'hour' + s"></option>
                                 </select>
                             </div>
                         </div>
                         <div class="col-md-4">
                             <label class="block form-label" x-text="option === 'time'? 'Change to Duration': 'Change to Time'">Option</label>
                             <select x-on:change="option = $event.target.value" name="time_option" id="time_option" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-2.5 block w-full">
                                 <option value="time">Time</option>
                                 <option value="duration">Duration</option>
                             </select>
                         </div>
                     </div>
                 </div>
                 <div class="col-md-12 mb-3">
                     <label for="color" class="form-label">Select Color</label>
                     <input type="color" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="event_color" name="color" value={{$task->color ?? ''}}>
                 </div>

                 <div class="col-md-12 mb-3">
                     {{-- <label for="color" class="form-label">Select Color</label> --}}
                     <input type="hidden" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="task_start_date" name="color" value="{{ $task->task_date ?? '' }}">
                 </div>
                 <div class="col-md-12 mb-3">
                     {{-- <label for="color" class="form-label">Select Color</label> --}}
                     <input type="hidden" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="task_event_id" name="id" value="{{ $task->id ?? '' }}">
                 </div>

             </div>

             <div class="mt-6 flex justify-end">
                 <x-secondary-button x-on:click="$dispatch('close')" id="closeEditBtn">
                     {{ __('Cancel') }}
                 </x-secondary-button>

                 <x-primary-button type="button" class="ml-3" onclick="updateForm()" id="updateForm">
                     Submit
                 </x-primary-button>
             </div>
         </div>
     </div>
 </x-modal>
 <script>
     window.addEventListener('load' , function(){
         initSelect2('.js-example-basic-single{{ $task->id }}');
     })
 </script>
 @endforeach