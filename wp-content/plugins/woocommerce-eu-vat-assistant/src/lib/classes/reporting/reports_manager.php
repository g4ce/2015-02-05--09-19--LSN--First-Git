<?php
namespace Aelia\WC\EU_VAT_Assistant;
if(!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Registers the reports introduced by the EU VAT Assistant.
 */
class ReportsManager extends \Aelia\WC\Base_Class {
	// @var array An array of WooCommerce version => Namespace pairs. The namespace will be used to load the appropriate class to override reports
	protected static $reports_namespaces = array(
		'2.1' => 'WC21',
		'2.2' => 'WC22',
	);

	// @var string The namespace to use to load the reports.
	protected static $report_namespace = null;

	protected static function get_report_namespace() {
		if(empty(self::$report_namespace)) {
			krsort(self::$reports_namespaces);
			foreach(self::$reports_namespaces as $supported_version => $namespace) {
				if(version_compare(wc()->version, $supported_version, '>=')) {
					self::$report_namespace = $namespace;
					break;
				}
			}

			if(empty(self::$report_namespace)) {
				trigger_error(sprintf(__('Reports could not be found for this WooCommerce version. ' .
																 'Supported version are from %s to: %s.', 'wc-aelia-eu-vat-assistant'),
															min(array_keys(self::$reports_namespaces)),
															max(array_keys(self::$reports_namespaces))),
											E_USER_WARNING);
			}
		}
		return '\\' . __NAMESPACE__ . '\\Reports\\' . self::$report_namespace;
	}

	/**
	 * Constructor
	 */
	public static function init() {
		add_action('woocommerce_admin_reports', array(__CLASS__, 'woocommerce_admin_reports'));
	}

	/**
	 * Registers the new EU VAT reports within WooCommerce.
	 *
	 * @param array reports An array of reports passed by WooCommerce.
	 * @return array
	 */
	public static function woocommerce_admin_reports($reports) {
		if(isset($reports['taxes'])) {
			//$reports['taxes']['reports']['eu_sales_list_report'] = array(
			//	'title' => __('EU Sales List', 'wc-aelia-eu-vat-assistant'),
			//	'description' => '',
			//	'hide_title' => true,
			//	'callback' => array(__CLASS__, 'eu_sales_list_report'),
			//);
			$reports['taxes']['reports']['eu_vat_by_country_report'] = array(
				'title' => __('EU VAT by Country', 'wc-aelia-eu-vat-assistant'),
				'description' => '',
				'hide_title' => true,
				'callback' => array(__CLASS__, 'eu_vat_by_country_report'),
			);
		}
		return $reports;
	}

	/**
	 * Callback to render the EU Sales report.
	 */
	public static function eu_sales_list_report() {
		$report_class = self::get_report_namespace() . '\WC_EU_VAT_Report_EC_Sales_List';
		$report = new $report_class();
		$report->output_report();
	}

	/**
	 * Callback to render the EU VAT report.
	 */
	public static function eu_vat_by_country_report() {
		$report_class = self::get_report_namespace() . '\EU_VAT_By_Country_Report';

		$report = new $report_class();
		$report->output_report();
	}
}
