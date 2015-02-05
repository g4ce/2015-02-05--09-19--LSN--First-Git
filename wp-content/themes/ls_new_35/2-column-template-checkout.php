<?php
/* Template name: 2 columns Template Checkout
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
				<?php get_sidebar('left_home');?>
			</div>
			<!-- end left column -->
	
			<!-- left column -->
			<div class="content_pane_two_cols_sidebar_left col-xs-8 col-md-9">

				<section class="main_content_section main_content_on_page">
					<?php 
					$post_id;
					if (have_posts() ) : ?>

					  <!-- pagination here -->

					  <!-- the loop -->
					  <?php while (have_posts() ) : the_post(); ?>
					    <?php $post_id = get_the_ID();?>
						<h1><?php the_title();?></h1>
						<div class="the_content">
						<?php the_content();?>
						</div>
					  <?php endwhile; ?>
					  <!-- end of the loop -->

					  <!-- pagination here -->

					  <?php wp_reset_postdata(); ?>

					<?php else:  ?>
					  <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
					<?php endif; ?>

				</section>
	
			</div>
			<!-- end left column -->

		</div>	
		<!-- end row -->

	</div>
	<!-- end middle_wrapper container -->

<?php get_footer();?>