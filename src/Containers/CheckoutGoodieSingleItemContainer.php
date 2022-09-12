<?php

namespace CheckoutGoodie\Containers;

use Ceres\Config\CeresConfig;
use Plenty\Plugin\Templates\Twig;

/**
 * @package CheckoutGoodie\Containers
 */
class CheckoutGoodieSingleItemContainer
{
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
        return $twig->render('CheckoutGoodie::content.Components.MyBasketList');
    }
}
