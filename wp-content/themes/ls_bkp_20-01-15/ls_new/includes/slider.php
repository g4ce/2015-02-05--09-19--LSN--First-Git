<!-- need to make this template dynamic -->

<div id="da-slider" class="da-slider">
<?php 
$args = array(
    'post_type' => 'slides',
    'order' => 'ASC'
);

$the_query = new WP_Query($args); ?>

<?php if ( $the_query->have_posts() ) : ?>

	<!-- the loop -->
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<a href="<?php echo get_post_meta($post->ID,'PRODUCT_URL',true);?>"><div class="da-slide">
			<h2><span><?php the_title();?></span></h2>
			<p><?php the_content();?></p>	
			<a href="<?php echo get_post_meta($post->ID,'PRODUCT_URL',true);?>" title="<?php echo get_the_title();?>" class="da-link">Our Price<span class="slider_price"> <?php echo get_post_meta($post->ID,'PRODUCT_PRICE',true);?> -- Buy!</span></a>
			<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'standard_recipe' ); ?>
			<div class="da-img"><img src="<?php echo $image[0]; ?>" title="<?php echo get_the_title();?>" alt="<?php echo get_the_title();?>" /></div>
		</div></a>
	<?php endwhile; ?>
	<!-- end of the loop -->
	<nav class="da-arrows">
		<span class="da-arrows-prev"></span>
		<span class="da-arrows-next"></span>
	</nav>
	<!-- pagination here -->
	
<?php wp_reset_postdata(); ?>

<?php endif; ?>
</div>