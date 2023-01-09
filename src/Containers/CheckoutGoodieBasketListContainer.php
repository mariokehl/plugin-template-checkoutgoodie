<?php

namespace CheckoutGoodie\Containers;

use CheckoutGoodie\Helpers\GoodieHelper;
use CheckoutGoodie\Helpers\TierListHelper;
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
        /** @var GoodieHelper $goodieHelper */
        $goodieHelper = pluginApp(GoodieHelper::class);
        if (!$goodieHelper->shouldRender()) return '';

        /** @var TierListHelper $tierListHelper */
        $tierListHelper = pluginApp(TierListHelper::class);
        $tierList = $tierListHelper->getAll();

        return $twig->render('CheckoutGoodie::content.Components.MyBasketList', [
            'hidden' => $goodieHelper->isExcludedByShippingCountryId(),
            'tierList' => $tierList
        ]);
    }
}
