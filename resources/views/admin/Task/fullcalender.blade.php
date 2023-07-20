<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assign Task') }}
        </h2>
    </x-slot>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
    
    <div class="container">
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
                            <select id="userEvent" class="border p-2 mb-4 w-100">
                                <option value="">select</option>
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
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="inputCity" class="form-label">Task Time</label>
                        <input type="time" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="event_time" name="time">
                    </div>
                    </div>
                   
                    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded" onclick="submitForm()" id="submitForm">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            /*------------------------------------------
            --------------------------------------------
            Get Site URL
            --------------------------------------------
            --------------------------------------------*/
            var SITEURL = "{{ url('/') }}";

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
            var calendar = $('#calendar').fullCalendar({
                editable: true
                , events: SITEURL + "/assign-task"
                , displayEventTime: false
                , editable: true
                , eventRender: function(event, element, view) {
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
                        var deleteMsg = confirm("Do you really want to delete?");
                        if (deleteMsg) {
                            $.ajax({
                                type: "POST",
                                url: SITEURL + '/fullcalenderAjax',
                                data: {
                                        id: event.id,
                                        type: 'delete'
                                },
                                success: function (response) {
                                    calendar.fullCalendar('removeEvents', event.id);
                                    displayMessage("Event Deleted Successfully");
                                }
                            });
                        }
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
                const user_id = document.getElementById('userEvent').value;
                const description = document.getElementById('event_description').value;
                const task_type = document.getElementById('task_type').value;
                const task_time = document.getElementById('event_time').value;
                // console.log(user_id , description , task_type , task_time);
                if (user_id) {
                    var start = $.fullCalendar.formatDate(selectedStart, "Y-MM-DD");
                    var end = $.fullCalendar.formatDate(selectedEnd, "Y-MM-DD");
                    $.ajax({
                        url: SITEURL + "/fullcalenderAjax"
                        , data: {
                             user_id: user_id
                            , description: description
                            , task_type : task_type
                            , time : task_time
                            , start: start
                            , end: end
                            , type: 'add'
                        }
                        , type: "POST"
                        , success: function(data) {
                            console.log(data)
                            displayMessage("Event Created Successfully");

                            calendar.fullCalendar('renderEvent', {
                                  id: data.id
                                , title : data.task_description
                                , start: data.task_date
                                , end: data.end_date
                                , allDay: selectedAllDay
                            }, true);

                            const modal = document.getElementById('defaultModal');
                            modal.classList.add('hidden');
                            // $('#closeModal').close();
                            calendar.fullCalendar('unselect');
                        }
                    });
                }
            })

            @foreach ($tasks  as $task )
                calendar.fullCalendar('renderEvent', {
                      id: '{{ $task->id }}'
                    , title :'{{ $task->task_description}}'
                    , start: '{{ $task->task_date }}'
                    , end:'{{ $task->end_date}}'
                    // , allDay: selectedAllDay
                }, true);

                // closeModal(); // Close the modal after form submission
                // $('#closeModal').close();
                calendar.fullCalendar('unselect');
            @endforeach

        });

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