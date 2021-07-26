<?php

namespace App\Http\Controllers;
use App\Message;
use App\Image;
use App\Audio;
use App\Video;
use App\Compressed;
use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class accessController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function fileQuery($fileType) {
        if($fileType === 'Image') {
            $model = new Image;
        }
        else if($fileType === 'Video') {
            $model = new Video;
        }
        else if($fileType === 'Audio') {
            $model = new Audio;
        }
        else if($fileType === 'Compressed') {
            $model = new Compressed;
        }
        else if($fileType === 'Document') {
            $model = new Document;
        }
        else {
            $model = null;
        }
        return $model;
    }
    function ctype_alnum_portable($text) {
        return (preg_match('~^[0-9a-z]*$~iu', $text) > 0);
    }
    // filter string (filename) from foreign-language characters
    private function filterStr($str) {
        $result = '';
        $allowedChars = explode(" ", "! @ # $ % ^ & ( ) - _ . , ' ");
        $allowedChars[] = " ";
        for($i = 0; $i < strlen($str); $i++) {
            if($this->ctype_alnum_portable($str[$i]) || in_array($str[$i], $allowedChars)) {
                $result .= $str[$i];
            }
        }
        return $result;
    }

    private function extractType($id) {
        $str = substr($id, 0, 10);
        $types = array('Image', 'Audio', 'Video', 'Document', 'Compressed', 'Other');
        for($i = 0; $i < count($types); $i++) {
            if(strpos($str, $types[$i]) !== false) {
                return $types[$i];
            }
        }
        return null;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('owner.control');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function dycryptFileName($fileN, $fileE) {
        $fileName = $this->utf8_strrev($fileN);
        $fileName = substr($fileName, 6+6, strlen($fileName)) . '.' . $fileE;
        return $fileName;
    }
    public function findFile(Request $request)
    {   
        $this->validate($request, [
            'search' => 'required|max:100',
            'sort' => 'required|max:4'
        ]);
        $name = $request->input('search');
        $type = $request->input('type');
        $method = $request->input('method');
        $model = $this->fileQuery($type);
        $sort = $request->input('sort');
        $sort = ($sort == "ASC" || $sort == "DESC" ? $sort : "DESC");
        if($method == 'username') {
            $files = $model::select('ID', 'name', 'size', 'extension', 'username', 'created_at')->where("username", 'like' ,  $name . '%')->orderBy('created_at', $sort)->get();
        }
        else if($method == 'filename') {
            $files = $model::select('ID', 'name', 'size', 'extension', 'username', 'created_at')->where("name", 'like' ,  strrev($name) . '%')->orderBy('created_at', $sort)->get();
        }
        else if($method == "fileid") {
            $files = $model::select('ID', 'name', 'size', 'extension', 'username', 'created_at')->where("id", '=' ,  $name)->orderBy('created_at', $sort)->get();
        }
        if(count($files) > 0) {
            return response()->json($files);
        }
        else {
            return response()->json([]);
        }
    }

    public function findMail(Request $request) {
        // Return array of messages\reports, pagination if needed
        $this->validate($request, [
            'type' => ['required', Rule::in(['all', 'report', 'message', 'unseen'])]
        ]);
        $type = $request->input('type');
        if($type == 'all') {
            $mails = Message::select('id', 'email', 'subject', 'type', 'message', 'seen', 'created_at')->orderBy('created_at', 'DESC')->paginate(5);
        }
        else if(in_array($type, array('report', 'message'))) {
            $mails = Message::select('id', 'email', 'subject', 'type', 'message', 'seen', 'created_at')->where('type', '=', $type)->orderBy('created_at', 'DESC')->paginate(5);
        }
        else if($type == 'unseen') {
            $mails = Message::select('id', 'email', 'subject', 'type', 'message', 'seen', 'created_at')->where('seen', '=', 0)->orderBy('created_at', 'DESC')->paginate(5);
        }
        else {
            $mails = [];
        }
        if(count($mails) > 1) {
            $response = [
                'pagination' => [
                    'total' => $mails->total(),
                    'per_page' => $mails->perPage(),
                    'current_page' => $mails->currentPage(),
                    'last_page' => $mails->lastPage(),
                    'from' => $mails->firstItem(),
                    'to' => $mails->lastItem()
                ],
                'data' => $mails
            ];
        }
        return response()->json($mails);
    }

    public function seen(Request $request) {
        $this->validate($request, [
            'mailid' => 'required'
        ]);
        $id = $request->input('mailid');
        $mail = Message::find($id);
        if($mail) {
            $mail->seen = 1;
            $mail->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyFile(Request $request)
    {
        $this->validate($request, [
            'fileid' => 'required|max:70'
        ]);
        $id = $request->input('fileid');
        $type = $this->extractType($id);
        $model = $this->fileQuery($type);
        $file = $model::find($id);
        if($file) {
            Storage::delete('/public/files/' . $file->type . '/' . $this->filterStr($file->name));
            $file->delete();
            return json_encode(array('msg' => "File Was Deleted Successfully!"));
        }
        else {
            return "FILE NOT FOUND";
        }
    }


    public function destroyMail(Request $request) {
        // delete a mail
        $this->validate($request, [
            'mailid' => 'required|integer'
        ]);

        $id = $request->input('mailid');
        $mail = Message::find($id);
        if($mail) {
            $mail->delete();
            return response()->json(array('msg' => "Mail Was Deleted Successfully!"));
        }
        else {
            return "MAIL NOT FOUND";
        }
    }
}
