<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\SMS;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SystemController extends Controller
{
    public function SendMessage(Request $request){

        $users = User::query()->where('type', 'agent')->whereNotNUll('phone')->get();

        if($request->isMethod('POST')){
            Log::info("SystemController :: SendMessage :: Request". print_r($request->all(),true));

            $validated = $request->validate([
                'users' => 'required|array',
                'message' => 'required',
            ],  [
                'users.required' => 'Please select users',
                'message.required' => 'Message is required',
            ]);

            if(!in_array('all',$request->users)){
                $users = User::find($request->users);
            }

            foreach($users as $user){
                try {
                    Log::info("SystemController :: SendMessage :: User Phone ::". $user->phone);
                    SMS::sendToUser($user, $request->message);
                } catch(Exception $e){
                    Log::info("SystemController :: SendMessage :: Exception ::".print_r($e->getMessage(),true));
                    continue;
                }
            }
            
            return redirect()->route('admin.system.send-message')->with(['message' => 'Message Sent Successfully']);
        }

        return view('admin.system.send_message',compact('users'));

    }
}
