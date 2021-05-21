<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Note;
class noteController extends Controller
{    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }
   public function index()
   {
       //
       if(Auth::check()) {
            $notes = Note::where("user_id", '=', auth()->user()->id)->get();
       }
       else {
           $notes = array();
       }
       return view("note")->with("notes", $notes);
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       //
       $this->validate($request, [
           'content' => 'required'
       ]);
       $note = new Note();
       $note->user_id = auth()->user()->id;
       $note->content = $request->input('content');
       $note->save();
       $notes = Note::where("user_id", '=', auth()->user()->id)->get();
       return view("note")->with("notes", $notes);
   }



   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
       //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete(Request $request)
   {
        $this->validate($request, [
            'content' => 'required',
            'note_id' => 'required'
        ]);
        $note_id = $request->input("note_id");
        $note = Note::where('note_id', '=', $note_id);
        $note->delete();
        $notes = Note::where("user_id", '=', auth()->user()->id)->get();
        return view("note")->with("notes", $notes);
   }
}
