<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

$heading = get_the_title();
?>

<?php if ( $heading ): ?>
  <h2 class="long_desc_heading"><?php echo $heading; ?></h2>
<?php endif; ?>

<?php the_content(); ?>
