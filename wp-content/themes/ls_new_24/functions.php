<?php
/* Template: Core Functions
 * Version: 1.00
 * Last Modified: 14/01/2015 10:44:02
 */

// Standard Menu Walker
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

?>
<?php
// Bootstrap Menu Walker
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

// Settings Page

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
    <p><strong>Download Brochure Link:</strong><br />  
      <input type="text" name="brochure_link" size="45" value="<?php echo get_option('brochure_link'); ?>" />  
    </p>
    <p><strong>Delivery Policy Link:</strong><br />  
      <input type="text" name="delivery_link" size="45" value="<?php echo get_option('delivery_link'); ?>" />  
    </p>

    <p><input type="submit" name="Submit" value="Save Options" /></p>  
    <input type="hidden" name="action" value="update" />  
    <input type="hidden" name="page_options" value="facebook_link,twitter_link,youtube_link,linkedin_link,brochure_link,delivery_link" />  
  </form>  
  <?php
}

add_theme_support( 'woocommerce' );

/* Register Menus */
register_nav_menus( array(
  'top_overhead_menu' => 'Overhead Menu',
  'side_bar_menu' => 'Product Category Navigation',
  'footer_menu_1' => 'Footer Our Service Menu',
  'footer_menu_2' => 'Footer Lockout Information Menu',
  'footer_menu_3' => 'Footer My Account Menu'
) );

/* Register Sidebars */
$left_args = array(
  'name'          => __( 'Left Sidebar', 'nls' ),
  'id'            => 'ls-left-sidebar',
  'description'   => 'Left sidebar that appears on normal 3 column pages',
        'class'         => '',
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget'  => '</div>',
  'before_title'  => '<h3 class="widgettitle">',
  'after_title'   => '</h1>' );

$left_args_home = array(
  'name'          => __( 'Left Sidebar on Homepage', 'nls' ),
  'id'            => 'ls-left-sidebar-home',
  'description'   => 'Left sidebar that appears only on Home Page',
        'class'         => '',
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget'  => '</div>',
  'before_title'  => '<h3 class="widgettitle">',
  'after_title'   => '</h1>' );

$right_args = array(
  'name'          => __( 'Right Sidebar', 'nls' ),
  'id'            => 'ls-right-sidebar',
  'description'   => 'Right sidebar that appears on normal 3 column pages',
        'class'         => '',
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget'  => '</div>',
  'before_title'  => '<h3 class="widgettitle">',
  'after_title'   => '</h1>' );


register_sidebar( $left_args );
register_sidebar( $right_args );
register_sidebar( $left_args_home );

/* Thumbnail sizes */
add_image_size( home_page_featured, 184, 166, true );
?>