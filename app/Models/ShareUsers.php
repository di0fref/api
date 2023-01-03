<?php

namespace App\Models;

class ShareUsers extends ModelUuid
{
    protected $fillable = [
        'project_id',
        'email',
        'status',
        'edit',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

}
