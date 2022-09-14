<?php

namespace CheckoutGoodie\Containers;

use CheckoutGoodie\Helpers\SubscriptionInfoHelper;
use Plenty\Modules\Basket\Contracts\BasketRepositoryContract;
use Plenty\Modules\Basket\Models\Basket;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;
use Plenty\Plugin\Templates\Twig;
use Plenty\Plugin\Translation\Translator;

/**
 * @package CheckoutGoodie\Containers
 */
class CheckoutGoodieProgressBarContainer
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
        /** @var SubscriptionInfoHelper $subscription */
        $subscription = pluginApp(SubscriptionInfoHelper::class);
        if (!$subscription->isPaid()) {
            return '';
        }

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
            $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Plenty.Basket', ['basket' => $basket]);
            $percentage = ($basket->itemSum / $minimumGrossValue) * 100;
            $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Frontend.Percentage', ['percentage' => $percentage]);
            $percentage = floor($percentage);
            $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Frontend.Percentage', ['percentage' => $percentage]);
            $percentage = ($percentage > 100) ? 100 : $percentage;
            $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Frontend.Percentage', ['percentage' => $percentage]);
        }

        // The currency
        $currency = $basket->currency ?? 'EUR';

        // The messages
        $messages = $this->getMessageTemplates();
        $label = '';
        if ($percentage < 100) {
            $label = $this->getMessageTemplates(number_format($currAmount, 2, ',', ''), $currency)['missing'];
            $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Frontend.ProgressText', ['label' => $label, 'percentageLower' => true]);
        } else {
            $label = $messages['goal'];
            $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Frontend.ProgressText', ['label' => $label]);
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
