<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function taskLogs()
    {
        return $this->hasMany(TaskLog::class);
    }

    // Users that this user collaborates with
    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'collaborations', 'user_id', 'collaborator_id')
                    ->withTimestamps();
    }

    // Users that collaborate with this user
    public function collaboratorOf()
    {
        return $this->belongsToMany(User::class, 'collaborations', 'collaborator_id', 'user_id')
                    ->withTimestamps();
    }

    // Get all collaborations (both ways)
    public function allCollaborators()
    {
        $collaborators = $this->collaborators->pluck('id')->toArray();
        $collaboratorOf = $this->collaboratorOf->pluck('id')->toArray();
        
        return User::whereIn('id', array_unique(array_merge($collaborators, $collaboratorOf)))
                   ->where('id', '!=', $this->id)
                   ->get();
    }

    // Get all tasks accessible to this user (own tasks + collaborative tasks)
    public function accessibleTasks()
    {
        $collaboratorIds = $this->allCollaborators()->pluck('id')->toArray();
        $allUserIds = array_merge($collaboratorIds, [$this->id]);

        return Task::whereIn('user_id', $allUserIds);
    }

    public function isAdmin()
    {
        return $this->is_admin == 1 || $this->role === 'admin';
    }
}
