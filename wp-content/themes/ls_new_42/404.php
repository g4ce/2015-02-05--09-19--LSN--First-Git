<?php
/* Template name: 2 columns Template Conctact
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

				<div class="the_content">

					<div class="row 404_row">
						<div class="hidden-xs col-md-6 image_404">
							<img src="<?php bloginfo('template_directory');?>/img/404.png" alt="404 - Page Not Found" />
						</div>
						<!-- end 404 image -->

						<div class="col-md-6 box_404">
							<h2>404 - Page Not Found</h2>
							<p>We are very sorry, but the page you are looking for <span>cannot</span> be found.</p>
							<p>However here's what you can do:</p>
							<ul>
								<li>Use the search facility in top left corner of your screen.</li>
								<li>Use the category menu to find the product you are after.</li>
								<li>If you are experiencing any difficulties with our website, please do not hesitate to contact us on <a href="mailto:sales@lockoutsafety.com?subject=LockoutSafety%20-%20website%20problem" title="Contact LockoutSafety.com">sales@lockoutsafety.com</a>.</li>
							</ul>
							<p class="go_home">To go back to home page please <a href="<?php bloginfo('url');?>" title="LockoutSafety.com">click here</a>.</p>
						</div>
						<!-- end 404_box -->
					</div>
					<!-- end 404 row -->
				</div>
				<!-- end the content -->
	
			</div>
			<!-- end left column -->

		</div>	
		<!-- end row -->

	</div>
	<!-- end middle_wrapper container -->

<?php get_footer();?>