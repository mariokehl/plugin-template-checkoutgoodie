# Product Information

With this plugin, you enable your customers to receive a free goodie from a certain shopping cart value, which is automatically placed in the shopping cart and also displayed there. The free goodie can be created as a variant and assigned from a shopping cart value (gross).

## Installation Guide

To display the free goodie, you must enter the appropriate values ​​in the plugin configuration.

1. Open the **Plugins » Plugin set overview** menu.
2. Select the desired plugin set.
3. Click on **Show free goodie in shopping cart**.<br>→ A new view opens.
4. Select the **Global** section from the list.
5. Enter your desired _goods value (gross)_ and the _variant ID_.
6. Check the **Active** checkbox to display the goodie
7. **Save** the settings.

<div class="alert alert-info" role="alert">
    Make sure that the variant to be linked has a variant name and an image link.
    Otherwise, your goodie will be given out with dummy values!
</div>

Note: Use the **Active** checkbox to temporarily turn off plugin output without changing container bindings or deactivating the plugin in the plugin set.

Then create the container links so that the free goodie is also displayed in the shopping cart of your plentyShop:

1. Change to the submenu **Container links**.
2. Associate the **Display goodie after basket list** content with the **Ceres::Script.AfterScriptsLoaded** container
3. Associate the **Display progress bar to reach goodie** content with the **Ceres::Basket.BeforeBasketTotals** container for display in the shopping cart
4. Associate the **Display progress bar to reach goodie** content with the **Ceres::BasketPreview.BeforeBasketTotals** container for display in the shopping cart preview
5. Associate the **Display progress bar to reach goodie** content with the **Ceres::Checkout.BeforeBasketTotals** container for display in the checkout

### Customization

| Setting                            | Description |
|------------------------------------|---------------|
| Message value of goods not reached | Text if the shopping cart value is not reached, the following placeholders are available: `:amount` for the missing amount and `:currency` for the currency. |
| Message Goods value reached        | Text when the shopping cart value is reached, i.e. as soon as the free goodie is added |

Tabelle 1: Configuration options customization

### Set up event procedure

The **[Manual](https://knowledge.plentymarkets.com/en-gb/manual/main/item/give-aways.html)** describes how to automatically attach the free goodie after the order creation.

<div class="alert alert-warning" role="alert">
  Make sure that you set up identical values ​​for the plugin and the event procedure in terms of variant ID and cart value!
</div>


<sub><sup>Every single purchase helps with constant further development and the implementation of user requests. Thanks very much!</sup></sub>