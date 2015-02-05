<?php
/**
 * Plugin Name: Lockout Safety Side Delivery
 * Plugin URI: http://powerpoint-engineering.com
 * Description: Delivery Price Banner
 * Version: 1.00
 * Author: Everyone's Favourite Pole
 * Author URI: http://checkmywebsite.info
 * License: GPL2
 */

class LSN_delivery_banner extends WP_Widget{

	function __construct() {
		parent::__construct('lsn-delivery-banner-wgt', 'Lockout Safety Delivery Banner', array('description' => 'Delivery banner appearing on the right hand side'));
	}

	function widget($args, $instance){ ?>

		<div id="side_delivery_wrapper" class="widget widget_lsn_delivery col-xs-12 col-sm-6 col-md-12 lsn_right_widgets">
		 	<h3 id="delivery_banner_heading">Free Delivery On Orders Over €200 + VAT</h3>
		 </div>
		 <?php 
	}

}

function lsn_delivery_banner_init(){
	register_widget('LSN_delivery_banner');
}
add_action('widgets_init', 'lsn_delivery_banner_init');

?>