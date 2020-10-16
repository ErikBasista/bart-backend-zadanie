<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;

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

    public function render(Request $request){
        $allimages = Image::all();
        return $this->successResponse($allimages);
    }

}
