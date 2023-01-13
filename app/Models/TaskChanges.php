<?php

namespace App\Models;

/* https://auth0.com/blog/developing-restful-apis-with-lumen/ */

use Illuminate\Database\Eloquent\Casts\Attribute;

class TaskChanges extends ModelUuid
{
    protected $fillable = [
        'old',
        'new',
        'user_id',
        "assigned_user_id",
        "field",
        "type",
        "task_id"
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

//    public function project()
//    {
//        return $this->belongsTo(Project::class);
//    }
//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }
//
//    function completed(): Attribute
//    {
//        return Attribute::make(
//            set: fn($value) => $value == "" ? 0 : 1
//        );
//    }
//
//    function pinned(): Attribute
//    {
//        return Attribute::make(
//            set: fn($value) => $value == "" ? 0 : 1
//        );
//    }
//
//    protected function due(): Attribute
//    {
//        return Attribute::make(
//            set: fn($value) => ($value == "" or $value == null) ? null : $value
//        );
//    }
//    protected function completedat(): Attribute
//    {
//        return Attribute::make(
//            set: fn($value) => (($value == "" or $value == null) ? null : $value),
//        );
//    }
//
//    protected function updatedAt(): Attribute
//    {
//        return Attribute::make(
//            set: fn($value) => (($value == "" or $value == null) ? null : $value),
//        );
//    }
//
//    protected function deletedat(): Attribute
//    {
//        return Attribute::make(
//            set: fn($value) => ($value == "" or $value == null) ? null : $value
//        );
//    }
}
