<?php

namespace App\Http\Controllers;

use Helper\ResponseService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OpenApi\Annotations\Swagger(
 *     schemes={"http","https"},
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Veho StandardDevFrameWork API v1",
 *     )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param int|null $code
     * @param null $data
     * @param null $message
     * @param null $internalMessage
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseJson(int $code = null, $data = null, $message = null, $internalMessage = null)
    {
        return ResponseService::responseJson($code, $data, $message, $internalMessage);
    }

    /**
     * @param int|null $code
     * @param null $message
     * @param null $internalMessage
     * @param null $dataError
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseJsonError(int $code = null, $message = null, $internalMessage = null, $dataError = null)
    {
        return ResponseService::responseJsonError($code, $message, $internalMessage, $dataError);
    }
}
