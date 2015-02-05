<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
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

					<div class="the_content sing_prod_cont">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

					</div>
					<!-- end the_content -->


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





	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		//do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>