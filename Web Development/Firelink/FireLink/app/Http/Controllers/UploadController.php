<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Image;
use App\Audio;
use App\Video;
use App\Compressed;
use App\Document;
use Validator;
use DateTime;

class UploadController extends Controller
{

    // function to get mimes,maxsize,file-path-to-store,icon class font-awesome, tableName by(type)
    private function fileQuery($fileType) {
        if($fileType === 'Image') {
            $arrayOfMimes = array('jpeg', 'jpg', 'png', 'gif', 'bmp', 'ico', 'pjpeg', 'svg');
            $maxSize = '4999';
            $storePath = '/public/files/Image/';
            $iconFA = 'far fa-image';
            $model = new Image;
        }
        else if($fileType === 'Video') {
            $arrayOfMimes = array('mp4', 'mpg', 'flv', 'avi', '3gp', 'rm', 'wmv', 'm4v');
            $maxSize = '14999';
            $storePath = '/public/files/Video/';
            $iconFA = 'far fa-file-video';
            $model = new Video;
        }
        else if($fileType === 'Audio') {
            $arrayOfMimes = array('mp3', 'mpga', 'wav', 'wma', 'mpa', 'cda', 'acc', 'm4a', 'mid', 'amr', 'ogg');
            $maxSize  = '14999';
            $storePath = '/public/files/Audio/';
            $iconFA = 'far fa-file-audio';
            $model = new Audio;
        }
        else if($fileType === 'Compressed') {
            $arrayOfMimes = array('rar', 'zip', '7z', 'z', 'rpm', 'tar.gz');
            $maxSize = '9999';
            $storePath = '/public/files/Compressed/';
            $iconFA = 'fas fa-file-archive';
            $model = new Compressed;
        }
        else if($fileType === 'Document') {
            $arrayOfMimes = array('pdf', 'doc', 'docx', 'ppt', 'pptx', 'xlr', 'xls', 'xlsx', 'rtf', 'wks', 'wps', 'txt');
            $maxSize = '14999';
            $storePath = '/public/files/Document/';
            $iconFA = 'far fa-file-alt';
            $model = new Document;
        }
        else if($fileType === 'Other') {
            $arrayOfMimes = null;
            $maxSize = null;
            $storePath = null;
            $iconFA = 'far fa-file';
            $model = null;
        }
        else {
            $arrayOfMimes = null;
            $maxSize = null;
            $storePath = null;
            $iconFA = null;
            $model = null;
        }
        $details = array('extensions' => $arrayOfMimes, 'maxSize' => $maxSize, 'storePath' => $storePath, 'icon' => $iconFA, 'model' => $model);
        return $details;
    }
    // check if able to getimagesize and width&height are integers , IDK what the hack could be !
    private function testImageSize($myImage) {
        try {
            list($width, $height) = getimagesize($myImage); 
            $passImageSize = (is_numeric($width) && is_numeric($height));
        }
        catch (Exception $e) {
            $passImageSize = false;
        }
        return $passImageSize;
    }
    function utf8_strrev($str){
        preg_match_all('/./us', $str, $ar);
        return join('', array_reverse($ar[0]));
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
    // encrypt file name by (filename, username, type)
    private function encryptFileName($a, $b, $c) {
        // Check if ENG characters //
        if( !($this->ctype_alnum_portable($a) && $this->ctype_alnum_portable($b)) ) {
            $alphanumeric = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $a1 = str_shuffle($alphanumeric)[rand(0, strlen($alphanumeric) - 1)];
            $b1 = str_shuffle($alphanumeric)[rand(0, strlen($alphanumeric) - 1)];
            $code = $a1[0] . $b1[0] . date("Hs", time()) . $c[0] . $c[1];
        }
        else {
            $code = $a[0] . $b[0] . date("Hs", time()) . $c[0] . $c[1];
        }
        $finalName =  $code . $a;
        return $this->utf8_strrev($finalName);
    }
    // get secure code by (filename, username, type), 
    private function getSecureCode($a, $b, $c) {
        // Check if ENG characters //
        if( !(ctype_alnum($a) && ctype_alnum($b)) ) {
            $alphanumeric = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $a1 = str_shuffle($alphanumeric)[rand(0, strlen($alphanumeric) - 1)];
            $b1 = str_shuffle($alphanumeric)[rand(0, strlen($alphanumeric) - 1)];
            $code = $a1[0] . $b1[0] . date("Hs", time()) . $c[0] . $c[1];
        }
        else {
            $code = $a[0] . $b[0] . date("Hs", time()) . $c[0] . $c[1];
        }
        $secureCode = str_shuffle($code);
        return $secureCode;
    }
    // dycrypt file name by (filename, fileExtension)
    private function dycryptFileName($fileN, $fileE) {
        $fileName = $this->utf8_strrev($fileN);
        $fileName = substr($fileName, 6+6, strlen($fileName)) . '.' . $fileE;
        return $fileName;
    }
    // get file type from its id //
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

    // get string format for time difference (now | file-upload-date) //
    private function formatTime($fileDate) {
        $start_date = new DateTime();
        $since_start = $start_date->diff(new DateTime($fileDate));
        // day (test)
        if($since_start->d > 0) {
            return $since_start->d . ' day(s) ago';
        }
        // hour
        else if($since_start->h > 0) {
            return $since_start->h . ' hour(s) ago';
        }
        // minute
        else if($since_start->i > 0) {
            return $since_start->i . ' minute(s) ago';
        }
        // second
        else if($since_start->i > 0) {
            return $since_start->s . ' second(s) ago';
        }
        else {
            return 'now';
        }
    }
    public function progress() {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type');
        $maxSize = $this->fileQuery($type)['maxSize'];
        $arrayOfMimes = $this->fileQuery($type)['extensions'];
        if($arrayOfMimes !== null) {
            $fileDetails = array('type' => $type, 'maxSize' => $maxSize, 'possibleExtn' => $arrayOfMimes);
            return view('upload')->with('fileDetails' ,$fileDetails);
        }
        return view('error');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $type = $request->input('type');
        $maxSize = $this->fileQuery($type)['maxSize'];
        if($maxSize !== null) {
            $extensions = $this->fileQuery($type)['extensions'];
            $storePath = $this->fileQuery($type)['storePath'];
            $mimes =  implode(",", $extensions);
            $this->validate($request, [
                'name' => 'nullable|max:50|',
                'file' => "required|file|max:$maxSize|mimes:$mimes"
            ]);
            $file = $request->file('file');
            $username = (strlen($request->input('name')) > 0 ? $request->input('name') : 'unknown');
            $keepfor = $request->input('duration');
            // keepfor : 0 = 4 hours , 1 = 1 day //
            // Security Checking //
            $fileFullName = $file->getClientOriginalName();
            $fileName = pathinfo($fileFullName, PATHINFO_FILENAME);
            $fileSize =round(($request->file('file')->getSize() / 1000000), 2) . ' MB';
            $fileExt = $file->getClientOriginalExtension();
            $passExtensionTest = in_array(strtolower($fileExt), $extensions);
            $isImageOrSecure = ($type == 'Image' ? $this->testImageSize($file) : true);
            if($passExtensionTest && $isImageOrSecure) {
                // Storage && Database //
                $uploadHour = date("H", time());
                $fileID = \uniqid($type) . str_shuffle($type);
                $secureCode = $this->getSecureCode($fileName, $username, $type);
                $fileNameToView = $fileName . '.' . $fileExt;
                $fileNameToStoreDB =  $this->encryptFileName($fileName, $username, $type) . '.' . strtolower($fileExt);
                $fileNameToStoreSRV = $this->filterStr($fileNameToStoreDB);
                $file_record = $this->fileQuery($type)['model'];
                $file_record->id = $fileID;
                $file_record->type = $type;
                $file_record->name = $fileNameToStoreDB;
                $file_record->size = $fileSize;
                $file_record->extension = strtolower($fileExt);
                $file_record->upload_hour = $uploadHour;
                $file_record->keepfor = $keepfor;
                $file_record->username = $username;
                $file_record->secure_code = $secureCode;
                $file_record->save();
                $store = $file->storeAs($storePath, $fileNameToStoreSRV);
                // what about same file uploaded twice or more ! //
                $success = 'File uploaded successfully';
                $info = 'Save & Remember your file secure code, in case you want to delete it!';
                $filedata = array('name' => $fileNameToView, 'size' => $fileSize, 'icon' => $this->fileQuery($type)['icon']
                , 'time' => $this->formatTime($file_record->created_at), 'type' => $type, 'extension' => $fileExt,
                 'id' => $fileID, 'downloadable' => $fileNameToStoreSRV ,'user' => $username,
                  'secureCode' => $secureCode, 'success' => $success, 'info' => $info);
                return view("files")->with('file', $filedata);
            }
            else {
                // Attack Detected //
                return redirect('/')->with('error', 'Somewting went wrong!, please try again');
            }
        }
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $type = $this->extractType($id);
        if($type !== null) {
            $model = $this->fileQuery($type)['model'];
            $file = $model::find($id);
            if($file) {
                // File found //
                $filedata = array('name' => $this->dycryptFileName($file->name, $file->extension), 'size' => $file->size, 'id' => $id, 'icon' => $this->fileQuery($type)['icon']
                , 'time' => $this->formatTime($file->created_at), 'type' => $type, 'downloadable' => $this->filterStr($file->name) ,'user' => $file->username);
                return view('files')->with('file', $filedata);
            }
            else {
                // File not found //
                $error = "File doesn't exists or expired!";
                return view('error')->with('error', $error);
            }
        }
        else {
            // Error
            return view('error');
        }
        // What notes will be given to use ? /* file:name,size,time,if(image){view}else{icon},delete
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // check secure code
        $this->validate($request, [
            'code' => 'required|max:10',
        ]);
        $type = $this->extractType($id);
        if($type != null) {
            $model = $this->fileQuery($type)['model'];
            $file = $model::find($id);
            if($file) {
                $secureCode = $request->input('code');
                if($secureCode === $file->secure_code) {
                    Storage::delete('/public/files/' . $file->type . '/' . $this->filterStr($file->name));
                    $filename = $this->dycryptFileName($file->name, $file->extension);
                    $success = "File '$filename' has been deleted successfully!";
                    $file->delete();
                    return redirect('/')->with('success', $success);
                }
                else {
                    $error = "The secure code you've entered is not correct!";
                    return redirect("files/$id")->with('error', $error);
                }
            }
            else {
                $error = "File not found!";
                return view("files")->with('error', $error);
            }
        }
        else {
            return view('error');
        }
    }
}
