<?php

namespace CheckoutGoodie\Providers;

use CheckoutGoodie\Helpers\SubscriptionInfoHelper;
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
     * Original plentyShop LTS templates have a priority of 100. Any number less than 100 will indicate a higher priority.
     */
    const PRIORITY = 0;

    /**
     * Register the service provider.
     */
    public function register()
    {
    }

    /**
     * Include custom functions for the progress bar in the Footer.twig of plentyShop LTS
     */
    public function boot(Twig $twig, Dispatcher $eventDispatcher)
    {
        /** @var SubscriptionInfoHelper $subscription */
        $subscription = pluginApp(SubscriptionInfoHelper::class);
        if ($subscription->isPaid()) {
            $eventDispatcher->listen('IO.Resources.Import', function (ResourceContainer $container) {
                $container->addScriptTemplate('CheckoutGoodie::content.Containers.Template.Script');
            }, self::PRIORITY);
        }
    }
}
