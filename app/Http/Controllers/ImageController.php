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

    /**
     * Funkcia pre vykreslenie obrázku na základe hodnôt z requestu
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function render(Request $request)
    {
        $rules = Validator::make($request->all(), [
            'w' => 'required',
            'h' => 'required',
            'path' => 'required',
            'image' => 'required'
        ]);

        // Zakomentovať - stále vyhadzuje túto chybu, aj ked response obsahuje všetky polia
        /*if ($rules->fails()){
            return response()->json(['Obrázok sa nenašiel'], 500);
        }*/

        // Získanie posledných segmentov z URL - /adresar_galerie/obrazok.jpg
        $gallery_dir = $this->urlParser($request->path);
        $image_dir = $request->image;

        $path = 'images/' . $gallery_dir[0] . '/' . $image_dir;


        if (!File::exists($path)) {
            return response()->json(['Obrázok sa nenašiel'], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        // Zostavenie response reťazca
        $response = \Illuminate\Support\Facades\Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    /* Funkcia pre zmenu veľkosti */
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

    /**
     * Privátna funkcia oddelí segmenty od URL adresy
     * @param $uri
     * @return false|string[]
     */
    private function urlParser($uri){
        $uri_path = parse_url($uri, PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);
        return $uri_segments;
    }

}
