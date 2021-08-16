<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Date: 11/24/2020
 * Time: 15:48
 */

namespace App\Services;

use App\Services\Contracts\ShippingAdapterInterface;
use App\Services\Contracts\ShippingFactory;
use App\Services\Contracts\ShippingSystem;
use App\Services\Shipping\GhnAdapter;
use InvalidArgumentException;

class ShippingManager implements ShippingFactory
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The array of resolved shipping system drivers.
     *
     * @var Contracts\ShippingSystem
     */
    protected $driver = null;

    /**
     * Create a new filesystem manager instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param null|string $name
     * @return Contracts\ShippingSystem
     */
    public function driver($name = null)
    {
        $this->driver = $this->resolve($name);
        return $this->driver;
    }

    /**
     * Resolve the given disk.
     *
     * @param  string $name
     * @return ShippingSystem
     */
    protected function resolve($name)
    {
        $driverMethod = 'create' . ucfirst($name) . 'Driver';

        if (method_exists($this, $driverMethod)) {
            return $this->{$driverMethod}();
        } else {
            throw new InvalidArgumentException("Driver [{$name}] is not supported.");
        }
    }

    /**
     * Create an instance of the GiaoHangNhanh driver.
     *
     * @param string $apiKey
     * @return ShippingAdapter
     */
    public function createGhnDriver(string $apiKey = null)
    {
        return $this->adapt(new GhnAdapter($apiKey));
    }

    /**
     * Adapt the filesystem implementation.
     *
     * @param ShippingSystem $shippingSystem
     * @return ShippingAdapter
     */
    protected function adapt(ShippingSystem $shippingSystem)
    {
        return new ShippingAdapter($shippingSystem);
    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->driver($this->driver)->$method(...$parameters);
    }

}