		<footer class="main_footer container">

			<div class="footer_row row">

				<div class="footer_menu_general col-xs-4 col-sm-2">
					<h4 class="footer_menu_heading">Our Service</h4>
					<?php 
						wp_nav_menu(array(
						  'menu' => 'Footer Our Service Menu', 
						  'container_id' => 'footer_service_menu', 
						  'walker' => new CSS_Menu_Maker_Walker()
						)); 
					?>
				</div>
				<!-- end footer menu general -->

				<div class="footer_menu_information col-xs-4 col-sm-2">
					<h4 class="footer_menu_heading">Lockout Information</h4>
					<?php 
						wp_nav_menu(array(
						  'menu' => 'Footer Lockout Information Menu', 
						  'container_id' => 'footer_info_menu', 
						  'walker' => new CSS_Menu_Maker_Walker()
						)); 
					?>
				</div>
				<!-- end footer menu information -->

				<div class="footer_menu_account col-xs-4 col-sm-2">
					<h4 class="footer_menu_heading">My Account</h4>
					<?php 
						wp_nav_menu(array(
						  'menu' => 'Footer My Account Menu', 
						  'container_id' => 'footer_account_menu', 
						  'walker' => new CSS_Menu_Maker_Walker()
						)); 
					?>
				</div>
				<!-- end foooter menu account -->

				<div class="footer_right col-sm-6">
					<div class="footer_right_box">
						<h4 class="footer_menu_heading">Lockout Tagout Brochure</h4>
						<p>Please enter your name and address and we will send you a hard copy of our Lockout Tagout Magazine.</p>
						<?php echo do_shortcode('[contact-form-7 id="48" title="Request Brochure"]'); ?>
					</div>
					<!-- end first footer right box -->

					<div class="footer_right_box bottom_box">
						<div class="bottom_box_small footer_social_media">
							<h4 class="footer_menu_heading">Follow us</h4>
							<ul>
								<li class="footer_facebook"><a href="<?php echo get_option('facebook_link');?>" target="_blank" title="Follow Us on Facebook"></a></li>
								<li class="footer_twitter"><a href="<?php echo get_option('twitter_link');?>" target="_blank" title="Follow Us on Twitter"></a></li>
								<li class="footer_youtube"><a href="<?php echo get_option('youtube_link');?>" target="_blank" title="View Our YouTube Channel"></a></li>
								<li class="footer_linkedin"><a href="<?php echo get_option('linkedin_link');?>" target="_blank" title="Follow us on LinkedIn"></a></li>
							</ul>
						</div>
						<!-- end social media footer -->

						<div class="bottom_box_small footer_payment_methods">
							<h4 class="footer_menu_heading">Payment Methods</h4>
							<img src="<?php bloginfo('template_directory');?>/img/g_payments_methods.png" alt="Accepted Payment Methods" />
						</div>
						<!-- end payment methods footer -->
					</div>
					<div class="clearfix"></div>
					<!-- end second footer right box -->
				</div>
				<!-- end footer menu right -->
				
			</div>
			<!-- end footer row -->
			<div id="copyrights">
				<p>&copy; <?php echo date("Y");?> <?php echo get_bloginfo('name');?>. All Rights Reserved. | <a href="<?php echo get_option('privacy_link');?>">Privacy Policy</a>.
			</div>
			<!-- end copyrights -->

		</footer>
		<!-- end footer -->
	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<?php wp_footer(); ?>
	
	</body>
	<!-- end body -->
</html>
<!-- end html -->
	