<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usage extends Model
{
     protected $table = 'usage';
    protected $fillable = ['day','useTime','location','user_id','application_id'];
    
    public function new_usage(Request $request)
    {
        $usage = new usage;
        $usage->day = $request->day;
        $usage->useTime = $request->useTime;
        $usage->location = $request->location;
        $usage->user_id = $request->user_id;
        $usage->application_id = $request->application_id;
        $usage->save();
    }
}
