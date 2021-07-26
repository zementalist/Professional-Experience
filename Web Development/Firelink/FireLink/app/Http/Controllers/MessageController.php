<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'subject' => 'required|max:50',
            'message' => 'required',
            'type' => ['required', Rule::in(['report', 'message'])]
        ]);
        $email = $request->input('email');
        $subject = $request->input('subject');
        $type = $request->input('type');
        $message = $request->input('message');
        $msg = new Message;
        $msg->email = $email;
        $msg->subject = $subject;
        $msg->type = $type;
        $msg->message = $message;
        $msg->seen = 0;
        $msg->save();
        return view('contact')->with('success', 'Your message was sent successfully');
    }

}
