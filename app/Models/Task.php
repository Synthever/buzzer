<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'status',
        'priority',
        'total_slot',
        'filled_slot',
        'form_link',
        'drive_link'
    ];

    protected $casts = [
        'total_slot' => 'integer',
        'filled_slot' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(TaskLog::class);
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->total_slot == 0) return 0;
        return round(($this->filled_slot / $this->total_slot) * 100, 2);
    }

    public function getProgressBarColorAttribute()
    {
        $percentage = $this->progress_percentage;
        if ($percentage < 30) return 'bg-red-500';
        if ($percentage < 70) return 'bg-yellow-500';
        return 'bg-green-500';
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'high' => 'text-red-500',
            'medium' => 'text-yellow-500',
            'low' => 'text-green-500',
            default => 'text-gray-500'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'text-gray-500',
            'in_progress' => 'text-blue-500',
            'selesai' => 'text-green-500',
            default => 'text-gray-500'
        };
    }
}
