<?php

namespace CheckoutGoodie\Containers;

use Plenty\Plugin\Templates\Twig;

/**
 * @package CheckoutGoodie\Containers
 */
class CheckoutGoodieStyleContainer
{
    public function call(Twig $twig): string
    {
        return $twig->render('CheckoutGoodie::content.Containers.Template.Style');
    }
}
