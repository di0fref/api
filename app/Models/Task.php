<?php

namespace App\Models;

/* https://auth0.com/blog/developing-restful-apis-with-lumen/ */

use Illuminate\Database\Eloquent\Casts\Attribute;

class Task extends ModelUuid
{
    protected $fillable = [
        'name',
        'text',
        'completed',
        'completed_at',
        'deleted',
        'deleted_at',
        'user_id',
        'due',
        "order",
        "type",
        "prio",
        "project_id",
        "pinned",
        "assigned_user_id"
    ];

    protected $casts = [
        "completed" => "boolean",
        "deleted" => "boolean",
        'created_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
        'completed_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    function completed(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value == "" ? 0 : 1
        );
    }

    function pinned(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value == "" ? 0 : 1
        );
    }

    protected function due(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ($value == "" or $value == null) ? null : $value
        );
    }
    protected function completedat(): Attribute
    {
        return Attribute::make(
            set: fn($value) => (($value == "" or $value == null) ? null : $value),
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            set: fn($value) => (($value == "" or $value == null) ? null : $value),
        );
    }

    protected function deletedat(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ($value == "" or $value == null) ? null : $value
        );
    }
}
