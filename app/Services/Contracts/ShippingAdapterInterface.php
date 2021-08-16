<?php
/**
 * Created by PhpStorm.
 * User: TanTan
 * Date: 11/26/2020
 * Time: 10:45
 */

namespace App\Services\Contracts;


interface ShippingAdapterInterface
{
    /**
     * @return mixed
     */
    public function setApiUrl();

    /**
     * @param $method
     * @param $endPoint
     * @param $params
     * @return mixed
     */
    public function doRequest($method, $endPoint, $params);

}