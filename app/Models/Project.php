<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    use RecordsActivity;

    protected $fillable = ['title', 'description', 'notes'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->latest();
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
}
