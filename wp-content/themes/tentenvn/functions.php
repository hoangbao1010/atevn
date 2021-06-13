<?php
define("BASE_URL", get_template_directory_uri());
include get_template_directory().'/includes/admin/function-admin.php';
include get_template_directory().'/includes/admin/core.php';
include get_template_directory().'/includes/admin/custom-post-type/custom-post-type.php';
include get_template_directory().'/includes/frontend/woocommerce/woocommerce.php';
include get_template_directory().'/includes/frontend/woocommerce/archive.php';
include get_template_directory().'/includes/frontend/woocommerce/add_meta_box.php';
include get_template_directory().'/includes/frontend/woocommerce/single-product.php';
include get_template_directory().'/includes/frontend/shortcode/shortcode.php';

function load_admin_style() {
  wp_register_style( 'admin_css', get_template_directory_uri() . '/css/admin.css', false, '1.0.0' );
  wp_enqueue_style('admin_css');
}
add_action( 'admin_enqueue_scripts', 'load_admin_style' );

function load_admin_js() {
  wp_register_script( 'admin_js', get_template_directory_uri() . '/js/admin.js', false, '1.0.0' );
  wp_enqueue_script('admin_js');
}
add_action( 'admin_enqueue_scripts', 'load_admin_js' );

// Navigation menus 
register_nav_menus(array(
  'primary' => __('Primary Menu'),
  'menu_mobile' => __('Mobile Menu')
));
  // Get top ancestor id
function get_top_ancestor_id(){
  global $post;
  if($post->post_parent){
    $ancestors= array_reverse(get_post_ancestors($post->ID));
    return $ancestors[0];
  } 
  return $post->ID;
}
  // Does page have children ? 
function has_children(){
  global $post;
  $pages = get_pages('child_of=' . $post->ID);
  return count($pages);
}
  // Customize excerpt word count length
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  } 
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
  // ADD FEATURED IMAGE SUPPORT
function featured_images_setup(){
  add_theme_support('post-thumbnails');
  add_image_size( 'thumbnail',300, 250, true ); //thumbnail
    add_image_size( 'medium', 600, 400, true ); //medium
    add_image_size( 'large', 1200, 800, true ); //large
  }
  add_action('after_setup_theme','featured_images_setup');
  // ADD POST FORMAT SUPPORT
  add_theme_support('post-formats',array('aside','gallery','link'));
  // ADD OUR WIDGETS LOCATION
  function our_widget_inits(){
    register_sidebar(array(
      'name' => 'Sidebar',
      'id' => 'sidebar1',
      'before_widget' => '<div id="%1$s" class="widget %2$s widget_area">',
      'after_widget' => "</div>",
      'before_title' => '<h3 class="widget-title">',
      'after_title' => '</h3>',
    ));
      register_sidebar(array(
    'name' => 'Footer area 1',
    'id' => 'footer1',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ));
  register_sidebar(array(
    'name' => 'Footer area 2',
    'id' => 'footer2',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ));
   register_sidebar(array(
    'name' => 'Footer area 3',
    'id' => 'footer3',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ));

  }
  add_action('widgets_init','our_widget_inits');
  /** Filter & Hook In Widget Before Post Content .*/
  function before_post_widget() {
    if ( is_home() && is_active_sidebar( 'sidebar1' ) ) { 
      dynamic_sidebar('sidebar1', array(
        'before' => '<div class="before-post">',
        'after' => '</div>',
      ) );      
    }
  }
  add_action( 'woo_loop_before', 'before_post_widget' );
  add_theme_support( 'custom-logo' );
//  ADD BREADCRUMB
  function the_breadcrumb() {

    if (!is_front_page()) {
      echo '<li><a href="';
      echo home_url();
      echo '">';
      echo 'Trang chủ ';
      echo "</a><li>";
      if (is_category() || is_single()) {
        echo '';
        the_category(' ');
        if (is_single()) {
          echo "<li>";
          the_title();
          echo '</li>';
        }
      } elseif (is_page()) {
        echo '';
        echo the_title();
        echo '';
      } elseif (is_home()) {
        echo wp_title('');
      }
    }
    elseif (is_tag()) {single_tag_title();}
    elseif (is_day()) {echo"Archive for "; the_time('F jS, Y'); echo'';}
    elseif (is_month()) {echo"Archive for "; the_time('F, Y'); echo'';}
    elseif (is_year()) {echo"Archive for "; the_time('Y'); echo'';}
    elseif (is_author()) {echo"Author Archive"; echo'';}
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "Blog Archives"; echo'';}
    elseif (is_search()) {echo"Search Results"; echo'';}

  }
//  END BREADCRUMB

/*
 *  DUPLICATE POST IN  ADMIN. Dups appear as drafts. User is redirected to the edit screen
 */
function rd_duplicate_post_as_draft(){
  global $wpdb;
  if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
    wp_die('No post to duplicate has been supplied!');
  }

  /*
   * Nonce verification
   */
  if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
    return;

  /*
   * get the original post id
   */
  $post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
  /*
   * and all the original post data then
   */
  $post = get_post( $post_id );

  /*
   * if you don't want current user to be the new post author,
   * then change next couple of lines to this: $new_post_author = $post->post_author;
   */
  $current_user = wp_get_current_user();
  $new_post_author = $current_user->ID;

  /*
   * if post data exists, create the post duplicate
   */
  if (isset( $post ) && $post != null) {

    /*
     * new post data array
     */
    $args = array(
      'comment_status' => $post->comment_status,
      'ping_status'    => $post->ping_status,
      'post_author'    => $new_post_author,
      'post_content'   => $post->post_content,
      'post_excerpt'   => $post->post_excerpt,
      'post_name'      => $post->post_name,
      'post_parent'    => $post->post_parent,
      'post_password'  => $post->post_password,
      'post_status'    => 'draft',
      'post_title'     => $post->post_title,
      'post_type'      => $post->post_type,
      'to_ping'        => $post->to_ping,
      'menu_order'     => $post->menu_order
    );

    /*
     * insert the post by wp_insert_post() function
     */
    $new_post_id = wp_insert_post( $args );

    /*
     * get all current post terms ad set them to the new post draft
     */
    $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
    foreach ($taxonomies as $taxonomy) {
      $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
      wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
    }

    /*
     * duplicate all post meta just in two SQL queries
     */
    $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
    if (count($post_meta_infos)!=0) {
      $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
      foreach ($post_meta_infos as $meta_info) {
        $meta_key = $meta_info->meta_key;
        if( $meta_key == '_wp_old_slug' ) continue;
        $meta_value = addslashes($meta_info->meta_value);
        $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
      }
      $sql_query.= implode(" UNION ALL ", $sql_query_sel);
      $wpdb->query($sql_query);
    }


    /*
     * finally, redirect to the edit post screen for the new draft
     */
    wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
    exit;
  } else {
    wp_die('Post creation failed, could not find original post: ' . $post_id);
  }
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );

/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {
  if (current_user_can('edit_posts')) {
    $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Nhân bản</a>';
  }
  return $actions;
}

add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );
// duplicate page
//add_filter('page_row_actions', 'rd_duplicate_post_link', 10, 2);

// REMOVE CSS WP_HEAD
//xoa header
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action( 'wp_head', 'feed_links', 2 ); 
remove_action('wp_head', 'feed_links_extra', 3 );
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

// Keep old Editor
   add_filter('use_block_editor_for_post', '__return_false');

// Email ctm
add_filter( 'woocommerce_email_recipient_new_order', 'custom_new_order_email_recipient', 10, 2 );
function custom_new_order_email_recipient( $recipient, $order ) {
    // Avoiding backend displayed error in Woocommerce email settings for undefined $order
    if ( ! is_a( $order, 'WC_Order' ) ) 
        return $recipient;

    // Check order items for a shipped product is in the order   
    foreach ( $order->get_items() as $item ) {
        $product = $item->get_product(); // Get WC_Product instance Object

        // When a product needs shipping we add the customer email to email recipients
        if ( $product->needs_shipping() ) {
            return $recipient . ',' . $order->get_billing_email();
        }
    }
    return $recipient;
}

