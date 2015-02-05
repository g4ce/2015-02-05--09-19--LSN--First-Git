<?php
/**
 * Plugin Name: Lockout Safety Recent News
 * Plugin URI: http://powerpoint-engineering.com
 * Description: Listing of the latest news on Lockout Safety
 * Version: 1.04
 * Author: Everyone's Favourite Pole
 * Author URI: http://checkmywebsite.info
 * License: GPL2
 */

class LSN_recent_news extends WP_Widget{

	function __construct() {
		parent::__construct('lsn-recent-news-wgt', 'Lockout Safety Recent News', array('description' => 'Listing of the latest news on Lockout Safety'));
	}

	function widget($args, $instance){
		 $looop = array(
			'category_name' => 'news-promotion',
			'posts_per_page' => 5,
			'order' => 'DESC'
		);

		$the_query = new WP_Query($looop); ?>
		<div id="lsn_recent_news_wrap" class="widget widget_lsn_recent_news_listing"><h3 class="widgettitle">Latest News</h3>
			
			<?php if ( $the_query->have_posts() ) : ?>
		        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		          	
		          	<article id="<?php echo 'post-'.get_the_ID();?>">
		               
		               	<section class="widget_post"> 
		                  <div class="widget_post_date">
		                    <p class="day"><?php echo get_the_date('d');?><p>
		                    <p class="month"><?php echo get_the_date('M');?></p>
		                  </div>
		                  <header>
		                    <h5 class="lsn_news_title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
		                  </header>
		                </section>

		            </article>
		            <div class="clearfix"></div>

		        <?php endwhile; ?>
		        <!-- end of the loop -->

		        <?php wp_reset_postdata(); ?>

		      <?php else:  ?>
		        <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
		      <?php endif; ?>

		</div>
		<?php
	}

}

function lsn_recent_news_init(){
	register_widget('LSN_recent_news');
}
add_action('widgets_init', 'lsn_recent_news_init');

?>