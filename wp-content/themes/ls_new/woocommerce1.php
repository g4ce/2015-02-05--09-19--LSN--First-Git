<?php
/* Template: Default 3 cols page template
 * Version: 1.00
 * Last Modified: 16/01/2015 13:04:37
 */
?>
<?php get_header();?>

	<div class="middle_wrapper container with_top_margin_10">
		
		<!-- two column layout -->

		<div class="row">
	        <!-- left column -->
			<div class="left_pane col-xs-4 col-md-3">
				<!-- get left sidebar -->
				<?php get_sidebar('left');?>
			</div>
			<!-- end left column -->
	
			<!-- left column -->
			<div class="content_pane_two_cols_sidebar_left col-xs-4 col-md-6">

				<section class="main_content_section main_content_on_page">

					<?php //woocommerce_content(); ?>

				</section>
	
			</div>
			<!-- end left column -->

			<div class="right_pane col-xs-4 col-md-3">
				<!-- get left sidebar -->
				<?php get_sidebar('right');?>
			</div>
			<!-- end right column -->

		</div>	
		<!-- end row -->

	</div>
	<!-- end middle_wrapper container -->

<?php get_footer();?>