<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 'email', 'password', 'profile_pic_path', 'credits', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function details(){
        if($this->role === 0) return $this->hasOne('App\Models\CustomerDetail', 'user_id');
        else if($this->role === 1) return $this->hasOne('App\Models\ProgrammerDetail', 'user_id');
    }

    public function models(){
        return $this->hasmany('App\Models\MLModel', 'user_id');
    }
    
    public function reviews(){
        return $this->hasmany('App\Models\ModelReview', 'user_id');
    }
    
    public function updates(){
        return $this->hasmany('App\Models\ModelUpdate', 'user_id');
    }
    
    public function getModelFolderAttribute(){
        return hash::make($this->id . '__' . $this->created_at);
    }

}
