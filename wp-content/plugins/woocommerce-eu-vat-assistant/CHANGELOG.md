# Aelia EU VAT Assistant - Change Log

## Version 1.x
####1.1.6.150126
* Extended EU VAT Report to include the totals of sales and shipping charged to each country.

####1.1.5.150120
* Fixed text domain.
* Added Bulgarian translation, courtesy of Ivaylo Ivanov.

####1.1.4.150113
* Fixed notice in `Settings` class.

####1.1.3.150111
* Added support for additional tax rate fields. The fields will allow to identify not only to which country a VAT applies, but also to which country it should be paid.
* Altered `EU VAT by Country report` to display the "country payable" for each tax amount.
* Renamed class `Aelia\WC\EU_VAT_Assistant\WCPDF\EU_Invoice_Price_Formatter` to `EU_Invoice_Helper`.
* Added *Shortcuts* sections in plugin settings page.

####1.1.2.150109
* Fixed minor issues that caused notice messages to be displayed on *EU VAT by Country* report page.

####1.1.1.150107
* Fixed bug in recording of customer's self-certification. Plugin always recorded "yes" even when the customer did not self-certify his location.
* Fixed minor notice messages.

####1.1.0.150106
* Added possibility to disallow sales to specific countries.

####1.0.6.150105
* Removed display of an empty "*VAT #*" entry in customer's address when such information is not available.

####1.0.5.150105
* Improved UI.
* Added `WCPDF\EU_Invoice_Helper::reverse_charge()` method. The method allows to quickly determine if an invoice is based on EU reverse charge rules, and print the related note on the invoice.

####1.0.4.150103
* Fixed minor bug at checkout. The bug caused the wrong country to be used for VAT number validation when tax was setting to use customer's shipping address.
* Improved recording of VAT data against orders. Now basic VAT details, such as the exchange rate to VAT currency, are recorded for all orders, whether VAT was applied or not.
* Improved display of VAT details in `Order Edit` admin page.

####1.0.3.150103
* Extended `Order::get_vat_data()` method to allow retrieval of specific parts of the VAT data.

####1.0.2.150101
* Fixed bug in reports. The bug caused reports for past quarters to appear empty.

####1.0.1.150101
* Added support for the new (and unannounced) exchange rates feed used by HMRC.
* Updated language files.

####1.0.0.141231
* Production ready.

## Version 0.x
####0.10.6.141231
* Fixed JavaScript bug in Admin section.

####0.10.5.141231
* Redacted FAQ.
* Fixed minor bug in `Order::get_vat_data()`.
* Optimised in `Order::get_vat_refunds()`.

####0.10.4.141231
* Fixed import of Danish National Bank exchange rates.
* Updated language files.
* Optimised loading of JavaScript parameters for `Tax Settings` admin pages.

####0.10.3.141231
* Added missing file (Danish National Bank interface was missing from WordPress repository).

####0.10.2.141231
* Rewritten EU VAT by Country report to correctly process VAT refunds.

####0.10.1.141230
* Fixed bug in handling of VAT refunds. Now VAT refunds are calculated on the fly on order edit view page.

####0.10.0.141230
* Added exchange rates provider for [Danish National Bank feed](http://www.nationalbanken.dk/en/statistics/exchange_rates/Pages/default.aspx).
* Added tracking of exchange rates provider against each order.
* Improved validation of VAT rates to be used on `WooCommerce > Tax` settings page.
* Reorganised Admin UI.
* Added possibility to make the `EU VAT Number` field optional, required, required for EU countries or hidden.

####0.9.23.141230
* Improved checks on of VAT validation responses. The new validation logic will prevent issues caused by corrupt cached responses.

####0.9.22.141230
* Updated requirements.

####0.9.21.141229
* Added recording of the timestamp of the VAT currency exchange rate.

####0.9.20.141229
* Fixed bug in handling of VIES response containing non-Latin UTF-8 characters.

####0.9.19.141229
* Added caching of VIES WSDL to speed up VAT validation.

####0.9.18.141229
* Fixed bug in VAT Number validation. The bug caused validation to fail when "odd" characters were returned by VIES service.

####0.9.17.141228
* Fixed bugs in EU VAT by Country report:
	* Fixed incorrect reference to plugin class.
	* Fixed bug in range calculation.

####0.9.16.141228
* Removed unused report.
* Fixed bug in handling of VAT rates for Isle of Man and Monaco.
* Added language files for English (GB).

####0.9.15.141227
* Fixed bug in handling of VAT rates for Isle of Man and Monaco.

####0.9.14.141227
* Added exchange rates provider for [HMRC feed](https://www.gov.uk/government/publications/exchange-rates-for-customs-and-vat-monthly).
* Added VAT rates for Monaco and Isle of Man.

####0.9.13.141226
* Fixed call to `WC_Aelia_EU_VAT_Assistant::get_eu_vat_countries()`.

####0.9.12.141226
* Replaced hard-coded table prefix with dynamic one in `Order::add_tax_rates_details()`.
* Added possibility to specify if shipping country should be used as location evidence.
* Added possibility to customise the self-certification message.
* Added support for Monaco (VAT as France) and Isle of Man (VAT as United Kingdom).

####0.9.11.141224
* Fixed call to auto-update mechanism (the wrong plugin ID was used).

####0.9.10.141224
* Rewritten EU VAT by Country report.
* Fixed several minor warnings.
* Added call to auto-update mechanism.

####0.9.9.141223
* Added logic to save tax details (rate and label) with the VAT data associated to an order.
* `Order` class now saves the tax rate and the tax country with the VAT data.
* Reorganised reports:
	* Divided reports in WC2.1 and WC2.2 namespaces.
	* Restructured report class to promote code reuse.
	* Updated EU VAT report to include "processing" orders.
* Added support for shipping tax refunds.
* Rewritten code to calculate and save tax subtotals against the orders.

####0.9.8.141222
* Added logic to fix incorrect country codes in the VAT Rates feed.

####0.9.7.141221
* Fixed logic in validation of VAT evidence at checkout.
* Refactored `EU VAT by Country` report.

####0.9.6.141220
* Implemented scaffolding classes for report management.
* Implemented `EU VAT by Country` report (draft, untested).

####0.9.5.141218
* Improved recording of VAT data and evidence:
	* Reduced the amount of duplicate data stored in order's "VAT paid" metadata.
	* Altered order metabox to calculate amounts in VAT currency on the fly.
	* Modified order VAT metadata to be stored as hidden fields.
	* Repurposed the "VAT paid" metadata to a more generic "VAT data".
* Added support for refunds (WooCommerce 2.2 and newer).
* Improved UI.

####0.9.4.141218
* Added logic to automatically append the VAT number to customer's formatted billing address.

####0.9.3.141218
* Added exchange rates provider for [ECB feed](https://www.ecb.europa.eu/stats/exchange/eurofxref/html/index.en.html).
* Added exchange rates provider for [Irish Revenue website](http://www.revenue.ie/en/customs/businesses/importing/exchange-rates/).

####0.9.2.141218
* Fixed logic used to determine the availability of sufficient evidence about customer's location.
* Fixed bug in validation of sufficient customer's location evidence.
* Added integration with [WooCommerce PDF Invoices & Packing Slips](https://wordpress.org/plugins/woocommerce-pdf-invoices-packing-slips/).
* Added notice to invite site administrator to complete the plugin configuration.

####0.9.1.141217
* Added extra filter to facilitate 3rd party integrations.
	* Added filter `wc_aelia_eu_vat_assistant_get_order_exchange_rate`.
	* Added filter `wc_aelia_eu_vat_assistant_get_setting`.

####0.9.0.141216
* Added feature to allow automatic population of EU VAT rates.

####0.8.1.141216
* Renamed plugin to **EU VAT Assistance** to avoid confusion with the existing EU VAT Compliance one.

####0.8.0.141215
* Added initial support for subscription renewal orders.
* Added validation of location self-certification field.

####0.7.5.141212
* Added collection of the exchange rate used during the VAT calculation in `Order::update_vat_data()` method.

####0.7.0.141212
* Implemented handling of self-certification field:
	* Added field to checkout page.
	* Added logic to show/hide the field depending on the configuration, and on the presence of sufficient evidence or a valid VAT number.
	* Added logic to save the self certification flag against orders.

####0.6.5.141211
* Improved logic that records VAT information against an order. Now data is recorded with subtotals for each tax rate.
* Improved order metabox to display the VAT totals broken down by rate.
* Improved UI of order metabox.

####0.6.0.141210
* Added recording of VAT paid upon order completion.
* Added recording of VAT evidence upon order completion.
* Added meta box to display VAT information on order edit page.
* Fixed bugs in handling of VAT details.

####0.5.0.141209
* Implemented integration with Currency Switcher.
	* Added automatic update of exchange rates when Currency Switcher settings change.
* Improved admin UI.
* Added `Settings::get_exchange_rates_method()`.
* Added rounding of VAT amounts during conversion to VAT currency.

####0.4.0.141208
* Improved look of admin UI.
* Added settings for customer's self-certification at checkout.
* Added settings for currency management (exchange rates and VAT currency).
* Added automatic updates of exchange rates.

####0.3.0.141207
* Added `EU_VAT_Validation` class to validate EU VAT numbers using VIES.
* Added view to render the EU VAT number field at checkout.
* Added frontend validation of the EU VAT number.
* Added caching of EU VAT validation responses.
* Added plugin settings UI.
* Added `Order` class template.
* Added icons to indicate if VAT number was validated correctly.

####0.1.0.141205
* First plugin draft.
