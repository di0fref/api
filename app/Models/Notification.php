<?php

namespace App\Models;

/* https://auth0.com/blog/developing-restful-apis-with-lumen/ */

use Illuminate\Database\Eloquent\Casts\Attribute;

class Notification extends ModelUuid
{
    protected $fillable = [
        "user_id",
        "action",
        "module_id",
        "module",
        "by_user_id"
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];
    public function notificationusers()
    {
        return $this->hasMany(NotificationsUsers::class);
    }
}
