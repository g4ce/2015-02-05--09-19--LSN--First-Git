<?php
namespace Aelia\WC\EU_VAT_Assistant;
if(!defined('ABSPATH')) exit; // Exit if accessed directly

use \Aelia\WC\Messages;
use \WP_Error;

/**
 * Implements a base class to store and handle the messages returned by the
 * plugin. This class is used to extend the basic functionalities provided by
 * standard WP_Error class.
 */
class Definitions {
	// @var string The menu slug for plugin's settings page.
	const MENU_SLUG = 'wc_aelia_eu_vat_assistant';
	// @var string The plugin slug
	const PLUGIN_SLUG = 'wc-aelia-eu-vat-assistant';
	// @var string The plugin text domain
	const TEXT_DOMAIN = 'wc-aelia-eu-vat-assistant';

	// GET/POST Arguments
	const ARG_COUNTRY = 'country';
	const ARG_VAT_NUMBER = 'vat_number';
	const ARG_LOCATION_SELF_CERTIFICATION = 'customer_location_self_certified';

	// Session constants

	// Transients
	const TRANSIENT_EU_NUMBER_VALIDATION_RESULT = 'aelia_wc_eu_vat_validation_';
	const TRANSIENT_EU_VAT_RATES = 'aelia_wc_eu_vat_rates';

	// Error codes
	const RES_OK = 0;
	const ERR_INVALID_TEMPLATE = 1001;
	const ERR_INVALID_SOURCE_CURRENCY = 1103;
	const ERR_INVALID_DESTINATION_CURRENCY = 1104;
	const ERR_INVALID_EU_VAT_NUMBER = 5001;

	const YES = 'yes';
	const NO = 'no';
	const VAT_NUMBER_VALIDATION_NO_NUMBER = 'no-number';
	const VAT_NUMBER_VALIDATION_VALID = 'valid';
	const VAT_NUMBER_VALIDATION_NOT_VALID = 'not-valid';
	const VAT_NUMBER_VALIDATION_NON_EU = 'non-eu';
}
