<?php
/**
 * Plugin Name: Lockout Safety Training Banner
 * Plugin URI: http://powerpoint-engineering.com
 * Description: Lockout Safety Training Banner in the sidebar
 * Version: 1.00
 * Author: Everyone's Favourite Pole
 * Author URI: http://checkmywebsite.info
 * License: GPL2
 */

class LSN_training_banner extends WP_Widget{

	function __construct() {
		parent::__construct('lsn-training-banner-wgt', 'Lockout Safety Training Banner', array('description' => 'Listing of the scheduled dates of the LTSA Training'));
	}

	function widget($args, $instance){
	  $post_id = 136; 
	  $training_1_on = get_post_meta($post_id,'training_one_on',true);
	  $date_1 = date("D d M Y", strtotime(get_post_meta($post_id,'training_one_date',true)));
	  $availability_1 = get_post_meta($post_id,'training_one_availability',true);
	  $code_1 = get_post_meta($post_id,'training_one_paypal_button',true);

	  $training_2_on = get_post_meta($post_id,'training_two_on',true);
	  $date_2 = date("D d M Y", strtotime(get_post_meta($post_id,'training_two_date',true)));
	  $availability_2 = get_post_meta($post_id,'training_two_availability',true);
	  $code_2 = get_post_meta($post_id,'training_two_paypal_button',true);

	  $training_3_on = get_post_meta($post_id,'training_three_on',true);
	  $date_3 = date("D d M Y", strtotime(get_post_meta($post_id,'training_three_date',true)));
	  $availability_3 = get_post_meta($post_id,'training_three_availability',true);
	  $code_3 = get_post_meta($post_id,'training_three_paypal_button',true);

		?>
		<div id="side_training_wrapper" class="widget widget_lsn_training_dates_listing  col-xs-12 col-sm-6 col-md-12 lsn_right_widgets">
			<h3>Lockout Tagout Safety Awareness Training</h3>
			<div class="col-md-6 side_training_column">
				<img src="<?php bloginfo('template_directory');?>/img/training_image_sidebar.png" alt="Lockout Tagout Safety Awareness Training">
			</div>
			<div class="col-md-6 side_training_column">
				<a href="<?php bloginfo('url');?>/pdf/Lockout-Safety-Training-Flyer.pdf" title="Download the Lockout Tagout Safety Awareness Training Brochure" target="_blank"><img class="side_download_button" src="<?php bloginfo('template_directory');?>/img/small_download_button.png" alt="Download the Lockout Tagout Safety Awareness Training Brochure"></a>
			</div>

			<p id="side_training_upcoming">Scheduled Training Dates</p>

			<?php if (strcmp($availability_1, 'Available') == 0){ ?>
				<p class="side_training_dates"><?php echo $date_1 . ' - Portlaoise - ' . '<a class="book_now_class" href="' . get_bloginfo('url') . '/lockout-tagout-1-day-safety-awareness-training-course#training_section_wrapper' . '" title="Lockout Tagout Training - Book Now!">Book Now</a>'; ?></p>
			<?php 
			}
			else
			{ 
			?>
				<p class="side_training_dates"><?php echo $date_1 . ' - Portlaoise - ' . '<a class="booked_out_class" href="' . get_bloginfo('url') . '/lockout-tagout-1-day-safety-awareness-training-course#training_section_wrapper' . '" title="Lockout Tagout Training">Booked Out</a>'; ?></p>
			<?php
			}
			?>

			<?php if (strcmp($training_2_on, 'Yes') == 0){ ?>
				<?php if (strcmp($availability_2, 'Available') == 0){ ?>
				<p class="side_training_dates"><?php echo $date_2 . ' - Portlaoise - ' . '<a class="book_now_class"  href="' . get_bloginfo('url') . '/lockout-tagout-1-day-safety-awareness-training-course#training_section_wrapper' . '" title="Lockout Tagout Training - Book Now!">Book Now</a>'; ?></p>
				<?php 
				}
				else
				{ 
				?>
					<p class="side_training_dates"><?php echo $date_2 . ' - Portlaoise - ' . '<a class="booked_out_class" href="' . get_bloginfo('url') . '/lockout-tagout-1-day-safety-awareness-training-course#training_section_wrapper' . '" title="Lockout Tagout Training">Booked Out</a>'; ?></p>
				<?php
				}
				?>
			<?php
			}
			?>

			<?php if (strcmp($training_3_on, 'Yes') == 0){ ?>
				<?php if (strcmp($availability_3, 'Available') == 0){ ?>
				<p class="side_training_dates"><?php echo $date_3 . ' - Portlaoise - ' . '<a class="book_now_class"  href="' . get_bloginfo('url') . '/lockout-tagout-1-day-safety-awareness-training-course#training_section_wrapper' . '" title="Lockout Tagout Training - Book Now!">Book Now</a>'; ?></p>
				<?php 
				}
				else
				{ 
				?>
					<p class="side_training_dates"><?php echo $date_3 . ' - Portlaoise - ' . '<a class="booked_out_class" href="' . get_bloginfo('url') . '/lockout-tagout-1-day-safety-awareness-training-course#training_section_wrapper' . '" title="Lockout Tagout Training">Booked Out</a>'; ?></p>
				<?php
				}
				?>
			<?php
			}
			?>


		</div>

	<?php
	}

}

function lsn_training_banner_init(){
	register_widget('LSN_training_banner');
}
add_action('widgets_init', 'lsn_training_banner_init');

?>