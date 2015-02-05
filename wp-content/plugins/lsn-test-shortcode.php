<?php
/**
 * Plugin Name: Lockout Safety Test  Shortcode
 * Plugin URI: http://powerpoint-engineering.com
 * Description: Sraka kaka
 * Version: 1.00
 * Author: Everyone's Favourite Pole
 * Author URI: http://checkmywebsite.info
 * License: GPL2
 */

class LSN_test_shortcode extends WP_Widget{

	function __construct() {
		parent::__construct('lsn-test-shortcode-wgt', 'Lockout Safety Test', array('description' => 'Testing inf shortcode will work'));
	}

	function widget($args, $instance){
		 
		lsn_cart_email_enq_modal();
		
	}

}

function lsn_test_shortcode_init(){
	register_widget('LSN_test_shortcode');
}
add_action('widgets_init', 'lsn_test_shortcode_init');

?>