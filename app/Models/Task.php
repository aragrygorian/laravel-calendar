<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;


class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'task_type', 'task_description' , 'task_time' , 'task_date' , 'end_date' , 'color', 'end_time', 'duration', 'duration_unit'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tasks', 'task_id', 'user_id');
    }

    // public static function calendarData()
    // {
    //     $tasks = self::with('users')->get();
    //     $events=[];
    //     foreach($tasks as $task){
    //         $events = array_merge($events , self::splitTask($task));
    //     }
    //     return $events;
    // }


    // public static function  splitTask($task){
    //     $events=[];
    //     $start_date = $task->task_date;
    //     $end_date = $task->end_date;

    //     $start_date = Carbon::CreateFromFormat('Y-m-d',$start_date);
    //     $end_date = Carbon::CreateFromFormat('Y-m-d',$end_date);
    //    $daysDiffer = $end_date->diffInDays($start_date);
    //    for($i =0 ; $i <=$daysDiffer; $i++){
    //        $current_date = $start_date->copy()->addDays($i);

    //        $eventDays = json_decode(json_encode($task));
    //        $eventDays->end_date = $current_date->format('Y-m-d');
    //        $eventDays->task_date = $current_date->format('Y-m-d');
    //        $eventDays->users = collect($eventDays->users);
           
    //        $events[] = $eventDays;
    //    }

    //    return $events;
    // }


    public static function calendarData()
{
    $tasks = self::with('users')->get();
    $events = [];
    foreach ($tasks as $task) {
        $events = array_merge($events, self::splitTask($task));
    }
    return $events;
}

public static function splitTask($task)
{
    $events = [];
    $start_date = $task->task_date;
    $end_date = $task->end_date;
    $task_type = $task->task_type; // Assuming you have a 'task_type' field in your Task model.

    $start_date = Carbon::createFromFormat('Y-m-d', $start_date);
    $end_date = Carbon::createFromFormat('Y-m-d', $end_date);

    if ($task_type == 0) {
        // For 'day' task_type, split the task by days
        $daysDifference = $end_date->diffInDays($start_date);
        for ($i = 0; $i <= $daysDifference; $i++) {
            $current_date = $start_date->copy()->addDays($i);
            $eventData = self::createEventData($task, $current_date);
            $events[] = $eventData;
        }
    } elseif ($task_type == 1) {
        // For 'week' task_type, split the task by weeks
        $weeksDifference = $end_date->diffInWeeks($start_date);
        for ($i = 0; $i <= $weeksDifference; $i++) {
            $current_date = $start_date->copy()->addWeeks($i);
            $eventData = self::createEventData($task, $current_date);
            $events[] = $eventData;
        }
    } elseif ($task_type == 2) {
        // For 'month' task_type, split the task by months
        $monthsDifference = $end_date->diffInMonths($start_date);
        for ($i = 0; $i <= $monthsDifference; $i++) {
            $current_date = $start_date->copy()->addMonths($i);
            $eventData = self::createEventData($task, $current_date);
            $events[] = $eventData;
        }
    } elseif ($task_type == 3){
        // For Day task 
       $eventData = self::createEventData($task , $start_date);
       $events[] = $eventData;       
    }
    return $events;
}

public static function createEventData($task, $current_date)
{
    $eventData = json_decode(json_encode($task));
    $eventData->end_date = $current_date->format('Y-m-d');
    $eventData->task_date = $current_date->format('Y-m-d');
    $eventData->users = collect($eventData->users);

    return $eventData;
}

}
