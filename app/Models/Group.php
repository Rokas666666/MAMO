<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function modules() {
        return $this->hasMany('App\Models\Module');
    }

    public function users() {
        return $this->belongsToMany('App\Models\User', 'group_user', 'group_id', 'user_id');
    }

}
