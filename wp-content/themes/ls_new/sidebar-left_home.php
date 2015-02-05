<?php
/* Template: Left Sidebar
 * Version: 1.00
 * Last Modified: 14/01/2015 10:27:12
 */
?>

	<div id="search_box">
		<?php lsn_get_product_search_form(); ?>
	</div>
	<section id="sidebar_menu">
		<div class="widget_header menu_header">
			<h3> >> Categories</h3>
		</div>

		<!-- dynamic menu starts here -->
		<?php 
		wp_nav_menu(array(
		  'menu' => 'Product Category Navigation', 
		  'container_id' => 'cssmenu', 
		  'walker' => new CSS_Menu_Maker_Walker()
		)); 
		?>

		<!-- dynamic menu ends here -->
	</section>

	<!-- widgetized sidebar starts here -->
	<?php if ( is_active_sidebar( 'ls-left-sidebar-home' ) ) : ?>
	<?php dynamic_sidebar( 'ls-left-sidebar-home' ); ?>
	<?php endif; ?>