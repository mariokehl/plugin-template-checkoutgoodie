# Product Information

With this plugin, you enable your customers to receive a free goodie from a certain shopping cart value, which is automatically placed in the shopping cart and also displayed there. The free goodie can be created as a variant and assigned from a shopping cart value (gross).

## Installation Guide

To display the free goodie, you must enter the appropriate values ​​in the plugin configuration.

1. Open the **Plugins » Plugin set overview** menu.
2. Select the desired plugin set.
3. Click on **Show free goodie in shopping cart**.<br>→ A new view opens.
4. Select the **Global** section from the list.
5. Enter your desired goods value (gross) and the variant ID.
6. **Save** the settings.

Then create the container links so that the free goodie is also displayed in the shopping cart of your plentyShop:

1. Change to the submenu **Container links**.
2. Associate the **Display goodie after basket list** content with the **Ceres::Script.AfterScriptsLoaded** container
3. Associate the **Display progress bar to reach goodie** content with the **Ceres::Basket.BeforeBasketTotals** container for display in the shopping cart
4. Associate the **Display progress bar to reach goodie** content with the **Ceres::BasketPreview.BeforeBasketTotals** container for display in the shopping cart preview
5. Associate the **Display progress bar to reach goodie** content with the **Ceres::Checkout.BeforeBasketTotals** container for display in the checkout

### Set up event procedure

The **[Manual](https://knowledge.plentymarkets.com/en-gb/manual/main/item/give-aways.html)** describes how to automatically attach the free goodie after the order creation.

<div class="alert alert-warning" role="alert">
  Make sure that you set up identical values ​​for the plugin and the event procedure in terms of variant ID and cart value!
</div>


<sub><sup>Every single purchase helps with constant further development and the implementation of user requests. Thanks very much!</sup></sub>