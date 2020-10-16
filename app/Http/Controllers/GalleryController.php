<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

        // Ak zadaná galéria v databáze neexistuje. Vráti sa chyba 404
        if ($id_gallery == null){
            return response()->json('Zvolená galéria neexistuje', 404);
        }

        foreach($id_gallery as $value){
            $get_id_of_gallery = $value->id;
        }

        //$imglist = Image::all()->where('id_gallery', $get_id_of_gallery );
        $imglist = DB::select('select name, path, fullpath, updated_at from images where id_gallery=?', [$get_id_of_gallery]);

        // Foreach slučka, ktorá znovu prepíše keys a zmení názov kľúča "updated_at" na "modified"
        foreach ($imglist as $key){
            $path = $key->path;
            $fullpath = $key->fullpath;
            $name = $key->name;
            $modified = $key->updated_at;
        }

        $imglist = [
            'path' => $path,
            'fullpath' => $fullpath,
            'name' => $name,
            'modified' => $modified
        ];

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

        // Vytvorí novú galériu do databázy
        $gallery = DB::insert('insert into galleries (name, path) values (?, ?)', [$rules['name'], $path]);

        // return, vráti response hodnotu
        return response()->json( ['name' => $rules['name'], 'path' => $path], Response::HTTP_CREATED);
    }

    public function update(){

    }

    public function upload(Request $request){
        $rules = Validator::make($request->all(), [
            'image' => 'required',
        ]);

        // Validator skontroluje, či bol vložený subor do POST požiadavky na nahratie. Ak nie - vrati response s chybovou hlaškou.
        if ($rules->fails()) {
            return response()->json('Chybný request - nenašiel sa súbor pre upload.', Response::HTTP_NOT_FOUND);
        }

        // proces nahravania suboru
        $files = $request->file('image');
        if(!empty($files)) {
            foreach($files as $file) {
                $image = Storage::put('public/images', file_get_contents($file));
                $this->insert($image);
            }
        }

        // Vytvorenie požadovaných reťazcov
        $name = substr($request->image->getClientOriginalName(), 0, -4);    // získa názov súboru bez prípony .jpg
        $path = strtolower($request->image->getClientOriginalName());                   // získa názov súboru s príponou .jpg so všetkými malými písmenami
        $galleryName = ucfirst($name);      // Prvé písmeno názvu obrázku zmeníme na veľké, aby sme v databáze našli rovnaký názov galérie, kam uložíme obrázok

        // Zistenie, či galeria existuje. Ak galeria neexistuje, vráti response 404
        $gallery_exists = DB::select('select name from galleries where path=?', [$galleryName]);

        // Ak sa nenašiel názor
        if ($gallery_exists == null){
            return response()->json('Galéria pre upload sa nenašla', Response::HTTP_NOT_FOUND);
        }


        return response()->json(['uploaded' => ['path' => $path, 'fullpath' => $path, 'name' => $name, 'modified' => '$modified']], Response::HTTP_OK);
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
            return $this->errorNotFound('Galeria neexistuje');
        } else {
            return $this->successDelete('Galéria bola úspešne vymazaná');
        }

        // Tento response pre všeobecnu chybu v exception sa nachádza v app/Exceptions/Handler.php:
        // return response()->json( ['message' => 'Nedefinovaná chyba'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function deleteImage($path){
        $ImageFullPath = $this->renderFullPath($path);

        $image = DB::select('select name from images where path=?', [$ImageFullPath]);

        if ($image == null){
            return $this->errorNotFound('obrázok neexistuje');
        } else {
            $image = Image::where('path', $path);
            $image->delete();
            return $this->successDelete('obrázok bol úspešne vymazaný');
        }
    }

    /**
     * Privatna funkcia, ktora zostaví relativnu URL k obrázku. Aby som mohol najsť obrazok v databaze a vymazať ho
     * @param $path
     * @return string
     */
    private function renderFullPath($path){
        $imagePath = strtolower($path) . '.jpg';
        $galleryPath = $path;
        return $fullPath = $imagePath . $galleryPath;
    }
}
