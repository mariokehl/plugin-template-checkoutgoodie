<?php

namespace CheckoutGoodie\Controllers;

use Plenty\Modules\Basket\Contracts\BasketRepositoryContract;
use Plenty\Modules\Basket\Models\Basket;
use Plenty\Modules\Basket\Models\BasketItem;
use Plenty\Modules\Webshop\Contracts\SessionStorageRepositoryContract;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Log\Loggable;
use Plenty\Plugin\Http\Request;

/**
 * Class CheckoutGoodieController
 * 
 * @package CheckoutGoodie\Controllers
 */
class CheckoutGoodieController extends Controller
{
    use Loggable;

    /**
     * @param Request $request
     * @param BasketRepositoryContract $basketRepo
     * @param SessionStorageRepositoryContract $sessionRepo
     * @param ConfigRepository $configRepo
     * @return string
     */
    public function getBasketValue(
        Request $request,
        BasketRepositoryContract $basketRepo,
        SessionStorageRepositoryContract $sessionRepo,
        ConfigRepository $configRepo
    ): string {

        /** @var Basket $basket */
        $basket = $basketRepo->load();
        $actualItemSum = $basket->itemSum ? ($basket->itemSum + $basket->couponDiscount) : 0;
        $filteredItemSum = 0;
        $this->getLogger(__METHOD__)->debug('CheckoutGoodie::Debug.BasketItems', ['basketItems' => $basket->basketItems]);

        $filterCatergory = intval($configRepo->get('CheckoutGoodie.global.categoryFilter', ''));
        if ($filterCatergory) {
            /** @var BasketItem $basketItem */
            foreach ($basket->basketItems as $basketItem) {
                if ($basketItem->categoryId === $filterCatergory) {
                    $filteredItemSum += ($basketItem->quantity * $basketItem->price);
                }
            }
            return json_encode(['basketValue' => $filteredItemSum, 'filtered' => true]);
        }

        return json_encode(['basketValue' => $actualItemSum]);
    }
}
