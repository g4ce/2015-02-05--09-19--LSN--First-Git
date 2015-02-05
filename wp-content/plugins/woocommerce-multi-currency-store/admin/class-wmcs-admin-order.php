<?php
/**
 * Admin Order class
 *
 * @package   Woocommerce Multi Currency Store
 * @author    Code Ninjas 
 * @link      http://codeninjas.co
 * @copyright 2014 Code Ninjas
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
class WMCS_Admin_Order{

	var $captured_price = NULL;
	var $wmcs_wc_price;

	public function __construct()
	{		
		/**
		 * Woo outputs order prices and totals in the store base currency rather than the order currency!!!
		 * So we'll have to filter the output for order only.
		 * The price output is the actual price at the time of purchase in the customer currency with the correct formatting and decimal places,
		 * so we just need to output the currency symbol
		 * however since we are filtering wc_price, by the time the price comes to us, its already been formatted to the stores decimal places and separators
		 * so we will attempt to capture the price before any formatting (using raw_woocommerce_price) and then when out filter is run, we will use this captured price
		 */
		 
		$this->wmcs_wc_price = new WMCS_WC_Price();
		add_filter( 'raw_woocommerce_price', array( $this->wmcs_wc_price, 'filter_raw_woocommerce_price' ) );
		add_filter( 'wc_price', array( $this, 'filter_wc_price_wrapper' ), 10, 3 );
		
		//add_filter( 'raw_woocommerce_price', array( $this, 'filter_raw_woocommerce_price' ) );
		//add_filter( 'wc_price', array( $this, 'filter_wc_price' ), 10, 3 );		
	}

	
	public function filter_raw_woocommerce_price( $price ){
		$this->captured_price = $price;
		return $price;
	}
	
	public function filter_wc_price_wrapper( $return, $price, $args ){
		
		$order = wc_get_order(); //TODO why isn't this available in init action???
		if( $order ) $args['currency'] = $order->get_order_currency();
		
		return $this->wmcs_wc_price->filter_wc_price( $return, $price, $args );
		
		/*if( $order ){
		
			if( $this->captured_price ) $new_price = $this->captured_price;
			else $new_price = $price;
			
			$currency = $order->get_order_currency();
			
			$store_currencies = get_option( 'wmcs_store_currencies', array() );
			
			//currency position
			if( array_key_exists( $currency, $store_currencies ) ){
				$currency_position = $store_currencies[$currency]['position'];
			} else {
				//currency may have been removed from store
				//default to base store positioning
				$currency_position = get_option( 'woocommerce_currency_pos' );
			}
			
			$currency_symbol = get_woocommerce_currency_symbol( $currency );
			
			switch( $currency_position ){
				case 'left':
					$return = $currency_symbol.$new_price;
					break;
				case 'right':
					$return = $new_price.$currency_symbol;
					break;
				case 'left_space':
					$return = $currency_symbol.' '.$new_price;
					break;
				case 'right_space':
					$return = $new_price.' '.$currency_symbol;
					break;
			}
			
		}
		
		$this->captured_price = NULL; //clear it, just incase
		return $return;*/
	}
	
}

return new WMCS_Admin_Order();