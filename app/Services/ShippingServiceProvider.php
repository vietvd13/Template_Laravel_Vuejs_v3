<?php
/**
 * Created by PhpStorm.
 * User: TanTan
 * Date: 11/24/2020
 * Time: 15:51
 */

namespace App\Services;


use Illuminate\Support\ServiceProvider;

class ShippingServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerManager();

        $this->app->singleton('shipping.driver', function ($app) {
            return $app['shipping']->driver($this->getDefaultDriver());
        });
    }

    /**
     * Register the filesystem manager.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('shipping', function ($app) {
            return new ShippingManager($app);
        });
    }

    /**
     * Get the default file driver.
     *
     * @return string
     */
    protected function getDefaultDriver()
    {
        return $this->app['config']['shipping.default'];
    }
}