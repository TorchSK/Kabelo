<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\MessageSent;
use App\Events\InitChat;

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

    public function initChat(Request $request)
    {
        $data['user'] = $request->get('user');

        event(new InitChat($data));
    }


   	public function sendMessage(Request $request)
	{
		$text = $request->get('text');

        $data['text'] = $text;

        if(Auth::check())
        {
            $data['user'] = Auth::user();
        }
        else
        {
            $data['user'] = Session::getId();
        }

	    event(new MessageSent($data));
	}

    public function chatWindowHtml(Request $request)
    {
        $data['user'] = $request->get('user');

        return view('chat.window', $data)->render();
    }

}
