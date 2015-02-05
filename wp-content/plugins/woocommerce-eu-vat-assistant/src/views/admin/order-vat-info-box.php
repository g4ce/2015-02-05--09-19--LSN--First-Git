<?php
if(!defined('ABSPATH')) exit; // Exit if accessed directly

use Aelia\WC\EU_VAT_Assistant\WC_Aelia_EU_VAT_Assistant;
use Aelia\WC\EU_VAT_Assistant\Settings;

$text_domain = WC_Aelia_EU_VAT_Assistant::$text_domain;
$settings = WC_Aelia_EU_VAT_Assistant::settings();

// VAT Paid data
$vat_info_labels = array(
	'items_total' => __('Items VAT', 'wc-aelia-eu-vat-assistant'),
	'shipping_total' => __('Shipping VAT ', 'wc-aelia-eu-vat-assistant'),
	'items_refund' => __('Items VAT refunded', 'wc-aelia-eu-vat-assistant'),
	'shipping_refund' => __('Shipping VAT refunded', 'wc-aelia-eu-vat-assistant'),
	'shipping_total' => __('Shipping VAT ', 'wc-aelia-eu-vat-assistant'),
	'total' => __('Total VAT', 'wc-aelia-eu-vat-assistant'),
);
$vat_info_labels = apply_filters('wc_aelia_eu_vat_assistant_vat_info_box_labels', $vat_info_labels);
$display_decimals = absint(get_option('woocommerce_price_num_decimals'));

// VAT evidence data
$vat_evidence_labels = array(
	'location' => array(
		'is_eu_country' => __('Customer located in EU', 'wc-aelia-eu-vat-assistant'),
		'billing_country' => __('Billing country', 'wc-aelia-eu-vat-assistant'),
		'shipping_country' => __('Shipping country', 'wc-aelia-eu-vat-assistant'),
		'customer_ip_address' => __('Customer\'s IP address', 'wc-aelia-eu-vat-assistant'),
		'customer_ip_address_country' => __('Country from IP address', 'wc-aelia-eu-vat-assistant'),
		'self_certified' => __('Customer self-certified location', 'wc-aelia-eu-vat-assistant'),
	),
	'exemption' => array(
		'vat_number' => __('Customer\'s VAT number', 'wc-aelia-eu-vat-assistant'),
		'vat_country' => __('Customer\'s VAT country', 'wc-aelia-eu-vat-assistant'),
		'vat_number_validated' => __('VAT number validated', 'wc-aelia-eu-vat-assistant'),
	),
);


// Debug
//var_dump($order->get_vat_data());
//var_dump($order->eu_vat_evidence);

$order_vat_data = $order->get_vat_data();
if(!empty($order_vat_data)) {
	if($order_vat_data['invoice_currency'] == $order_vat_data['vat_currency']) {
		$invoice_currency_column_css = 'hidden';
	}
	$order_vat_totals = $order_vat_data['totals'];
}

/**
 * Renders the table displaying the VAT totals for the order.
 *
 * @param array vat_info An array of VAT information.
 * @param array labels The labels to use for the various totals.
 * @param int display_decimals The amount of decimals to use when displaying VAT amounts.
 */
// TODO Move this function to its own class, to avoid clashes
function render_order_vat_info_table(array $vat_info, array $labels, $display_decimals) {
	$invoice_currency_column_css = '';
	if($vat_info['invoice_currency'] == $vat_info['vat_currency']) {
		$invoice_currency_column_css = 'hidden';
	}
	$exchange_rate = $vat_info['vat_currency_exchange_rate'];
	?>
	<h4 class="subtitle"><?php echo get_value('title', $vat_info, ''); ?></h4>
	<table>
		<thead>
			<tr>
				<td class="label"><!-- Empty --></td>
				<td class="invoice_currency <?php echo $invoice_currency_column_css ?>"><?php
					echo $vat_info['invoice_currency'];
				?></td>
				<td class="vat_currency"><?php
					echo $vat_info['vat_currency'];
				?></td>
			</tr>
		</thead>
		<tbody>
			<!-- Items VAT totals -->
			<tr>
				<td class="label"><?php
					echo $labels['items_total'];
				?></td>
				<td class="amount invoice_currency <?php echo $invoice_currency_column_css ?>"><?php
					echo number_format($vat_info['items_total'], $display_decimals);
				?></td>
				<td class="amount vat_currency"><?php
					echo number_format($vat_info['items_total'] * $exchange_rate, $display_decimals);
				?></td>
			</tr>
			<?php if(!empty($vat_info['items_refund'])): ?>
				<!-- Items VAT refunds -->
				<tr>
					<td class="refund label"><?php
						echo $labels['items_refund'];
						// Make refund negative for display purposes (it will be clearer that
						// it's a refund)
						$vat_info['items_refund'] = $vat_info['items_refund'] * -1;
					?></td>
					<td class="refund amount invoice_currency <?php echo $invoice_currency_column_css ?>"><?php
						echo number_format($vat_info['items_refund'], $display_decimals);
					?></td>
					<td class="refund amount vat_currency"><?php
						echo number_format($vat_info['items_refund'] * $exchange_rate, $display_decimals);
					?></td>
				</tr>
			<?php endif; // Items refund - END ?>
			<!-- Shipping VAT totals -->
			<tr>
				<td class="label"><?php
					echo $labels['shipping_total'];
				?></td>
				<td class="amount invoice_currency <?php echo $invoice_currency_column_css ?>"><?php
					echo number_format($vat_info['shipping_total'], $display_decimals);
				?></td>
				<td class="amount vat_currency"><?php
					echo number_format($vat_info['shipping_total'] * $exchange_rate, $display_decimals);
				?></td>
			</tr>
			<?php if(!empty($vat_info['shipping_refund'])): ?>
			<!-- Shipping VAT refunds -->
			<tr>
				<td class="refund label"><?php
					echo $labels['shipping_refund'];
					// Make refund negative for display purposes (it will be clearer that
					// it's a refund)
					$vat_info['shipping_refund'] = $vat_info['shipping_refund'] * -1;
				?></td>
				<td class="refund amount invoice_currency <?php echo $invoice_currency_column_css ?>"><?php
					echo number_format($vat_info['shipping_refund'], $display_decimals);
				?></td>
				<td class="refund amount vat_currency"><?php
					echo number_format($vat_info['shipping_refund'] * $exchange_rate, $display_decimals);
				?></td>
			</tr>
			<?php endif; // Shipping refund - END ?>
		</tbody>
		<tfoot>
			<!-- Grand totals -->
			<tr>
				<td class="label"><?php
					echo $labels['total'];
				?></td>
				<td class="amount invoice_currency <?php echo $invoice_currency_column_css ?>"><?php
					echo number_format($vat_info['total'], $display_decimals);
				?></td>
				<td class="amount vat_currency"><?php
					echo number_format($vat_info['total'] * $exchange_rate, $display_decimals);
				?></td>
			</tr>
		</tfoot>
	</table>
<?php
}

/**
 * Renders the table displaying the VAT totals for the order.
 *
 * @param array vat_info An array of VAT information.
 * @param array labels The labels to use for the various totals.
 * @param int display_decimals The amount of decimals to use when displaying VAT amounts.
 */
// TODO Move this function to its own class, to avoid clashes
function render_order_vat_evidence_list(array $vat_evidence, array $labels) {
?>
	<table class="data">
		<tbody><?php
			foreach($vat_evidence as $evidence_key => $evidence_value) { ?>
				<tr>
					<td class="label"><?php echo $labels[$evidence_key]; ?></td>
					<td class="value"><?php echo $evidence_value; ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php
}

// TODO Add button to manually recalculate the taxes
?>
<div id="woocommerce_eu_vat_order_vat_info_box">
	<!-- VAT info section -->
	<div id="vat_info">
		<?php if(empty($order_vat_totals) || (get_value('total', $order_vat_totals, 0) == 0)) : ?>
			<div id="no_vat_paid_message"><?php
				echo __('No VAT was paid on this order.', 'wc-aelia-eu-vat-assistant');
			?></div>
		<?php else: ?>
			<div class="vat_currency">
				<div><?php
					echo __('VAT Currency:', 'wc-aelia-eu-vat-assistant');
					?>
					<span class="currency"><?php
						echo $order_vat_data['vat_currency'];
					?></span>
				</div>
				<div><?php
					echo sprintf(__('Exchange rate (%s to %s):', 'wc-aelia-eu-vat-assistant'),
											 $order_vat_data['invoice_currency'],
											 $order_vat_data['vat_currency']);
					?>
					<span class="exchange_rate"><?php
						echo number_format($order_vat_data['vat_currency_exchange_rate'], 4);
					?></span>
				</div>
				<div><?php
					echo __('Exchange rate retrieved on:', 'wc-aelia-eu-vat-assistant');
					?>
					<span class="exchange_rate_timestamp"><?php
						if(!empty($order_vat_data['vat_currency_exchange_rate_timestamp'])) {
							$exchange_rate_update_timestamp = date_i18n(get_datetime_format(), $order_vat_data['vat_currency_exchange_rate_timestamp']);
						}
						else {
							$exchange_rate_update_timestamp = __('Not recorded', 'wc-aelia-eu-vat-assistant');
						}
						echo $exchange_rate_update_timestamp;
					?></span>
				</div>
				<div><?php
					echo __('Exchange rate provider:', 'wc-aelia-eu-vat-assistant');
					?>
					<span class="exchange_rate_provider"><?php
						$exchange_rates_provider_label = get_value('exchange_rates_provider_label', $order_vat_data, __('Not recorded', 'wc-aelia-eu-vat-assistant'));
						echo $exchange_rates_provider_label;
					?></span>
				</div>
			</div>
			<div class="totals">
				<h4 class="title"><?php echo __('Total VAT', 'wc-aelia-eu-vat-assistant'); ?></h4>
				<div><?php
					// No need to fill $order_vat_totals['title']
					$order_vat_totals['invoice_currency'] = $order_vat_data['invoice_currency'];
					$order_vat_totals['vat_currency'] = $order_vat_data['vat_currency'];
					$order_vat_totals['vat_currency_exchange_rate'] = $order_vat_data['vat_currency_exchange_rate'];

					render_order_vat_info_table($order_vat_totals, $vat_info_labels, $display_decimals);
				?></div>
			</div>
			<div class="totals_by_tax">
				<h4 class="title"><?php echo __('Totals by VAT rate', 'wc-aelia-eu-vat-assistant'); ?></h4>
				<div><?php
					foreach($order_vat_data['taxes'] as $tax_rate_id => $tax_info) {
						$tax_totals = $tax_info['amounts'];
						$tax_totals['title'] = sprintf('%s (%.2f%%)', $tax_info['label'], $tax_info['vat_rate']);
						$tax_totals['invoice_currency'] = $order_vat_data['invoice_currency'];
						$tax_totals['vat_currency'] = $order_vat_data['vat_currency'];
						$tax_totals['vat_currency_exchange_rate'] = $order_vat_data['vat_currency_exchange_rate'];

						render_order_vat_info_table($tax_totals, $vat_info_labels, $display_decimals);
					}
					//
				?></div>
			</div>

		<?php endif; ?>
	</div>
	<!-- VAT evidence section -->
	<div id="vat_evidence">
		<h4 class="title"><?php echo __('VAT evidence', 'wc-aelia-eu-vat-assistant'); ?></h4>
		<div>
			<?php if(empty($order->eu_vat_evidence)) : ?>
				<div id="no_vat_evidence_message"><?php
					echo __('No VAT evidence was stored with this order.', 'wc-aelia-eu-vat-assistant');
				?></div>
			<?php else: ?>
				<div class="location">
					<h4 class="subtitle"><?php echo __('Location details', 'wc-aelia-eu-vat-assistant'); ?></h4>
					<?php
						$vat_evidence = $order->eu_vat_evidence['location'];
						$vat_evidence['is_eu_country'] = $vat_evidence['is_eu_country'] ? __('yes', 'wc-aelia-eu-vat-assistant') : __('no', 'wc-aelia-eu-vat-assistant');
						render_order_vat_evidence_list($vat_evidence, $vat_evidence_labels['location']);
					?>
				</div>
				<div class="exemption">
					<h4 class="subtitle"><?php echo __('Exemption details', 'wc-aelia-eu-vat-assistant'); ?></h4>
					<?php
						$vat_evidence = $order->eu_vat_evidence['exemption'];
						// Render the list of VAT evidence
						if(is_numeric($vat_evidence['vat_number_validated'])) {
							$vat_evidence['vat_number_validated'] = $vat_evidence['vat_number_validated'] ? __('yes', 'wc-aelia-eu-vat-assistant') : __('no', 'wc-aelia-eu-vat-assistant');
						}
						// Clarify which information is not available
						foreach($vat_evidence as $evidence_key => $evidence_value) {
							if(empty($vat_evidence[$evidence_key])) {
								$vat_evidence[$evidence_key] = __('N/A', 'wc-aelia-eu-vat-assistant');
							}
						}
						render_order_vat_evidence_list($vat_evidence, $vat_evidence_labels['exemption']);
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
