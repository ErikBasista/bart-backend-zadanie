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
     * Response pre úspešne vymazanie galerie / obrazku
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successDelete($message, $code = Response::HTTP_OK){
        return response()->json(['message' => $message], $code);
    }

    /**
     * Response pre vypis chyby o nenajdenej galerii / obrazku
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorNotFound($message, $code = Response::HTTP_NOT_FOUND){
        return response()->json(['chyba' => $message], $code);
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
