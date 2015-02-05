<?php
/**
 * Product Class
 *
 * @package   Woocommerce Multi Currency Store
 * @author    Code Ninjas 
 * @link      http://codeninjas.co
 * @copyright 2014 Code Ninjas
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
class WMCS_Product {

	public function __construct()
	{	
		add_filter( 'woocommerce_get_price', array( $this, 'filter_price' ), 10, 2 );
		add_filter( 'woocommerce_get_regular_price', array( $this, 'filter_regular_price' ), 10, 2 );
		add_filter( 'woocommerce_get_sale_price', array( $this, 'filter_sale_price' ), 10, 2 );
		
		add_filter( 'woocommerce_get_variation_price', array( $this, 'filter_variation_price' ), 10, 4 );
		add_filter( 'woocommerce_get_variation_regular_price', array( $this, 'filter_variation_regular_price' ), 10, 4 );
		//add_filter( 'woocommerce_get_variation_sale_price', array( $this, 'filter_variation_sale_price' ), 10, 4 ); // Not used anywhere in Woo!
	}
	
	public function filter_price( $price, $product ){
		
		$return_price = '';
		
		if($product->is_type('variable')){
			$return_price = $this->get_variable_products_price( $product );
		} else {
			$return_price = $this->get_products_price( $product );
		}
		
		if( $return_price ) return $return_price;
		
		return wmcs_convert_price( $price );
	}
	
	public function filter_regular_price( $price, $product ){
		
		$return_price = '';
		
		if($product->is_type('variable')){
			$return_price = $this->get_variable_products_price( $productm, 'min', 'regular' );
		} else {
			$return_price = $this->get_products_price( $product, 'regular' );
		}
		
		if( $return_price ) return $return_price;
		
		return wmcs_convert_price( $price );
		
	}
	
	public function filter_sale_price( $price, $product ){
		
		$return_price = '';
		
		if($product->is_type('variable')){
			$return_price = $this->get_variable_products_price( $productm, 'min', 'sale' );
		} else {
			$return_price = $this->get_products_price( $product, 'sale' );
		}
		
		if( $return_price ) return $return_price;
		
		return wmcs_convert_price( $price );
		
	}
	
	public function filter_variation_price( $price, $product, $min_or_max, $display ){
	
		$return_price = $this->get_variable_products_price( $product, $min_or_max );
		
		if( $return_price ) return $return_price;
		
		return wmcs_convert_price( $price );
	
	}
	
	public function filter_variation_regular_price( $price, $product, $min_or_max, $display ){
	
		$return_price = $this->get_variable_products_price( $product, $min_or_max, 'regular' );
		
		if( $return_price ) return $return_price;
		
		return wmcs_convert_price( $price );
	
	}
	
	
	/**
	 * Get the lowest/highest price of all variations of this product
	 */
	private function get_variable_products_price( $product, $min_or_max = 'min', $price_type = '' ){
	
		$min_price = '';
		$max_price = '';
	
		$customers_currency = wmcs_get_customers_currency();
	
		foreach( $product->children as $child_id ){
			
			$currency_prices = (array)get_post_meta( $child_id, 'wmcs_currency_prices', TRUE );
			
			if( array_key_exists( $customers_currency, $currency_prices ) ){
			
				if( $price_type == 'regular' ){
				
					if( $min_price === '' ) $min_price = $currency_prices[$customers_currency]['regular'];
					else{
						if( $currency_prices[$customers_currency]['regular'] < $min_price ) $min_price = $currency_prices[$customers_currency]['regular'];
					}
					
					if( $max_price === '' ) $max_price = $currency_prices[$customers_currency]['regular'];
					else{
						if( $currency_prices[$customers_currency]['regular'] > $max_price ) $max_price = $currency_prices[$customers_currency]['regular'];
					}
				
				} elseif( $price_type == 'sale' ){

					if( $min_price === '' ) $min_price = $currency_prices[$customers_currency]['sale'];
					else{
						if( $currency_prices[$customers_currency]['sale'] < $min_price ) $min_price = $currency_prices[$customers_currency]['sale'];
					}
					
					if( $max_price === '' ) $max_price = $currency_prices[$customers_currency]['sale'];
					else{
						if( $currency_prices[$customers_currency]['sale'] > $max_price ) $max_price = $currency_prices[$customers_currency]['sale'];
					}
				
				} else {
	
					if( $currency_prices[$customers_currency]['sale'] ){
				
						if( $min_price === '' ) $min_price = $currency_prices[$customers_currency]['sale'];
						else {
							if( $currency_prices[$customers_currency]['sale'] < $min_price ) $min_price = $currency_prices[$customers_currency]['sale'];
						}
						
						if( $max_price === '' ) $max_price = $currency_prices[$customers_currency]['sale'];
						else {
							if( $currency_prices[$customers_currency]['sale'] > $max_price ) $max_price = $currency_prices[$customers_currency]['sale'];
						}
						
					} elseif( $currency_prices[$customers_currency]['regular'] ){
					
						if( $min_price === '' ) $min_price = $currency_prices[$customers_currency]['regular'];
						else{
							if( $currency_prices[$customers_currency]['regular'] < $min_price ) $min_price = $currency_prices[$customers_currency]['regular'];
						}
						
						if( $max_price === '' ) $max_price = $currency_prices[$customers_currency]['regular'];
						else{
							if( $currency_prices[$customers_currency]['regular'] > $max_price ) $max_price = $currency_prices[$customers_currency]['regular'];
						}
					}
				
				}
			
			}
			
		}
		
		return ( $min_or_max == 'min' ) ? $min_price : $max_price;
	
	}
	
	private function get_products_price( $product, $price_type = '' ){
		
		$price = '';
		
		$customers_currency = wmcs_get_customers_currency();
		
		$product_id = ( isset( $product->variation_id ) && $product->variation_id ) ? $product->variation_id : $product->id;
		
		$currency_prices = (array)get_post_meta( $product_id, 'wmcs_currency_prices', TRUE );
		
		if( array_key_exists( $customers_currency, $currency_prices ) ){
		
			if( $price_type == 'regular' ){
			
				$price = $currency_prices[$customers_currency]['regular'];
			
			} elseif( $price_type == 'sale' ){
			
				$price = $currency_prices[$customers_currency]['sale'];
			
			} else {
				
				if( $currency_prices[$customers_currency]['sale'] )
					$price = $currency_prices[$customers_currency]['sale'];
				elseif( $currency_prices[$customers_currency]['regular'] )
					$price = $currency_prices[$customers_currency]['regular'];
				
			}		
				
		}
		
		return $price;
	}
}
return new WMCS_Product();