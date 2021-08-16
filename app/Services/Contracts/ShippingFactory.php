<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Date: 11/24/2020
 * Time: 15:56
 */

namespace App\Services\Contracts;


interface ShippingFactory
{
    /**
     * Get a filesystem implementation.
     *
     * @param  string|null $name
     * @return ShippingSystem
     */
    public function driver($name = null);
}