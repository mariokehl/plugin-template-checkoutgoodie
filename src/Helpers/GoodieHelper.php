<?php

namespace CheckoutGoodie\Helpers;

use Plenty\Modules\Basket\Contracts\BasketRepositoryContract;
use Plenty\Modules\Basket\Models\Basket;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;

/**
 * Class GoodieHelper
 * 
 * @package CheckoutGoodie\Helpers
 */
class GoodieHelper
{
    use Loggable;

    /**
     * @var ConfigRepository
     */
    private ConfigRepository $configRepo;

    /**
     * @param ConfigRepository $configRepo
     */
    public function __construct(ConfigRepository $configRepo)
    {
        $this->configRepo = $configRepo;
    }

    /**
     * @return boolean
     */
    public function shouldRender(): bool
    {
        // Is output active in plugin config?
        $shouldRender = $this->configRepo->get('CheckoutGoodie.global.active', 'true');

        /** @var SubscriptionInfoHelper $subscription */
        $subscription = pluginApp(SubscriptionInfoHelper::class);
        if (!$subscription->isPaid() || $shouldRender === 'false') {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return array
     */
    public function getExcludedShippingCountries(): array
    {
        /** @var ConfigRepository $configRepo */
        $configRepo = pluginApp(ConfigRepository::class);

        // Excluded shipping countries
        $excludedShippingCountriesAsString = $configRepo->get('CheckoutGoodie.global.excludedShippingCountries', '');
        $excludedShippingCountries = array_map('intval', explode(',', $excludedShippingCountriesAsString));

        return $excludedShippingCountries;
    }

    /**
     * @return boolean
     */
    public function isExcludedByShippingCountryId(): bool
    {
        /** @var BasketRepositoryContract $basketRepo */
        $basketRepo = pluginApp(BasketRepositoryContract::class);

        /** @var Basket $basket */
        $basket = $basketRepo->load();

        return in_array($basket->shippingCountryId, $this->getExcludedShippingCountries());
    }
}
