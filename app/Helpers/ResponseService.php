<?php
/**
 * Created by PhpStorm.
 * User: Fuji_account
 * Date: 21/06/2019
 * Time: 09:59
 */

namespace Helper;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class ResponseService
{
    public static function responseJson($code = 200, $data = null, $message = null, $messageContent = null)
    {
        $return = [];
        $return['code'] = $code;
        if ($message) $return['message'] = $message;
        if ($messageContent) $return['message_content'] = $messageContent;
        $return['data'] = $data;
        return response()->json($return);
    }

    public static function responseJsonError($code = null, $message = null, $messageContent = null, $internalMessage = null, $dataError = null)
    {
        return response()->json([
            'code' => ($code && $code > 0) ? $code : Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $message ?? trans('errors.something_error'),
            'message_content' => $messageContent,
            'message_internal' => !in_array(env('APP_ENV'), ['production', 'product']) ? $internalMessage : null,
            'data_error' => $dataError
        ]);
    }

    public static function responsePaginate($result, LengthAwarePaginator $resource)
    {
        return [
            'result' => $result,
            'pagination' => [
                'display' => (int)$resource->count(),
                'total_records' => (int)$resource->total(),
                'per_page' => (int)$resource->perPage(),
                'current_page' => (int)$resource->currentPage(),
                'total_pages' => (int)$resource->lastPage(),
            ],
        ];
    }
}
