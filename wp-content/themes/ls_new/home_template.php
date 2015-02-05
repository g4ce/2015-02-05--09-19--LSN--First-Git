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

							<a href="#"><div class="item">
								<!-- an even slide -->
								<div class="slide">
									<img src="<?php bloginfo('template_directory');?>/img/slide01.png" alt="" title="" />
								</div>
								<span class="slider_heading slider_even_heading">Featured product</span>
								<div class="slider_even_description">
									<h2>Safety Padlocks</h2>
									<p class="product_even_description">410 Zenex Safety Padlocks
Withstands temperatures of -57°C to +177°C 
4 Key Types - 8 Colour Options</p>
									<p class="slider_even_price">only €22.22</p>
									<p class="hidden-sm btn slider_btn_even btn-default">Shop Now!</p>
								</div>
								<!-- end slide_1 -->
		 					</div>
		 					</a>
							<!-- end item -->

							<a href="#"><div class="item">
								<!-- an odd slide -->
								<div class="slide">
									<img src="<?php bloginfo('template_directory');?>/img/slide02.png" alt="" title="" />
								</div>
								<span class="slider_heading slider_odd_heading">Featured product</span>
								<div class="slider_odd_description">
									<h2>Cable Lockout</h2>
									<p class="product_odd_description">Ideal for simultaneous lock-out of multiple valves and circuit breakers. Device can be locked using four padlocks. Can be adjusted once the cable is locked.</p>
									<p class="slider_odd_price">only €22.22</p>
									<p class="btn btn-default">Shop Now!</p>
								</div>
								<!-- end slide_2 -->
		 					</div>
		 					</a>
							<!-- end item -->

							<a href="#"><div class="item">
								<!-- an even slide -->
								<div class="slide">
									<img src="<?php bloginfo('template_directory');?>/img/slide03.png" alt="" title="" />
								</div>
								<span class="slider_heading slider_even_heading">Featured product</span>
								<div class="slider_even_description">
									<h2>497A "DO NOT OPERATE" tags</h2>
									<p class="product_even_description">Grease and dirt resistant polyester laminate.
Can be customised with name, 
department, planned task, etc...</p>
									<p class="slider_even_price">only €22.22</p>
									<p class="btn slider_btn_even btn-default">Shop Now!</p>
								</div>
								<!-- end slide_1 -->
		 					</div>
		 					</a>
							<!-- end item -->

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
						<div class="item">
							<div class="home_ft_items">
								<a href="#" title="###">
									<div class="home_ft_item">
										<div class="home_ft_item_ft_img">
											<img src="<?php bloginfo('template_directory');?>/img/dev/01.png" alt="###" />
										</div>
										<div class="home_ft_item_price_bar">
											<p>only <span class="home_ft_item_price_span">€22.22</span></p>								
										</div>
										<div class="home_ft_item_bottom_bar">
											<p>View Product >></p>
											<h3>Safety Padlocks</h3>
										</div>
									</div>
								</a>
							</div>
							<!-- end ft item 2 -->
						</div>
						<div class="item">
							<div class="home_ft_items">
								<a href="#" title="###">
									<div class="home_ft_item">
										<div class="home_ft_item_ft_img">
											<img src="<?php bloginfo('template_directory');?>/img/dev/02.png" alt="###" />
										</div>
										<div class="home_ft_item_price_bar">
											<p>only <span class="home_ft_item_price_span">€22.22</span></p>								
										</div>
										<div class="home_ft_item_bottom_bar">
											<p>View Product >></p>
											<h3>Lockout Hasps</h3>
										</div>
									</div>
								</a>
							</div>
							<!-- end ft item 2 -->
						</div>
						<div class="item">
							<div class="home_ft_items">
								<a href="#" title="###">
									<div class="home_ft_item">
										<div class="home_ft_item_ft_img">
											<img src="<?php bloginfo('template_directory');?>/img/dev/03.png" alt="###" />
										</div>
										<div class="home_ft_item_price_bar">
											<p>only <span class="home_ft_item_price_span">€22.22</span></p>								
										</div>
										<div class="home_ft_item_bottom_bar">
											<p>View Product >></p>
											<h3>Lockout Kits</h3>
										</div>
									</div>
								</a>
							</div>
							<!-- end ft item 2 -->
						</div>
						<div class="item">
							<div class="home_ft_items">
								<a href="#" title="###">
									<div class="home_ft_item">
										<div class="home_ft_item_ft_img">
											<img src="<?php bloginfo('template_directory');?>/img/dev/04.png" alt="###" />
										</div>
										<div class="home_ft_item_price_bar">
											<p>only <span class="home_ft_item_price_span">€22.22</span></p>								
										</div>
										<div class="home_ft_item_bottom_bar">
											<p>View Product >></p>
											<h3>Gas Valve Lockouts</h3>
										</div>
									</div>
								</a>
							</div>
							<!-- end ft item 2 -->
						</div>
						<div class="item">
							<div class="home_ft_items">
								<a href="#" title="###">
									<div class="home_ft_item">
										<div class="home_ft_item_ft_img">
											<img src="<?php bloginfo('template_directory');?>/img/dev/05.png" alt="###" />
										</div>
										<div class="home_ft_item_price_bar">
											<p>only <span class="home_ft_item_price_span">€22.22</span></p>								
										</div>
										<div class="home_ft_item_bottom_bar">
											<p>View Product >></p>
											<h3>Cable Lockouts</h3>
										</div>
									</div>
								</a>
							</div>
							<!-- end ft item 2 -->
						</div>
						<div class="item">
							<div class="home_ft_items">
								<a href="#" title="###">
									<div class="home_ft_item">
										<div class="home_ft_item_ft_img">
											<img src="<?php bloginfo('template_directory');?>/img/dev/06.png" alt="###" />
										</div>
										<div class="home_ft_item_price_bar">
											<p>only <span class="home_ft_item_price_span">€22.22</span></p>								
										</div>
										<div class="home_ft_item_bottom_bar">
											<p>View Product >></p>
											<h3>Lockout Tags</h3>
										</div>
									</div>
								</a>
							</div>
							<!-- end ft item 2 -->
						</div>
						
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