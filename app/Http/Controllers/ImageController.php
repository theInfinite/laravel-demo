<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

use App\Http\Requests;

class ImageController extends Controller
{
    public function index(){

        $image = new \App\Image();
        $data = $image->get();

        return view('image',['images'=>$data]);
    }

    public function uploadPic(Request $request){

        $fileName =  $request->filename;
        dd($request);
        $uploads_dir = '/public/uploads/';
//        $fileName->move($uploads_dir,$fileName);
        move_uploaded_file($fileName, "$uploads_dir");
    }


    public function uploadImage(Request $request) {


        $type = request()->file('file')->getMimeType();
        $file_extension = request()->file('file')->guessClientExtension();
        $file_size = request()->file('file')->getClientSize();
        $file_name = date('dmyhis').request()->file('file')->getClientOriginalName();

        if (isset($type)) {
            $validextensions = array("jpeg", "jpg", "png");

            if ((($type == "image/png") || ($type == "image/jpg") || ($type == "image/jpeg")) && ($file_size < 2097152) && in_array($file_extension, $validextensions)) {

                if (request()->file('file')->getError() > 0) {
                    echo "Return Code: " . request()->file('file')->getError() . "<br/><br/>";
                } else {
                    if (file_exists("/uploads" . $file_name)) {
                        echo $file_name . " <span id='invalid'><b>already exists.</b></span> ";
                    } else {

                        $file = request()->file('file')->move(public_path() . "/uploads", $file_name);

                        $image = new \App\Image();

                        $image->file = $file_name;
                        $image->created_at = date('Y-m-d H:i:s');
                        $image->updated_at = date('Y-m-d H:i:s');
                        $image->save();

                        return 'success';
                    }
                }
            } else {
                echo "<span id='invalid'>Invalid file Size or Type.<span>";
                return 'Invalid';
            }


        }
    }



    public function closeImage(Request $request) {

        $image = new \App\Image();
        $data = $image->get();
        $fileIds = array();
     //   dd($data[0]['file']);

        $file_id = $request->file_id;
        $content = '';
        foreach($data as $detail) {
            $fileName = ($detail['file']);
            if($detail['id'] != $file_id) {

                $content .= "<div id=\"lightboxOverlay\" class=\"lightboxOverlay\"></div>
                                <div id=\"lightbox\" class=\"lightbox\">
                                    <div class=\"lb-dataContainer\">
                                        <div class=\"lb-data\">
                                            <div class=\"lb-details\">
                                                <span class=\"lb-caption\"></span>
                                                <span class=\"lb-number\"></span>
                                            </div>
                                            <div class=\"lb-closeContainer\">
                                                <a class=\"lb-close\"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"col-md-3\" style=\"height:150px; margin-bottom: 50px;\">
                                    <img src=\"{{ asset('uploads/$fileName') }}\" style=\"height:120px\">
                                </div>";
            }

        }
        return $content;
    }

}
