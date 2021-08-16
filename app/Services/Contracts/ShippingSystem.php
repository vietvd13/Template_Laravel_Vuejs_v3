<?php
/**
 * Created by PhpStorm.
 * User: TanTan
 * Date: 11/24/2020
 * Time: 15:59
 */

namespace App\Services\Contracts;


interface ShippingSystem
{
    /**
     * @param $params
     */
    public function createStore($params);

    /**
     * @param $params
     */
    public function getStores($params);
}