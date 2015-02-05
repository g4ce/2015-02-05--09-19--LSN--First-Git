=== WooCommerce EU VAT Assistant ===
Contributors: daigo75
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=LVSZCS2SABN7Y
Requires at least: 3.6
Tested up to: 4.1
Stable tag: 1.1.6.150126
Tags: woocommerce, eu vat, vat compliance, iva, moss, vat rates, eu tax, hmrc, digital vat, tax, woocommerce taxes
License: GPLv3

Extends the standard WooCommerce sale process and assists in achieving compliance with the new EU VAT regime starting on the 1st of January 2015.

== Description ==

EU VAT Assistant for WooCommerce is designed to help achieving compliance with the new European VAT regulations, coming into effect on the 1st of January 2015. Starting from that date, digital goods sold to consumers in the European Union are liable to EU VAT, no matter where the seller is located. The VAT rate to apply to each sale is the one charged in the country of consumption, i.e. where the customer  resides. These new rules apply to worldwide sellers, whether resident in the European Union or not, who sell their products to EU customers. For more information: [EU: 2015 Place of Supply Changes - Mini One-Stop-Shop](http://www2.deloitte.com/global/en/pages/tax/articles/eu-2015-place-of-supply-changes-mini-one-stop-shop.html).

This is a full version of the **[premium EU VAT Assistant plugin](http://bit.ly/1tpq6P5WP)**, developed by [Aelia Team - The WooCommerce multi-currency experts](http://aelia.co), provided free of charge. You can use it as you like, and we hope it will make it easier for you to deal with the new, complex EU VAT regulations. If you would like to avail of our support service, we would like to invite you to [buy the paid version](http://bit.ly/1tpq6P5WP), which includes full support through our dedicated portal.

**Important**

* Please make sure that you read the requirements below before installing this plugin.
* You must install our [AFC plugin for WooCommerce](http://aelia.co/downloads/wc-aelia-foundation-classes.zip) for the EU VAT Assistant to work.

= How this product works =

The EU VAT Assistant plugin extends the standard WooCommerce sale process and calculates the VAT due under the new regime. The information gathered by the plugin can then be used to prepare VAT reports, which will help filing the necessary VAT/MOSS returns.

The EU VAT Assistant plugin also records details about each sale, to prove that the correct VAT rate was applied. This is done to comply with the new rules, which require that at least two pieces of non contradictory evidence must be gathered, for each sale, as a proof of customer's location. The evidence is saved automatically against each new order, from the moment the EU VAT compliance plugin is activated.

In addition to the above, the plugin includes powerful features to minimise the effort required to achieve compliance, such as the validation of EU VAT numbers for B2B sales, support for customer's self-certification of location, automatic update of exchange rates, etc. Please refer to the **Key Features** section, below, for more details.

= Key Features =

* **Accepts and validates EU VAT numbers, applying VAT exemption when appropriate**. Validation of European VAT numbers is performed via the official VIES service, provided by the European Commission. This feature is equivalent to the one provided by the EU VAT Number plugin.
* **Supports a dedicated VAT currency**, which is used to generate the reports. You can sell in any currency you like, the EU VAT Assistant plugin will take care of converting the VAT amounts to the currency you will use to file your returns.
* **Supports mixed products/services scenarios**. The new EU VAT MOSS regime applies to the sale of digital products and services that do not require significal manual intervention. Sale of services that are provided with human intervention, such as support, consultancy, design, are still subject to VAT at source. In this case, VAT has to be paid to the revenue in merchant's country. WooCommerce allows to specify to which country a tax applies, but not to which country it should be paid once collected. The EU VAT Assistant can help, by allowing merchants to specify the "payable to" country for each VAT. Such information is then displayed in the VAT reports.
* **Allows to force B2B or B2C sales**. You can decide if you wish to force customers to a valid EU VAT number at checkout, thus accepting only B2B transactions, or prevent them from doing it, thus accepting only B2C transactions.
* **Allows to prevent sales to specific countries**. You can exclude some countries from the list of allowed ones, thus preventing customers from those countries from placing an order.
* **Fully compatible with our products**, such the [WooCommerce Currency Switcher](http://aelia.co/shop/currency-switcher-woocommerce/), [Prices by Country](http://aelia.co/shop/prices-by-country-woocommerce/), [Tax Display by Country](http://aelia.co/shop/tax-display-by-country-for-woocommerce/) and Prices by Role (coming soon).
* **Automatically updates the exchange rates that are be used to produce the VAT reports in the selected VAT currency**. The plugin can fetch exchange rates from the following providers:
  * European Central Bank
	* HM Revenue and Customs service
	* Bitpay
	* Irish Revenue (experimental)
	* Danish National Bank (sponsored by [Asbjoern Andersen](http://www.asoundeffect.com/)).
* Calculates and stores the VAT amounts automatically, for each order.
* Collects evidence required by the new regulations, to prove that the correct VAT rate was applied. The plugin can automatically detect customer's location, thus gathering one of the approved pieces of evidence.
* Allows to collect a self-certification from the customer, when insufficient evidence is available to prove his/her location.
* Automatically populates the VAT rates for all EU countries in WooCommerce Tax Settings.
* Includes integration with [PDF Invoices and Packing Slips plugin](https://wordpress.org/plugins/woocommerce-pdf-invoices-packing-slips/), to automatically generate EU VAT-compliant invoices. **Documentation coming soon**.
* **Reports**
	* EU VAT report by Country.
	* Sales by Country (**in development**).

= Requirements =

* WordPress 3.6 or later.
* PHP 5.3 or later.
* WooCommerce 2.1.x/2.2.x.
* [AFC plugin for WooCommerce](http://aelia.co/downloads/wc-aelia-foundation-classes.zip) 1.4.9.150111 or later.

= Disclaimer =

This product has been designed to help you fulfil the requirements of the following new EU VAT regulations:

* Identify customers' location.
* Collect at least two non-contradictory pieces of evidence about the determined location.
* Apply the correct VAT rate.
* Ensure that VAT numbers used for B2B transactions are valid before applying VAT exemption.
* Collect all the data required to prepare VAT returns.

We cannot, however, give any legal guarantee that the features provided by this product will be sufficient for you to be fully compliant. By using this product, you declare that you understand and agree that we cannot take any responsibility for errors, omissions or any non-compliance arising from the use of this plugin, alone or together with other products, plugins, themes, extensions or services. It will be your responsibility to check the data produced by this product and file accurate VAT returns on time with your Revenue authority. For more information, please refer to our [terms and conditions of sale and support](http://aelia.co/terms-and-conditions-of-sale/#FreeSupportCovers).

== Frequently Asked Questions ==

= Is this really a premium plugin? =

Yes, the EU VAT Assistant is a premium plugin. It's based on the same framework we use for our other premium products, such as the [WooCommerce Currency Switcher](http://aelia.co/shop/currency-switcher-woocommerce/), [Prices by Country](http://aelia.co/shop/prices-by-country-woocommerce/), [Tax Display by Country](http://aelia.co/shop/tax-display-by-country-for-woocommerce/) and Prices by Role (coming soon), and it follows the same quality standards. It's fully functional, without restrictions or limitations.

= Does this plugin cover cross-country compliant invoicing? =
**This feature is now being evaluated**. The new EU VAT regulations specify that invoices sent to customers across Europe must comply to the rules that apply in customers' country. At the same time, invoices must also comply to the rules in merchant's country, and the two may not match. To further complicate things, the original invoice may be in a currency different from the one required by both customers' and merchant country.

We are gathering information from all EU countries, to determine the complexity of a cross-country compliant invoicing solution. Once we will have collected all the necessary data, we will be able to draft a plan to implement such solution. **Note**: we are planning to use the PDF Invoicing and Packing Slips plugin to produce the invoices. Support for other plugins will be evaluated at a later stage.

= Can the EU VAT Assistant show the correct VAT rate as soon as a visitor comes to the site? =

In short, no. Such feature is included in our [Tax Display by Country plugin](http://bit.ly/1mdgsoeac), which was released at the beginning of 2014. Adding it to the EU VAT Assistant would mean additional work for us, with the result of potentially killing the sales for our commercial product. If you wish to automatically show the VAT rate that applies to visitors' location, we encourage you to buy the [Tax Display by Country plugin](http://bit.ly/1mdgsoeac). It's a flexible, yet inexpensive product. The revenue it generates will also help us covering the maintenance costs of the EU VAT Assistant.

= What is the support policy for this plugin? =

As indicated in the Description section, we offer this plugin **free of charge**, but we cannot afford to also provide free, direct support for it as we do for our paid products. Should you encounter any difficulties with this plugin, and need support, you have several options:

1. **Report the issue using [our Support portal](https://aelia.freshdesk.com/helpdesk/tickets/new)**, and we will look into it as soon as possible. This option is **free**, and it's offered on a best effort basis. Please note that we won't be able to guarantee a response time, and we won't be able to offer hands-on troubleshooting on issues related to a specific site, such as incompatibilities with a specific environment or 3rd party plugins.
2. **[Buy a support plan](http://bit.ly/1tpq6P5WP)**. You will receive top class, direct assistance from our team, who will troubleshoot your site and help you to make it work smoothly. We can also help you with installation, customisation and development of new features.
3. **Report the issue on the Support section, above**. We do not monitor such section as actively as we do with our own dedicated portal, but we will reply as soon as we can. Posting the request there will also allow other users to see it, and they may be able to assist you.

= I have a question unrelated to support, where can I ask it? =

Should you have any question about this product, please use the [contact form on our site](http://aelia.co/contact). We will deal with each enquiry as soon as possible. **Important**: we won't be able to provide advice about taxation, accounting or legal matters of any kind.

== Installation ==

1. Extract the zip file and drop the contents in the ```wp-content/plugins/``` directory of your WordPress installation.
2. Activate the EU VAT Assistant plugin through the **Plugins** menu in WordPress.
3. Go to ```WooCommerce > EU VAT Assistant``` to configure the plugin. **Important**: the EU VAT Assistant is very flexible and includes many options. We recommend reading the descriptions carefully, to ensure that you have a clear understanding of what each setting does. Its features can be summarised as follows:

For more information about installation and management of plugins, please refer to [WordPress documentation](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

== Screenshots ==

1. **Settings > Checkout**. In this section you can configure how the EU VAT Assistant will behave on the checkout page.
2. **Settings > Self-certification**. In this section you can configure if the plugin should allow customers to self-certify their location.
3. **Settings > Currency**. In this section you can specify which currency you would like to use for VAT reports. It doesn't have to match the WooCommerce base currency. In the lower section, you can choose which provider you would like to use to retrieve the exchange rates that will be used to calculate the amounts in VAT currency.
4. **Settings > Sales**. This section contains the settings that can be used to control how sales are handled (e.g. by preventing sales to some specific countries).
5. **Settings > Options**. Miscellaneous options.
6. **Settings > Shortcuts**. This section contains a few handy shortcuts to reach the WooCommerce sections related to the EU VAT compliance.
7. **Frontend > Checkout**. This screenshot shows the new elements displayed to the customer at checkout. The **EU VAT Number** field can be used by EU businesses to enter their own VAT number. The number is validated using the VIES service and, when valid, a VAT exemption is applied automatically. The **self-certification** element can be used to allow the customer to self-certify that he is resident in the country he selected. This information can be used as a further piece of evidence to prove that the correct VAT rate was applied.
8. **Admin > WooCommerce > Order edit page**. This page shows how the VAT details are displayed when an order is reviewed in the Admin section. The meta box shows the details of the VAT charged for order items and shipping, as well as the amounts refunded. **Note**: refunds are available in WooCommerce 2.2 and later.
9. **Admin > WooCommerce > Tax Settings**. This screenshots shows the Tax Settings page extended by the EU VAT Assistant. The new user inerface allows to automatically retrieve and update the European VAT rates. It's possible to choose which VAT rates are applied in each page. Another important feature is the possibility to specify to which country a VAT will have to be paid. It will be possible, for example, to apply a *20% UK VAT* for services to a German customer who buys consultancy hours, and still keep track of the fact that such tax will have to be paid to HMRC (i.e. outside of MOSS scheme).
10. **Report > EU VAT by Country**. This report shows the totals of VAT applied and refunded at each rate, for both items and shipping, grouped by country. The Export CSV button allows to export the data to a CSV file, which can be easily imported by accounting software.

== Changelog ==

= 1.1.6.150126 =
* Extended EU VAT Report to include the totals of sales and shipping charged to each country.

= 1.1.5.150120 =
* Fixed text domain.
* Added Bulgarian translation, courtesy of Ivaylo Ivanov.

= 1.1.4.150113 =
* Fixed notice in `Settings` class.

= 1.1.3.150111 =
* Added support for additional tax rate fields. The fields will allow to identify not only to which country a VAT applies, but also to which country it should be paid.
* Altered `EU VAT by Country report` to display the "country payable" for each tax amount.
* Renamed class `Aelia\WC\EU_VAT_Assistant\WCPDF\EU_Invoice_Price_Formatter` to `EU_Invoice_Helper`.

= 1.1.2.150109 =
* Fixed notices on EU VAT Report page.

= 1.1.1.150107 =
* Fixed bug in recording of customer's self-certification. Plugin always recorded "yes" even when the customer did not self-certify his location.
* Fixed minor notice messages.

= 1.1.0.150106 =
* Added possibility to disallow sales to specific countries.

= 1.0.6.150105 =
* Removed display of an empty "*VAT #*" entry in customer's address when such information is not available.

= 1.0.5.150105 =
* Improved UI.
* Added `WCPDF\EU_Invoice_Price_Formatter::reverse_charge()` method. The method allows to quickly determine if an invoice is based on EU reverse charge rules, and print the related note on the invoice.

= 1.0.4.150103 =
* Fixed minor bug at checkout. The bug caused the wrong country to be used for VAT number validation when tax was setting to use customer's shipping address.
* Improved recording of VAT data against orders. Now basic VAT details, such as the exchange rate to VAT currency, are recorded for all orders, whether VAT was applied or not.
* Improved display of VAT details in `Order Edit` admin page.

= 1.0.3.150103 =
* Extended `Order::get_vat_data()` method to allow retrieval of specific parts of the VAT data.

= 1.0.2.150101 =
* Fixed bug in reports. The bug caused reports for past quarters to appear empty.

= 1.0.1.150101 =
* Added support for the new (and unannounced) exchange rates feed used by HMRC.
Updated language files.

= 1.0.0.141231 =
* Production ready.

= 0.10.6.141231 =
* Fixed JavaScript bug in Admin section.

= 0.10.5.141231 =
* Redacted FAQ.
* Fixed minor bug in `Order::get_vat_data()`.
* Optimised in `Order::get_vat_refunds()`.

= 0.10.4.141231 =
* Fixed import of Danish National Bank exchange rates.
* Updated language files.
* Optimised loading of JavaScript parameters for `Tax Settings` admin pages.

= 0.10.3.141231 =
* Added missing file (Danish National Bank interface was missing from WordPress repository).

= 0.10.2.141231 =
* Rewritten EU VAT by Country report to correctly process VAT refunds.

= 0.10.1.141230 =
* Fixed bug in handling of VAT refunds. Now VAT refunds are calculated on the fly on order edit view page.

= 0.10.0.141230 =
* Added exchange rates provider for [Danish National Bank feed](http://www.nationalbanken.dk/en/statistics/exchange_rates/Pages/default.aspx).
* Added tracking of exchange rates provider against each order.
* Improved validation of VAT rates to be used on `WooCommerce > Tax` settings page.
* Reorganised Admin UI.
* Added possibility to make the `EU VAT Number` field optional, required, required for EU countries or hidden.

= 0.9.23.141230 =
* Improved checks on of VAT validation responses. This will prevent issues caused by corrupt cached responses.

= 0.9.22.141230 =
* Updated requirements.

= 0.9.21.141229 =
* Added recording of the timestamp of the VAT currency exchange rate.

= 0.9.20.141229 =
* Fixed bug in handling of VIES response containing non-Latin UTF-8 characters.

= 0.9.19.141229 =
* Added caching of VIES WSDL to speed up VAT validation.

= 0.9.18.141229 =
* Fixed bug in VAT Number validation. The bug caused validation to fail when "odd" characters were returned by VIES service.

= 0.9.17.141228 =
* Fixed bugs in EU VAT by Country report:
	* Fixed incorrect reference to plugin class.
	* Fixed bug in range calculation.

= 0.9.16.141228 =
* Removed unused report.
* Fixed bug in handling of VAT rates for Isle of Man and Monaco.

= 0.9.15.141227 =
* Fixed bug in handling of VAT rates for Isle of Man and Monaco.

= 0.9.14.141227 =
* Added exchange rates provider for [HMRC feed](https://www.gov.uk/government/publications/exchange-rates-for-customs-and-vat-monthly).
* Added VAT rates for Monaco and Isle of Man.

= 0.9.13.141226 =
* Fixed call to `WC_Aelia_EU_VAT_Assistant::get_eu_vat_countries()`.

= 0.9.12.141226 =
* Replaced hard-coded table prefix with dynamic one in `Order::add_tax_rates_details()`.
* Added possibility to specify if shipping country should be used as location evidence.
* Added possibility to customise the self-certification message.

= 0.9.11.141224 =
* Fixed call to auto-update mechanism (the wrong plugin ID was used

= 0.9.10.141224 =
* Rewritten EU VAT by Country report.
* Fixed several minor warnings.
* Added call to auto-update mechanism.

= 0.9.9.141223 =
* Added logic to save tax details (rate and label) with the VAT data associated to an order.
* `Order` class now saves the tax rate and the tax country with the VAT data.
* Reorganised reports:
	* Divided reports in WC2.1 and WC2.2 namespaces.
	* Restructured report class to promote code reuse.
	* Updated EU VAT report to include "processing" orders.
* Added support for shipping tax refunds.
* Rewritten code to calculate and save tax subtotals against the orders.

= 0.9.8.141222 =
* Added logic to fix incorrect country codes in the VAT Rates feed.

= 0.9.7.141221 =
* Fixed logic in validation of VAT evidence at checkout.
* Refactored `EU VAT by Country` report.

= 0.9.6.141220 =
* Implemented scaffolding classes for report management.
* Implemented `EU VAT by Country` report (draft, untested).

= 0.9.5.141218 =
* Improved recording of VAT data and evidence:
	* Reduced the amount of duplicate data stored in order's "VAT paid" metadata.
	* Altered order metabox to calculate amounts in VAT currency on the fly.
	* Modified order VAT metadata to be stored as hidden fields.
	* Repurposed the "VAT paid" metadata to a more generic "VAT data".
* Added support for refunds (WooCommerce 2.2 and newer).
* Improved UI.

= 0.9.4.141218 =
* Added logic to automatically append the VAT number to customer's formatted billing address.

= 0.9.3.141218 =
* Added exchange rates provider for [ECB feed](https://www.ecb.europa.eu/stats/exchange/eurofxref/html/index.en.html).
* Added exchange rates provider for [Irish Revenue website](http://www.revenue.ie/en/customs/businesses/importing/exchange-rates/).

= 0.9.2.141218 =
* Fixed logic used to determine the availability of sufficient evidence about customer's location.
* Fixed bug in validation of sufficient customer's location evidence.
* Added integration with [WooCommerce PDF Invoices & Packing Slips](https://wordpress.org/plugins/woocommerce-pdf-invoices-packing-slips/).
* Added notice to invite site administrator to complete the plugin configuration.

= 0.9.1.141217 =
* Added extra filter to facilitate 3rd party integrations.
	* Added filter `wc_aelia_eu_vat_assistant_get_order_exchange_rate`.
	* Added filter `wc_aelia_eu_vat_assistant_get_setting`.

= 0.9.0.141216 =
* Added feature to allow automatic population of EU VAT rates.

= 0.8.1.141216 =
* Renamed plugin to **EU VAT Assistance** to avoid confusion with the existing EU VAT Compliance one.

= 0.8.0.141215 =
* Added initial support for subscription renewal orders.
* Added validation of location self-certification field.

= 0.7.5.141212 =
* Added collection of the exchange rate used during the VAT calculation in `Order::update_vat_paid_data()` method.

= 0.7.0.141212 =
* Implemented handling of self-certification field:
	* Added field to checkout page.
	* Added logic to show/hide the field depending on the configuration, and on the presence of sufficient evidence or a valid VAT number.
	* Added logic to save the self certification flag against orders.

= 0.6.5.141211 =
* Improved logic that records VAT information against an order. Now data is recorded with subtotals for each tax rate.
* Improved order metabox to display the VAT totals broken down by rate.
* Improved UI of order metabox.

= 0.6.0.141210 =
* Added recording of VAT paid upon order completion.
* Added recording of VAT evidence upon order completion.
* Added meta box to display VAT information on order edit page.
* Fixed bugs in handling of VAT details.

= 0.5.0.141209 =
* Implemented integration with Currency Switcher.
	* Added automatic update of exchange rates when Currency Switcher settings change.
* Improved admin UI.
* Added `Settings::get_exchange_rates_method()`.
* Added rounding of VAT amounts during conversion to VAT currency.

= 0.4.0.141208 =
* Improved look of admin UI.
* Added settings for customer's self-certification at checkout.
* Added settings for currency management (exchange rates and VAT currency).
* Added automatic updates of exchange rates.

= 0.3.0.141207 =
* Added `EU_VAT_Validation` class to validate EU VAT numbers using VIES.
* Added view to render the EU VAT number field at checkout.
* Added frontend validation of the EU VAT number.
* Added caching of EU VAT validation responses.
* Added plugin settings UI.
* Added `Order` class template.
* Added icons to indicate if VAT number was validated correctly.

= 0.1.0.141205 =
* First plugin draft.
