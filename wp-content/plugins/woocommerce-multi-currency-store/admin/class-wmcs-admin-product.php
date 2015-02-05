<?php
/**
 * Admin Product class
 *
 * @package   Woocommerce Multi Currency Store
 * @author    Code Ninjas 
 * @link      http://codeninjas.co
 * @copyright 2014 Code Ninjas
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
class WMCS_Admin_Product {

	public function __construct()
	{		
		if( get_option( 'wmcs_enabled', FALSE ) ){
			add_action( 'woocommerce_product_options_pricing', array( $this, 'output_currency_table' ) );
			add_action( 'save_post', array( $this, 'save_currency_rates' ) );
			
			//variations
			add_action( 'woocommerce_product_after_variable_attributes', array( $this, 'output_currency_table_variation'), 10, 3 );
			add_action( 'woocommerce_save_product_variation', array( $this, 'save_currency_rates_variation' ) );
		}
				
	}
	
	public function output_currency_table( ){
	
		global $thepostid, $post;
		
		$product = get_product( $thepostid );
		if( $product->is_type( 'variable' ) ) return;
		
		$products_currency_prices = get_post_meta( $thepostid, 'wmcs_currency_prices', TRUE );
		
		$regular_price = get_post_meta( $thepostid, '_regular_price', true );
		$sale_price = get_post_meta( $thepostid, '_sale_price', true );
		
		$store_currencies = get_option( 'wmcs_store_currencies', array() );
	
		echo '<div class="form-field wmcs_currency_prices_form_field">
				<label>'._e( 'Currency Prices', 'woocommerce' ).'</label>';
		
				include 'views/product-currency-table.phtml';
				
		echo '<p class="description">Note: Remember to set both the regular and the sale price if needed.</p>
			  </div>';
	}
	
	public function save_currency_rates( $post_id ){
	
		if( !$post_id ) return;        
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		
		if( isset( $_POST['currency_prices'] ) ){
			
			$data = array();
			foreach( $_POST['currency_prices'] as $currency => $rate ){
				
				$rate_regular = (float)$rate['regular'];
				$rate_regular = ( $rate_regular <= 0 ) ? '' : $rate_regular;
				$rate_sale = (float)$rate['sale'];
				$rate_sale = ( $rate_sale <= 0 ) ? '' : $rate_sale;
				
				$data[$currency] = array('regular' => $rate_regular, 'sale' => $rate_sale);
			}
			
			update_post_meta( $post_id, 'wmcs_currency_prices', $data );
		}
	
	}
	
	public function output_currency_table_variation( $loop, $variation_data, $variation ){
		
		$store_currencies = get_option( 'wmcs_store_currencies', array() );
		
		$products_currency_prices = ( isset( $variation_data['wmcs_currency_prices'] ) ) ? unserialize( $variation_data['wmcs_currency_prices'][0] ) : array();
		
		$regular_price = $variation_data['_regular_price'][0];
		$sale_price = $variation_data['_sale_price'][0];
	
		echo '<tr>
				<td colspan="2">';
			
			echo '<label>Currency Pricing:</label>';
			include 'views/product-currency-table-variation.phtml';
		
		echo '	</td>
			</tr>';
	}
	
	public function save_currency_rates_variation( $variation_id ){    
		
		if( !$variation_id ) return;        
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		
		if( isset( $_POST['currency_prices'] ) ){
		
			$currency_prices = array_shift( $_POST['currency_prices'] ); 
			
			$data = array();
			foreach( $currency_prices as $currency => $rate ){
				
				$rate_regular = (float)$rate['regular'];
				$rate_regular = ( $rate_regular < 0 ) ? 0.0 : $rate_regular;
				$rate_sale = (float)$rate['sale'];
				$rate_sale = ( $rate_sale < 0 ) ? 0.0 : $rate_sale;
				
				$data[$currency] = array('regular' => $rate_regular, 'sale' => $rate_sale);
			}
			
			update_post_meta( $variation_id, 'wmcs_currency_prices', $data );
		}
		
	}

}
return new WMCS_Admin_Product();

