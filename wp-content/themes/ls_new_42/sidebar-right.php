<?php
/* Template: Left Sidebar
 * Version: 1.00
 * Last Modified: 14/01/2015 10:27:12
 */
?>

	<!-- widgetized sidebar starts here -->
	<?php if ( is_active_sidebar( 'ls-right-sidebar' ) ) : ?>
	<?php dynamic_sidebar( 'ls-right-sidebar' ); ?>
	<?php endif; ?>