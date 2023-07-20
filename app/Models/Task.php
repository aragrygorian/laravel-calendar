<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'task_type', 'task_description' , 'task_time' , 'task_date' , 'end_date'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
