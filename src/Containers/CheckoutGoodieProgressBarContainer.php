<?php

namespace CheckoutGoodie\Containers;

use Plenty\Plugin\Templates\Twig;

/**
 * @package CheckoutGoodie\Containers
 */
class CheckoutGoodieProgressBarContainer
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
        //TODO Warenkorb wert holen und status berechnen
        return $twig->render('CheckoutGoodie::content.Containers.ProgressBar');
    }
}
