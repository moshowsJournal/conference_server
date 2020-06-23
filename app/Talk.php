<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
class Talk extends Model
{
    //
    protected $table = 'talks';
    protected $fillable  = ['talk_title','speaker_name','allocated_time','location','attendees_id'];

    public static function is_valid(){
        $validator = Validator::make(Request::all(),[
            'talk_title' => 'required',
            'speaker_name' => 'required',
            'allocated_time' => 'required|numeric',
            'location' => 'required' 
        ]);
        if($validator->fails()){
            return false;
        }
        return true;
    }
}
