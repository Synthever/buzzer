<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'priority',
        'deadline',
        'total_slots',
        'completed_slots',
        'form_link',
        'drive_link',
        'user_id'
    ];

    // Relationship with User (owner)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with collaborators
    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'task_collaborators');
    }
}
