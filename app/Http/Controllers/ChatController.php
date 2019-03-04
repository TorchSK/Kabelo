<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\MessageSent;

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


   	public function sendMessage(Request $request)
	{
		$text = $request->get('text');

        $data['text'] = '111';

	    event(new MessageSent($data));
	}

}
