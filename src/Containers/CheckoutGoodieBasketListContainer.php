<?php

namespace CheckoutGoodie\Containers;

use CheckoutGoodie\Helpers\SubscriptionInfoHelper;
use CheckoutGoodie\Helpers\TierListHelper;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;
use Plenty\Plugin\Templates\Twig;

/**
 * @package CheckoutGoodie\Containers
 */
class CheckoutGoodieBasketListContainer
{
    use Loggable;

    /**
     * Renders the template.
     * 
     * @param Twig $twig The twig instance
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function call(Twig $twig): string
    {
        /** @var ConfigRepository $configRepo */
        $configRepo = pluginApp(ConfigRepository::class);

        // Is output active in plugin config?
        $shouldRender = $configRepo->get('CheckoutGoodie.global.active', 'true');

        /** @var SubscriptionInfoHelper $subscription */
        $subscription = pluginApp(SubscriptionInfoHelper::class);
        if (!$subscription->isPaid() || $shouldRender === 'false') {
            return '';
        }

        /** @var TierListHelper $tierListHelper */
        $tierListHelper = pluginApp(TierListHelper::class);
        $tierList = $tierListHelper->getAll();

        return $twig->render('CheckoutGoodie::content.Components.MyBasketList', ['tierList' => $tierList]);
    }
}
