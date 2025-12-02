<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'description',
        'is_archived'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
