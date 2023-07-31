<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Task') }}
        </h2>
    </x-slot>

<div class="container">
    <div id='calendar'></div>
</div>

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
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
            // put your options and callbacks here
            events : [
                @foreach($assignTask as $task)
                {
                    id: '{{ $task->id }}',
                                title: 'Task : {{ $task->task_description }}',
                                start: '{{ $task->task_date. " " . $task->task_time }}',
                                end: '{{ $task->end_date. " 23:59:59" }}', // Set end time to 23:59:59 of the same day
                                backgroundColor: '{{ $task->color }}',
                                time: '{{ $task->task_time }}'
                },
                @endforeach
            ]
        })
    });
</script>

</x-app-layout>

