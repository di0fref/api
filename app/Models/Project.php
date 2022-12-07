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

}
