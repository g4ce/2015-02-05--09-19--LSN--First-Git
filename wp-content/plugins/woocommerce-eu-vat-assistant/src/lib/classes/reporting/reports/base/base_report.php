<?php
namespace Aelia\WC\EU_VAT_Assistant\Reports;
if(!defined('ABSPATH')) exit; // Exit if accessed directly

use Aelia\WC\EU_VAT_Assistant\WC_Aelia_EU_VAT_Assistant;
use Aelia\WC\EU_VAT_Assistant\Settings;

/**
 * A base report class with properties and methods common to all EU VAT Assistant
 * reports.
 */
class Base_Report extends \WC_Admin_Report {
	// @var string The text domain to use for localisation.
	protected $text_domain;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->text_domain = WC_Aelia_EU_VAT_Assistant::$text_domain;
	}

	/**
	 * Returns the value of a configuration parameter for the EU VAT Assistant
	 * plugin.
	 *
	 * @param string settings_key The key to retrieve the parameter.
	 * @param mixed default The default value to return if the parameter is not
	 * found.
	 * @return mixed
	 */
	protected function settings($settings_key, $default = null) {
		return WC_Aelia_EU_VAT_Assistant::settings()->get($settings_key, $default);
	}

	/**
	 * Returns the currency to use for the VAT returns.
	 *
	 * @return string
	 */
	protected function vat_currency() {
		return $this->settings(Settings::FIELD_VAT_CURRENCY);
	}

	/**
	 * Formats a price, adding the VAT currency symbol.
	 *
	 * @param float price The price to format.
	 * @return string
	 */
	protected function format_price($price) {
		$args = array(
			'currency' => $this->vat_currency(),
		);
		return wc_price($price, $args);
	}

	/**
	 * Get the legend for the main chart sidebar.
	 *
	 * @return array
	 */
	public function get_chart_legend() {
		// No legend is needed (this report) doesn't have a chart
		return array();
	}

	/**
	 * Output an export link
	 */
	public function get_export_button() {
		$current_range = !empty($_GET['range']) ? sanitize_text_field($_GET['range']) : 'last_month';
		?>
		<a
			href="#"
			download="report-<?php echo esc_attr($current_range); ?>-<?php echo date_i18n('Y-m-d', current_time('timestamp')); ?>.csv"
			class="export_csv"
			data-export="table"
		>
			<?php echo __('Export CSV', 'wc-aelia-eu-vat-assistant'); ?>
		</a>
		<?php
	}

	/**
	 * Returns an array of ranges that are used to produce the reports.
	 *
	 * @return array
	 * @since 0.9.7.141221
	 */
	protected function get_report_ranges() {
		$ranges = array();

		$current_time = current_time('timestamp');
		$label_fmt = __('Q%d %d', 'wc-aelia-eu-vat-assistant');

		// Current quarter
		$quarter = ceil(date('m', $current_time) / 3);
		$year = date('Y');
		$ranges['quarter'] = sprintf($label_fmt, $quarter, $year);

		// Quarter before this one
		$month = date('m', strtotime('-3 MONTH', $current_time));
		$year  = date('Y', strtotime('-3 MONTH', $current_time));
		$quarter = ceil($month / 3);
		$ranges['previous_quarter'] = sprintf($label_fmt, $quarter, $year);

		// Two quarters ago
		$month = date('m', strtotime('-6 MONTH', $current_time));
		$year  = date('Y', strtotime('-6 MONTH', $current_time));
		$quarter = ceil($month / 3);
		$ranges['quarter_before_previous'] = sprintf($label_fmt, $quarter, $year);

		return array_reverse($ranges);
	}

	/**
	 * Output the report
	 */
	public function output_report() {
		$ranges = $this->get_report_ranges();
		$current_range = !empty($_GET['range']) ? sanitize_text_field($_GET['range']) : 'quarter';

		if(!in_array($current_range, array_merge(array_keys($ranges), array('custom')))) {
			$current_range = 'quarter';
		}
		$this->calculate_current_range($current_range);

		$hide_sidebar = true;
		include(WC()->plugin_path() . '/includes/admin/views/html-report-by-date.php');
	}

	/**
	 * Get the current range and calculate the start and end dates
	 * @param  string $current_range
	 */
	public function calculate_current_range($current_range) {
		$this->chart_groupby = 'month';
		switch ($current_range) {
			case 'quarter_before_previous':
				$month = date('m', strtotime('-6 MONTH', current_time('timestamp')));
				$year  = date('Y', strtotime('-6 MONTH', current_time('timestamp')));
			break;
			case 'previous_quarter':
				$month = date('m', strtotime('-3 MONTH', current_time('timestamp')));
				$year  = date('Y', strtotime('-3 MONTH', current_time('timestamp')));
			break;
			case 'quarter':
				$month = date('m', current_time('timestamp'));
				$year  = date('Y', current_time('timestamp'));
			break;
			default:
				parent::calculate_current_range($current_range);
				return;
			break;
		}

		if($month <= 3) {
			$this->start_date = strtotime($year . '-01-01');
			$this->end_date = strtotime(date('Y-m-t', strtotime($year . '-03-01')));
		}
		elseif($month > 3 && $month <= 6) {
			$this->start_date = strtotime($year . '-04-01');
			$this->end_date = strtotime(date('Y-m-t', strtotime($year . '-06-01')));
		}
		elseif($month > 6 && $month <= 9) {
			$this->start_date = strtotime($year . '-07-01');
			$this->end_date = strtotime(date('Y-m-t', strtotime($year . '-09-01')));
		}
		elseif($month > 9) {
			$this->start_date = strtotime($year . '-10-01');
			$this->end_date = strtotime(date('Y-m-t', strtotime($year . '-12-01')));
		}
	}

	protected function get_tax_rates_data(array $tax_rate_ids) {
		global $wpdb;
		if(empty($tax_rate_ids)) {
			return;
		}

		$SQL = "
			SELECT
				TR.tax_rate_id
				,TR.tax_rate
				,TR.tax_rate_class
				,TR.tax_rate_country
			FROM
				{$wpdb->prefix}woocommerce_tax_rates TR
			WHERE
				(TR.tax_rate_id IN (%s));
		";
		// We cannot use $wpdb::prepare(). We need the result of the implode()
		// call to be injected as is, while the prepare() method would wrap it in quotes.
		$SQL = sprintf($SQL, implode(',', $tax_rate_ids));

		// Retrieve the details of the tax rates
		return $wpdb->get_results($SQL, OBJECT_K);
	}

	/**
	 * Get report totals such as order totals and discount amounts.
	 *
	 * Data example:
	 *
	 * '_order_total' => array(
	 *     'type'     => 'meta',
	 *     'function' => 'SUM',
	 *     'name'     => 'total_sales'
	 * )
	 *
	 * @param  array $args
	 * @return array|string depending on query_type
	 */
	public function get_order_report_data($args = array()) {
		$args = array_merge(array(
			'filter_range' => true,
			'nocache' => true,
			'debug' => WC_Aelia_EU_VAT_Assistant::instance()->debug_mode(),
		), $args);
		return parent::get_order_report_data($args);
	}

	/**
	 * Returns the name of the country passed as an argument.
	 *
	 * @param string country_code A ountry code.
	 * @return string The country name.
	 * @since 0.9.7.141221
	 */
	protected function get_country_name($country_code) {
		if(empty($this->countries)) {
			$this->countries = WC()->countries->countries;
		}
		return $this->countries[$country_code];
	}
}
