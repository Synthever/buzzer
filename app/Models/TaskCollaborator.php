<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCollaborator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_id',
        'user_id',
    ];
    
    /**
     * Get the task that this collaboration is for.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    
    /**
     * Get the user that is collaborating.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
