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
        $path = resource_path() . '/images/' . 'Elephant.jpg';

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

    }


}
