<?php
/* Template: Left Sidebar
 * Version: 1.00
 * Last Modified: 14/01/2015 10:27:12
 */
?>

	<div id="search_box">
		<div class="input-group">
		  <input type="text" class="form-control" placeholder="Search for...">
		  <span class="input-group-btn">
		    <button class="btn btn-default btn-search" type="button">Search</button>
		  </span>
		</div><!-- /input-group -->
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