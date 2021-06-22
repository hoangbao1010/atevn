<?php 

## ---- 1. Backend ---- ##
// Adding a custom Meta container to admin products pages
add_action( 'add_meta_boxes', 'create_custom_meta_box' );
if ( ! function_exists( 'create_custom_meta_box' ) )
{
  function create_custom_meta_box()
  {
    add_meta_box(
      'custom_product_meta_box',  __( 'Khuyến nghị', 'cmb' ), 'add_custom_content_meta_box', 'product', 'normal','default'
    );
  }
}

//  Custom metabox content in admin product pages
if ( ! function_exists( 'add_custom_content_meta_box' ) ){
  function add_custom_content_meta_box( $post ){
        $prefix = '_bhww_'; // global $prefix;

        $advice = get_post_meta($post->ID, $prefix.'advice_ip', true) ? get_post_meta($post->ID, $prefix.'advice_ip', true) : '';
        $args['textarea_rows'] = 6;

        wp_editor( $advice, 'advice_ip', $args );


        echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
      }
    }

//Save the data of the Meta field
    add_action( 'save_post', 'save_custom_content_meta_box', 10, 1 );
    if ( ! function_exists( 'save_custom_content_meta_box' ) )
    {

      function save_custom_content_meta_box( $post_id ) {
        $prefix = '_bhww_'; // global $prefix;

        // We need to verify this with the proper authorization (security stuff).

        // Check if our nonce is set.
        if ( ! isset( $_POST[ 'custom_product_field_nonce' ] ) ) {
          return $post_id;
        }
        $nonce = $_REQUEST[ 'custom_product_field_nonce' ];

        //Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce ) ) {
          return $post_id;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
          return $post_id;
        }

        // Check the user's permissions.
        if ( 'product' == $_POST[ 'post_type' ] ){
          if ( ! current_user_can( 'edit_product', $post_id ) )
            return $post_id;
        } else {
          if ( ! current_user_can( 'edit_post', $post_id ) )
            return $post_id;
        }

        // Sanitize user input and update the meta field in the database.
        update_post_meta( $post_id, $prefix.'advice_ip', wp_kses_post($_POST[ 'advice_ip' ]) );
      }
    }

## ---- 2. Front-end ---- ##

// Create custom tabs in product single pages
    add_filter( 'woocommerce_product_tabs', 'custom_product_tabs' );
    function custom_product_tabs( $tabs ) {
      global $post;

      $product_advice = get_post_meta( $post->ID, '_bhww_advice_ip', true );

      if ( ! empty( $product_advice ) )
        $tabs['advice_tab'] = array(
          'title'    => __( 'Khuyến nghị', 'woocommerce' ),
          'priority' => 10,
          'callback' => 'advice_product_tab_content'
        );

      return $tabs;
    }

// Remove description heading in tabs content
    add_filter('woocommerce_product_description_heading', '__return_null');

// Add content to custom tab in product single pages (1)
    function advice_product_tab_content() {
      global $post;

      $product_advice = get_post_meta( $post->ID, '_bhww_advice_ip', true );

      if ( ! empty( $product_advice ) ) {
        // Updated to apply the_content filter to WYSIWYG content
        echo apply_filters( 'the_content', $product_advice );
      }
    }


         /**
 * Adds a meta box tuyendung
 */
      function prfx_featured_meta() {
        add_meta_box( 'info_tuyendung_area', 'Ngày tuyển dụng', 'tuyendung_info_ouput', 'recruitment' );
      }
      add_action( 'add_meta_boxes', 'prfx_featured_meta' );


function prfx_meta_callback( $post ) {

  $prfx_stored_meta = get_post_meta( $post->ID );
  ?>
    <div class="prfx-row-content">
       <input type="checkbox" name="featured-checkbox" id="featured-checkbox" value="yes" <?php if ( isset ( $prfx_stored_meta['featured-checkbox'] ) ) checked( $prfx_stored_meta['featured-checkbox'][0], 'yes' ); ?> />
      <label for="featured-checkbox">
        <?php _e( 'Tích chọn vào đây', 'prfx-textdomain' )?>
      </label>

    </div>  

  <?php
}


function tuyendung_info_ouput( $post )
{
  $ngaynophs = get_post_meta( $post->ID, '_ngaynophs', true );
  $ngayhh = get_post_meta( $post->ID, '_ngayhh', true );
  ?>
  <div class="wrap_tuyendung">
    <div class="row">
      <div class="col-sm-6">
        <label for="ngaynophs">Ngày ứng tuyển </label>
        <div class="wrap_group_item">
          <input type="text" id="ngaynophs" name="ngaynophs" data-language="en" data-position='right top'  class="tg_date_choose datepicker-here" placeholder="dd-mm-yyyy" value="<?php echo esc_attr($ngaynophs) ;?>"  />
        </div>
      </div>  
      <div class="col-sm-6">
        <label for="ngayhh">Ngày hết hạn </label>
        <div class="wrap_group_item">
          <input type="text" id="ngayhh" name="ngayhh" data-language="en" data-position='right top'  class="tg_date_choose datepicker-here" placeholder="dd-mm-yyyy" value="<?php echo esc_attr($ngayhh) ;?>" />
        </div>
      </div>      
    </div>
  </div>

  <?php
}


 function tg_thongtintd_save($post_id){
  if(isset($_POST['ngaynophs']) ){
    $ngaynophs =  sanitize_text_field($_POST['ngaynophs']) ;
    $ngayhh =  sanitize_text_field($_POST['ngayhh']) ;
    update_post_meta( $post_id, '_ngaynophs', $ngaynophs );
    update_post_meta( $post_id, '_ngayhh', $ngayhh );
  }  
 }
 add_action( 'save_post', 'tg_thongtintd_save' );

 // end meta box tuyendung

// gallery meta box du an

 function tg_meta_box()
{
  add_meta_box( 'gallery-metabox', 'Ảnh thư viện', 'gallery_meta_callback','project');
}
add_action( 'add_meta_boxes', 'tg_meta_box' );

 // Gallery cpt
 function gallery_meta_callback($post) {
  wp_nonce_field( basename(__FILE__), 'gallery_meta_nonce' );
  $ids = get_post_meta($post->ID, '_tdc_gallery_id', true);
  ?>
  <table class="form-table">
    <tr><td>
      <a class="gallery-add button" href="#" data-uploader-title="Thêm hình ảnh" data-uploader-button-text="Thêm nhiều hình ảnh" style="margin:0px 0px 10px 0px;">Upload Images</a>
      <ul id="gallery-metabox-list">
        <?php if ($ids) : foreach ($ids as $key => $value) : $image = wp_get_attachment_image_src($value); ?>
          <li>
            <input type="hidden" name="tdc_gallery_id[<?php echo $key; ?>]" value="<?php echo $value; ?>">
            <img class="image-preview" src="<?php echo $image[0]; ?>">
            <a class="change-image button button-small" href="#" data-uploader-title="Đổi hình khác" data-uploader-button-text="Đổi hình khác">Change Image</a><br>
            <small><a class="remove-image" href="#">Delete</a></small>
          </li>
        <?php endforeach; endif; ?>
      </ul>
    </td></tr>
  </table>
 <?php }
 function gallery_meta_save($post_id) {
  if (!isset($_POST['gallery_meta_nonce']) || !wp_verify_nonce($_POST['gallery_meta_nonce'], basename(__FILE__))) return;
  if (!current_user_can('edit_post', $post_id)) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if(isset($_POST['tdc_gallery_id'])) {
    update_post_meta($post_id, '_tdc_gallery_id', $_POST['tdc_gallery_id']);
  } else {
    delete_post_meta($post_id, '_tdc_gallery_id');
  }
 }
 add_action('save_post', 'gallery_meta_save');

 // end gallery meta box du an 

