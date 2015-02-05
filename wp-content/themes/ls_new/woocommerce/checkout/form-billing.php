<?php
/**
 * Checkout billing information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

update_shipping_rates();
?>
<div class="woocommerce-billing-fields">
	<?php if ( WC()->cart->ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3><?php _e( 'Billing Details', 'woocommerce' ); ?></h3>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<?php foreach ( $checkout->checkout_fields['billing'] as $key => $field ) : ?>

		<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

	<?php endforeach; ?>

	<?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?>

	<?php if ( ! is_user_logged_in() && $checkout->enable_signup ) : ?>

		<?php if ( $checkout->enable_guest_checkout ) : ?>

			<p class="form-row form-row-wide create-account">
				<input class="input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true) ?> type="checkbox" name="createaccount" value="1" /> <label for="createaccount" class="checkbox"><?php _e( 'Create an account?', 'woocommerce' ); ?></label>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( ! empty( $checkout->checkout_fields['account'] ) ) : ?>

			<div class="create-account">

				<p><?php _e( 'Create an account by entering the information below. If you are a returning customer please login at the top of the page.', 'woocommerce' ); ?></p>

				<?php foreach ( $checkout->checkout_fields['account'] as $key => $field ) : ?>

					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

				<?php endforeach; ?>

				<div class="clear"></div>

			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

	<?php endif; ?>
</div>

<?php 

function update_shipping_rates(){
	?>
<!-- shipping rate autoupdate -->
<?php
  global $wpdb;

  $extract = $wpdb->get_var( "SELECT option_value FROM $wpdb->options WHERE option_id = 1053;");
  //echo $extract;

  // first extract the exaxt amount
  $current_rate = substr($extract, 70, -4);
  //echo $current_rate;

  // convert to float 
  $current_rate = floatval($current_rate);
  $current_rate = number_format(round($current_rate, 4), 4);
  //echo $current_rate;

  //set the current rate GB shipping cost and base
  $uk_shipping_cost = 10 / $current_rate;
  $uk_shipping_base = 200 / $current_rate;
  $uk_shipping_cost = number_format(round($uk_shipping_cost, 4), 4);
  $uk_shipping_base = number_format(round($uk_shipping_base, 4), 4);
  //echo $uk_shipping_cost . ' and ' . $uk_shipping_base;

  // prepare update string
  //$uk_update = 'a:4:{i:0;a:7:{s:2:"id";s:1:"9";s:4:"zone";s:1:"1";s:5:"basis";s:5:"price";s:3:"min";s:1:"0";s:3:"max";s:8:"'.strval($uk_shipping_base).'";s:4:"cost";s:7:"'.strval($uk_shipping_cost).'";s:7:"enabled";s:1:"1";}i:1;a:7:{s:2:"id";s:2:"10";s:4:"zone";s:1:"1";s:5:"basis";s:5:"price";s:3:"min";s:8:"266.3588";s:3:"max";s:1:"*";s:4:"cost";s:1:"0";s:7:"enabled";s:1:"1";}i:2;a:7:{s:2:"id";s:2:"11";s:4:"zone";s:1:"2";s:5:"basis";s:5:"price";s:3:"min";s:1:"0";s:3:"max";s:3:"200";s:4:"cost";s:2:"10";s:7:"enabled";s:1:"1";}i:3;a:7:{s:2:"id";s:2:"12";s:4:"zone";s:1:"2";s:5:"basis";s:5:"price";s:3:"min";s:3:"200";s:3:"max";s:1:"*";s:4:"cost";s:1:"0";s:7:"enabled";s:1:"1";}}';
  $uk_update = 'a:4:{i:0;a:7:{s:2:"id";s:2:"17";s:4:"zone";s:1:"2";s:5:"basis";s:5:"price";s:3:"min";s:1:"0";s:3:"max";s:3:"200";s:4:"cost";s:2:"10";s:7:"enabled";s:1:"1";}i:1;a:7:{s:2:"id";s:2:"18";s:4:"zone";s:1:"2";s:5:"basis";s:5:"price";s:3:"min";s:3:"200";s:3:"max";s:1:"*";s:4:"cost";s:1:"0";s:7:"enabled";s:1:"1";}i:2;a:7:{s:2:"id";s:2:"19";s:4:"zone";s:1:"1";s:5:"basis";s:5:"price";s:3:"min";s:1:"0";s:3:"max";s:10:"'.strval($uk_shipping_base).'";s:4:"cost";s:9:"'.strval($uk_shipping_cost).'";s:7:"enabled";s:1:"1";}i:3;a:7:{s:2:"id";s:2:"20";s:4:"zone";s:1:"1";s:5:"basis";s:5:"price";s:3:"min";s:10:"'.strval($uk_shipping_base).'";s:3:"max";s:1:"*";s:4:"cost";s:1:"0";s:7:"enabled";s:1:"1";}}';
  //echo $uk_update;
  

  //$wpdb->query("UPDATE $wpdb->options SET option_value= '$uk_update' WHERE option_id = 1412;");

}

?>