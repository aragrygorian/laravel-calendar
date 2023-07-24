<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assign Task') }}
        </h2>
    </x-slot>

    <style>
       span.select2-container{
            width: 100%!important;
        }
    </style>
    <div class="container mt-5" >
        <nav x-data="{ open: false }" class="border-b border-gray-100 mb-3">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-end h-16">
                    <div class="flex">
                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            @role('admin')
                            <x-nav-link :href="route('assign-task')" :active="request()->routeIs('assign-task')">
                                {{ __('Calendar View') }}
                            </x-nav-link>
                            @endrole
                            @role('admin')
                            <x-nav-link :href="route('task.index')" :active="request()->routeIs('task.index')">
                                {{ __('Table View') }}
                            </x-nav-link>
                            @endrole
                        </div>
                    </div>
        
                
                </div>
            </div>
        </nav>
        <div id='calendar'></div>
    </div>

  
    <!-- The custom modal -->
    <div id="defaultModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden flex items-center justify-center w-full h-full p-4 overflow-x-hidden overflow-y-auto md:inset-0">
        <div class="relative w-full max-w-2xl">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Calendar App
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeModal()" id="closeModel">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                  <!-- Modal body -->
                  <div class="p-6 space-y-6">
                    <div class="row">
                        <div class="col-md-12">
                            <select id="userEvent" class="block w-full js-example-basic-single" multiple name="user_id[]">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-12">
                            <label for="inputPassword4" class="form-label">Task Description</label>
                            <textarea class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="event_description" name="description" > </textarea>
                        </div>
                  
                    <div class="col-md-12">
                        <label for="inputEmail4" class="form-label">Task Type</label>
                        <select name="task_type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="task_type">
                            <option value="">Select Task Type</option>
                            <option value="0">Daily</option>
                            <option value="1">Weekly</option>
                            <option value="2">Monthly</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="inputCity" class="form-label">Task Time</label>
                        <input type="time" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="event_time" name="time">
                    </div>
                    <div class="col-md-12">
                        <label for="inputCity" class="form-label">Task End Date</label>
                        <input type="date" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="event_end_date" name="end_date">
                    </div>
                    <div  class="col-md-12">
                        <label for="color" class="form-label">Select Color</label>
                        <input type="color" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="event_color" name="color">
                    </div>
                    </div>
                   
                    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded" onclick="submitForm()" id="submitForm">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Edit modal -->
    @foreach ($tasks as $task)
        <x-primary-button
            id="editModalBtn{{ $task->id }}"
            class="hidden"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'editModal{{ $task->id }}')"
        ></x-primary-button>

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
    @endforeach

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                placeholder: "Select",
                allowClear: true
            });
            
        });
</script>
    <script type="text/javascript">
        /*------------------------------------------
        --------------------------------------------
        Get Site URL
        --------------------------------------------
        --------------------------------------------*/
        var SITEURL = "{{ url('/') }}";

        var calendar = null;

        $(document).ready(function() {

            /*------------------------------------------
            --------------------------------------------
            CSRF Token Setup
            --------------------------------------------
            --------------------------------------------*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /*------------------------------------------
            --------------------------------------------
            FullCalender JS Code
            --------------------------------------------
            --------------------------------------------*/
            calendar = $('#calendar').fullCalendar({
                header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay,dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                // right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'

            },

            navLinks: true,
            editable: true,
            events: "getevent",       
            displayEventTime: false,
                 events: SITEURL + "/assign-task"
                , eventRender: function(event, element, view) {
                    element.find('.fc-title').html(event.title);
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                }
                
                , selectable: true
                , selectHelper: true
                , select: function(start, end, allDay) {
                    openModal(start, end, allDay);
                },
            
                eventDrop: function (event, delta) {
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                        const user_id = $('.js-example-basic-single').find(':selected');
                        // console.log(user_id[0]);
                        let users = [];
                        for(let i = 0; i < user_id.length; i++){
                            users[i] = user_id[i].value;
                        }
                        
                        const description = document.getElementById('event_description').value;
                        const task_type = document.getElementById('task_type').value;
                        const task_time = document.getElementById('event_time').value;
                        const task_end_date = document.getElementById('event_end_date').value;
                        const color = document.getElementById('event_color').value;
                        
                        // console.log(event)
  
                        $.ajax({
                            url: SITEURL + '/fullcalenderAjax',
                            data: {
                                description: event.title,
                                task_date: start,
                                end_date: end,
                                id: event.id,
                                type: 'update'
                            },
                            type: "POST",
                            success: function (response) {
                                displayMessage("Event Updated Successfully");
                            }
                        });
                    },
          
                eventClick: function (event) {
                        $('#editModalBtn' + event.id).click();
                    }
                });
            // Function to open the custom modal
            function openModal(start, end, allDay) {
                const modal = document.getElementById('defaultModal');
                modal.classList.remove('hidden');
                selectedStart = start;    
                selectedEnd = end;
                selectedAllDay = allDay;
            }

            // Function to close the custom modal
            $('#closeModel').click(function() {
                const modal = document.getElementById('defaultModal');
                modal.classList.add('hidden');

            })

            function closeModal(){
                const modal = document.getElementById('defaultModal');
                modal.classList.add('hidden');
            }

           
            // Function to handle form submission inside the modal
            $('#submitForm').click(function() {
                const user_id = $('.js-example-basic-single').find(':selected');
                // console.log(user_id[0]);
                let users = [];
                for(let i = 0; i < user_id.length; i++){
                    users[i] = user_id[i].value;
                }
                
                const description = document.getElementById('event_description').value;
                const task_type = document.getElementById('task_type').value;
                const task_time = document.getElementById('event_time').value;
                const task_end_date = document.getElementById('event_end_date').value;
                const color = document.getElementById('event_color').value;
                console.log(color)
                // console.log(user_id , description , task_type , task_time);
                if (user_id) {
                    var start = $.fullCalendar.formatDate(selectedStart, "Y-MM-DD");
                    var end = $.fullCalendar.formatDate(selectedEnd, "Y-MM-DD");
                    $.ajax({
                        url: SITEURL + "/fullcalenderAjax"
                        , data: {
                             users: users
                            , description: description
                            , task_type : task_type
                            , time : task_time
                            , color: color
                            , start: start
                            , end: task_end_date
                            , type: 'add'
                        }
                        , type: "POST"
                        , success: function(data) {
                            console.log(data)
                            displayMessage("Event Created Successfully");

                            calendar.fullCalendar('renderEvent', {
                                  id: data.id
                                , title : 'Task :' + data.task_description + '<br>' + 'UserName :' + data.username + '<br>' + 'Time :' + data.task_time 
                                , start: data.task_date + ' ' + data.task_time
                                , end: data.end_date + ' 11:59:59'
                                , backgroundColor : data.color
                                // , allDay: selectedAllDay
                            }, true);

                            const modal = document.getElementById('defaultModal');
                            modal.classList.add('hidden');
                            // $('#closeModal').close();
                            calendar.fullCalendar('unselect');
                        }
                    });
                }
            })

                    @foreach ($tasks as $task)
                                    calendar.fullCalendar('renderEvent', {
                                        id: '{{ $task->id }}',
                                        title: 'Task : {{ $task->task_description }} <br> UserName : {{ $task->userNames ?? '' }} <br> Task Time : {{ $task->task_time }}', // Use <br> to create a line break
                                        start: '{{ $task->task_date . ' ' . $task->task_time }}',
                                        end: '{{ $task->end_date  . ' 11:59:59'}}',
                                        backgroundColor: '{{ $task->color }}'
                                        // Other event properties...
                                    }, true);
                    @endforeach

        });

        function deleteTask(id) {
            var deleteMsg = confirm("Do you really want to delete?");
            if (deleteMsg) {
                $.ajax({
                    type: "POST",
                    url: SITEURL + '/fullcalenderAjax',
                    data: {
                            id: id,
                            type: 'delete'
                    },
                    success: function (response) {
                        calendar.fullCalendar('removeEvents', id);
                        console.log($('#editModal' + id));
                        console.log($('#editModalBtn' + id));
                        $('#closeEditBtn' + id).click();
                        displayMessage("Event Deleted Successfully");
                    }
                });
            }
        }

        /*------------------------------------------
        --------------------------------------------
        Toastr Success Code
        --------------------------------------------
        --------------------------------------------*/
        function displayMessage(message) {
            toastr.success(message, 'Event');
        }

    </script>

</x-app-layout>