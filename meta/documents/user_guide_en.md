# Product Information

With this plugin, you enable your customers to receive a free goodie from a certain shopping cart value, which is automatically placed in the shopping cart and also displayed there. The free goodie can be created as a variant and assigned from a shopping cart value (gross).

## Features

<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Easy setup<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Display of free goodies in the shopping cart (preview) and checkout<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Several free goodies depending on a price scale are also possible<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Visualization of the threshold until the next free goodie is reached<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Individual and localizable texts for missing and success<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Appearance of the progress bar can be customized<br> 
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Vouchers are taken into account in the calculation<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Hide display for delivery countries without goodies

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
2. Associate the **Display Goodie after Basket List** content with the **Ceres::Script.AfterScriptsLoaded** container
3. Associate the **Display Progress Bar to reach Goodie** content with the **Ceres::Basket.BeforeBasketTotals** container for display in the shopping cart (_Shopping cart: Before basket totals_)
4. Associate the **Display Progress Bar to reach Goodie (Shopping Cart Preview)** content with the **Ceres::BasketPreview.BeforeBasketTotals** container for display in the shopping cart preview(_Shopping cart preview: Before basket totals_)
5. Associate the **Display Progress Bar to reach Goodie (Checkout)** content with the **Ceres::Checkout.BeforeBasketTotals** container for display in the checkout (_Checkout: Before basket totals_)

### Tiers / Multiple Goodies

Grading according to prices and corresponding free gifts is now also possible. Below is a simple example:
 
    50 Euro   = Product A
    100 Euro  = Product A + Product B
    200 Euro  = Product A + Product B + Product C

To do this, store the corresponding goods values ​​and variant IDs in the optional areas **Tier 1** and **Tier 2** in the plugin configuration. If you only want to offer two tiers, you can simply leave the input fields for **Tier 2** empty. You can find an example configuration for the maximum specification in the plugin preview images.

<div class="alert alert-info" role="alert">
    Don't forget to adjust the filters of your event action for adding the goodie(s) to the desired values ​​as well!
</div>

### Exclude shipping countries without goodies

If you do not offer any free gifts in one or more delivery countries, you can exclude them via the plugin configuration and thus prevent the output.

To do this, open the plugin configuration and enter a comma-separated list of prohibited delivery countries in the **General** area in the **Excluded shipping countries** field, e.g. _3,12_ for Belgium and the United Kingdom.

    1=Germany
    2=Austria
    ...
    
A complete list of all delivery country IDs can be found under **Setup » Orders » Shipping » Settings** in the **Shipping Countries** tab.

<div class="alert alert-info" role="alert">
    Don't forget to adjust the filters of your event action for adding the goodie(s) to the desired values ​​as well!
</div>

### Customization

In the **CMS » Multilingualism** menu, you can customize the texts below the progress bar. **Save** after customization and don't forget to press **Publish**.

| Key                                | Description   |
|------------------------------------|---------------|
| MessageMissing | Text if the shopping cart value is not reached, the following placeholders are available: `:amount` for the missing amount and `:currency` for the currency. |
| MessageGoal | Text when the shopping cart value is reached, i.e. as soon as the free goodie is added |
| MessageInterim | Text until the next free gift(s) is reached, only relevant for tiers |
| MessageAdditional | Text placeholders to explain your promotion or freebie terms and conditions |

Table 1: Configuration options customization

The appearance of the progress bar can be customized in the **Individualization** area in the **Plugin configuration**.

| Setting                            | Description   |
|------------------------------------|---------------|
| CSS class for missing | This bootstrap class will get your progress bar and text as the background color until the freebie is added.<br>Choose Custom to override this with your theme. |
| CSS class for goal | This bootstrap class will get your progress bar and text as the background color once the freebie is added.<br>Choose Custom to override this with your theme. |
| Increase text padding | Allows to increase the distance from text to progress bar. |
| Progress bar striped | Adds the .progress-bar-striped bootstrap class to the progress bar |
| Thumbnails below the progress bar | Should thumbnails of the free gift(s) be displayed as additional information? |

Table 2: Plugin configuration Individualization

### Set up event procedure

The **[Manual](https://knowledge.plentymarkets.com/en-gb/manual/main/item/give-aways.html)** describes how to automatically attach the free goodie after the order creation.

<div class="alert alert-warning" role="alert">
  Make sure that you set up identical values ​​for the plugin and the event procedure in terms of variant ID and cart value!
</div>


<sub><sup>Every single purchase helps with constant further development and the implementation of user requests. Thanks very much!</sup></sub>