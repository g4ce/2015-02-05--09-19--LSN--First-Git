<?php
/* Template name: 2 Column Template Option 2
 * Version: 1.00
 * Last Modified: 14/01/2015 09:20:26
 */
?>
<?php get_header();?>

	<div id="breadsearch" class="container border12">
		<div class="row">
			<div class="search_box col-sm-12 col-md-3 border12">
				<div class="input-group">
			      <input type="text" class="form-control" placeholder="Search for...">
			      <span class="input-group-btn">
			        <button class="btn btn-default" type="button">Go!</button>
			      </span>
			    </div><!-- /input-group -->
			</div>
			<!-- end search box -->

			<div class="breadcrs hidden-xs hidden-sm col-md-9 border12">
				Home / Safety Padlocks / Composite Safety Padlocks
			</div>
			<!-- end breadcrs -->

		</div>
		<!-- end row -->
	</div>
	<!-- end breadsearch -->

	<div class="middle_wrapper container border12 with_top_margin_10">
		
		<!-- two column layout -->

		<div class="row">
	        <!-- left column -->
			<div class="left_pane col-xs-4 col-md-3 border12">
				<!-- get left sidebar -->
				<?php get_sidebar('left');?>
			</div>
			<!-- end left column -->
	
			<!-- left column -->
			<div class="content_pane_two_cols_sidebar_left col-xs-8 col-md-9 border12">
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. </p>
	
				<p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. </p>
	
				<p>Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. </p>
	
			</div>
			<!-- end left column -->
		</div>	
		<!-- end row -->

	</div>
	<!-- end middle_wrapper container -->

<?php get_footer();?>