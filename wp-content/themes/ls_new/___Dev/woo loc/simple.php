<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if ( ! $product->is_purchasable() ) return;
?>

<?php
	// Availability
	$availability      = $product->get_availability();
	$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
	
	echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
?>

<?php if ( $product->is_in_stock() ) : ?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>



<form class="cart single-product" method="post" enctype='multipart/form-data'>
    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
    <button type="submit" class="single_add_to_cart_button button alt cart-buttton add-to-cart"><?php echo $product->single_add_to_cart_text(); ?></button>
    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>
<div style="padding-top: 50px;">
	<?php lsn_email_enquiry_popup();
	lsn_buy_now_redirect();?>
</div>
<!-- <form class="cart single-product" method="post" enctype='multipart/form-data' action="/__woo/?page_id=6?set-cart-qty_<?php echo $product->id;?>=1">
    <button type="submit"  class="single_add_to_cart_button button alt cart-buttton buy-now">Buy Now</button>
    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
</form> -->
	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>