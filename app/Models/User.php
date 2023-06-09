<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function school() {
        return $this->belongsTo('App\Models\School');
    }

    public function modules() {
        return $this->hasMany('App\Models\Module');
    }

    public function grades() {
        return $this->hasMany('App\Models\Grade');
    }

    public function mails() {
        return $this->hasMany('App\Models\Mail', 'sender_id');
    }

    public function groups() {
        return $this->belongsToMany('App\Models\Group', 'group_user', 'user_id', 'group_id');
    }

    public function parents() {
        return $this->belongsToMany('App\Models\User', 'child_parent', 'child_id', 'parent_id');
    }

    public function child() {
        return $this->belongsToMany('App\Models\User', 'child_parent', 'parent_id', 'child_id');
    }

    public function receivedMails() {
        return $this->belongsToMany('App\Models\Mail', 'mail_received', 'receiver_id', 'mail_id');
    }
}
