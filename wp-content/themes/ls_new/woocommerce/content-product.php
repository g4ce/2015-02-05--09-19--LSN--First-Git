<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
?>

	<li <?php post_class( $classes ); ?>>

		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

		<a class="cat_prod_link" href="<?php the_permalink(); ?>">

		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>

			<h2 class="cat_prod_name"><?php the_title(); ?></h2>
			<p class="cat_prod_sku">SKU: <?php echo $product->get_sku(); ?></p></a>
			
			<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10 data-toggle="modal" data-target="#smEmailPopup">
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' ); ?>

			<?php // this is only visible on category page ?>

			<?php 
			if( $product->is_type( 'simple' ) ){ ?>
				<!-- simple -->
				<?php get_cons_enquiry();?>

				<form class="cart single-product form_inline" method="post" enctype='multipart/form-data' action="/?page_id=6?set-cart-qty_<?php echo $product->id;?>=1">
				<!-- <form class="cart single-product form_inline" method="post" enctype='multipart/form-data' action="/checkout?set-cart-qty_<?php echo $product->id;?>=1"> -->
				    <button type="submit"  class="single_add_to_cart_button button alt cart-buttton buy-now">Buy Now</button>
				    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
				</form>

			<?php
			} elseif( $product->is_type( 'variable' ) ){ ?>
			  	<!-- variable -->
			  	<button type="button" disabled class="single_add_to_cart_button button alt cart-buttton add-to-cart">Email Enquiry</button>
			  	<form class="cart single-product form_inline" method="post" enctype='multipart/form-data' action="/?page_id=6?set-cart-qty_<?php echo $product->id;?>=1">
				<!-- <form class="cart single-product form_inline" method="post" enctype='multipart/form-data' action="/checkout?set-cart-qty_<?php echo $product->id;?>=1"> -->
				    <button type="submit" disabled class="single_add_to_cart_button button alt cart-buttton buy-now">Buy Now</button>
				    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
				</form>
			  <?php
			}
?>

			<!-- </a> -->
		
		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>


	</li>
<hr class="cat_prod_divider">



