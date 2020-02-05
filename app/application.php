<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class application extends Model
{
    protected $table = 'application';
    protected $fillable = ['name','icon'];
    
    public function new_application(Request $request)
    {
        $application = new application;
        $application->name = $request->name;
        $application->icon = $request->icon;
        $application->save();
    }
    
    public function applicationExists($name){
        $applications = self::where('name',$name)->get();
        
        foreach ($applications as $key => $value) {
            if($value->name == $name){
                return true;
            }
        }
        return false;
    }
    public function getApplications(){
        $applications = self::all();
        return $applications;
    }
}
