<?php
/**
 * Common init class for both frontend and admin
 *
 * @package   Woocommerce Multi Currency Store
 * @author    Code Ninjas 
 * @link      http://codeninjas.co
 * @copyright 2014 Code Ninjas
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
class WMCS_Common_Init {

	public function __construct()
	{	
		include_once 'wmcs-helper.php';
		include_once 'class-wmcs-exchange-api.php';
		include_once 'widgets/class-wmcs-widget-currency-switcher.php';
	
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	
		add_action( 'init', array( $this, 'start_session' ), 1);
		add_action('wp_logout', array( $this, 'end_session' ) );
		add_action('wp_login', array( $this, 'end_session' ) );
	
		add_action( 'init', array( $this, 'init' ) );
		
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
		add_action( 'init', array( $this, 'capture_currency_change' ) );
		
		add_filter( 'woocommerce_package_rates', array( $this, 'convert_shipping_rates' ), 10, 2 );
		
		//add_filter( 'pre_option_woocommerce_price_num_decimals', array( $this, 'filter_woocommerce_price_num_decimals' ) );
		
	}
	
	public function filter_woocommerce_price_num_decimals( $num ){
		//pr($num);
		return 1;
	}

	
	public function convert_shipping_rates( $rates, $package ){
		
		foreach( $rates as $id => $rate ){
			$rates[$id]->cost = wmcs_convert_price($rate->cost);
		}
		
		return $rates;
				
	}

	public function init(){
	
		if( defined('DOING_AJAX') && DOING_AJAX || !is_admin() ){
			
			include_once 'class-wmcs-product.php';
			include_once 'class-wmcs-cart.php';
			add_filter( 'woocommerce_currency', array( $this, 'filter_woocommerce_currency' ), 99 );
			
			$wmcs_wc_price = new WMCS_WC_Price();
			add_filter( 'raw_woocommerce_price', array( $wmcs_wc_price, 'filter_raw_woocommerce_price' ) );
			add_filter( 'wc_price', array( $wmcs_wc_price, 'filter_wc_price' ), 10, 3 );
			//add_filter( 'wc_price', array( $this, 'filter_wc_price' ), 1, 3 );			
		
		}
		
	}
	
	public function start_session(){
		if( !session_id() ) session_start();
	}
	
	public function end_session(){
	
		session_destroy();
		
	}
	
	public function register_widgets(){
	
		register_widget( 'WMCS_Widget_Currency_Switcher' );
		
	}
	
	public function enqueue_scripts(){
	
		wp_enqueue_script( 'jquery' );
		
	}
	
	public function capture_currency_change(){
	
		if( !empty( $_GET ) && isset( $_GET['wmcs_set_currency'] ) ){
			
			$new_currency = $_GET['wmcs_set_currency'];
			
			$store_currencies = get_option( 'wmcs_store_currencies', array() );
			if( array_key_exists( $new_currency, $store_currencies ) ){ //only change if its a store currency
				$_SESSION['wmcs_currency'] = $new_currency;
			} else {
				$_SESSION['wmcs_currency'] = get_option('woocommerce_currency'); //otherwise revert to store base currency
			}
			
			wp_redirect( remove_query_arg( 'wmcs_set_currency' ) );
			exit;
			
		}
	
	}
	
	/**
	 * Change the currency of the whole store to the customers currency
	 * Even though the display of the price is being filtered too, need to do this so orders are created in the customer currency
	 *
	 * @var		string	$currency			The current store currency
	 * @return	string	$customers_currency	The customer currency if found
	 
	 * @since	1.0
	 */
	public function filter_woocommerce_currency( $currency ){
		
		$customers_currency = wmcs_get_customers_currency();
		
		$store_currencies = get_option( 'wmcs_store_currencies', array() );
		
		if($customers_currency)
			if( array_key_exists( $customers_currency, $store_currencies ) )
				return $customers_currency;
			
		return $currency;
	}
	
	
	/**
	 * Format and output the price passed based on the formatting options for the customers currency
	 *
	 * @var		string	$return		Current price string
	 * @var		string	$price		The price being output
	 * @var		array	$args		Additional arguments
	 * @return	string	$return		Formatted price for this currency
	 * @since	1.0
	 */
	public function filter_wc_price( $return, $price, $args ){
	pr($price);
		if( !$price ) return $return;
	
		if( isset( $args['currency'] ) ) $customers_currency = $args['currency'];
		else $customers_currency = wmcs_get_customers_currency();
		if( !$customers_currency ) return $return;
		
		$store_currencies = get_option( 'wmcs_store_currencies', array() );
		if( !array_key_exists( $customers_currency, $store_currencies ) ) return $return;
		
		$currency_symbol = get_woocommerce_currency_symbol( $customers_currency );
		$decimal_places = $store_currencies[$customers_currency]['decimal_places'];
		$decimal_sep = $store_currencies[$customers_currency]['decimal_separator'];
		$thousand_sep = $store_currencies[$customers_currency]['thousand_separator'];
		$currency_position = $store_currencies[$customers_currency]['position'];
		$rounding_precision = (int)$store_currencies[$customers_currency]['rounding_to'];
		
		$price = str_replace( ',', '', $price ); //price is already formatted by wc_price and may contain a ',' so remove it
		
		//rounding
		if( $store_currencies[$customers_currency]['rounding_type'] != 'none' ){
			if( $store_currencies[$customers_currency]['rounding_type'] == 'up' )	$price = round( $price, $rounding_precision, PHP_ROUND_HALF_UP );
			else $price = round( $price, $rounding_precision, PHP_ROUND_HALF_DOWN );
		}
		
		//formatting
		$price = number_format( $price, $decimal_places, $decimal_sep, $thousand_sep );
		
		//symbol position
		switch( $currency_position ){
			case 'left':
				$price = $currency_symbol.$price;
				break;
			case 'right':
				$price = $price.$currency_symbol;
				break;
			case 'left_space':
				$price = $currency_symbol.' '.$price;
				break;
			case 'right_space':
				$price = $price.' '.$currency_symbol;
				break;
		}
	
		return $price;
	
	}
	
}
return new WMCS_Common_Init();