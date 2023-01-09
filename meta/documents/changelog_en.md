# Release Notes for "Show free goodie in shopping cart"

## v1.1.0 (2023-01-09)

### Added
- Multiple free goodies can be scaled, e.g. 50 euros = product A, 100 euros = product A + product B, ... You can use up to 3 tiers
- You now have the option of excluding individual shipping countries from goodies via the plugin configuration and thus hiding the progress bar
- The appearance of the progress bar now allows a variety of customizations: CSS class(es) for missing and success (determines the background color of the texts and the progress bar), if necessary striped progress bar, preview images + tool tip of the goodies
- A text placeholder for a link or explanation has been added below the progress bar

## v1.0.6 (2022-11-17)

### Changed
- The messages of the progress bar have been moved to the **CMS » Multilingualism** menu so that they can be translated. Furthermore, you can now use emojis or HTML code there

### TODO
- Customize the translations for the **Individualization** section of the CheckoutGoodie plugin in the **CMS » Multilingualism** menu

## v1.0.5 (2022-11-07)

### Fixed
- Voucher codes were not correctly taken into account in the goods value (gross). This could result in the freebie being displayed in the frontend but not being added to the order by the event procedure

## v1.0.4 (2022-10-25)

### Fixed
- German umlauts in the stored messages of the plugin configuration could not be displayed correctly
- The progress bar was not updated when the shopping cart preview was opened for the first time

## v1.0.3 (2022-10-17)

### Changed
- The installation instructions for the container links have been extended based on user feedback

## v1.0.2 (2022-10-05)

### Changed
- Updated plugin thumbnails regarding plugin configuration and fixed release notes for last version

## v1.0.1 (2022-09-30)

### Added
- New checkbox **Active** in the plugin configuration for controlling the output
- The messages above the progress bar are now also customizable in the configuration under **Individualization**

### TODO
- Check the plugin configuration and set the **Active** switch to enable goodie output

## v1.0.0 (2022-09-14)

### Added
- Initial release
