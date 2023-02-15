<?php

namespace CheckoutGoodie\Helpers;

use Plenty\Modules\PlentyMarketplace\Contracts\SubscriptionInformationServiceContract;
use Plenty\Modules\PlentyMarketplace\Models\SubscriptionOrderInformation;
use Plenty\Plugin\Application;
use Plenty\Plugin\Log\Loggable;

/**
 * Class SubscriptionInfoHelper
 * 
 * @package CheckoutGoodie\Helpers
 */
class SubscriptionInfoHelper
{
    use Loggable;

    /**
     * @return boolean
     */
    public function isPaid(): bool
    {
        /** @var SubscriptionInformationServiceContract $subscriptionInfoService */
        $subscriptionInfoService = pluginApp(SubscriptionInformationServiceContract::class);

        /** @var SubscriptionOrderInformation $subscriptionInfo */
        $subscriptionInfo = $subscriptionInfoService->getSubscriptionInfo('CheckoutGoodie');
        $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Debug.Subscription', ['subscriptionInfo' => $subscriptionInfo]);

        // Exception for my development system
        $pid = $this->plentyID();
        if ($pid === 58289) {
            $this->getLogger(__METHOD__)->info('CheckoutGoodie::Debug.SubscriptionDev');
            return true;
        }

        // Check if user has paid and show warning in log if he hasn't
        $isPaid = $subscriptionInfoService->isPaid('CheckoutGoodie');
        if (!$isPaid) {
            $this->getLogger(__METHOD__)->warning('CheckoutGoodie::Debug.Subscription', ['isPaid' => false]);
        }

        return $isPaid;
    }

    /**
     * @return integer
     */
    public function plentyID(): int
    {
        /** @var Application $application */
        $application = pluginApp(Application::class);

        return $application->getPlentyId();
    }
}
