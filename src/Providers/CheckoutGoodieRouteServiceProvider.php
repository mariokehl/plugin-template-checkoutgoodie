<?php

namespace CheckoutGoodie\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

/**
 * Class CheckoutGoodieRouteServiceProvider
 * 
 * @package CheckoutGoodie\Providers
 */
class CheckoutGoodieRouteServiceProvider extends RouteServiceProvider
{
    /**
     * @param Router $router
     */
    public function map(Router $router)
    {
        $router->get('plugin/checkout-goodie/basket-value','CheckoutGoodie\Controllers\CheckoutGoodieController@getBasketValue');
    }
}