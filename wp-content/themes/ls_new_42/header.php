<?php
/* Template: Page Header
 * Version: 1.00
 * Last Modified: 13/01/2015 13:05:36
 */
?>

<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
	<!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width" />
		<title>Title</title>
		<!--<title><?php wp_title( '|', true, 'right' ); ?></title>--> <!-- REMEMBER TO UNCOMMENT -->
		<?php 
			checkRobots();
		?>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url');?>">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800,700,600' rel='stylesheet' type='text/css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<!-- <script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/source.min.js"></script> -->
		<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/source.js"></script>
		<link rel="icon" type="image/png" href="<?php bloginfo('template_directory');?>/img/favicon.png" />
		<?php wp_head();?>
	<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]--> 
	</head>

	<body <?php body_class('test1'); ?>>

		<header>

			<div class="top_row container">
			
				<div class="row">
					
					<div class="top_row_menu col-md-8">
						
						<nav class="navbar navbar-default" role="navigation">
						  <div class="container-fluid">
							<!-- Brand and toggle get grouped for better mobile display -->
							<div class="navbar-header">
							  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span>
								<span class="menu_toggle">Menu</span>
							  </button>
							</div>

								<?php
						            wp_nav_menu( array(
						                'menu'              => 'Overhead Menu',
						                'theme_location'    => 'top_overhead_menu',
						                'depth'             => 2,
						                'container'         => 'div',
						                'container_class'   => 'collapse navbar-collapse',
						        		'container_id'      => 'bs-example-navbar-collapse-1',
						                'menu_class'        => 'nav navbar-nav',
						                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
						                'walker'            => new wp_bootstrap_navwalker())
						            );
						        ?>
								
							</div>
						</nav>

					</div>
					<!-- end top_row_menu -->

					<div class="top_row_currency_selector col-md-4">
						<p>Choose your currency: 
						<select>
						  <option value="EUR">EUR</option>
						  <option value="GBR">GBR</option>
						</select>
						</p>
					</div>
					<!-- end top_row_currency_selector -->

				</div>
				<!-- end row -->

			</div>
			<!-- end top row container -->

			<div class="top_bar container">
				
				<div class="row">

					<div class="site_top_logo col-md-5">
						<a class="logo_link" href="<?php bloginfo('url');?>" title="LockoutSafety.com">
						<div class="top_logo"></div>
						</a>
					</div>
					<!-- end site_top_logo -->

					<div class="site_top_tagline col-md-5">
						<h1>THE COMPLETE <span class="tagline_highlight">LOCKOUT/TAGOUT</span> PROVIDER</h1>
					</div>
					<!-- end site_top_tagline -->

					<div class="site_top_contact col-md-2">
						<!-- <p id="site_top_call">CALL <a class="top_call" href="tel:+353578662162">+353 (0) 57 866 2162</a></p> -->
						<p id="site_top_call"><?php echo do_shortcode("[phone]"); ?></p>
						<p id="site_top_email"><a class="top_mail" href="mailto:sales@lockoutsafety.com?subject=LockoutSafety%20-%20Website%20Enquiry" title="Contact Lockout Safety">sales@lockoutsafety.com</a></p>
					</div>
					<!-- end site_top_contact_no -->
					
				</div>
				<!-- end row -->

			</div>
			<!-- end top bar container -->

		</header>
		<!-- end header -->

		<div class="pvw-title"><span>Normal</span></div>