<?php
namespace Aelia\WC\EU_VAT_Assistant\Reports;
if(!defined('ABSPATH')) exit; // Exit if accessed directly

use Aelia\WC\EU_VAT_Assistant\WC_Aelia_EU_VAT_Assistant;

/**
 * Renders the report containing the EU VAT for each country in a specific
 * period.
 */
abstract class Base_EU_VAT_By_Country_Report extends \Aelia\WC\EU_VAT_Assistant\Reports\Base_Report {
	/**
	 * Returns the tax data for the report.
	 *
	 * @return array The tax data.
	 */
	protected function get_tax_data() {
		global $wpdb;
		$wpdb->show_errors();

		$dataset = $this->get_order_report_data(array(
			'data' => array(
				'_eu_vat_data' => array(
					'type' => 'meta',
					'order_item_type' => '',
					'function' => '',
					'name' => '_eu_vat_data'
				),
			),
			'query_type' => 'get_results',
			'group_by' => '',
			'order_types' => array('shop_order'),
			'order_status' => array('processing', 'completed')
		));

		$tax_data = array();
		foreach($dataset as $data) {
			$eu_vat_data = maybe_unserialize($data->_eu_vat_data);

			$vat_currency_exchange_rate = $eu_vat_data['vat_currency_exchange_rate'];
			$taxes_recorded = get_value('taxes', $eu_vat_data, array());
			foreach($taxes_recorded as $rate_id => $tax_details) {
				if(!isset($tax_data[$rate_id])) {
					$tax_data[$rate_id] = (object)array(
						'items_tax_amount' => 0,
						'shipping_tax_amount' => 0,
						'refunded_items_tax_amount' => 0,
						'refunded_shipping_tax_amount' => 0,
						// Sales information
						'items_total' => 0,
						'shipping_total' => 0,
						'refunded_items_total' => 0,
						'refunded_shipping_total' => 0,

						'tax_rate_data' => (object)array(
							'label' => $tax_details['label'],
							'tax_rate' => $tax_details['vat_rate'],
							'tax_rate_country' => $tax_details['country'],
						),
					);
				}

				$tax_amounts = $tax_details['amounts'];
				$tax_data[$rate_id]->items_tax_amount += wc_round_tax_total($tax_amounts['items_total']  * $vat_currency_exchange_rate);
				$tax_data[$rate_id]->shipping_tax_amount += wc_round_tax_total($tax_amounts['shipping_total']  * $vat_currency_exchange_rate);

				$items_tax_refund = get_value('items_refund', $tax_amounts, 0);
				$shipping_tax_refund = get_value('shipping_refund', $tax_amounts, 0);
				$tax_data[$rate_id]->refunded_items_tax_amount += wc_round_tax_total($items_tax_refund * $vat_currency_exchange_rate);
				$tax_data[$rate_id]->refunded_shipping_tax_amount += wc_round_tax_total($shipping_tax_refund * $vat_currency_exchange_rate);

				// Sales data
				$vat_rate = $tax_details['vat_rate'] / 100;
				$tax_data[$rate_id]->items_total += wc_round_tax_total($tax_amounts['items_total'] / $vat_rate * $vat_currency_exchange_rate);
				$tax_data[$rate_id]->shipping_total += wc_round_tax_total($tax_amounts['shipping_total'] / $vat_rate * $vat_currency_exchange_rate);
				$tax_data[$rate_id]->refunded_items_total += wc_round_tax_total($items_tax_refund / $vat_rate* $vat_currency_exchange_rate);
				$tax_data[$rate_id]->refunded_shipping_total += wc_round_tax_total($shipping_tax_refund / $vat_rate * $vat_currency_exchange_rate);
			}
		}

		// TODO Add sales totals grouped by tax rate
		/* NOTES
		 * - Tax rate can be calculated by dividing the line_tax by the tax_total
		 * - Sale totals must be calculated in a second pass. If we add line_total and tax_total to
		 *   the query, it will return one line per order product. However, each line will also contain
		 *   ALL the taxes for the entire order, which would be processed multiple times.
		 */
		return $tax_data;
	}

	/**
	 * Retrieves the refunds for the specified period and adds them to the tax
	 * data.
	 *
	 * @param array tax_data The tax data to which refund details should be added.
	 * @return array The tax data including the refunds applied in the specified
	 * period.
	 */
	protected function get_tax_refunds_data($tax_data) {
		// This method must be implemented by descendant classes
		return $tax_data;
	}

	/**
	 * Reorganises the tax data, grouping and sorting it by country.
	 *
	 * @param array tax_data The tax data.
	 */
	protected function key_by_tax_country($tax_data) {
		$result = array();
		foreach($tax_data as $rate_id => $data) {
			/* The tax should be paid to the country specified in "tax payable to
			 * country" field. If that field is empty, then take the tax country instead
			 */
			$country_code = get_value('tax_payable_to_country', $data->tax_rate_data, $data->tax_rate_data->tax_rate_country);
			if(empty($result[$country_code])) {
				$result[$country_code] = array();
			}
			$result[$country_code][$rate_id] = $data;
		}
		ksort($result);
		return $result;
	}

	/**
	 * Get the data for the report.
	 *
	 * @return string
	 */
	public function get_main_chart() {
		$tax_data = $this->get_tax_data();
		// Add the refunds to the tax data
		$tax_data = $this->get_tax_refunds_data($tax_data);


		// Debug
		//var_dump($tax_data);

		// Reorganise VAT information, associating it to each country and sorting it
		// by country code
		$taxes_by_country = $this->key_by_tax_country($tax_data);

		$eu_countries = WC_Aelia_EU_VAT_Assistant::instance()->get_eu_vat_countries();
		?>
		<div id="eu_vat_report" class="wc_aelia_eu_vat_assistant report">
			<table class="widefat">
				<thead>
					<tr>
						<th colspan="15">
							<span class="label"><?php
							echo __('Currency for VAT returns:', 'wc-aelia-eu-vat-assistant');
							?></span>
							<span><?php echo $this->vat_currency(); ?></span>
						</th>
					</tr>
					<tr>
						<th colspan="5"></th>
						<th colspan="4" class="column_group header"><?php echo __('Items', 'wc-aelia-eu-vat-assistant'); ?></th>
						<th colspan="4" class="column_group header"><?php echo __('Shipping', 'wc-aelia-eu-vat-assistant'); ?></th>
						<th colspan="2">&nbsp;</th>
					</tr>
					<tr>
						<th class="country_name"><?php echo __('Payable to Country', 'wc-aelia-eu-vat-assistant'); ?></th>
						<th class="country_code"><?php echo __('Country Code (Payable)', 'wc-aelia-eu-vat-assistant'); ?></th>
						<th class="country_name"><?php echo __('Country', 'wc-aelia-eu-vat-assistant'); ?></th>
						<th class="country_code"><?php echo __('Country Code (Applied)', 'wc-aelia-eu-vat-assistant'); ?></th>
						<th class="tax_rate"><?php echo __('Tax Rate', 'wc-aelia-eu-vat-assistant'); ?></th>

						<!-- Items -->
						<th class="total_row column_group left"><?php echo __('Sales', 'wc-aelia-eu-vat-assistant'); ?></th>
						<th class="total_row column_group "><?php echo __('Refunds', 'wc-aelia-eu-vat-assistant'); ?></th>
						<th class="total_row column_group "><?php echo __('VAT Charged', 'wc-aelia-eu-vat-assistant'); ?></th>
						<th class="total_row column_group right"><?php echo __('VAT Refunded', 'wc-aelia-eu-vat-assistant'); ?></th>

						<!-- Shipping -->
						<th class="total_row column_group left"><?php echo __('Shipping charged', 'wc-aelia-eu-vat-assistant'); ?></th>
						<th class="total_row column_group "><?php echo __('Shipping refunded', 'wc-aelia-eu-vat-assistant'); ?></th>
						<th class="total_row column_group "><?php echo __('VAT Charged', 'wc-aelia-eu-vat-assistant'); ?></th>
						<th class="total_row column_group right"><?php echo __('VAT Refunded', 'wc-aelia-eu-vat-assistant'); ?></th>

						<!-- Totals -->
						<th class="total_row"><?php echo __('Total charged', 'wc-aelia-eu-vat-assistant'); ?></th>
						<th class="total_row"><?php echo __('Final VAT Total', 'wc-aelia-eu-vat-assistant'); ?></th>
					</tr>
				</thead>
				<?php if(empty($taxes_by_country)) : ?>
					<tbody>
						<tr>
							<td colspan="15"><?php echo __('No VAT has been processed in this period', 'wc-aelia-eu-vat-assistant'); ?></td>
						</tr>
					</tbody>
				<?php else : ?>
					<tbody>
						<?php
						$tax_grand_totals = array(
							'items_tax_amount' => 0,
							'refunded_items_tax_amount' => 0,
							'shipping_tax_amount' => 0,
							'refunded_shipping_tax_amount' => 0,
						);
						foreach($taxes_by_country as $country_code => $tax_data) {
							foreach($tax_data as $rate_id => $tax_row) {
								$rate = $tax_row->tax_rate_data;
								if(!empty($tax_row->tax_rate_country) && !in_array($rate->tax_rate_country, $eu_countries)) {
									continue;
								}

								$tax_payable_to_country = get_value('tax_payable_to_country', $rate, $rate->tax_rate_country)
								?>
								<tr>
									<th class="country_name" scope="row"><?php echo esc_html(WC()->countries->countries[$tax_payable_to_country]); ?></th>
									<th class="country_code" scope="row"><?php echo esc_html($tax_payable_to_country); ?></th>
									<th class="country_name" scope="row"><?php echo esc_html(WC()->countries->countries[$rate->tax_rate_country]); ?></th>
									<th class="country_code" scope="row"><?php echo esc_html($rate->tax_rate_country); ?></th>
									<td class="tax_rate"><?php echo number_format(apply_filters('woocommerce_reports_taxes_rate', $rate->tax_rate, $rate_id, $tax_row), 2); ?>%</td>

									<!-- Items -->
									<td class="total_row column_group left"><?php echo $this->format_price($tax_row->items_total); ?></td>
									<td class="total_row column_group "><?php echo $this->format_price($tax_row->refunded_items_total); ?></td>
									<td class="total_row column_group "><?php echo $this->format_price($tax_row->items_tax_amount); ?></td>
									<td class="total_row column_group right"><?php echo $this->format_price($tax_row->refunded_items_tax_amount * -1); ?></td>

									<!-- Shipping -->
									<td class="total_row column_group left"><?php echo $this->format_price($tax_row->shipping_total); ?></td>
									<td class="total_row column_group "><?php echo $this->format_price($tax_row->refunded_shipping_total); ?></td>
									<td class="total_row column_group "><?php echo $this->format_price($tax_row->shipping_tax_amount); ?></td>
									<td class="total_row column_group right"><?php echo $this->format_price($tax_row->refunded_shipping_tax_amount * -1); ?></td>

									<!-- Total -->
									<td class="total_row"><?php
										echo $this->format_price($tax_row->items_total
																						 + $tax_row->shipping_total
																						 - $tax_row->refunded_items_total
																						 - $tax_row->refunded_shipping_total);
									?></td>
									<td class="total_row"><?php
										echo $this->format_price($tax_row->items_tax_amount
																						 + $tax_row->shipping_tax_amount
																						 - $tax_row->refunded_items_tax_amount
																						 - $tax_row->refunded_shipping_tax_amount);
									?></td>
								</tr>
								<?php

								// Calculate grand totals
								$tax_grand_totals['items_tax_amount'] += $tax_row->items_tax_amount;
								$tax_grand_totals['refunded_items_tax_amount'] += $tax_row->refunded_items_tax_amount;
								$tax_grand_totals['shipping_tax_amount'] += $tax_row->shipping_tax_amount;
								$tax_grand_totals['refunded_shipping_tax_amount'] += $tax_row->refunded_shipping_tax_amount;

								// Sales data
								$tax_grand_totals['items_total'] += $tax_row->items_total;
								$tax_grand_totals['refunded_items_total'] += $tax_row->refunded_items_total;
								$tax_grand_totals['shipping_total'] += $tax_row->shipping_total;
								$tax_grand_totals['refunded_shipping_total'] += $tax_row->refunded_shipping_total;
							}
						}
						?>
					</tbody>
					<!--- VAT Totals --->
					<tfoot id="vat-grand-totals">
						<tr>
							<th class="label" colspan="5"><?php echo __('Totals', 'wc-aelia-eu-vat-assistant'); ?></th>
							<!-- Items -->
							<td class="total_row column_group left"><?php echo $this->format_price($tax_grand_totals['items_total']); ?></td>
							<td class="total_row column_group "><?php echo $this->format_price($tax_grand_totals['refunded_items_total']); ?></td>
							<td class="total_row column_group "><?php echo $this->format_price($tax_grand_totals['items_tax_amount']); ?></td>
							<td class="total_row column_group right"><?php echo $this->format_price($tax_grand_totals['refunded_items_tax_amount'] * -1); ?></td>

							<!-- Shipping -->
							<td class="total_row column_group left"><?php echo $this->format_price($tax_grand_totals['shipping_total']); ?></td>
							<td class="total_row column_group "><?php echo $this->format_price($tax_grand_totals['refunded_shipping_total']); ?></td>
							<td class="total_row column_group "><?php echo $this->format_price($tax_grand_totals['shipping_tax_amount']); ?></td>
							<td class="total_row column_group right"><?php echo $this->format_price($tax_grand_totals['refunded_shipping_tax_amount'] * -1); ?></td>

							<!-- Totals -->
							<td class="total_row"><?php
								echo $this->format_price($tax_grand_totals['items_total']
																				 + $tax_grand_totals['shipping_total']
																				 - $tax_grand_totals['refunded_items_total']
																				 - $tax_grand_totals['refunded_shipping_total']);
							?></td>
							<td class="total_row"><?php
								echo $this->format_price($tax_grand_totals['items_tax_amount']
																				 + $tax_grand_totals['shipping_tax_amount']
																				 - $tax_grand_totals['refunded_items_tax_amount']
																				 - $tax_grand_totals['refunded_shipping_tax_amount']);
							?></td>
						</tr>
					</tfoot>
				<?php endif; ?>
			</table>
		</div>
		<?php
	}
}
