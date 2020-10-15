<?php


namespace App\Traits;


use Illuminate\Http\Response;

trait ApiResponser
{
    /**
     * Build success response
     * @param  string|array $data
     * @param  int $code
     * @return Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $code = Response::HTTP_OK){
        return response()->json(['galleries' => $data], $code);
    }

    /**
     * Response pre úspešne vymazanie galerie
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successDelete($message, $code = Response::HTTP_OK){
        return response()->json(['message' => 'Galéria bola úspešne vymazaná'], $code);
    }

    /**
     * Response pre pokus o vymazanie galerie s chybou o nenajdení
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function notfoundDelete($message, $code = Response::HTTP_NOT_FOUND){
        return response()->json(['message' => 'Galeria neexistuje'], $code);
    }

    /**
     * Error response
     * @param  string|array $message
     * @param  int $code
     * @return Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code = 500)
    {
        return response()->json(['chyba' => $message, 'code' => $code], $code);
    }
}
