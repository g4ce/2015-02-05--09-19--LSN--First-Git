<?php
/* Template name: Home Page Template
 * Version: 1.00
 * Last Modified: 14/01/2015 12:52:57
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
				
				<div class="slider_row row">
		
					<div class="hidden-xs slider_box col-md-9">
						<div id="overhead-slider" class="owl-carousel owl-theme">

							<?php 
								$args = array(
									'post_type' => 'slides',
									'posts_per_page' => 5,
									'order' => 'ASC'
								);

								$the_query = new WP_Query($args); ?>

									<?php if ( $the_query->have_posts() ) : ?>

										<!-- the loop -->
										<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

											<?php $product_id = (int)get_post_meta($post->ID,'product_id',true);
											$alignment = get_post_meta($post->ID,'text_alignment',true);
											$product = new WC_Product( $product_id );
											$product_price = $product->get_price_html();
											$product_permalink = get_permalink( $product_id );
											?>

											<a href="<?php echo $product_permalink;?>">
											<div class="item">
												<!-- an even slide -->
												<div class="slide">
													<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'slider_size' ); ?>
													<img src="<?php echo $image[0]; ?>" title="<?php echo get_the_title();?>" alt="<?php echo get_the_title();?>">
												</div>
												<?php if (strcmp($alignment, 'Right') == 0){?>
												<span class="slider_heading slider_even_heading">Featured product</span>
												<div class="slider_even_description">
													<h2><?php the_title();?></h2>
													<p class="product_even_description"><?php echo get_the_content();?></p>
													<p class="slider_even_price">only <?php echo $product_price;?></p>
													<p class="hidden-sm btn slider_btn_even btn-default">Shop Now!</p>
												</div>
												<!-- end slide -->
												<?php }
												else{?>
												<span class="slider_heading slider_odd_heading">Featured product</span>
												<div class="slider_odd_description">
													<h2><?php the_title();?></h2>
													<p class="product_odd_description"><?php echo get_the_content();?></p>
													<p class="slider_odd_price">only <?php echo $product_price;?></p>
													<p class="btn btn-default">Shop Now!</p>
												</div>
												<!-- end slide_2 -->
												<?php
												} ?>
											</div></a>
											<!-- end item -->

										<?php endwhile; ?>
										<!-- end of the loop -->
												
									<?php wp_reset_query(); ?>

									<?php else:  ?>
										<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
									<?php endif; ?>

						</div>
					</div>
					<!-- end slider row -->

					<div class="slider_support_box col-md-3">
						<div class="home_brochure_box">
							<a href="<?php echo get_option('brochure_link');?>" title="Lockout Safety Lockout Tagout Brochure Download"><img src="<?php bloginfo('template_directory');?>/img/download_catalogue.png" alt="Lockout Safety Lockout Tagout Brochure Download" title="Lockout Safety Lockout Tagout Brochure Download" /></a>
						</div>
						<!-- end product focus box -->

						<a href="<?php echo get_option('delivery_link');?>" title="Lockout Safety Delivery Policy"><div class="home_delivery_cost border">
							<p id="home_free_delivery">FREE DELIVERY ON ORDERS OVER €200!</p>
						</div>
						</a>
						<!-- end home brochure box -->

					</div>
				</div>
				<!-- end slider row -->


				<!-- hidden xs just temporary until owl is sorted for smaller screens -->
				<div class="hidden-xs home_featured_products_row row">
					<h2>Top Selling Products</h2>
					<div id="home_ft_products">
					
						<?php 
							 $args = array( 'post_type' => 'product', 'meta_key' => '_featured', 'meta_value' => 'yes' );
						     $loop = new WP_Query( $args );

						     while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>

								<div class="item">
									<div class="home_ft_items">
										<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
											<div class="home_ft_item">
												<div class="home_ft_item_ft_img">
													 <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'home_page_featured'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="184px" height="166px" />'; ?>
												</div>
												<div class="home_ft_item_price_bar">
													<p>only <span class="home_ft_item_price_span"><?php echo $product->get_price_html(); ?></span></p>								
												</div>
												<div class="home_ft_item_bottom_bar">
													<p>View Product >></p>
													<h3><?php echo get_parent_cats($loop->post->ID, 'product_cat');?></h3>
												</div>
											</div>
										</a>
									</div>
									<!-- end ft item 2 -->
								</div>

							<?php endwhile; ?>
						<?php wp_reset_query(); ?>
						
						
					</div>
				</div>
				<!-- end home featured products row -->

				<section class="main_content_section">

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