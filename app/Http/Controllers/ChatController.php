<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\MessageSent;
use App\Events\InitChat;
use App\Events\ActivateChat;
use App\Events\DeactivateChat;

use App\Setting;

use Auth;
use Session;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function activateChat()
    {
        $data = []; 

        event(new ActivateChat($data));

        $chatActive = Setting::firstOrCreate(['name'=>'chat_active']);
        $chatActive->value = 1;
        $chatActive->save();

    }

    public function deactivateChat()
    {
        $data = []; 

        event(new DeactivateChat($data));

        $chatActive = Setting::firstOrCreate(['name'=>'chat_active']);
        $chatActive->value = 0;
        $chatActive->save();
    }

    public function initChat(Request $request)
    {
        $data['user'] = $request->get('user');

        event(new InitChat($data));
    }


   	public function sendMessage(Request $request)
	{
		$text = $request->get('text');
        $user = $request->get('user');
        
        if(Auth::check())
        {
            $sender = Auth::user()->id;
        }
        else
        {
            $sender = Session::getId();
        }

        $data['text'] = $text;
        $data['user'] = $user;
        $data['sender'] = $sender;

	    event(new MessageSent($data));
	}

    public function chatWindowHtml(Request $request)
    {
        $data['user'] = $request->get('user');

        return view('chat.window', $data)->render();
    }

}
