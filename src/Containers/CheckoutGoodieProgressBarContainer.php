<?php

namespace CheckoutGoodie\Containers;

use Plenty\Modules\Basket\Contracts\BasketRepositoryContract;
use Plenty\Modules\Basket\Models\Basket;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\Translation\Translator;

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
        /** @var ConfigRepository $configRepo */
        $configRepo = pluginApp(ConfigRepository::class);

        // The amount to reach
        $minimumGrossValue = $configRepo->get('CheckoutGoodie.global.grossValue', 50);

        // Current goal amount
        $currAmount = 0;

        // The initial percentage to reach goodie (later on we will rely on afterBasketChanged event)
        $percentage = 0;

        /** @var BasketRepositoryContract $basketRepo */
        $basketRepo = pluginApp(BasketRepositoryContract::class);
 
        /** @var Basket $basket */
        $basket = $basketRepo->load();

        if ($basket && $basket instanceof Basket) {
            $currAmount = ($minimumGrossValue - $basket->itemSum);
            $percentage = ($basket->itemSum / $minimumGrossValue) * 100;
            $percentage = round($percentage);
            $percentage = ($percentage > 100) ? 100 : $percentage;
        }

        // The currency
        $currency = $basket->currency ?? 'EUR';

        // The messages
        $messages = $this->getMessageTemplates();
        $label = '';
        if ($percentage === 100) {
            $label = $messages['goal'];
        } else {
            $label = $this->getMessageTemplates(number_format($currAmount, 2, ',', ''), $currency)['missing'];
        }

        return $twig->render('CheckoutGoodie::content.Containers.ProgressBar', [
            'grossValue' => $minimumGrossValue,
            'itemSum'    => $basket->itemSum ?? 0,
            'label'      => $label,
            'percentage' => $percentage,
            'width'      => 'width: ' . number_format($percentage, 0, '', '') . '%',
            'messages'   => $messages,
            'currency'   => $currency
        ]);
    }

     /**
      * @param string $amount
      * @param string $currency
      * @return array
      */
    private function getMessageTemplates(string $amount = '', string $currency = ''): array
    {
        /** @var Translator $translator */
        $translator = pluginApp(Translator::class);

        $messages = [];
        $messages['goal'] = $translator->trans('CheckoutGoodie::Frontend.MessageGoal');
        if (strlen($amount) && strlen($currency)) {
            $messages['missing'] = $translator->trans('CheckoutGoodie::Frontend.MessageMissing', ['amount' => $amount, 'currency' => $currency]);
        } else {
            $messages['missing'] = $translator->trans('CheckoutGoodie::Frontend.MessageMissing');
        }

        return $messages;
    }
}
