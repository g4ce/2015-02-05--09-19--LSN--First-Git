<?php
namespace Aelia\WC\EU_VAT_Assistant;
if(!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Implements a class that will render the settings page.
 */
class Settings_Renderer extends \Aelia\WC\Settings_Renderer {
	// @var string The URL to the support portal.
	const SUPPORT_URL = 'http://aelia.freshdesk.com/support/home';
	// @var string The URL to the contact form for general enquiries.
	const CONTACT_URL = 'http://aelia.co/contact/';

	/*** Settings Tabs ***/
	const TAB_CHECKOUT = 'checkout';
	const TAB_SELF_CERTIFICATION = 'self-certification';
	const TAB_CURRENCY = 'currency';
	const TAB_SALES = 'sales';
	const TAB_REPORTS = 'reports';
	const TAB_OPTIONS = 'options';
	const TAB_LINKS = 'links';
	const TAB_SUPPORT = 'support';

	/*** Settings sections ***/
	const SECTION_CHECKOUT = 'checkout';
	const SECTION_SELF_CERTIFICATION = 'self_certification';
	const SECTION_CURRENCY = 'currency';
	const SECTION_EXCHANGE_RATES_UPDATE = 'exchange_rates_update';
	const SECTION_EXCHANGE_RATES = 'exchange_rates';
	const SECTION_REPORTS = 'reports';
	const SECTION_SALE_RESTRICTIONS = 'sale_restrictions';
	const SECTION_OPTIONS = 'options';
	const SECTION_LINKS = 'links';
	const SECTION_DEBUG = 'debug';
	const SECTION_SUPPORT = 'support_section';

	/**
	 * Transforms an array of currency codes into an associative array of
	 * currency code => currency description entries. Currency labels are retrieved
	 * from the list of currencies available in WooCommerce.
	 *
	 * @param array currencies An array of currency codes.
	 * @return array
	 */
	protected function add_currency_labels(array $currencies) {
		$woocommerce_currencies = get_woocommerce_currencies();

		// Add the VAT currency to the list, in case it's not already there
		$currencies[] = $this->_settings_controller->vat_currency();

		$result = array();
		foreach($currencies as $currency_code) {
			$result[$currency_code] = get_value($currency_code,
																					$woocommerce_currencies,
																					sprintf(__('Label not found for currency "%s"', 'wc-aelia-eu-vat-assistant'),
																									$currency_code));
		}

		return $result;
	}

	/**
	 * Sets the tabs to be used to render the Settings page.
	 */
	protected function add_settings_tabs() {
		// Checkout settings
		$this->add_settings_tab($this->_settings_key,
														self::TAB_CHECKOUT,
														__('Checkout', 'wc-aelia-eu-vat-assistant'));
		// Self-certification
		$this->add_settings_tab($this->_settings_key,
														self::TAB_SELF_CERTIFICATION,
														__('Self-certification', 'wc-aelia-eu-vat-assistant'));
		// Currency
		$this->add_settings_tab($this->_settings_key,
														self::TAB_CURRENCY,
														__('Currency', 'wc-aelia-eu-vat-assistant'));
		// Sales
		$this->add_settings_tab($this->_settings_key,
														self::TAB_SALES,
														__('Sales', 'wc-aelia-eu-vat-assistant'));
		// Reports
		$this->add_settings_tab($this->_settings_key,
														self::TAB_REPORTS,
														__('Reports', 'wc-aelia-eu-vat-assistant'));
		// Options
		$this->add_settings_tab($this->_settings_key,
														self::TAB_OPTIONS,
														__('Options', 'wc-aelia-eu-vat-assistant'));
		// Shortcuts
		$this->add_settings_tab($this->_settings_key,
														self::TAB_LINKS,
														__('Shortcuts', 'wc-aelia-eu-vat-assistant'));
		// Support tab
		$this->add_settings_tab($this->_settings_key,
														self::TAB_SUPPORT,
														__('Support', 'wc-aelia-eu-vat-assistant'));
	}

	/**
	 * Configures the plugin settings sections.
	 */
	protected function add_settings_sections() {
		// Add checkout settings section
		$this->add_settings_section(
				self::SECTION_CHECKOUT,
				__('Checkout settings', 'wc-aelia-eu-vat-assistant'),
				array($this, 'checkout_section_callback'),
				$this->_settings_key,
				self::TAB_CHECKOUT
		);
		// Add self-certification settings section
		$this->add_settings_section(
				self::SECTION_SELF_CERTIFICATION,
				__('Self-certification settings', 'wc-aelia-eu-vat-assistant'),
				array($this, 'self_certification_section_callback'),
				$this->_settings_key,
				self::TAB_SELF_CERTIFICATION
		);
		// Add currency section
		$this->add_settings_section(
				self::SECTION_CURRENCY,
				__('Currency', 'wc-aelia-eu-vat-assistant'),
				array($this, 'currency_section_callback'),
				$this->_settings_key,
				self::TAB_CURRENCY
		);
		$this->add_settings_section(
				self::SECTION_EXCHANGE_RATES_UPDATE,
				__('Automatic update of exchange rates', 'wc-aelia-eu-vat-assistant'),
				array($this, 'exchange_rates_update_section_callback'),
				$this->_settings_key,
				self::TAB_CURRENCY
		);
		$this->add_settings_section(
				self::SECTION_EXCHANGE_RATES,
				__('Exchange rates', 'wc-aelia-eu-vat-assistant'),
				array($this, 'exchange_rates_section_callback'),
				$this->_settings_key,
				self::TAB_CURRENCY
		);
		// Add sales section
		$this->add_settings_section(
				self::SECTION_SALE_RESTRICTIONS,
				__('Sale restrictions', 'wc-aelia-eu-vat-assistant'),
				array($this, 'sale_restrictions_section_callback'),
				$this->_settings_key,
				self::TAB_SALES
		);
		// Add reports section
		$this->add_settings_section(
				self::SECTION_REPORTS,
				__('Reports settings', 'wc-aelia-eu-vat-assistant'),
				array($this, 'reports_section_callback'),
				$this->_settings_key,
				self::TAB_REPORTS
		);
		// Add options section
		$this->add_settings_section(
				self::SECTION_OPTIONS,
				__('Options', 'wc-aelia-eu-vat-assistant'),
				array($this, 'options_section_callback'),
				$this->_settings_key,
				self::TAB_OPTIONS
		);
		// Add Links section
		$this->add_settings_section(
				self::SECTION_LINKS,
				__('Options', 'wc-aelia-eu-vat-assistant'),
				array($this, 'links_section_callback'),
				$this->_settings_key,
				self::TAB_LINKS
		);
		// Add Support section
		$this->add_settings_section(
				self::SECTION_SUPPORT,
				__('Support Information', 'wc-aelia-eu-vat-assistant'),
				array($this, 'support_section_callback'),
				$this->_settings_key,
				self::TAB_SUPPORT
		);
		// Add Debug section
		$this->add_settings_section(
				self::SECTION_DEBUG,
				__('Debug', 'wc-aelia-eu-vat-assistant'),
				array($this, 'debug_section_callback'),
				$this->_settings_key,
				self::TAB_SUPPORT
		);
	}

	/**
	 * Configures the plugin settings fields.
	 */
	protected function add_settings_fields() {
		// Checkout settings
		$eu_vat_number_field_handling_options = array(
			Settings::OPTION_EU_VAT_NUMBER_FIELD_OPTIONAL => __('Optional', 'wc-aelia-eu-vat-assistant'),
			Settings::OPTION_EU_VAT_NUMBER_FIELD_REQUIRED => __('Always required', 'wc-aelia-eu-vat-assistant'),
			Settings::OPTION_EU_VAT_NUMBER_FIELD_REQUIRED_EU_ONLY => __('Required only for EU addresses', 'wc-aelia-eu-vat-assistant'),
			Settings::OPTION_EU_VAT_NUMBER_FIELD_HIDDEN => __('Hidden', 'wc-aelia-eu-vat-assistant'),
		);
		$this->render_dropdown_field(self::SECTION_CHECKOUT,
																 Settings::FIELD_EU_VAT_NUMBER_FIELD_REQUIRED,
																 __('EU VAT number field will be', 'wc-aelia-eu-vat-assistant'),
																 $eu_vat_number_field_handling_options,
																 __('Choose if you would like to display the EU VAT Number field, and ' .
																		'how you would like to handle it.'.
																		'<ul class="description">' .
																		'<li><strong>Optional</strong> - Customers can enter a EU VAT ' .
																		'number to get VAT exemption.</li>' .
																		'<li><strong>Always required</strong> - Customers must enter a ' .
																		'valid EU VAT number to complete a purchase. This means that ' .
																		'only B2B sales with EU businesses can be completed.</li>' .
																		'<li><strong>Required only for EU addresses</strong> - Customers ' .
																		'who select a billing country that is part of the EU must enter a ' .
																		'valid EU VAT number to complete a purchase. Customer who select ' .
																		'a non-EU country can proceed without entering the VAT number.</li>' .
																		'<li><strong>Hidden</strong> - Customers will not be able ' .
																		'to enter a EU VAT number. This option is useful if you do not ' .
																		'plan to sell to EU businesses.</li>' .
																		'</ul>', 'wc-aelia-eu-vat-assistant'),
																 '');
		// Label for EU VAT field
		$this->render_text_field(self::SECTION_CHECKOUT,
														 Settings::FIELD_EU_VAT_FIELD_TITLE,
														 __('EU VAT field label', 'wc-aelia-eu-vat-assistant'),
														 __('The label that will be displayed above the EU VAT field at checkout.', 'wc-aelia-eu-vat-assistant'),
														 'title');
		// Description for EU VAT field
		$this->render_text_field(self::SECTION_CHECKOUT,
														 Settings::FIELD_EU_VAT_FIELD_DESCRIPTION,
														 __('EU VAT field description', 'wc-aelia-eu-vat-assistant'),
														 __('A description that will be displayed above the EU VAT field at checkout.', 'wc-aelia-eu-vat-assistant'),
														 'description');
		$this->render_checkbox_field(self::SECTION_CHECKOUT,
																 Settings::FIELD_SHOW_EU_VAT_FIELD_IF_CUSTOMER_IN_BASE_COUNTRY,
																 __('Show EU VAT field when customer is located in base country', 'wc-aelia-eu-vat-assistant'),
																 __('Show the EU VAT field when customer address is located in any European ' .
																		'country, including your shop\'s base country.', 'wc-aelia-eu-vat-assistant'),
																 '');
		$this->render_checkbox_field(self::SECTION_CHECKOUT,
																 Settings::FIELD_REMOVE_VAT_IF_CUSTOMER_IN_BASE_COUNTRY,
																 __('Remove VAT customer is located in base country', 'wc-aelia-eu-vat-assistant'),
																 __('Enable this option to remove VAT for customers who are located ' .
																		'in your shop\'s base country if they enter a valid EU VAT number.', 'wc-aelia-eu-vat-assistant'),
																 '');
		$this->render_checkbox_field(self::SECTION_CHECKOUT,
																 Settings::FIELD_STORE_INVALID_VAT_NUMBERS,
																 __('Store invalid VAT numbers', 'wc-aelia-eu-vat-assistant'),
																 __('Enable this option to store VAT numbers that don\'t pass ' .
																		'validation. Note: when an invalid VAT number is detected, ' .
																		'VAT will still be applied.', 'wc-aelia-eu-vat-assistant'),
																 '');
		$this->render_checkbox_field(self::SECTION_CHECKOUT,
																 Settings::FIELD_ACCEPT_VAT_NUMBER_WHEN_VALIDATION_SERVER_BUSY,
																 __('Accept VAT numbers that cannot be validated due to server busy', 'wc-aelia-eu-vat-assistant'),
																 __('VAT numbers are validates using EU VIES service. Occasionally, ' .
																		'the VIES server may return a "busy" response, which means that ' .
																		'the VAT number was not processed and its validity is unknown. ' .
																		'If you enable this option, a VAT number that cannot be validated ' .
																		'due to the VIES server being busy will be accepted, and the ' .
																		'customer will be considered exempt from VAT.', 'wc-aelia-eu-vat-assistant'),
																 '');
		// Self-certification
		$self_certification_show_options = array(
			Settings::OPTION_SELF_CERTIFICATION_FIELD_NO => __('No (never show it)', 'wc-aelia-eu-vat-assistant'),
			Settings::OPTION_SELF_CERTIFICATION_FIELD_YES => __('Yes (always show it)', 'wc-aelia-eu-vat-assistant'),
			Settings::OPTION_SELF_CERTIFICATION_FIELD_CONFLICT_ONLY => __('Only when there is insufficient ' .
																																		'evidence about customer\'s location .', 'wc-aelia-eu-vat-assistant'),
		);
		$this->render_dropdown_field(self::SECTION_SELF_CERTIFICATION,
																 Settings::FIELD_SHOW_SELF_CERTIFICATION_FIELD,
																 __('Allow customers to self-certify their location of residence', 'wc-aelia-eu-vat-assistant'),
																 $self_certification_show_options,
																 __('Choose if you would like to display a "self-certification" field at ' .
																		'checkout. By ticking the self-certification box, customers will be ' .
																		'allowed to certify that the country entered as part of the billing ' .
																		'address is their country of residence. Such declaration will be ' .
																		'recorded with the completed order as part of the EU VAT evidence.', 'wc-aelia-eu-vat-assistant'),
																 '');
		$this->render_checkbox_field(self::SECTION_SELF_CERTIFICATION,
																 Settings::FIELD_SELF_CERTIFICATION_FIELD_REQUIRED_WHEN_CONFLICT,
																 __('Require self-certification when the evidence about location is insufficient', 'wc-aelia-eu-vat-assistant'),
																 __('<a href="http://en.wikipedia.org/wiki/European_Union_value_added_tax#EU_VAT_area">' .
																		'EU regulations require at least two pieces of non-conflicting ' .
																		'evidence</a> to prove a customer\'s location (e.g. billing address, shipping ' .
																		'address, IP address). If you enable this option, the self-certification ' .
																		'will become mandatory unless at least two of these information will ' .
																		'match the same country. <strong>Important</strong>: this rule ' .
																		'applies only when the self-certification field is visible to the ' .
																		'customer (see visibility options, above).', 'wc-aelia-eu-vat-assistant'),
																 '');
		$this->render_checkbox_field(self::SECTION_SELF_CERTIFICATION,
																 Settings::FIELD_USE_SHIPPING_ADDRESS_AS_EVIDENCE,
																 __('Consider the shipping address as valid location evidence', 'wc-aelia-eu-vat-assistant'),
																 __('Tick this box if you would like to use the shipping address ' .
																		'as evidence to validate customer\'s location. When this ' .
																		'option is enabled, and the customer enters the same country ' .
																		'in both billing and shipping address, the plugin will consider ' .
																		'them two pieces of non contradictory evidence and it will no ' .
																		'longer ask for self-certification. ' .
																		'We would recommend that you discuss with your Revenue office ' .
																		'the possibility of using the shipping address as evidence ' .
																		'before enabling this option.', 'wc-aelia-eu-vat-assistant'),
																 '');
		$this->render_checkbox_field(self::SECTION_SELF_CERTIFICATION,
																 Settings::FIELD_HIDE_SELF_CERTIFICATION_FIELD_VALID_VAT_NUMBER,
																 __('Hide the self-certification field when a valid VAT number is entered', 'wc-aelia-eu-vat-assistant'),
																 __('Enable this option if you would like to hide the self-certification ' .
																		'field at checkout even when the customer enters a valid VAT number. ' .
																		'<strong>Important</strong>: when this option is enabled, if the ' .
																		'customer will enter a valid VAT number the self-certification ' .
																		'requirement above will be ignored.', 'wc-aelia-eu-vat-assistant'),
																 '');
		$this->render_text_field(self::SECTION_SELF_CERTIFICATION,
																 Settings::FIELD_SELF_CERTIFICATION_FIELD_TITLE,
																 __('Self-certification field label', 'wc-aelia-eu-vat-assistant'),
																 __('The label that will be displayed above the self-certification ' .
																		'field at checkout. You can use the <code>{billing_country}</code> ' .
																		'placeholder to automatically show the billing country chosen ' .
																		'by the customer.', 'wc-aelia-eu-vat-assistant'),
																 'title');
		// Currency
		$this->render_dropdown_field(self::SECTION_CURRENCY,
																 Settings::FIELD_VAT_CURRENCY,
																 __('VAT Currency', 'wc-aelia-eu-vat-assistant'),
																 get_woocommerce_currencies(),
																 __('EU regulations require that all payment and VAT amounts ' .
																		'are indicated in the currency where your business is based. ' .
																		'If you file your VAT reports in a currency different from ' .
																		'shop\'s base currency, you can choose it here. ' .
																		'<strong>Important:</strong> all VAT data will be calculated and ' .
																		'stored with the orders as they are created. We strongly recommend ' .
																		'to double check the currency you have selected, as changing it later ' .
																		'could result in incorrect VAT reports being generated.', 'wc-aelia-eu-vat-assistant'),
																 'title');

		// Exchange rates settings
		$this->render_checkbox_field(self::SECTION_EXCHANGE_RATES_UPDATE,
																 Settings::FIELD_EXCHANGE_RATES_UPDATE_ENABLE,
																 __('Tick this box to enable automatic updating of exchange rates.', 'wc-aelia-eu-vat-assistant'),
																 '', // No description required
																 '');

		// Add "Exchange Rates Schedule" field
		// Render the dropdown to allow choosing how often to update the Exchange Rates
		$schedule_info = $this->_settings_controller->get_exchange_rates_schedule_info();
		$this->render_dropdown_field(self::SECTION_EXCHANGE_RATES_UPDATE,
																 Settings::FIELD_EXCHANGE_RATES_UPDATE_SCHEDULE,
																 __('Select how often you would like to update the exchange rates.', 'wc-aelia-eu-vat-assistant'),
																 $this->_settings_controller->get_schedule_options(),
																 sprintf(__('<p>Last update: <span id="last_exchange_rates_update">%s</span>.</p>' .
																						'<p>Next update: <span id="next_exchange_rates_update">%s</span>.</p>', 'wc-aelia-eu-vat-assistant'),
																				 $schedule_info['last_update'],
																				 $schedule_info['next_update']),
																 'exchange_rates_schedule');
		// Render the dropdown to choose the exchange rates provider
		$this->render_dropdown_field(self::SECTION_EXCHANGE_RATES_UPDATE,
																 Settings::FIELD_EXCHANGE_RATES_PROVIDER,
																 __('Exchange rates provider', 'wc-aelia-eu-vat-assistant'),
																 $this->_settings_controller->exchange_rates_providers_options(),
																 __('Select the Provider from which the exchange rates will be fetched.', 'wc-aelia-eu-vat-assistant'),
																 'exchange_rates_provider');
		// Render the exchange rates table
		$this->render_exchange_rates_fields();

		// Sales
		$this->render_dropdown_field(self::SECTION_SALE_RESTRICTIONS,
																 Settings::FIELD_SALE_DISALLOWED_COUNTRIES,
																 __('Prevent sales to these countries', 'wc-aelia-eu-vat-assistant'),
																 wc()->countries->countries,
																 __('Here you can add a list of countries to which you do not want ' .
																		'to sell. The countries in this list will not appear to the customer ' .
																		'at any stage, thus preventing him from completing an order. Leave ' .
																		'this field empty to allow sales to all countries configured in ' .
																		'<strong>WooCommerce > Settings</strong> section.', 'wc-aelia-eu-vat-assistant'),
																 'multi_country_selector',
																 array('multiple' => 'multiple'));
		// Sales
		$woocommerce_tax_classes = $tax_classes = array_filter(array_map('trim', explode("\n", get_option('woocommerce_tax_classes'))));
		$available_tax_classes = array(
			// The "Standard" tax class actually has a blank key
			'' => 'Standard',
		);
		foreach($woocommerce_tax_classes as $tax_class_name) {
			$available_tax_classes[sanitize_title($tax_class_name)] = $tax_class_name;
		}
		$this->render_dropdown_field(self::SECTION_REPORTS,
																 Settings::FIELD_TAX_CLASSES_EXCLUDED_FROM_MOSS,
																 __('The following tax classes should not be included in MOSS reports', 'wc-aelia-eu-vat-assistant'),
																 $available_tax_classes,
																 __('Here you can select one or more tax classes whose rates should ' .
																		'be excluded from MOSS reports. The tax information for ' .
																		'those rates will still be tracked, this setting will just ' .
																		'be used to filter the data using the report filters ' .
																		'in the <strong>Reports</strong> interface.', 'wc-aelia-eu-vat-assistant'),
																 'moss_excluded_tax_classes',
																 array('multiple' => 'multiple'));
		// Options
		$this->render_text_field(self::SECTION_OPTIONS,
														 Settings::FIELD_VAT_ROUNDING_DECIMALS,
														 __('Decimals for VAT rounding', 'wc-aelia-eu-vat-assistant'),
														 __('The amount of decimals to use when rounding VAT. This setting ' .
																'applies when the VAT evidence is generated (for example during ' .
																'the conversion of VAT totals to the appropriate VAT currency). ' .
																'If you are not sure of how many decimals you should use, please ' .
																'contact your Revenue office.', 'wc-aelia-eu-vat-assistant'),
														 'numeric');

		// Debug
		if(function_exists('wc_get_log_file_path')) {
			$log_file_path = wc_get_log_file_path(Definitions::PLUGIN_SLUG);
		}
		else {
			$log_file_path = sprintf('woocommerce/logs/%s-%s.txt', Definitions::PLUGIN_SLUG, sanitize_file_name(wp_hash(Definitions::PLUGIN_SLUG)));
		}
		$this->render_checkbox_field(self::SECTION_DEBUG,
																 Settings::FIELD_DEBUG_MODE,
																 __('Enable debug mode.', 'wc-aelia-eu-vat-assistant'),
																 sprintf(__('When debug mode is enabled, the plugin will log ' .
																						'events to file <code>%s</code>.', 'wc-aelia-eu-vat-assistant'),
																				 $log_file_path),
																 '');
	}

	/**
	 * Returns the title for the menu item that will bring to the plugin's
	 * settings page.
	 *
	 * @return string
	 */
	protected function menu_title() {
		return __('EU VAT Assistant', 'wc-aelia-eu-vat-assistant');
	}

	/**
	 * Returns the slug for the menu item that will bring to the plugin's
	 * settings page.
	 *
	 * @return string
	 */
	protected function menu_slug() {
		return Definitions::MENU_SLUG;
	}

	/**
	 * Returns the title for the settings page.
	 *
	 * @return string
	 */
	protected function page_title() {
		return __('EU VAT Assistant - Settings', 'wc-aelia-eu-vat-assistant') .
					 sprintf('&nbsp;(v. %s)', WC_Aelia_EU_VAT_Assistant::$version);
	}

	/**
	 * Returns the description for the settings page.
	 *
	 * @return string
	 */
	protected function page_description() {
		// TODO Restore link to documentation
		return __('In this page you can configure the settings for the EU VAT Assistant plugin.', 'wc-aelia-eu-vat-assistant');
	}

	/*** Settings sections callbacks ***/
	public function checkout_section_callback() {
		echo __('Here you can configure various parameters related to checkout.', 'wc-aelia-eu-vat-assistant');

		echo '<noscript>';
		echo __('This page requires JavaScript to work properly. Please enable JavaScript ' .
						'in your browser and refresh the page.</u>.', 'wc-aelia-eu-vat-assistant');
		echo '</noscript>';
	}

	public function self_certification_section_callback() {
		echo __('Here you can decide to display an additional self-certification field that ' .
						'customers can use to confirm their country of residence.', 'wc-aelia-eu-vat-assistant');
	}

	public function currency_section_callback() {
		// Dummy
	}

	public function exchange_rates_update_section_callback() {
		// Dummy
	}

	public function exchange_rates_section_callback() {
		echo __('These exchange rates will be used to convert ' .
						'the order amounts (totals, VAT, etc) in the currency you use to file your VAT returns. ' .
						'<strong>Important</strong>: you can enter the exchange rates manually, if you wish, but ' .
						'please make sure that they are in line with the values that your Revenue office would ' .
						'consider acceptable. The responsibility of ensuring that the rates are correct lies ' .
						'upon you. If you are in doubt, please contact your revenue office to determine which ' .
						'exchange rates they would consider acceptable. Most revenue offices have their own ' .
						'list of exchange rates, which you can enter here.', 'wc-aelia-eu-vat-assistant');
		echo '<br /><br />';
		echo __('To set an exchange rate manually, tick the box next to the exchange rate field ' .
						'for the desired currency and enter the rate in the exchange rate field itself. ' .
						'The checkbox next to the "<strong>Set manually</strong>" label will select/deselect the checkboxes ' .
						'for all the currencies. <strong>Important</strong>: ensure that all exchange rates ' .
						'you flagged to be entered manually are filled. An empty exchange rate could lead to ' .
						'unpredictable results, as it\'s intepreted as zero.', 'wc-aelia-eu-vat-assistant');
	}

	public function sale_restrictions_section_callback() {
		// Dummy
	}

	public function reports_section_callback() {
		// Dummy
	}

	public function options_section_callback() {
		echo __('Miscellaneous options.', 'wc-aelia-eu-vat-assistant');
	}

	public function links_section_callback() {
		?>
		<div class="links">
			<p><?php
				echo __('This section contains some convenient links to the ' .
								'sections of WooCommerce relevant to EU VAT compliance', 'wc-aelia-eu-vat-assistant');
			?></p>
			<div class="settings">
				<h4 class="title"><?php
					echo __('Settings', 'wc-aelia-eu-vat-assistant');
				?></h4>
				<ul>
					<li class="tax">
						<a href="<?php echo admin_url('admin.php?page=wc-settings&tab=tax'); ?>"><?php
							echo __('Tax Settings', 'wc-aelia-eu-vat-assistant');
						?></a>
					</li>
				</ul>
			</div>
			<div class="reports">
				<h4 class="title"><?php
					echo __('Reports', 'wc-aelia-eu-vat-assistant');
				?></h4>
				<ul>
					<li class="eu_vat_report">
						<a href="<?php echo admin_url('admin.php?page=wc-reports&tab=taxes&report=eu_vat_by_country_report'); ?>"><?php
							echo __('EU VAT By Country', 'wc-aelia-eu-vat-assistant');
						?></a>
					</li>
				</ul>
			</div>
		</div>
		<?php
	}

	public function support_section_callback() {
		echo '<div class="support_information">';
		echo '<p>';
		echo __('We designed this plugin to be robust and effective, ' .
						'as well as intuitive and easy to use. However, we are aware that, despite ' .
						'all best efforts, issues can arise and that there is always room for ' .
						'improvement.', 'wc-aelia-eu-vat-assistant');
		echo '</p>';
		echo '<p>';
		echo __('Should you need assistance, or if you just would like to get in touch ' .
						'with us, please use one of the links below.', 'wc-aelia-eu-vat-assistant');
		echo '</p>';

		// Support links
		echo '<ul id="contact_links">';
		echo '<li>' . sprintf(__('<span class="label">To request support</span>, please use our <a href="%s">Support portal</a>. ' .
														 'The portal also contains a Knowledge Base, where you can find the ' .
														 'answers to the most common questions related to our products.', 'wc-aelia-eu-vat-assistant'),
													self::SUPPORT_URL) . '</li>';
		echo '<li>' . sprintf(__('<span class="label">To send us general feedback</span>, suggestions, or enquiries, please use ' .
														 'the <a href="%s">contact form on our website.</a>', 'wc-aelia-eu-vat-assistant'),
													self::CONTACT_URL) . '</li>';
		echo '</ul>';

		echo '</div>';
	}

	public function debug_section_callback() {
	}

	/*** Rendering methods ***/
	/**
	 * Renders the buttons at the bottom of the settings page.
	 */
	protected function render_buttons() {
		parent::render_buttons();
		submit_button(__('Save and update exchange rates', 'wc-aelia-eu-vat-assistant'),
									'secondary',
									$this->_settings_key . '[update_exchange_rates_button]',
									false);
	}

	protected function render_exchange_rates_fields() {
		// Prepare fields to display the Exchange Rate options for each selected currency
		$exchange_rates_field_id = Settings::FIELD_EXCHANGE_RATES;
		$exchange_rates = $this->current_settings($exchange_rates_field_id, $this->default_settings($exchange_rates_field_id, array()));
		// Add "Exchange Rates" table
		add_settings_field(
			$exchange_rates_field_id,
			'', // No label needed
			array($this, 'render_exchange_rates_options'),
			$this->_settings_key,
			self::SECTION_EXCHANGE_RATES,
			array(
				'settings_key' => $this->_settings_key,
				'exchange_rates' => $exchange_rates,
				'id' => $exchange_rates_field_id,
				'label_for' => $exchange_rates_field_id,
				// Input field attributes
				'attributes' => array(
					'class' => $exchange_rates_field_id,
				),
			)
		);
	}

	/**
	 * Renders a table containing several fields that admins can use to configure
	 * the Exchange Rates for the various currencies.
	 *
	 * @param array args An array of arguments passed by add_settings_field().
	 * @see add_settings_field().
	 */
	public function render_exchange_rates_options($args) {
		/* Generate the base field ID and field name that will be used to dynamically
		 * create the hierarchy of fields for the exchange rates. Every field will
		 * have a name like "base_field_id[currency]", so that PHP will automatically
		 * build a hierarchy out of them when the settings will be saved.
		 *
		 * Note: $base_field_id and $base_field_name are output parameters, they will
		 * be populated by the method.
		 */
		$this->get_field_ids($args, $base_field_id, $base_field_name);

		//var_dump($args);die();
		// Retrieve the enabled currencies
		$currencies = $this->add_currency_labels($this->_settings_controller->enabled_currencies());
		// Retrieve the exchange rates
		$exchange_rates = get_value(Settings::FIELD_EXCHANGE_RATES, $args, array());
		if(!is_array($exchange_rates)) {
			//var_dump($exchange_rates);return;
			throw new InvalidArgumentException(__('Argument "exchange_rates" must be an array.', 'wc-aelia-eu-vat-assistant'));
		}

		// Retrieve the Currency used internally by WooCommerce
		$vat_currency = $this->_settings_controller->vat_currency();

		$html = '<table id="exchange_rates_settings">';
		// Table header
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th class="currency_name">' . __('Currency', 'wc-aelia-eu-vat-assistant') . '</th>';
		$html .= '<th class="exchange_rate">' . __('Exchange Rate', 'wc-aelia-eu-vat-assistant') . '</th>';
		$html .= '<th class="set_manually">' .
						 __('Set Manually', 'wc-aelia-eu-vat-assistant') .
						 '<input type="checkbox" id="set_manually_all" />' .
						 '</th>';
		//$html .= '<th class="rate_markup">';
		//$html .= __('Rate Markup', 'wc-aelia-eu-vat-assistant');
		//$html .= '<span class="help-icon" title="' .
		//				 __('If specified, this markup will be added to the standard ' .
		//						'exchange rate. Markup must be an absolute value. Example: ' .
		//						'if you have an exchange rate of 1.34 enter a markup of 0.05. ' .
		//						'The final exchange rate will then be (1.34 + 0.05) = 1.39', 'wc-aelia-eu-vat-assistant') .
		//				 '"></span>';
		$html .= '</th>';

		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';

		// Render one line to display settings for base currency
		$html .= $this->render_settings_for_vat_currency($vat_currency,
																										 $currencies[$vat_currency],
																										 $exchange_rates,
																										 $base_field_id,
																										 $base_field_name);

		foreach($currencies as $currency => $currency_name) {
			// No need to render an Exchange Rate for main currency, as it would be 1:1
			if($currency == $vat_currency) {
				continue;
			}

			$currency_field_id = $this->group_field($currency, $base_field_id);
			$currency_field_name = $this->group_field($currency, $base_field_name);
			$html .= '<tr>';
			// Output currency label
			$html .= '<td class="currency_name">';
			$html .= "<span>$currency_name ($currency)</span>";
			$html .= '</td>';

			$currency_settings = get_value($currency, $exchange_rates, array());
			$currency_settings = array_merge($this->_settings_controller->default_currency_settings(), $currency_settings);
			//var_dump($currency_settings);

			// Render exchange rate field
			$html .= '<td class="exchange_rate">';
			$field_args = array(
				'id' => $currency_field_id . '[rate]',
				'value' => get_value('rate', $currency_settings, ''),
				'attributes' => array(
					'class' => 'numeric',
				),
			);
			ob_start();
			$this->render_textbox($field_args);
      $field_html = ob_get_contents();
      ob_end_clean();
			$html .= $field_html;
			$html .= '</td>';

			//var_dump($currency_settings);
			// Render "Set Manually" checkbox
			$html .= '<td class="set_manually">';
			$field_args = array(
				'id' => $currency_field_id . '[set_manually]',
				'value' => 1,
				'attributes' => array(
					'class' => '',
					'checked' => get_value('set_manually', $currency_settings),
				),
			);
			ob_start();
			$this->render_checkbox($field_args);
			$field_html = ob_get_contents();
			ob_end_clean();
			$html .= $field_html;
			$html .= '</td>';

			// Render exchange rate markup field
			//$html .= '<td>';
			//$field_args = array(
			//	'id' => $currency_field_id . '[rate_markup]',
			//	'value' => get_value('rate_markup', $currency_settings, ''),
			//	'attributes' => array(
			//		'class' => 'numeric',
			//	),
			//);
			//ob_start();
			//$this->render_textbox($field_args);
			//$field_html = ob_get_contents();
			//ob_end_clean();
			//$html .= $field_html;
			//$html .= '</td>';
			$html .= '</tr>';
		}

		$html .= '</tbody>';
		$html .= '</table>';

		echo $html;
	}

	/**
	 * Renders a "special" row on the exchange rates table, which contains the
	 * settings for the base currency.
	 *
	 * @param string currency The currency to display on the row.
	 * @param string exchange_rates An array of currency settings.
	 * @param string base_field_id The base ID that will be assigned to the
	 * fields in the row.
	 * @param string base_field_id The base name that will be assigned to the
	 * fields in the row.
	 * @return string The HTML for the row.
	 */
	protected function render_settings_for_vat_currency($currency, $currency_name, $exchange_rates, $base_field_id, $base_field_name) {
		$currency_field_id = $this->group_field($currency, $base_field_id);
		$currency_field_name = $this->group_field($currency, $base_field_name);

		$html = '<tr>';
		// Output currency label
		$html .= '<td class="currency_name">';
		$html .= "<span>$currency_name ($currency)</span>";
		$html .= '</td>';

		$currency_settings = get_value($currency, $exchange_rates, array());
		$currency_settings = array_merge($this->_settings_controller->default_currency_settings(), $currency_settings);
		//var_dump($currency_settings);

		// Render exchange rate field
		$html .= '<td class="exchange_rate numeric">';
		$html .= '1'; // Exchange rate for base currency is always 1
		$html .= '</td>';

		// Render "Set Manually" checkbox
		$html .= '<td>';
		$html .= '</td>';

		// Render exchange rate markup field
		//$html .= '<td>';
		//$html .= '</td>';
		$html .= '</tr>';

		return $html;
	}
}
