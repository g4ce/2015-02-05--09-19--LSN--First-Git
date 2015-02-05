<?php
namespace Aelia\WC\EU_VAT_Assistant;
if(!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Runs automatic updates for the EU VAT Assistant plugin.
 **/
class WC_Aelia_EU_VAT_Assistant_Install extends \Aelia\WC\Aelia_Install {
	// @var string The name of the lock that will be used by the installer to prevent race conditions.
	protected $lock_name = 'WC_AELIA_EU_VAT_ASSISTANT';

	/**
	 * Updated the VAT data for the orders saved by the EU VAT Assistant 0.9.8.x.
	 * and earlier.
	 *
	 * @return bool
	 * @since 0.9.9.141223
	 */
	protected function update_to_0_9_9_141223() {
		// Retrieve the exchange rates for the orders whose data already got
		// partially converted
		$SQL = "
			SELECT
				PM.post_id AS order_id
				,PM.meta_value AS eu_vat_data
			FROM
				{$this->wpdb->postmeta} AS PM
			WHERE
				(PM.meta_key = '_eu_vat_data')
		";

		$orders_to_update = $this->select($SQL);
		// Debug
		//var_dump($orders_to_update); die();

		foreach($orders_to_update as $order_meta) {
			// Skip VAT data that is already in the correct format
			$vat_data_version = get_value('eu_vat_assistant_version', $order_meta->eu_vat_data);
			if(version_compare($vat_data_version, '0.9.9.141223', '>=')) {
				continue;
			}

			// Add tax rate details to the all orders having VAT data that doesn't
			// already contain such information
			$order = new Order($order_meta->order_id);
			$order->update_vat_data();
		}
		return true;
	}

	/**
	 * Updated the VAT data for the orders saved by the EU VAT Assistant 0.10.0.x
	 * and earlier.
	 *
	 * @return bool
	 * @since 0.10.1.141230
	 */
	protected function update_to_0_10_1_141230() {
		// Retrieve the exchange rates for the orders whose data already got
		// partially converted
		$SQL = "
			SELECT
				PM.post_id AS order_id
				,PM.meta_value AS eu_vat_data
			FROM
				{$this->wpdb->postmeta} AS PM
			WHERE
				(PM.meta_key = '_eu_vat_data')
		";

		$orders_to_update = $this->select($SQL);
		// Debug
		//var_dump($orders_to_update); die();

		foreach($orders_to_update as $order_meta) {
			// Skip VAT data that is already in the correct format
			$vat_data_version = get_value('eu_vat_assistant_version', $order_meta->eu_vat_data);
			if(version_compare($vat_data_version, '0.10.1.141230', '>=')) {
				continue;
			}

			// Add tax rate details to the all orders having VAT data that doesn't
			// already contain such information
			$order = new Order($order_meta->order_id);
			$order->update_vat_data();
		}
		return true;
	}

	protected function update_to_1_1_3_150111() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'woocommerce_tax_rates';
		$column_name = 'tax_payable_to_country';
		if($this->column_exists($table_name, $column_name)) {
			return true;
		}

		return $this->add_column($table_name, $column_name);
	}

	/**
	 * Overrides standard update method to ensure that requirements for update are
	 * in place.
	 *
	 * @param string plugin_id The ID of the plugin.
	 * @param string new_version The new version of the plugin, which will be
	 * stored after a successful update to keep track of the status.
	 * @return bool
	 */
	public function update($plugin_id, $new_version) {
		//delete_option($plugin_id);
		return parent::update($plugin_id, $new_version);
	}
}
