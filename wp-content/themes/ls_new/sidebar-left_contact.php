<?php
/* Template: Left Sidebar for Contact Page
 * Version: 1.00
 * Last Modified: 21/01/2015 11:59:28
 */
?>
	<!-- widgetized sidebar starts here -->
	<?php if ( is_active_sidebar( 'ls-left-sidebar-contact' ) ) : ?>
	<?php dynamic_sidebar( 'ls-left-sidebar-contact' ); ?>
	<?php endif; ?>