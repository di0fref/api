<?php

namespace App\Models;

class ProjectsUsers extends ModelUuid
{
    protected $fillable = [
        'project_id',
        'user_id',
        'shared_user_id',
        "email",
        "status"
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];


}
