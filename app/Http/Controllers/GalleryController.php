<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
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
     * Funkcia zobrazi vsetky galerie z databazy
     * @param Request $request
     * @return \App\Traits\Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $gallery = Gallery::all();
        return $this->successResponse($gallery);
    }

    public function show($path){
        $item = Gallery::all()->where('path', $path);
        $id_gallery = DB::select('select * from galleries where path = ?', [$path]);

        foreach($id_gallery as $value){
            $get_id_of_gallery = $value->id;
        }

        $imglist = Image::all()->where('id_gallery', $get_id_of_gallery );

        // return, vráti response hodnotu
        return response()->json( ['gallery' => $item, 'images' => $imglist], 200);
    }

    /**
     * Funkcia vytvori novu galeriu a prideli path -  cestu k priecinku.
     * @param Request $request
     * @return \App\Traits\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert(Request $request){
        $rules = [
            'name' => 'required|max:255',
        ];

        $rules = $this->validate($request, $rules);
        $path = $rules['name'];
        $path .= '.jpg';

        $path = strtolower($rules['name']);

        // Vytvorí novú galeériu do databázy
        $gallery = DB::insert('insert into galleries (name, path) values (?, ?)', [$rules['name'], $path]);

        // return, vráti response hodnotu
        return response()->json( ['name' => $rules['name'], 'path' => $path], Response::HTTP_CREATED);
    }

    public function update(){

    }

    public function upload(){

    }

    /**
     * Funkcia odstráni galériu na základe zvolenej URL PATH $path /gallery/{path}
     * @param $path
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($path){
        $gallery = Gallery::where('path', $path);
        $gallery = $gallery->delete();

        if ($gallery == null){
            return $this->notfoundDelete($gallery);
        } else {
            return $this->successDelete($gallery);
        }

        // Tento response pre všeobecnu chybu v exception sa nachádza v app/Exceptions/Handler.php:
        // return response()->json( ['message' => 'Nedefinovaná chyba'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
