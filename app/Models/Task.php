<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    use RecordsActivity;

    protected $fillable = ['title', 'description', 'user_id', 'status'];

    protected static $recordableEvents = ['created', 'deleted'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
