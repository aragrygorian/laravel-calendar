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
            // put your options and callbacks here
            events : [
                @foreach($assignTask as $task)
                {
                    title : '{{ $task->task_description }}',
                    start : '{{ $task->task_date }}',
                    end : '{{$task->end_date}}',
                    displayEventTime : true,
                    // url : '{{ route('task.edit', $task->id) }}',
                },
                @endforeach
            ]
        })
    });
</script>

</x-app-layout>

