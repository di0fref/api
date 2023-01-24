<?php

namespace App\Models;

class Project extends ModelUuid
{
    protected $fillable = [
        'name',
        'text',
        'deleted',
        'user_id',
        "order",
        "color"
    ];

    protected $casts = [
        "completed" => "boolean",
        "deleted" => "boolean",
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
