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
        $is_existed = Attendee::where('email','=',$request->email)->exists();
        if($is_existed){
            $response = array(
                'code' => 402,
                'message' => 'Opps! Email address has already been added.'
            );
            return response()->json(compact('response'));
        }
        if($validator->fails()){
            $response = [
                'code' => 402,
                'message' => 'All required fields must be filled correctly'
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

    public function get_attendees(Request $request){
        $all_attendees = Attendee::all();
        $talk = null;
        if(isset($request->talk_id)){
            $talk = Talk::find($request->talk_id);
        }
        $response = array(
            'code' => 200,
            'attendees' => $all_attendees,
            'talk' => $talk
        );
        return response()->json(compact('response'));
    }

    public function add_to_talk(Request $request){
        $validator = Validator::make($request->all(),[
            'talk_id' => 'required',
            'attendee_id' => 'required'
        ]);
        if($validator->fails()){
            $response = [
                'code' => 402,
                'message' => 'All required fields must be filled correctly'
            ];
            return response()->json(compact('response'));
        }
        $talk = Talk::find($request->talk_id);
        if($talk === null){
            return $response = [
                'code' => 404,
                'message' => 'Opps! Record not found'
            ];
            return response()->json(compact('response'));
        }
        $attendees_array = explode(',',$talk->attendees_id);
        if(in_array($request->attendee_id,$attendees_array)){
            //remove attendee
           $index = array_search($request->attendee_id,$attendees_array);
           array_splice($attendees_array,$index,1);
        }else{
            array_push($attendees_array,$request->attendee_id);
        }
        $talk->attendees_id = implode(',',$attendees_array);
        if(!$talk->save()){
            $response  = [
                'code' => 500,
                'message' => 'Opps! Something went wrong'
            ];
            return response()->json(compact('response'));
        }
        $talk = Talk::find($request->talk_id);
        $response = [
            'code' => 200,
            'message' => 'Success! Record has been saved',
            'talk' => $talk
        ];
        return response()->json(compact('response'));
    }
}
