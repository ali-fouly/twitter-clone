<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    public function user(){

    	return $this->belongsTo('App\User');

    }
}
