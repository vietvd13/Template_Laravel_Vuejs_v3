<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Date: 11/24/2020
 * Time: 15:47
 */

namespace App\Services;


use App\Services\Contracts\ShippingSystem;

class ShippingAdapter implements ShippingSystem
{

    /**
     * The Shipping system implementation.
     *
     * @var ShippingSystem
     */
    protected $driver;

    /**
     * Create a new filesystem adapter instance.
     *
     * @param  ShippingSystem  $driver
     * @return void
     */
    public function __construct(ShippingSystem $driver)
    {
        $this->driver = $driver;
    }

    public function createStore($params)
    {
        return $this->driver->createStore($params);
    }

    public function getStores($params = null)
    {
        return $this->driver->getStores($params);
    }

    /**
     * @param null $url
     * @return mixed
     */
    public function setApiUrl($url = null)
    {
        // TODO: Implement setApiUrl() method.
    }

    public function doRequest($method, $endPoint, $params)
    {
        // TODO: Implement doRequest() method.
    }

    public function setApiKey($apiKey)
    {
        if(method_exists($this->driver, 'setApiKey')) {
            $this->driver->setApiKey($apiKey);
        }
        return $this;
    }
}