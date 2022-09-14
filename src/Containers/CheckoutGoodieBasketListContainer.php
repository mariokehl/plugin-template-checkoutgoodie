<?php

namespace CheckoutGoodie\Containers;

use CheckoutGoodie\Helpers\SubscriptionInfoHelper;
use Plenty\Modules\Item\Variation\Contracts\VariationRepositoryContract;
use Plenty\Modules\Item\Variation\Models\Variation;
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
        /** @var SubscriptionInfoHelper $subscription */
        $subscription = pluginApp(SubscriptionInfoHelper::class);
        if (!$subscription->isPaid()) {
            return '';
        }

        /** @var ConfigRepository $configRepo */
        $configRepo = pluginApp(ConfigRepository::class);

        /** @var VariationRepositoryContract $variationRepo */
        $variationRepo = pluginApp(VariationRepositoryContract::class);

        /** @var Variation $variation */
        $variation = $variationRepo->findById($configRepo->get('CheckoutGoodie.global.variantId'));
        $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Plenty.Variation', ['variation' => $variation]);

        // The amount to reach
        $minimumGrossValue = $configRepo->get('CheckoutGoodie.global.grossValue', 50);

        return $twig->render('CheckoutGoodie::content.Components.MyBasketList', [
            'variationName'  => $variation->name,
            'variationImage' => $this->getPreviewImageUrl($variation),
            'grossValue'     => $minimumGrossValue
        ]);
    }

    /**
     * @param Variation $variation
     * @return string
     */
    private function getPreviewImageUrl(Variation $variation): string
    {
        $images = $variation->images;
        if (count($images) === 0) {
            return 'https://dummyimage.com/150x150/000/fff';
        }
        if (count($images) === 1) {
            return $images[0]['urlPreview'];
        }
        return '';
    }
}
