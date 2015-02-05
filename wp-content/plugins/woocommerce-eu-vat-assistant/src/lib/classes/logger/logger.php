<?php
namespace Aelia\WC\EU_VAT_Assistant;
if(!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Writes to the log used by the plugin.
 */
class Logger extends \Aelia\WC\Logger {
	/**
	 * Retrieves the value of "debug mode" setting.
	 *
	 * @return bool
	 */
	protected function get_debug_mode() {
		return WC_Aelia_EU_VAT_Assistant::settings()->get('debug_mode', false);
	}
}
