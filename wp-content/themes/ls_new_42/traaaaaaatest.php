


<?php 
	 $args = array( 'post_type' => 'product', 'meta_key' => '_featured', 'meta_value' => 'yes' );
     $loop = new WP_Query( $args );

     while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>

		<div class="item">
			<div class="home_ft_items">
				<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
					<div class="home_ft_item">
						<div class="home_ft_item_ft_img">
							 <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'home_page_featured'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="184px" height="166px" />'; ?>
						</div>
						<div class="home_ft_item_price_bar">
							<p>only <span class="home_ft_item_price_span"><?php echo $product->get_price_html(); ?></span></p>								
						</div>
						<div class="home_ft_item_bottom_bar">
							<p>View Product >></p>
							<h3><?php echo get_parent_cats($loop->post->ID, 'product_cat');?></h3>
						</div>
					</div>
				</a>
			</div>
			<!-- end ft item 2 -->
		</div>

	<?php endwhile; ?>
<?php wp_reset_query(); ?>

<?php
function get_parent_cats($id , $taxonomy){
	$terms = get_the_terms( $id , $taxonomy );
	$temp_arr = array();
	foreach ( $terms as $term ) {
		$temp_arr[] = $term->name;
	}
	
	if (count($temp_arr) > 2){
		echo $temp_arr[1];
	}
	else
	{
		echo $temp_arr[0];
	}
	
}
?>