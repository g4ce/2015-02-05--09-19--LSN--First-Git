<?php
/**
* The Template for displaying product archives, including the main shop page which is a post type archive.
*
* Override this template by copying it to yourtheme/woocommerce/archive-product.php
*
* @author 		WooThemes
* @package 	WooCommerce/Templates
* @version     2.0.0
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header(); ?>

	<?php
	/**
	* woocommerce_before_main_content hook
	*
	* @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	* @hooked woocommerce_breadcrumb - 20
	*/
	do_action( 'woocommerce_before_main_content' );
	gtfc();
	?>

	<div class="middle_wrapper container with_top_margin_10">

		<!-- three column layout -->
		<div class="row">
		<!-- left column -->
			<div class="left_pane col-xs-4 col-md-3">
				<!-- get left sidebar -->
				<?php get_sidebar('left');?>
			</div>
			<!-- end left column -->

			<!-- middle column -->
			<div class="content_pane_two_cols_sidebar_left col-xs-4 col-md-6">

				<section class="main_content_section main_content_on_page">


					<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

						<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

					<?php endif; ?>

					<div class="the_content">

						<!-- if have kids algorithm -->
						<?php get_kids( $post->ID ); ?>
						<!-- end kids algorithm -->

						<?php do_action( 'woocommerce_archive_description' ); ?>

						<?php if ( have_posts() ) : ?>

						<?php
						/**
						* woocommerce_before_shop_loop hook
						*
						* @hooked woocommerce_result_count - 20
						* @hooked woocommerce_catalog_ordering - 30
						*/
						do_action( 'woocommerce_before_shop_loop' );
						?>

						<?php woocommerce_product_loop_start(); ?>

						<?php woocommerce_product_subcategories(); ?>

							<?php while ( have_posts() ) : the_post(); ?>

								<?php wc_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>

						<?php woocommerce_product_loop_end(); ?>

						<?php
						/**
						* woocommerce_after_shop_loop hook
						*
						* @hooked woocommerce_pagination - 10
						*/
						do_action( 'woocommerce_after_shop_loop' );
						?>

						<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

						<?php wc_get_template( 'loop/no-products-found.php' ); ?>

						<?php endif; ?>
					</div>
					<!-- end the content -->
				</section>
				<!-- end main content section -->

			</div>
			<!-- end middle column -->

			<div class="right_pane col-xs-4 col-md-3">
				<!-- get left sidebar -->
				<?php get_sidebar('right');?>
			</div>
			<!-- end right column -->

		</div>	
		<!-- end row -->

	</div>
	<!-- end middle_wrapper container -->

<?php
/**
* woocommerce_after_main_content hook
*
* @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
*/
do_action( 'woocommerce_after_main_content' );
?>



<?php get_footer();?>