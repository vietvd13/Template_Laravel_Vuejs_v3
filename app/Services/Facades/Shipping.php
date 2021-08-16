<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Date: 11/26/2020
 * Time: 09:58
 */

namespace App\Services\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Services\Contracts\ShippingSystem driver(string $name = null)
 * @method static \App\Services\Contracts\ShippingSystem setApiKey(string $apiKey)
 *
 * @see \App\Services\ShippingManager
 */
class Shipping extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shipping';
    }
}