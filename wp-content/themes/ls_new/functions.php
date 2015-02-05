<?php
/* Template: Core Functions
 * Version: 1.00
 * Last Modified: 26/01/2015 09:55:05
 * Last Action: Tidy up
 */

/* Function Index 
 * --------------
 * 1. Nav Walkers
 *  1.1.  Sidebar / Footer Menu Walker
 *  1.2.  Bootstrap Menu Walker
 * 
 * 2. Theme Settings
 *
 * 3. Wordpress Settings
 *  3.1.  Register Menus
 *  3.2.  Register Sidebars
 *  3.3.  Add Image Size
 *  3.4.  Add Theme Support
 *
 * 4.  Register Custom Posts
 *
 * 5.  Woo Functions
 *  5.1.  Remove Woo Actions
 *  5.2.  Add Woo Filters / Actions
 *  5.3.  Add Woo Filters / Actions Functions
 *   5.3.1.  Single Product E-mail Enquiry
 *   5.3.2.  Start Button Wrap
 *   5.3.3.  End Button Wrap
 *   5.3.4.  End Button Wrap
 *   5.3.5.  Cart Email Enquiry
 *   5.3.6  Catalog Page Ordering
 *
 * 6.  SELF FUNCTIONS
 *  6.1.  Get Cat Children
 *  6.2.  Display Phone Shortcode
 *  6.3.  Actual Email Enquiry
 *  6.4.  Attach to CF7
 *  6.5.  Set Robots Meta tag
 */

add_filter('widget_text', 'do_shortcode');

/** 1.  NAV WALKERS **/

/**** 1.1.  Sidebar / Footer Menu Walker */
class CSS_Menu_Maker_Walker extends Walker {

  var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );
  
  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul>\n";
  }
  
  function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul>\n";
  }
  
  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
  
    global $wp_query;
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    $class_names = $value = ''; 
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    
    /* Add active class */
    if(in_array('current-menu-item', $classes)) {
      $classes[] = 'active';
      unset($classes['current-menu-item']);
    }
    
    /* Check for children */
    $children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
    if (!empty($children)) {
      $classes[] = 'has-sub';
    }
    
    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
    
    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
    
    $output .= $indent . '<li' . $id . $value . $class_names .'>';
    
    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
    
    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'><span>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= '</span></a>';
    $item_output .= $args->after;
    
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }
  
  function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $output .= "</li>\n";
  }
}

/**** 1.2.  Bootstrap Menu Walker */
class wp_bootstrap_navwalker extends Walker_Nav_Menu {
  /**
   * @see Walker::start_lvl()
   * @since 3.0.0
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param int $depth Depth of page. Used for padding.
   */
  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat( "\t", $depth );
    $output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
  }
  /**
   * @see Walker::start_el()
   * @since 3.0.0
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param object $item Menu item data object.
   * @param int $depth Depth of menu item. Used for padding.
   * @param int $current_page Menu item ID.
   * @param object $args
   */
  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    /**
     * Dividers, Headers or Disabled
     * =============================
     * Determine whether the item is a Divider, Header, Disabled or regular
     * menu item. To prevent errors we use the strcasecmp() function to so a
     * comparison that is not case sensitive. The strcasecmp() function returns
     * a 0 if the strings are equal.
     */
    if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
      $output .= $indent . '<li role="presentation" class="divider">';
    } else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
      $output .= $indent . '<li role="presentation" class="divider">';
    } else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
      $output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
    } else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
      $output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
    } else {
      $class_names = $value = '';
      $classes = empty( $item->classes ) ? array() : (array) $item->classes;
      $classes[] = 'menu-item-' . $item->ID;
      $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
      if ( $args->has_children )
        $class_names .= ' dropdown';
      if ( in_array( 'current-menu-item', $classes ) )
        $class_names .= ' active';
      $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
      $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
      $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
      $output .= $indent . '<li' . $id . $value . $class_names .'>';
      $atts = array();
      $atts['title']  = ! empty( $item->title ) ? $item->title  : '';
      $atts['target'] = ! empty( $item->target )  ? $item->target : '';
      $atts['rel']    = ! empty( $item->xfn )   ? $item->xfn  : '';
      // If item has_children add atts to a.
      if ( $args->has_children && $depth === 0 ) {
        $atts['href']       = '#';
        $atts['data-toggle']  = 'dropdown';
        $atts['class']      = 'dropdown-toggle';
        $atts['aria-haspopup']  = 'true';
      } else {
        $atts['href'] = ! empty( $item->url ) ? $item->url : '';
      }
      $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
      $attributes = '';
      foreach ( $atts as $attr => $value ) {
        if ( ! empty( $value ) ) {
          $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
          $attributes .= ' ' . $attr . '="' . $value . '"';
        }
      }
      $item_output = $args->before;
      /*
       * Glyphicons
       * ===========
       * Since the the menu item is NOT a Divider or Header we check the see
       * if there is a value in the attr_title property. If the attr_title
       * property is NOT null we apply it as the class name for the glyphicon.
       */
      if ( ! empty( $item->attr_title ) )
        $item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
      else
        $item_output .= '<a'. $attributes .'>';
      $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
      $item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';
      $item_output .= $args->after;
      $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
  }
  /**
   * Traverse elements to create list from elements.
   *
   * Display one element if the element doesn't have any children otherwise,
   * display the element and its children. Will only traverse up to the max
   * depth and no ignore elements under that depth.
   *
   * This method shouldn't be called directly, use the walk() method instead.
   *
   * @see Walker::start_el()
   * @since 2.5.0
   *
   * @param object $element Data object
   * @param array $children_elements List of elements to continue traversing.
   * @param int $max_depth Max depth to traverse.
   * @param int $depth Depth of current element.
   * @param array $args
   * @param string $output Passed by reference. Used to append additional content.
   * @return null Null on failure with no changes to parameters.
   */
  public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;
        $id_field = $this->db_fields['id'];
        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
  /**
   * Menu Fallback
   * =============
   * If this function is assigned to the wp_nav_menu's fallback_cb variable
   * and a manu has not been assigned to the theme location in the WordPress
   * menu manager the function with display nothing to a non-logged in user,
   * and will add a link to the WordPress menu manager if logged in as an admin.
   *
   * @param array $args passed from the wp_nav_menu function.
   *
   */
  public static function fallback( $args ) {
    if ( current_user_can( 'manage_options' ) ) {
      extract( $args );
      $fb_output = null;
      if ( $container ) {
        $fb_output = '<' . $container;
        if ( $container_id )
          $fb_output .= ' id="' . $container_id . '"';
        if ( $container_class )
          $fb_output .= ' class="' . $container_class . '"';
        $fb_output .= '>';
      }
      $fb_output .= '<ul';
      if ( $menu_id )
        $fb_output .= ' id="' . $menu_id . '"';
      if ( $menu_class )
        $fb_output .= ' class="' . $menu_class . '"';
      $fb_output .= '>';
      $fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
      $fb_output .= '</ul>';
      if ( $container )
        $fb_output .= '</' . $container . '>';
      echo $fb_output;
    }
  }
}

/** 2.  THEME SETTINGS **/

add_action( 'admin_menu', 'register_theme_settings_page' );

$icon_location = get_bloginfo('template_directory').'/img/icon.png';
//echo $icon_location;
//

function register_theme_settings_page(){
   add_menu_page('Theme Settings Page', 'Theme Settings', 'manage_options', 'themesettings', 'change_settings','http://localhost/lsn/powerp/wp-content/themes/ls_new/img/icon.png', 3 ); 
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
  
    echo '<h2 class="h2in_page">'.$theme_name.' Extra Settings Page</h2>';
  ?>
  <form method="post" action="options.php">  
    <?php wp_nonce_field('update-options') ?>

    <h3 class="h3in_page">Social Media Links:</h3>
    <p><strong>Facebook Link:</strong><br />  
      <input type="text" name="facebook_link" size="45" value="<?php echo get_option('facebook_link'); ?>" />  
    </p>
    <p><strong>Twitter Link:</strong><br />  
      <input type="text" name="twitter_link" size="45" value="<?php echo get_option('twitter_link'); ?>" />  
    </p> 
    <p><strong>Youtube Link:</strong><br />  
      <input type="text" name="youtube_link" size="45" value="<?php echo get_option('youtube_link'); ?>" />  
    </p>
    <p><strong>LinkedIn Link:</strong><br />  
      <input type="text" name="linkedin_link" size="45" value="<?php echo get_option('linkedin_link'); ?>" />  
    </p>

    <h3 class="h3in_page">Site Settings:</h3>
    <p><strong>Display Related Products (Y/N):</strong><br />  
      <input type="text" name="is_related" size="45" value="<?php echo get_option('is_related'); ?>" />  
    </p>
    <p><strong>Download Brochure Link:</strong><br />  
      <input type="text" name="brochure_link" size="45" value="<?php echo get_option('brochure_link'); ?>" />  
    </p>
    <p><strong>Delivery Policy Link:</strong><br />  
      <input type="text" name="delivery_link" size="45" value="<?php echo get_option('delivery_link'); ?>" />  
    </p>
    <p><strong>Privacy Policy Link:</strong><br />  
      <input type="text" name="privacy_link" size="45" value="<?php echo get_option('privacy_link'); ?>" />  
    </p>

    <h3 class="h3in_page">SEO Settings:</h3>
    <p><strong>Google Analytics (Y/N):</strong><br />  
      <input type="text" name="analytics" size="45" value="<?php echo get_option('analytics'); ?>" />  
    </p>
    <p><strong>Conversion/Goal Tracking on Sales (Y/N):</strong><br />  
      <input type="text" name="tracking_sales" size="45" value="<?php echo get_option('tracking_sales'); ?>" />  
    </p>
    <p><strong>Conversion/Goal Tracking on Email Enquiries (Y/N):</strong><br /> 
      <input type="text" name="tracking_enquiries" size="45" value="<?php echo get_option('tracking_enquiries'); ?>" />  
    </p>
    <p><strong>Conversion/Goal Tracking on Contact Form (Y/N):</strong><br />   
      <input type="text" name="tracking_emails" size="45" value="<?php echo get_option('tracking_emails'); ?>" />  
    </p>
    <p><strong>Conversion/Goal Tracking on Brochure Request (Y/N):</strong><br /> 
      <input type="text" name="tracking_brochures" size="45" value="<?php echo get_option('tracking_brochures'); ?>" />  
    </p>
    <p><strong>Conversion/Goal Tracking on Mobile Clicks (Y/N):</strong><br />   
      <input type="text" name="tracking_mobiles" size="45" value="<?php echo get_option('tracking_mobiles'); ?>" />  
    </p>

    <p><input type="submit" name="Submit" value="Save Options" /></p>  
    <input type="hidden" name="action" value="update" />  
    <input type="hidden" name="page_options" value="facebook_link,twitter_link,youtube_link,linkedin_link,is_related,brochure_link,delivery_link,privacy_link,analytics,tracking_sales,tracking_enquiries,tracking_emails,tracking_brochures,tracking_mobiles" />  
  </form>  
  <?php
}




/** 3.  WORDPRESS SETTINGS **/
/**** 3.1.  Register Menus */
register_nav_menus( array(
  'top_overhead_menu' => 'Overhead Menu',
  'side_bar_menu' => 'Product Category Navigation',
  'footer_service_menu' => 'Footer Our Service Menu',
  'footer_info_menu' => 'Footer Lockout Information Menu',
  'footer_account_menu' => 'Footer My Account Menu'
) );

/**** 3.2.  Register Sidebars */
$left_args = array(
  'name'          => __( 'Left Sidebar', 'lsn' ),
  'id'            => 'ls-left-sidebar',
  'description'   => 'Left sidebar that appears on normal 3 column pages',
        'class'         => '',
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget'  => '</div>',
  'before_title'  => '<h3 class="widgettitle">',
  'after_title'   => '</h3>' );

$left_args_home = array(
  'name'          => __( 'Left Sidebar on Homepage', 'lsn' ),
  'id'            => 'ls-left-sidebar-home',
  'description'   => 'Left sidebar that appears only on Home Page',
        'class'         => '',
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget'  => '</div>',
  'before_title'  => '<h3 class="widgettitle">',
  'after_title'   => '</h3>' );

$right_args = array(
  'name'          => __( 'Right Sidebar', 'lsn' ),
  'id'            => 'ls-right-sidebar',
  'description'   => 'Right sidebar that appears on normal 3 column pages',
        'class'         => '',
  'before_widget' => '<div id="%1$s" class="col-xs-12 col-sm-6 col-md-12 lsn_right_widgets widget %2$s">',
  'after_widget'  => '</div>',
  'before_title'  => '<h3 class="widgettitle">',
  'after_title'   => '</h3>' );


$currency_selector_top = array(
  'name'          => __( 'Currency Selector Wgt', 'lsn' ),
  'id'            => 'currency-selector-wgt',
  'description'   => 'Currency Selector in the Header',
        'class'         => '',
  'before_widget' => '',
  'after_widget'  => '',
  'before_title'  => '',
  'after_title'   => '' );

register_sidebar( $left_args );
register_sidebar( $right_args );
register_sidebar( $left_args_home );
register_sidebar( $currency_selector_top );

/**** 3.3.  Add Image Size */
add_image_size( 'home_page_featured', 184, 166, true );
add_image_size( 'slider_size', 619, 230, true );

/**** 3.4.  Add Theme Support */
add_theme_support( 'woocommerce' );

/**** 3.5.  Add Login/Logout Buttons */

add_filter( 'wp_nav_menu_items', 'add_loginout_link_overhead', 10, 2 );
function add_loginout_link_overhead( $items, $args ) {
    if (is_user_logged_in() && $args->theme_location == 'top_overhead_menu') {
        $items .= '<li><a href="'. get_bloginfo('url') . '/?customer-logout=true' .'">Log Out</a></li>';
    }
    elseif (!is_user_logged_in() && $args->theme_location == 'top_overhead_menu') {
        $items .= '<li><a href="'. get_bloginfo('url') .'/my-account/">Log In</a></li>';
    }
    return $items;
}

/** 4.  REGISTER CUSTOM POSTS */
function add_menu_icons_styles() /* v. 1.00 */{
  // http://melchoyce.github.io/dashicons/
?>
 
<style>
#adminmenu .menu-icon-trainings div.wp-menu-image:before {
  content: "\f118";
}
#adminmenu .menu-icon-testimonials div.wp-menu-image:before {
  content: "\f328";
}
</style>
 
<?php
}
add_action( 'admin_head', 'add_menu_icons_styles' );

add_action( 'init', 'lsn_slider_init' );
/**
 * Register a ATEX Training post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function lsn_slider_init() {
  $labels = array(
    'name'               => _x( 'LSN Slider Images', 'post type general name', 'your-plugin-textdomain' ),
    'singular_name'      => _x( 'LSN Slider Image', 'post type singular name', 'your-plugin-textdomain' ),
    'menu_name'          => _x( 'LSN Slider Images', 'admin menu', 'your-plugin-textdomain' ),
    'name_admin_bar'     => _x( 'LSN Slider Image', 'add new on admin bar', 'your-plugin-textdomain' ),
    'add_new'            => _x( 'Add New', 'LSN Slider Image', 'your-plugin-textdomain' ),
    'add_new_item'       => __( 'Add New LSN Slider Image', 'your-plugin-textdomain' ),
    'new_item'           => __( 'New LSN Slider Image', 'your-plugin-textdomain' ),
    'edit_item'          => __( 'Edit LSN Slider Image', 'your-plugin-textdomain' ),
    'view_item'          => __( 'View LSN Slider Image', 'your-plugin-textdomain' ),
    'all_items'          => __( 'All LSN Slider Images', 'your-plugin-textdomain' ),
    'search_items'       => __( 'Search LSN Slider Images', 'your-plugin-textdomain' ),
    'parent_item_colon'  => __( 'Parent LSN Slider Images:', 'your-plugin-textdomain' ),
    'not_found'          => __( 'No LSN Slider Images found.', 'your-plugin-textdomain' ),
    'not_found_in_trash' => __( 'No LSN Slider Images found in Trash.', 'your-plugin-textdomain' )
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'exclude_from_search'=> true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'slide' ),
    'capability_type'    => 'post',
    'has_archive'        => false,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' )
  );

  register_post_type( 'slides', $args );
}

function get_parent_cats($id , $taxonomy){
  $terms = get_the_terms( $id , $taxonomy );
  $temp_arr = array();
  foreach ( $terms as $term ) {
    $temp_arr[] = $term->name;
  }
  //print_r($temp_arr);
  if (count($temp_arr) > 1){
    echo $temp_arr[1];
  }
  else
  {
    echo $temp_arr[0];
  }
  
}

/** 5.  WOO FUNCTIONS **/

/*** 5.1.  Remove Woo Actions */

// woocommerce_before_main_content
add_action( 'init', 'jk_remove_wc_breadcrumbs' );
function jk_remove_wc_breadcrumbs()  /* v. 1.00 */{
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}
// woocommerce_before_single_product_summary
remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_sale_flash', 10);
// woocommerce_single_product_summary
remove_action('woocommerce_single_product_summary','woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta', 40);
// woocommerce_after_shop_loop_item_title
remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price', 10);
// woocommerce_after_single_product_summary
if (strcmp(get_option('is_related'), 'N') == 0) {
remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products',20);
}

/**** 5.2.  Add Woo Filters / Actions */
// loop_shop_per_page
add_filter('loop_shop_per_page','dl_sort_by_page');
// woocommerce_before_shop_loop
add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_page_ordering', 20 );
// woocommerce_before_single_product_summary
add_action( 'woocommerce_before_single_product_summary','woocommerce_template_single_title',5 );
add_action( 'woocommerce_before_single_product_summary','woocommerce_template_single_meta', 10 );
add_action( 'woocommerce_before_single_product_summary','woocommerce_show_product_sale_flash', 15 );

      //add_action( 'woocommerce_after_shop_loop_item_title','lsn_single_enquiry', 40 );
// woocommerce_single_product_summary
add_action( 'woocommerce_single_product_summary','woocommerce_template_single_excerpt', 5);
// woocommerce_after_shop_loop_item_title
add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_single_excerpt', 5);
//add_action('woocommerce_after_shop_loop_item_title','lsn_add_read_more_link', 20);
add_action('woocommerce_after_shop_loop_item_title', 'lsn_price_wrap_start', 23);
add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 25);
add_action('woocommerce_after_shop_loop_item_title', 'lsn_price_wrap_end', 27);
// woocommerce_after_shop_loop_item_title
add_action('woocommerce_after_shop_loop_item_title','lsn_single_enquiry', 20);
add_action('woocommerce_after_shop_loop_item_title','lsn_start_button_wrap', 30);
// woocommerce_after_shop_loop_item
add_action('woocommerce_after_shop_loop_item', 'lsn_end_button_wrap', 33);
// woocommerce_product_tabs
add_filter( 'woocommerce_product_tabs', 'sb_woo_remove_reviews_tab', 98);

/**** 5.3.  Add Woo Filters / Actions Functions */

/****** 5.3.2.  Start Button Wrap */
function lsn_start_button_wrap() /* v. 1.00 */{
  echo '<div class="cat_page_button_wrap">';
}

/****** 5.3.3.  End Button Wrap */
function lsn_end_button_wrap() /* v. 1.00 */{
  echo '</div>';
}

/****** 5.3.2.  Start Button Wrap */
function lsn_price_wrap_start() /* v. 1.00 */{
  echo '<div class="price_wrap">';
}

/****** 5.3.3.  End Button Wrap */
function lsn_price_wrap_end() /* v. 1.00 */{
  echo '</div>';
}


/****** 5.3.4.  End Button Wrap */
function sb_woo_remove_reviews_tab($tabs) {

 unset($tabs['reviews']);

 return $tabs;
}

/****** 5.3.5.  Add Read More Link */
function lsn_add_read_more_link() /* v. 1.00 */{ ?>
  <div class="product_cat_read_more"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read more</a></div> <?php
}

/****** 5.3.6.  Cart Email Enquiry */
function lsn_cart_email_enq_modal() /* v. 1.00 */{
?>
<button type="button" class="single_add_to_cart_button button alt cart-buttton add-to-cart" data-toggle="modal" data-target="#emailEnquiryModal">
Email Enquiry
</button>

<!-- Modal -->
<div class="modal fade" id="emailEnquiryModal" tabindex="-1" role="dialog" aria-labelledby="emailEnquiryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="emailEnquiryModalLabel">Email Enquiry</h4>
      </div>
      <div class="modal-body">
        <?php echo do_shortcode('[contact-form-7 id="46" title="Email Enquiry"]'); ?> 
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
}

function lsn_mini_cart_enquiry() /* v. 1.00 */{
?>
<button type="button" class="single_add_to_cart_button button alt cart-buttton add-to-cart" data-toggle="modal" data-target="#emailEnquiryModal">
Email Enquiry
</button>

<!-- Modal -->
<div class="modal fade" id="emailEnquiryModal" tabindex="-1" role="dialog" aria-labelledby="emailEnquiryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="emailEnquiryModalLabel">Email Enquiry</h4>
      </div>
      <div class="modal-body">
        <?php echo do_shortcode('[contact-form-7 id="46" title="Email Enquiry"]'); ?> 
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
}

/****** 5.3.6  Catalog Page Ordering */
function woocommerce_catalog_page_ordering() /* v. 1.00 */{
?>
<?php echo '<span class="itemsorder">' ?>
    <form action="" method="POST" name="results" class="woocommerce-ordering">
    <label for="woocommerce-sort-by-columns">Show: </label>
    <select name="woocommerce-sort-by-columns" id="woocommerce-sort-by-columns" class="sortby" onchange="this.form.submit()">
<?php
 
//Get products on page reload
if  (isset($_POST['woocommerce-sort-by-columns']) && (($_COOKIE['shop_pageResults'] <> $_POST['woocommerce-sort-by-columns']))) {
        $numberOfProductsPerPage = $_POST['woocommerce-sort-by-columns'];
          } else {
        $numberOfProductsPerPage = $_COOKIE['shop_pageResults'];
          }
 
//  This is where you can change the amounts per page that the user will use  feel free to change the numbers and text as you want, in my case we had 4 products per row so I chose to have multiples of four for the user to select.
      $shopCatalog_orderby = apply_filters('woocommerce_sortby_page', array(
      //Add as many of these as you like, -1 shows all products per page
        //  ''       => __('Results per page', 'woocommerce'),
        '10'    => __('10', 'woocommerce'),
        '20'    => __('20', 'woocommerce'),
        '-1'    => __('All', 'woocommerce'),
      ));

    foreach ( $shopCatalog_orderby as $sort_id => $sort_name )
      echo '<option value="' . $sort_id . '" ' . selected( $numberOfProductsPerPage, $sort_id, true ) . ' >' . $sort_name . '</option>';
?>
</select>
</form>

<?php echo ' </span>' ?>
<?php
}
 
// now we set our cookie if we need to
function dl_sort_by_page($count)  /* v. 1.00 */{
  if (isset($_COOKIE['shop_pageResults'])) { // if normal page load with cookie
     $count = $_COOKIE['shop_pageResults'];
  }
  if (isset($_POST['woocommerce-sort-by-columns'])) { //if form submitted
    setcookie('shop_pageResults', $_POST['woocommerce-sort-by-columns'], time()+1209600, '/', 'www.your-domain-goes-here.com', false); //this will fail if any part of page has been output- hope this works!
    $count = $_POST['woocommerce-sort-by-columns'];
  }
  // else normal page load and no cookie
  return $count;
}


/** 6.  SELF FUNCTIONS **/

/**** 6.1.  Get Cat Children */
function get_kids ($post_id) /* v. 1.01 */{
      $queried_object = get_queried_object();
      $term_id = $queried_object->term_id;

      //echo $term_id;
      $taxonomy_name = 'product_cat';


      $termchildren = get_term_children( $term_id, $taxonomy_name ); ?>
      <?php //print_r($termchildren);?>
      <div class="row sub_cat_row"> 
        <?php
        foreach ( $termchildren as $child ) {
          $term = get_term_by( 'id', $child, $taxonomy_name );
            ?>
            <a href="<?php echo get_term_link( $child, $taxonomy_name );?>" title="<?php echo $term->name;?>">
                <div class="col-md-6 sub_cat_display">
                  <?php 
                  global $wp_query;
                  // get the query object
                  $cat = $wp_query->get_queried_object();
                  // get the thumbnail id user the term_id
                  $thumbnail_id = get_woocommerce_term_meta($term->term_id, 'thumbnail_id', true ); 
                  // get the image URL
                  $image = wp_get_attachment_url( $thumbnail_id ); 
                  // print the IMG HTML
                  echo '<img src="'.$image.'" alt="'. $term->name .'" width="52" height="52" />';
                  echo '<h3><a href="' . get_term_link( $child, $taxonomy_name ) . '" title="'. $term->name .'">' . $term->name . '</a></h3>';
                  echo '<p>' . $term->count. ' product(s)'; ?>
                </div>
              </a>

            <?php
        }
        ?>
      </div>
      <!-- end sub cat row -->
      <?php
}

/**** 6.2.  Display Phone Shortcode */

// Add Shortcode
function display_phone() /* v. 1.00 */{
  if (strcmp(get_option('tracking_mobiles'), 'N') == 0) {
     // not tracking mobile calls conversions
     echo '<span id="content_phone_number"><a class="top_call" href="tel:+353578662162">+353 (0) 57 866 2162</a></span>';
  }
  else
     // tracking mobile calls conversions
  {
      echo '<span id="content_phone_number"><a class="top_call" href="tel:+353578662162">+353 (0) 57 866 2162</a></span>';
      // modify that to include conversion tracking
  }
  
}
add_shortcode( 'phone', 'display_phone' );


// Add Shortcode
function simpleEnquiry() {
  global $post;
  $post_id = $post->ID;
  // Code
  $product = new WC_Product( $post_id );

  $product_name = $product->get_title();
  //$product_price = $product->get_price_html();
  $product_price = $product->get_price();
  $product_sku = $product->sku;

  $msg = 'Product: '.$product_name.', SKU: '.$product_sku.', Qty: 1, Price: '.$product_price;

  return $msg;
}
add_shortcode( 'sendSimpleEnquiry', 'simpleEnquiry' );

/**** 6.4.  Actual Cart Email Enquiry */
function gtfc() /* v. 1.03 */{

  $msg ='<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2">
<tbody>
<tr>
<td style="vertical-align: top;">Product name<br>
</td>
<td style="vertical-align: top;">Product SKU<br>
</td>
<td style="vertical-align: top;">Qty<br>
</td>
<td style="vertical-align: top;">Price<br>
</td>
</tr>';
  if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

    <?php
      foreach ( WC()->cart->get_cart() as $crt_item_key => $crt_item ) {
        $_product     = apply_filters( 'woocommerce_cart_item_product', $crt_item['data'], $crt_item, $crt_item_key );
        $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $crt_item['product_id'], $crt_item, $crt_item_key );

        if ( $_product && $_product->exists() && $crt_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $crt_item, $crt_item_key ) ) {

          $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $crt_item, $crt_item_key );
          $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $crt_item, $crt_item_key );
          $product_sku = $_product->sku;

          ?>
          <?php $msg .= '<tr>';?>
          <?php if ( $_product->is_visible() ) { ?>

              <?php $msg .= '<td style="vertical-align: top;">' . $product_name . '</td><td style="vertical-align: top;">'. $product_sku .'</td><td style="vertical-align: top;">'. $crt_item['quantity'] .'</td><td style="vertical-align: top;">'. $product_price .'</td></tr>';?>

          <?php } ?>
            <?php echo WC()->cart->get_item_data( $crt_item ); ?>

          <?php
        }
      }
    ?>
    <?php $price_total = WC()->cart->get_cart_subtotal(); ?>
    <?php $msg .= '<tr>
<td style="vertical-align: top;">
</td>
<td style="vertical-align: top;">
</td>
<td style="vertical-align: top;">Total
</td>
<td style="vertical-align: top;">' . $price_total .'
</td>
</tr>
</tbody>
</table>';

    //echo $msg; ?>

    <?php endif; ?>


<?php
//$msg = wordwrap($msg, 70, "\r\n");
return $msg;

}

add_action( 'wpcf7_before_send_mail', 'wpcf7_add_text_to_mail_body' );

/**** 6.5.  Attach to CF7 short */
function wpcf7_add_text_to_mail_body($contact_form) /* v. 1.00 */{

  $id = $contact_form->id();
  if ($id == 46){

    // get mail property
    $mail = $contact_form->prop( 'mail' ); // returns array with mail values

    $add_this = gtfc();

    // add date (or other content) to email body
    $mail['body'] .= $add_this;

    // set mail property with changed value(s)
    $contact_form->set_properties( array( 'mail' => $mail ) );
  }
}


/**** 6.7.  Set Robots Meta tag */
function checkRobots() /* v. 1.00 */{
  global $post; 
      $robots = get_post_meta($post->ID, 'seo_meta_robots_status', true );
      if (strcmp($robots, 'Index_Follow') == 0){
       // echo 'Robots will Index and will Follow';
        echo '<meta name="robots" content="index,follow">';
      }
      else if (strcmp($robots, 'Index_NOFollow') == 0){
       // echo 'Robots will Index and NOT Follow';
         echo '<meta name="robots" content="index,nofollow">';
      }
      else if (strcmp($robots, 'NOIndex_Follow') == 0){
       // echo 'Robots will NOT Index and will Follow';
         echo '<meta name="robots" content="noindex,follow">';
      }
      else if (strcmp($robots, 'NOIndex_NOFollow') == 0){
       // echo 'Robots will NOT Index and will NOT Follow';
         echo '<meta name="robots" content="noindex,nofollow">';
      }
}

/**** 6.8.  Training Calendar Snippet */
function get_calendar_snippet($training_start_date)/* v. 1.00 */{
  ?>
  <script type="text/javascript">(function () {
            if (window.addtocalendar)if(typeof window.addtocalendar.start == "function")return;
            if (window.ifaddtocalendar == undefined) { window.ifaddtocalendar = 1;
                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                s.type = 'text/javascript';s.charset = 'UTF-8';s.async = true;
                s.src = ('https:' == window.location.protocol ? 'https' : 'http')+'://addtocalendar.com/atc/1.5/atc.min.js';
                var h = d[g]('body')[0];h.appendChild(s); }})();
    </script>
  <?php
  $endtime; 
  $training_provider = "LockoutSafety.com";
  $contact_email = "sales@lockoutsafety.com";
  $training_description = 'Lockout Tagout Safety Awareness Training - Portlaoise';
  $time = $training_start_date;
  $endtime = date('d-m-Y', strtotime($time . ' + 1 day')); ?>
  <div class="g_addtocalendar">

    <span class="addtocalendar atc-style-blue g_addtocal">
          <var class="atc_event">
              <var class="atc_date_start"><?php echo $training_start_date.' 09:30:00';?></var>
              <var class="atc_date_end"><?php echo $endtime.' 16:30:00';?></var>
              <var class="atc_timezone">Europe/London</var>
              <var class="atc_title"><?php echo 'Lockout Tagout Safety Awareness Training';?></var>
              <var class="atc_description"><?php echo $training_description;?></var>
              <var class="atc_location"><?php echo 'Maldron Hotel, Portlaoise, Co. Laois';?></var>
              <var class="atc_organizer"><?php echo $training_provider;?></var>
              <var class="atc_organizer_email"><?php echo $contact_email;?></var>
          </var>
      </span>

  </div>

    <?php
}

function training_page_display($post_id){
  $training_1_on = get_post_meta($post_id,'training_one_on',true);
  $date_1 = date("D d M Y", strtotime(get_post_meta($post_id,'training_one_date',true)));
  $availability_1 = get_post_meta($post_id,'training_one_availability',true);
  $code_1 = get_post_meta($post_id,'training_one_paypal_button',true);

  $training_2_on = get_post_meta($post_id,'training_two_on',true);
  $date_2 = date("D d M Y", strtotime(get_post_meta($post_id,'training_two_date',true)));
  $availability_2 = get_post_meta($post_id,'training_two_availability',true);
  $code_2 = get_post_meta($post_id,'training_two_paypal_button',true);

  $training_3_on = get_post_meta($post_id,'training_three_on',true);
  $date_3 = date("D d M Y", strtotime(get_post_meta($post_id,'training_three_date',true)));
  $availability_3 = get_post_meta($post_id,'training_three_availability',true);
  $code_3 = get_post_meta($post_id,'training_three_paypal_button',true);
  ?>
  

    <div id="training_section_wrapper">
    <h2>Scheduled Lockout Tagout Training Dates:</h2>
    <div class="training_wrapper">  
      <div class="col-md-4 training_items">
        <p><strong><?php echo $date_1; ?></strong></p>
      </div><!-- end training items -->
      <div class="col-md-4 training_items">
        <?php if (strcmp($availability_1, 'Available') == 0){ ?>
        <?php get_calendar_snippet(get_post_meta($post_id,'training_one_date',true));?>
        <?php } else { ?>
        <?php } ?>
      </div><!-- end training items -->
      <div class="col-md-4 training_items">
        <?php if (strcmp($availability_1, 'Available') == 0){ ?>
        <?php echo $code_1;?>
        <?php } else { ?>
        <?php echo '<span class="training_booked_out">Booked Out</span>'; ?>
        <?php } ?>
      </div><!-- end training items -->
    </div>
  
  <?php
  if (strcmp($training_2_on, 'Yes') == 0){ ?>
    <div class="training_wrapper">  
      <div class="col-md-4 training_items">
        <p><strong><?php echo $date_2; ?></strong></p>
      </div><!-- end training items -->
      <div class="col-md-4 training_items">
        <?php if (strcmp($availability_2, 'Available') == 0){ ?>
        <?php get_calendar_snippet(get_post_meta($post_id,'training_two_date',true));?>
        <?php } else { ?>
        <?php } ?>
      </div><!-- end training items -->
      <div class="col-md-4 training_items">
        <?php if (strcmp($availability_2, 'Available') == 0){ ?>
        <?php echo $code_2;?>
        <?php } else { ?>
        <?php echo '<span class="training_booked_out">Booked Out</span>'; ?>
        <?php } ?>
      </div><!-- end training items -->
    </div>
  <?php
  } // end if

  if (strcmp($training_3_on, 'Yes') == 0){ ?>
    <div class="training_wrapper">  
      <div class="col-md-4 training_items">
        <p><strong><?php echo $date_3; ?></strong></p>
      </div><!-- end training items -->
      <div class="col-md-4 training_items">
        <?php if (strcmp($availability_3, 'Available') == 0){ ?>
        <?php get_calendar_snippet(get_post_meta($post_id,'training_three_date',true));?>
        <?php } else { ?>
        <?php } ?>
      </div><!-- end training items -->
      <div class="col-md-4 training_items">
        <?php if (strcmp($availability_3, 'Available') == 0){ ?>
        <?php echo $code_3;?>
        <?php } else { ?>
        <?php echo '<span class="training_booked_out">Booked Out</span>'; ?>
        <?php } ?>
      </div><!-- end training items -->
    </div>
  <?php
  } // end if?>
  </div>
  <?php
}

function get_analytics(){
  $is_analytics = get_option('analytics');
  if (strcmp($is_analytics, 'Y') == 0){ ?>
    <!-- BEGIN GOOGLE ANALYTICS CODEs -->
    <script type="text/javascript">
    //<![CDATA[
        var _gaq = _gaq || [];
        
    _gaq.push(['_setAccount', 'UA-46901992-1']);
    _gaq.push(['_trackPageview']);
        
        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    //]]>
    </script>
    <!-- END GOOGLE ANALYTICS CODE -->
    <?php
  }
}

function get_cons_enquiry(){ ?>

    <button type="submit" class="single_add_to_cart_button button alt cart-buttton add-to-cart" data-toggle="modal" data-target="#superEmailPopup-<?php the_ID(); ?>">Email Enquiry</button>
    <?php if ( sizeof( WC()->cart->get_cart() ) < 1 ) : ?>
      <!-- pusty -->
    <!-- Modal HTML -->
      <div id="superEmailPopup-<?php the_ID(); ?>" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Email Enquiry</h4>
                  </div>
                  <div class="modal-body">
                    <?php //echo do_shortcode('[sendSimpleEnquiry]'); ?>
                      <?php echo do_shortcode('[contact-form-7 id="56" title="Simple Email Enquiry"]'); ?>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
              </div>
          </div>
      </div>

  <?php else : ?>
    <!-- pelny -->
      <!-- Modal HTML -->
      <div id="superEmailPopup-<?php the_ID(); ?>" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Email Enquiry</h4>
                  </div>
                  <div class="modal-body">
                    <?php echo do_shortcode('[contact-form-7 id="46" title="Email Enquiry"]'); ?> 
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
              </div>
          </div>
      </div>

  <?php endif;
}

if ( ! function_exists( 'lsn_get_product_search_form' ) ) {

  /**
   * Output Product search forms.
   *
   */
  function lsn_get_product_search_form( $echo = true  ) {
    do_action( 'lsn_get_product_search_form'  );

    $search_form_template = locate_template( 'product-searchform.php' );
    if ( '' != $search_form_template  ) {
      require $search_form_template;
      return;
    }

    $form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
      <div class="input-group">
        <input type="text" class="form-control" value="' . get_search_query() . '" name="s" id="s" placeholder="Search for..." />
        
        <span class="input-group-btn">
          <input type="submit" id="searchsubmit" class="btn btn-default btn-search" value="'. esc_attr__( 'Search', 'woocommerce' ) .'" />
        </span>
        <input type="hidden" name="post_type" value="product" />
      </div><!-- /input-group -->
    </form>';

    if ( $echo  )
      echo apply_filters( 'get_product_search_form', $form );
    else
      return apply_filters( 'get_product_search_form', $form );
  }
}
//<input type="submit" id="searchsubmit" value="'. esc_attr__( 'Search', 'woocommerce' ) .'" />
/*
//override woocommerce function
function woocommerce_template_single_price() {
    global $product;
    if ( ! $product->is_type('variable') ) { 
        woocommerce_get_template( 'single-product/price.php' );
    }
}*/

/*
add_filter('woocommerce_variable_price_html', 'custom_variation_price', 10, 2);

function custom_variation_price( $price, $product ) {

     $price = '';


     $price .= woocommerce_price($product->get_price());

     return $price;
}
*/
?>