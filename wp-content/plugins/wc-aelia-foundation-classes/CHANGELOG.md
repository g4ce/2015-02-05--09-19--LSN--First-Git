Aelia Foundation Classes for WooCommerce
===

###Version 1.x
####1.4.9.150111
* Added `Aelia_Install::column_exists()` method.
* Added `Aelia_Install::add_column()` method.

####1.4.8.150109
* Added `attributes` argument to `Settings_Renderer::render_text_field()`.
* Added `attributes` argument to `Settings_Renderer::render_checkbox_field()`.

####1.4.7.150107
* Improved requirement checker class. Replaced absolute plugin path with `WP_PLUGIN_DIR` constant.

####1.4.6.150106
* Fixed bug in `Settings_Renderer::render_dropdown_field()`. The bug prevented the CSS class specified in field settings from being applied to the rendered element.

####1.4.5.141230
* Added Httpful library.

####1.4.4.141224
* Fixed bug in auto-update mechanism that prevented external plugin from being able to call it.

####1.4.3.141223
* Refactored `Semaphore` class to use MySQL `GET_LOCK()`.
* Moved automatic updates to WordPress `init` event.

####1.4.2.141222
* Updated GeoIP database.

####1.4.1.141214
* Improved display of "missing requirements" messages.

####1.4.0.141210
* Improved performance in Admin sections. Admin pages now run initialisation code only when they are requested.
* Improved rendering of checkboxes. The new logic ensures that a value is always posted for a checkbox, whether it's ticked or unticked.
* Added `Aelia\WC\Order::get_meta()` method.

####1.3.0.141208
* Added base `Aelia\WC\ExchangeRatesModel` class.
* Added `Settings_Renderer::render_dropdown_field()` method.
* Improved semaphore logic used during auto-updates to reduce race conditions.
* Updated GeoIP database.

####1.2.3.141129
* Added `WC\Aelia\Aelia_Plugin::log()` method.
* Added `Aelia\WC\Order::get_customer_vat_number()` method.
* Added possibility to show a description below the fields in plugin's settings page.
* Added `Aelia\WC\Settings_Renderer::render_text_field()` method.
* Added `Aelia\WC\Settings_Renderer::render_checkbox_field()` method.
* Added `AeliaSimpleXMLElement` class.
* Added support for database transactions to `Aelia_Install` class.
* Added `Model` class.
* Fixed bug in `Settings_Renderer::default_settings()` method.

####1.2.2.141023
* Improved checks in `Aelia\WC\Settings::load()`. Method can now detect and ignore corrupt settings.

####1.2.1.141017
* Added new `Aelia\WC\Aelia_Plugin::init_woocommerce_session()` method, which initialises the WooCommerce session.

####1.2.0.141013
* Added `aelia_t()` function. The function integrates with WPML to translate dynamically generated text and plugin settings.

####1.1.3.140910
* Updated reference to `plugin-update-checker` library.

####1.1.2.140909
* Updated `readme.txt`.

####1.1.1.140909
* Cleaned up build file.

####1.1.0.140909
* Added automatic update mechanism.

####1.0.12.140908
* Added `Aelia_SessionManager::session()` method, as a convenience to retrieve WC session

####1.0.11.140825
* Fixed minor bug in `IP2Location` class that generated a notice message.

####1.0.10.140819
* Fixed logic used to check and load plugin dependencies in `Aelia_WC_RequirementsChecks` class.

####1.0.9.140717
* Refactored semaphore class:
	* Optimised logic used for auto-updates to improve performance.
	* Fixed logic to determine the lock ID for the semaphore.

####1.0.8.140711
* Improved semaphore used for auto-updates:
	* Reduced timeout to forcibly release a lock to 180 seconds.
* Modified loading of several classes to work around quirks of Opcode Caching extensions, such as APC and XCache.

####1.0.7.140626
* Added geolocation resolution for IPv6 addresses.
* Updated Geolite database.

####1.0.6.140619
* Modified loading of Aelia_WC_RequirementsChecks class to work around quirks of Opcode Caching extensions, such as APC and XCache.

####1.0.5.140611
* Corrected loading of plugin's text domain.

####1.0.4.140607
* Modified logic used to load main class to allow dependent plugins to load AFC for unit testing.

####1.0.3.140530
* Optimised auto-update logic to reduce the amount of queries.

####1.0.2.140509
* Updated Composer dependencies.
* Removed unneeded code.
* Corrected reference to global WooCommerce instance in Aelia\WC\Aelia_SessionManager class.

####1.0.1.140509
* First public release
