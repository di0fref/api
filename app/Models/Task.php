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
        'deleted',
        'user_id',
        'due',
        "order",
        "type",
        "prio",
        "project_id"
    ];

    protected $casts = [
        "completed" => "boolean",
        "deleted" => "boolean"
    ];

    protected function due(): Attribute
    {
        return Attribute::make(set: fn($value) => ($value == "" or $value == null) ? null : $value,);
    }

}
