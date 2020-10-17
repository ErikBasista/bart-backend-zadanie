<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class ImageUploadController extends BaseController
{
    public $path;
    public $fullpath;
    public function __construct($path, $fullpath)
    {
        $this->path = $path;
        $this->fullpath = $fullpath;
    }

    public function uploadImage(Request $request)
    {
        $response = null;
        $user = (object) ['image' => ""];

        if ($request->hasFile('image')) {
            $original_filename = $request->file('image')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './images/' . $this->fullpath;
            $image = $this->path;

            if ($request->file('image')->move($destination_path, $image)) {
                $user->image = '/images/' . $this->fullpath;
                return $this->responseRequestSuccess($user);
            } else {
                return $this->responseRequestError('Obrázok sa nedá nahrať');
            }
        } else {
            return $this->responseRequestError('Chybný request - nenašiel sa súbor pre upload.', 400);
        }
    }

    protected function responseRequestSuccess($ret)
    {
        return response()->json(['status' => 'success', 'data' => $ret], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    protected function responseRequestError($message = 'Bad request', $statusCode = 200)
    {
        return response()->json(['status' => 'error', 'error' => $message], $statusCode)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    //
}
