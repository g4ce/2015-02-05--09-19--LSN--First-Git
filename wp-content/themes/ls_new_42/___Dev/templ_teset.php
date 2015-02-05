<?php
/**
 * Template name: Tester
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>
<?php get_sidebar(); ?>
		<div id="primary">
			<div id="content" role="main">

				<?php 
					$args = array(
	                    'post_type' => 'trainings',
	                    'posts_per_page' => 5,
	                    'order' => 'ASC'
	                );

					$the_query = new WP_Query($args); ?>
					
					<?php if ( $the_query->have_posts() ) : ?>

						<!-- pagination here -->
						<div class="entry-content">
						<h1 class="cat-title">ATEX Training</h1>
						<?php the_content();?>

						</div>

						<div id="training_wrapper">
						<h2><strong>Scheduled Trainings:</strong></h2>
						<table style="text-align: left; width: 100%;" border="0" cellpadding="10" cellspacing="2">
						<tbody>

						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

							<?php $active = get_post_meta($post->ID, 'training-availability', true );
							$date = get_post_meta($post->ID, 'training-date', true );
							$calendar_date = getDateForCalendarSnippet($date);
							$trainingtype = get_post_meta($post->ID, 'training-type', true );
							$venue = get_post_meta($post->ID, 'venue', true );
							$venue_location = get_post_meta($post->ID, 'venue_location', true );
							$code = get_post_meta($post->ID, 'paypal_button_code', ture);

							if ((strcmp($active, 'Available') == 0) && (check_valid_date($date))){ ?>
								<tr>
								<td class="stable"><strong><?php echo getTrainingDate($date);?></strong><br>
								</td>
								<td class="stable"><strong><?php echo $venue;?><br><?php echo $venue_location;?></strong><br>
								</td>
								<td class="stable"><?php echo do_shortcode( '[training training_name="ATEX Safety Awareness Training" training_start_date="'.$calendar_date.'" training_duration="2" training_location="Portlaoise - Maldron Hotel"]' ); ?><br>
								</td>
								<td class="stable"><strong><?php echo $g_price;?></strong><br>
								</td>
								<td class="stable">
									<?php if (strcmp($trainingtype, '1 Day Training') == 0){
										echo $code;
									}
									else if (strcmp($trainingtype, '2 Day Training') == 0){
										echo $code;
									}
									?>
								</td>
								</tr>
								<?php
							}
							else if ((strcmp($active, 'Booked Out') == 0) && (check_valid_date($date))){ ?>
								<tr>
								<td class="stable"><strong><?php echo getTrainingDate($date);?></strong><br>
								</td>
								<td class="stable"><strong><?php echo the_title(); ?></strong><br>
								</td>
								<td class="stable"><strong><?php echo $venue;?></strong><br>
								</td>
								<td class="stable"><strong><?php echo $g_price;?></strong><br>
								</td>
								<td class="stable"><span class="g_booked_out"><strong>BOOKED OUT</strong></span><br>
								</td>
								</tr>
								<?php
							}
							else{
							}?>

						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
						</tbody>
						</table>
						</div>



					<?php else:  ?>
						<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
					<?php endif; ?>
					<?php the_excerpt();?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>