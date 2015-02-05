<?php
/**
 * The Header 
 */
?><!DOCTYPE html>
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
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<link href="<?php bloginfo('template_directory'); ?>/favicon.ico" rel="shortcut icon" />
    <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>> <!-- body start -->
	<div class="main_wrapper container"> <!-- start wrapper -->
		<header class="main_header"> <!-- header -->
			<div id="topbar" class="full_width_container">
				<div id="header_top_row" class="row">
					<div id="logo_element" class="col-sm-5">
						<a href="<?php bloginfo('url');?>">
							<div class="logo">	
							</div>
						</a>
					</div>
					<div id="header_contacts" class="col-md-4">
						Phone: <?php echo get_option('phone'); ?> <br />
						E-mail: <?php echo get_option('e_mail'); ?>
					</div>
					<div id="header_social_media" class="col-md-3">
						<ul class="top_social_media_box">
							<?php $check = get_option('facebook_link');
							if ($check != ''){
								?><a href="<?php echo get_option('facebook_link'); ?>" target="_blank"><li class="facebook_big"></li></a>
							<?php
							}
							$check = get_option('twitter_link');
							if ($check != ''){
								?><a href="<?php echo get_option('twitter_link'); ?>" target="_blank"><li class="twitter_big"></li></a>
							<?php
							}
							$check = get_option('linkedin_link');
							if ($check != ''){
								?><a href="<?php echo get_option('linkedin_link'); ?>" target="_blank"><li class="linkedin_big"></li></a>
							<?php
							}
							$check = get_option('gplus_link');
							if ($check != ''){
								?><a href="<?php echo get_option('gplus_link'); ?>" target="_blank"><li class="gplus_big"></li></a>
							<?php
							} ?>
						</ul>
					</div>
				</div> <!-- end of header top row element -->
			</div>
			<!-- end of topbar element -->

			<!-- navbar starts here -->
			<div class="row">
				<nav class="menu_container navbar navbar-default" role="navigation">
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
								'menu'              => 'header-menu',
								'theme_location'    => 'Header Menu',
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
				<!-- end main navigation -->
			</div>

			<div id="offer_slider" class="row">
				
				<div id="owl-demo" class="owl-carousel owl-theme">

					<!-- zdynamizowac -->
					<!-- limit 5 najnowszych ofert i nowy format zdjecia -->
 
					<?php 

					$args = array(
	                    'post_type' => 'offers',
	                    'posts_per_page' => 6,
	                    'order' => 'ASC'
	                );

					$the_query = new WP_Query($args); ?>

					<?php if ( $the_query->have_posts() ) : ?>

						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
							 
							 <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'header_offer' ); ?>
							<a href="<?php the_permalink();?>"><div class="item"><img src="<?php echo $image[0]; ?>" title="<?php echo get_the_title();?>" alt="<?php echo get_the_title();?>"><div class="caption_overlay"><h2><?php the_title();?></h2><p><?php the_content();?></p></div></div></a>
							
							
						<?php endwhile; ?>
						
					<?php wp_reset_postdata(); ?>

					<?php else:  ?>
						<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
					<?php endif; ?>
				</div>

			</div>


			
	

		</header><!-- end header -->

	