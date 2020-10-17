<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function render(Request $request)
    {
        /*$rules = Validator::make($request->all(), [
            'w' => 'required',
            'h' => 'required',
            'path' => 'required'
        ]);*/

        //$path = storage_path('/images/' . 'Elephant.jpg');
        $path = 'images/' . 'Elephant.jpg';

        if (!File::exists($path)) {
            return response()->json(['Obrázok sa nenašiel'], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        //$response = Response::make();

        $response = \Illuminate\Support\Facades\Response::make($file, 200);
        $response->header("Content-Type", $type);

        //return response()->json($file, 200)->header("Content-Type", $type);
        return $response;

        //usage example


        //$this->resize_crop_image(100, 100, "$path", 'images/');

    }

    public function test(){
        if (empty($base64_encoded))
            return 'Elephant.jpg';

        $uploads_dir = base_path('public/images');
        $file_name = uniqid();

        $allowed_mimes = ['data:image/jpeg;base64', 'data:image/png;base64'];

        $the_image = explode(',', $base64_encoded);

        // Log::debug(var_export($the_image,true));

        $mime = $the_image[0]; // data:image/jpeg;base64
        $image = $the_image[1];
        $extension = '.jpg';

        if (!in_array($mime, $allowed_mimes))
            return response([
                'message' => ['File not allowed']
            ], 403);

        $file = fopen($uploads_dir.'/'.$file_name.$extension, 'wb');
        fwrite($file, base64_decode($image));
        fclose($file);


    }

    /*public function resize_crop_image($max_width = 400, $max_height = 400, $source_file, $dst_dir, $quality = 80){
        $imgsize = getimagesize($source_file);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];

        $image_create = "imagecreatefromjpeg";
        $image = "imagejpeg";
        $quality = 80;


        $dst_img = imagecreatetruecolor($max_width, $max_height);
        $src_img = $image_create($source_file);

        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if($width_new > $width){
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        }else{
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }

        $image($dst_img, $dst_dir, $quality);

        if($dst_img)imagedestroy($dst_img);
        if($src_img)imagedestroy($src_img);
    }*/



}
