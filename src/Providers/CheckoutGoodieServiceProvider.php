<?php

namespace CheckoutGoodie\Providers;

use IO\Helper\TemplateContainer;
use IO\Helper\ResourceContainer;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;

/**
 * Class CheckoutGoodieServiceProvider
 * 
 * @package CheckoutGoodie\Providers
 */
class CheckoutGoodieServiceProvider extends ServiceProvider
{
    /**
     * The priority of the template (any number less than 100 will indicate a higher priority)
     */
    const PRIORITY = 0;

    /**
     * Register the service provider.
     */
    public function register()
    {
    }

    /**
     * Boot a template for the basket list that will be displayed in the template plugin instead of the original.
     *
     * @param Twig $twig
     * @param Dispatcher $eventDispatcher
     * @return void
     */
    public function boot(Twig $twig, Dispatcher $eventDispatcher)
    {
        $eventDispatcher->listen('IO.Resources.Import', function (ResourceContainer $container) {
            $container->addScriptTemplate('CheckoutGoodie::content.Components.MyBasketList');
        }, self::PRIORITY);
    }
}
