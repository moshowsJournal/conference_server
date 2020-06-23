<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Talk;
use Illuminate\Support\Facades\Validator;
use App\Attendee;
class PagesController extends Controller
{
    //

    public function add_talk(Request $request){
        $is_valid = Talk::is_valid();
        $response = array(
            'status' => 200,
            'message' => 'Success! Talk has been saved'
        );
        if(!$is_valid){
            $response = array(
                'code' => 402,
                'message' => 'All required fields must be filled correctly'
            );
            return response()->json(compact('response'));
        }
        if(!$talk = Talk::create($request->all())){
            $response = array(
                'code' => 500,
                'message' => 'Opps! Something went wrong'
            );
            return response()->json(compact('response'));
        }
        $response['talk'] = $talk;
        return response()->json(compact('response'));
    }

    public function get_talks(){
        $all_talks = Talk::all();
        $response = [
            'code' => 200,
            'talks' => $all_talks
        ];
        return response()->json(compact('response'));
    }

    public function create_attendees(Request $request){
        $validator = Validator::make($request->all(),[
            'full_name' => 'required',
            'email' => 'required'
        ]);
        if($validator->fails()){
            $response = [
                'code' => 402,
                'errors' => $validator->errors()
            ];
            return response()->json(compact('response'));
        }
        if(!$attendee = Attendee::create($request->all())){
            $response = [
                'code' => 500,
                'message' => 'Opps! Something went wrong. Please retry'
            ];
            return response()->json(compact('response'));
        }
        $response = [
            'code' => 200,
            'attendee' => $attendee,
            'message' => 'Success! Record has been saved'
        ];
        return response()->json(compact('response'));
    }

    public function get_attendees(){
        $all_attendees = Attendee::all();
        $response = array(
            'code' => 200,
            'attendees' => $all_attendees
        );
        return response()->json(compact('response'));
    }
}
