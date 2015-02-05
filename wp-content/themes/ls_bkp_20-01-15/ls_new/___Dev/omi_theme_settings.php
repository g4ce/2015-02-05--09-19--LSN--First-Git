<?php 

/* Theme Settings page */

add_action( 'admin_menu', 'register_theme_settings_page' );

function getContentUri(){
	$uri = get_stylesheet_directory_uri();
	$contentUri;
	
	//http://localhost/wordpress/wp-content/themes/DSHiVaC

	$arr = explode('/', $uri);
	$arr_len = count($arr);
	if ($arr_len == 6)	// meaning domain.com/wp-admin
	{
		$contentUri = 'themes/'.$arr[5].'/utils/img/icon.png';
	}
	else if ($arr_len == 7)	// meaning domain.com/folder/wp-admin
	{
		$contentUri = 'themes/'.$arr[6].'/utils/img/icon.png';
	}
	return $contentUri;
}

function register_theme_settings_page(){
	 add_menu_page('Theme Settings Page', 'Theme Settings', 'edit_posts', 'themesettings', 'change_settings', content_url( getContentUri() ), 3 ); 
}

function change_settings(){
	?>
	<style type="text/css">
	h2.h2in_page{
		font-size: 23px;
		font-weight: 400;
		padding: 9px 15px 4px 0;
		line-height: 29px;
	}
	h3.h3in_page{
		font-size: 20px;
		font-weight: 350;
		padding: 9px 15px 4px 0;
		line-height: 25px;
	}
	</style>
	<?php
	
    echo '<h2 class="h2in_page">'.$theme_name.' Theme Settings Page</h2>';
	?>
	<form method="post" action="options.php">  
            <?php wp_nonce_field('update-options') ?> 
			
			<h3 class="h3in_page">Contact Details:</h3>		
			<p><strong>Hotline</strong><br />  
                <input type="text" name="phone" size="45" value="<?php echo get_option('phone'); ?>" />  
            </p>
            <p><strong>Company Email:</strong><br />  
                <input type="text" name="e_mail" size="45" value="<?php echo get_option('e_mail'); ?>" />  
            </p>
			<h3 class="h3in_page">Social Media Links:</h3>
			<p><strong>Facebook Link:</strong><br />  
				<input type="text" name="facebook_link" size="45" value="<?php echo get_option('facebook_link'); ?>" />  
			</p>
            <p><strong>Twitter Link:</strong><br />  
                <input type="text" name="twitter_link" size="45" value="<?php echo get_option('twitter_link'); ?>" />  
            </p> 
			<p><strong>GPlus Link:</strong><br />  
				<input type="text" name="gplus_link" size="45" value="<?php echo get_option('gplus_link'); ?>" />  
			</p>
			<p><strong>LinkedIn Link:</strong><br />  
				<input type="text" name="linkedin_link" size="45" value="<?php echo get_option('linkedin_link'); ?>" />  
			</p>
			<p><strong>Our Partners Text on home page:</strong><br />  
				<input type="text" name="partners_text" size="45" value="<?php echo get_option('partners_text'); ?>" />  
			</p>
			<p><strong>Newsletter Text:</strong><br />  
				<input type="text" name="newsletter_text" size="45" value="<?php echo get_option('newsletter_text'); ?>" />  
			</p>
            
            
            <p><input type="submit" name="Submit" value="Save Options" /></p>  
            <input type="hidden" name="action" value="update" />  
            <input type="hidden" name="page_options" value="phone,e_mail,facebook_link,twitter_link,gplus_link,linkedin_link,partners_text,newsletter_text" />  
    </form>  
	<?php
}

?>