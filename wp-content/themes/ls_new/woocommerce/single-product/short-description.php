<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

if ( ! $post->post_excerpt ) return;
?>
<div itemprop="description">
	<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>

	<?php if (is_product_category()){ ?>
		<div class="read_more_wrap">
			<a href="<?php the_permalink();?>" title="<?php the_title();?>">Read more...</a>
		</div>
	<?php
	}?>

</div>
