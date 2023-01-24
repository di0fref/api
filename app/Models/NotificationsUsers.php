<?php

namespace App\Models;

/* https://auth0.com/blog/developing-restful-apis-with-lumen/ */

use Illuminate\Database\Eloquent\Casts\Attribute;

class NotificationsUsers extends ModelUuid
{
    protected $fillable = [
        "user_id",
        "notification_id",
        "status",
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nofification()
    {
        return $this->belongsTo(Notification::class);
    }
}

