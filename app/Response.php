<?php


namespace App;


use Illuminate\Http\JsonResponse;

class Response
{
    /**
     * @param $obj
     * @return JsonResponse
     */
    public static function create($obj): JsonResponse
    {
        $key = $obj instanceof Error ? "error" : "response";
        $statusCode = $obj instanceof Error && $obj->getCode() == 404 ? 404 : 200;
        return response()->json([$key => $obj], $statusCode, [], JSON_UNESCAPED_SLASHES);
    }

}
