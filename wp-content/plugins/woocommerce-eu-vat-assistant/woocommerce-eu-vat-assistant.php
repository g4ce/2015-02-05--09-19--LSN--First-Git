<?php if(!defined('ABSPATH')) exit; // Exit if accessed directly
/*
Plugin Name: WooCommerce EU VAT Assistant
Description: Assists with EU VAT compliance, for the new VAT regime beginning 1st January 2015.
Author: <a href="http://aelia.co">Aelia (Diego Zanella)</a>
Version: 1.1.6.150126
Text Domain: wc-aelia-eu-vat-assistant
*/

require_once(dirname(__FILE__) . '/src/lib/classes/install/aelia-wc-eu-vat-assistant-requirementscheck.php');
// If requirements are not met, deactivate the plugin
if(Aelia_WC_EU_VAT_Assistant_RequirementsChecks::factory()->check_requirements()) {
	require_once dirname(__FILE__) . '/src/plugin-main.php';

	// Check for plugin updates
	Aelia\WC\EU_VAT_Assistant\WC_Aelia_EU_VAT_Assistant::instance()->check_for_updates(__FILE__, 'woocommerce-eu-vat-assistant');
}
