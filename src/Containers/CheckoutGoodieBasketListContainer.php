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
     * @var VariationRepositoryContract
     */
    private VariationRepositoryContract $variationRepo;

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

        /** @var VariationRepositoryContract $variationRepo */
        $this->variationRepo = pluginApp(VariationRepositoryContract::class);

        // Setup the tiers
        $tierList = [];

        // Tier 0 (default)
        $tierList[] = [
            'variations' => $this->assignVariants($configRepo->get('CheckoutGoodie.global.variantId', '')),
            'grossValue' => $configRepo->get('CheckoutGoodie.global.grossValue', 50)
        ];

        // Tier 1
        if (
            $configRepo->get('CheckoutGoodie.global.tier1.grossValue', 0) &&
            $configRepo->get('CheckoutGoodie.global.tier1.variantId')
        ) {
            $tierList[] = [
                'variations' => $this->assignVariants($configRepo->get('CheckoutGoodie.global.tier1.variantId', '')),
                'grossValue' => $configRepo->get('CheckoutGoodie.global.tier1.grossValue', 0)
            ];
        } else {
            $tierList[] = ['grossValue' => false];
        }

        // Tier 2
        if (
            $configRepo->get('CheckoutGoodie.global.tier2.grossValue', 0) &&
            $configRepo->get('CheckoutGoodie.global.tier2.variantId')
        ) {
            $tierList[] = [
                'variations' => $this->assignVariants($configRepo->get('CheckoutGoodie.global.tier2.variantId', '')),
                'grossValue' => $configRepo->get('CheckoutGoodie.global.tier2.grossValue', 0)
            ];
        } else {
            $tierList[] = ['grossValue' => false];
        }
        $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Debug.TierList', ['tierList' => $tierList]);

        return $twig->render('CheckoutGoodie::content.Components.MyBasketList', ['tierList' => $tierList]);
    }

    /**
     * @param string $variations comma separated list of variant ids
     * @return array
     */
    private function assignVariants(string $variations): array
    {
        $assignments = [];
        foreach (explode(',', $variations) as $variationId) {
            /** @var Variation $variation */
            $variation = $this->variationRepo->findById($variationId);
            $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Debug.Variation', ['variation' => $variation]);
            $assignments[$variation->id] = ['variationName' => $variation->name, 'variationImage' => $this->getPreviewImageUrl($variation)];
        }
        return $assignments;
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
        } else {
            return $images[0]['urlPreview'];
        }
    }
}
