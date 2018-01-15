<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $fillable = ['city','country', 'user_id','about'];

    public function user(){
    	return $this->belongsTo('App\User');
    }

}
