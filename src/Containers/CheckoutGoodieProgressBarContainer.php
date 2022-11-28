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
     * The constants
     */
    const MESSAGE_TEMPLATE_INTERIM = 'interim';
    const MESSAGE_TEMPLATE_MISSING = 'missing';
    const MESSAGE_TEMPLATE_GOAL = 'goal';

    /**
     * Message templates (either default or individualized)
     *
     * @var array
     */
    private $messageTemplates = [
        self::MESSAGE_TEMPLATE_INTERIM => '',
        self::MESSAGE_TEMPLATE_MISSING => '',
        self::MESSAGE_TEMPLATE_GOAL => ''
    ];

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

        // The amounts to reach
        $minValue = floatval($configRepo->get('CheckoutGoodie.global.grossValue', 50));
        $tier1GrossValue = floatval($configRepo->get('CheckoutGoodie.global.tier1.grossValue', 0));
        $tier2GrossValue = floatval($configRepo->get('CheckoutGoodie.global.tier2.grossValue', 0));
        $maxValue = max([$minValue, $tier1GrossValue, $tier2GrossValue]);

        // Current goal amount
        $currAmount = 0;

        // The initial percentage to reach goodie (later on we will rely on afterBasketChanged event)
        $percentage = 0;

        /** @var BasketRepositoryContract $basketRepo */
        $basketRepo = pluginApp(BasketRepositoryContract::class);

        /** @var Basket $basket */
        $basket = $basketRepo->load();
        $actualItemSum = $basket->itemSum ? ($basket->itemSum + $basket->couponDiscount) : 0;

        if ($basket && $basket instanceof Basket) {
            $currAmount = ($maxValue - $actualItemSum);
            $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Debug.Basket', ['basket' => $basket]);
            $percentage = ($actualItemSum / $maxValue) * 100;
            $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Debug.Percentage', ['percentage' => $percentage]);
            $percentage = floor($percentage);
            $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Debug.Percentage', ['percentage' => $percentage]);
            $percentage = ($percentage > 100) ? 100 : $percentage;
            $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Debug.Percentage', ['percentage' => $percentage]);
        }

        // The currency
        $currency = $basket->currency ?? 'EUR';

        // Separators
        $tierList = [];
        $tier1Separator = $tier1GrossValue ? ($minValue * 100) / $maxValue : false;
        if ($tier1Separator) $tierList[] = $minValue;
        $tier2Separator = $tier2GrossValue ? ($tier1GrossValue * 100) / $maxValue : false;
        if ($tier2Separator) $tierList[] = $tier1GrossValue;

        // The messages
        $messages = $this->getMessageTemplates();
        $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Debug.MsgTemplates', ['messages' => $messages]);
        $label = '';
        if ($percentage < 100) {
            if ($tier2Separator) {
                $label = $this->getMessageTemplates(number_format($tierList[1] - $actualItemSum, 2, ',', ''), $currency)[self::MESSAGE_TEMPLATE_INTERIM];
            } elseif ($tier1Separator) {
                $label = $this->getMessageTemplates(number_format($tierList[0] - $actualItemSum, 2, ',', ''), $currency)[self::MESSAGE_TEMPLATE_INTERIM];
            } else {
                $label = $this->getMessageTemplates(number_format($currAmount, 2, ',', ''), $currency)[self::MESSAGE_TEMPLATE_MISSING];
            }
            $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Debug.ProgressText', ['label' => $label, 'percentageLower' => true]);
        } else {
            $label = $messages[self::MESSAGE_TEMPLATE_GOAL];
            $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Debug.ProgressText', ['label' => $label]);
        }

        return $twig->render('CheckoutGoodie::content.Containers.ProgressBar', [
            'tierList'   => $tierList,
            'grossValue' => $maxValue,
            'itemSum'    => $actualItemSum,
            'label'      => $label,
            'percentage' => $percentage,
            'width'      => 'width: ' . number_format($percentage, 0, '', '') . '%',
            'separators' => [
                'tier1' => $tier1Separator ? $tier1Separator . '%' : '',
                'tier2' => $tier2Separator ? $tier2Separator . '%' : '',
            ],
            //'messages'   => $messages,
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

        // Initialize the custom templates
        $this->messageTemplates[self::MESSAGE_TEMPLATE_INTERIM] = $translator->trans('CheckoutGoodie::Template.MessageInterim');
        $this->messageTemplates[self::MESSAGE_TEMPLATE_MISSING] = $translator->trans('CheckoutGoodie::Template.MessageMissing');
        $this->messageTemplates[self::MESSAGE_TEMPLATE_GOAL] = $translator->trans('CheckoutGoodie::Template.MessageGoal');

        // Replace markers
        if (strlen($amount) && strlen($currency)) {
            $this->messageTemplates[self::MESSAGE_TEMPLATE_INTERIM] = str_replace([':amount', ':currency'], [$amount, $currency], $this->messageTemplates[self::MESSAGE_TEMPLATE_INTERIM]);
            $this->messageTemplates[self::MESSAGE_TEMPLATE_MISSING] = str_replace([':amount', ':currency'], [$amount, $currency], $this->messageTemplates[self::MESSAGE_TEMPLATE_MISSING]);
        }

        // Replace german umlauts
        #array_walk_recursive($this->messageTemplates, function (&$value) {
        #    $value = htmlentities($value);
        #});

        return $this->messageTemplates;
    }
}
