<?php 
   // shortcode social header info
   function myshortcode_header_info()
   {
   	ob_start();
   	$phone = get_option('phone');
   	$phone_trim = trim($phone);
   	$address = get_option('address_header');
   	$address_trim = trim($address);
   	if (get_option('phone') || get_option('address_header'))
   	{
   		?>
<ul>
   <?php if (get_option('phone'))
      { ?>
   <li> Hotline:
      <a href="tel:<?php echo $phone_trim; ?>"><?php echo $phone_trim; ?></a>
   </li>
   <?php
      } ?>
   <?php if (get_option('address_header'))
      { ?>
   <li>  - Email:
      <a href="mailto:<?php echo $address_trim; ?>"><?php echo $address_trim; ?></a>
   </li>
   <?php
      } ?>
</ul>
<?php
   }
   return ob_get_clean();
   }
   add_shortcode('sc_tel_hd', 'myshortcode_header_info');


      // shortcode category product homepage
   function myshortcode_cat_pro(){ 
   ob_start();?>
<div class="qb_cat_pro">
   <?php
      $taxonomy     = 'product_cat';
      $orderby      = 'name';  
          $show_count   = 0;      // 1 for yes, 0 for no
          $pad_counts   = 0;      // 1 for yes, 0 for no
          $hierarchical = 1;      // 1 for yes, 0 for no  
          $title        = '';  
          $empty        = 0;
      
          $args = array(
            'taxonomy'     => $taxonomy,
            'orderby'      => $orderby,
            'show_count'   => $show_count,
            'pad_counts'   => $pad_counts,
            'hierarchical' => $hierarchical,
            'title_li'     => $title,
            'hide_empty'   => $empty
          );
          $all_categories = get_categories( $args );
          foreach ($all_categories as $cat) {
            if($cat->category_parent == 0) {
               $category_id = $cat->term_id; ?>      
   <h2 class="title_parents"><a href="<?php echo get_term_link($cat->slug, 'product_cat') ?>">Danh mục sản phẩm</a></h2>
   <?php $args2 = array(
      'taxonomy'     => $taxonomy,
      'child_of'     => 0,
      'parent'       => $category_id,
      'orderby'      => $orderby,
      'show_count'   => $show_count,
      'pad_counts'   => $pad_counts,
      'hierarchical' => $hierarchical,
      'title_li'     => $title,
      'hide_empty'   => $empty
      ); ?>
   <div class="cat_pro_detailds">
      <ul>
         <?php $sub_cats = get_categories( $args2 );
            if($sub_cats) { ?>
         <?php foreach($sub_cats as $sub_category) { ?>
         <li>
            <?php $thumbnail_id = get_term_meta( $sub_category->term_id, 'thumbnail_id', true );  
               $image = wp_get_attachment_url( $thumbnail_id );  ?>
            <figure><a href="<?php echo get_term_link($sub_category->slug, 'product_cat') ?>"><img src="<?php echo $image;  ?>"></a></figure>
            <h3><a href="<?php echo get_term_link($sub_category->slug, 'product_cat') ?>"><?php echo  $sub_category->name ; ?></a></h3>
            <span class="des"><?php echo $sub_category->description; ?></span>
         </li>
         <?php }  ?> 
         <?php } ?>
      </ul>
   </div>
   <?php }       
      }
      ?>
</div>
</div>
<?php 
   return ob_get_clean();
   }
   add_shortcode('sc_cat_pro','myshortcode_cat_pro');

        // shortcode maykeothangmay product homepage
   function myshortcode_mktm_pro(){ 
      ob_start();?>
<div class="qb_mktm_pro qb_pro_detailds">
   <?php     $mktm_args = array(
      'post_type'             => 'product',
      'post_status'           => 'publish',
      'posts_per_page'        => '12',
      'tax_query'             => array(
         array(
            'taxonomy'      => 'product_cat',
               'field' => 'term_id', //This is optional, as it defaults to 'term_id'
               'terms'         => 23,
               'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
        ),
      )
      );
      $mktm_query = new WP_Query($mktm_args);
      if($mktm_query->have_posts()) : ?>
   <ul class="row">
      <?php while ($mktm_query->have_posts()) : $mktm_query->the_post(); ?>
      <li class="col-sm-3">
         <?php global $post;
            $project_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size = 'large'); ?>
         <div class="wrap_figure">
            <figure style="background: url('<?php echo $project_image[0]; ?>');"><a href="<?php the_permalink(); ?>" ></a></figure>
            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <span class="price">Giá: <label>Liên Hệ</label></span>
            <div class="detailds">
               <a href="<?php the_permalink(); ?>">Chi tiết</a>
            </div>
         </div>
      </li>
      <?php endwhile; 
         wp_reset_postdata();
         ?>
   </ul>
   <?php else : echo 'No data'; 
      endif; ?>
</div>
</div>
<?php 
   return ob_get_clean();
   }
   add_shortcode('sc_mktm_pro','myshortcode_mktm_pro');

   // shortcode news homepage
   function myshortcode_news_hp(){ 
   ob_start();?>
<div class="qb_news_hp">
   <div class="row">
      <div class="col-sm-6">
         <div class="ct_left">
            <?php $news_arg = array(
               'post_type' => 'post',
               'order' => 'ASC',
               'orderby' => 'date',
               'post_status' => 'publish',
               'cat' => 1,
               'posts_per_page' => 1
               );
               $news_query = new WP_Query($news_arg);
               if($news_query->have_posts()) : ?>
            <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
            <?php 
               global $post;
               $sk_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size = 'large'); ?>
            <div class="wrap_figure">
               <figure style="background: url('<?php echo $sk_image[0]; ?>');"><a href="<?php the_permalink(); ?>"></a></figure>
            </div>
            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <?php endwhile; 
               wp_reset_postdata();
               ?>
            <?php else : echo 'No data'; 
               endif; ?>
         </div>
      </div>
      <div class="col-sm-6">
         <div class="ct_right">
            <?php $news_arg = array(
               'post_type' => 'post',
               'order' => 'ASC',
               'orderby' => 'date',
               'post_status' => 'publish',
               'cat' => 1,
               'posts_per_page' => 4,
               'offset' => 1
               );
               $news_query = new WP_Query($news_arg);
               if($news_query->have_posts()) : ?>
            <ul>
               <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
               <li>
                  <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                  <span class="qb_date_post"> Ngày đăng: <?php the_time('d/m/Y'); ?></span>
               </li>
               <?php endwhile; 
                  wp_reset_postdata();
                  ?>
            </ul>
            <?php else : echo 'No data'; 
               endif; ?>
         </div>
      </div>
   </div>
</div>
<?php 
   return ob_get_clean();
   }
   add_shortcode('sc_news_hp','myshortcode_news_hp');

      // shortcode project homepage
   function myshortcode_project_hp(){ 
   ob_start();?>
<div class="qb_project_hp">
   <?php $project_arg = array(
      'post_type' => 'project',
      'order' => 'ASC',
      'orderby' => 'date',
      'post_status' => 'publish',
      'posts_per_page' => -1,
      );
      $project_query = new WP_Query($project_arg);
      if($project_query->have_posts()) : ?>
   <ul class="row">
      <?php while ($project_query->have_posts()) : $project_query->the_post(); ?>
      <li class="col-sm-3">
         <?php global $post;
            $project_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size = 'large'); ?>
         <div class="wrap_figure">
            <figure style="background: url('<?php echo $project_image[0]; ?>');"><a href="<?php the_permalink(); ?>" class="fancybox" data-fancybox="images"></a></figure>
         </div>
      </li>
      <?php endwhile; 
         wp_reset_postdata();
         ?>
   </ul>
   <?php else : echo 'No data'; 
      endif; ?>
</div>
<?php 
   return ob_get_clean();
   }
   add_shortcode('sc_project_hp','myshortcode_project_hp');

      // shortcode recruitment homepage
   function myshortcode_recruitment_hp(){ 
   ob_start();?>
<div class="qb_recruitment_hp">
   <?php $recruitment_arg = array(
      'post_type' => 'recruitment',
      'order' => 'ASC',
      'orderby' => 'date',
      'post_status' => 'publish',
      'posts_per_page' => 3
      );
      $recruitment_query = new WP_Query($recruitment_arg);
      if($recruitment_query->have_posts()) : ?>
   <ul>
      <?php while ($recruitment_query->have_posts()) : $recruitment_query->the_post(); ?>
      <li>
         <?php 
            global $post;
            $sk_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size = 'large'); ?>
         <div class="wrap_figure">
            <figure style="background: url('<?php echo $sk_image[0]; ?>');"><a href="<?php the_permalink(); ?>"></a></figure>
         </div>
         <div class="text_widget">
            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <?php  
               $ngaynophs = get_post_meta( $post->ID, '_ngaynophs', true );
               $ngayhh = get_post_meta( $post->ID, '_ngayhh', true );
               ?> 
            <?php if(!empty($ngaynophs) && !empty($ngayhh) ){ ?>
            <span class="date_time_td"><?php echo $ngaynophs; ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> <?php echo $ngayhh; ?></span>
            <?php }?>
         </div>
      </li>
      <?php endwhile; 
         wp_reset_postdata();
         ?>
   </ul>
   <?php else : echo 'No data'; 
      endif; ?>
</div>
<?php 
   return ob_get_clean();
   }
   add_shortcode('sc_recruitment_hp','myshortcode_recruitment_hp');


          // shortcode thietbithangcuon product homepage
   function myshortcode_tbtc_pro(){ 
   ob_start();?>
<div class="qb_tbtc_pro qb_pro_detailds">
   <?php     $tbtc_args = array(
      'post_type'             => 'product',
      'post_status'           => 'publish',
      'posts_per_page'        => '12',
      'tax_query'             => array(
         array(
            'taxonomy'      => 'product_cat',
               'field' => 'term_id', //This is optional, as it defaults to 'term_id'
               'terms'         => 21,
               'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
        ),
      )
      );
      $tbtc_query = new WP_Query($tbtc_args);
      if($tbtc_query->have_posts()) : ?>
   <ul class="row">
      <?php while ($tbtc_query->have_posts()) : $tbtc_query->the_post(); ?>
      <li class="col-sm-3">
         <?php global $post;
            $tbtc_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size = 'large'); ?>
         <div class="wrap_figure">
            <figure style="background: url('<?php echo $tbtc_image[0]; ?>');"><a href="<?php the_permalink(); ?>" ></a></figure>
            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <span class="price">Giá: <label>Liên Hệ</label></span>
            <div class="detailds">
               <a href="<?php the_permalink(); ?>">Chi tiết</a>
            </div>
         </div>
      </li>
      <?php endwhile; 
         wp_reset_postdata();
         ?>
   </ul>
   <?php else : echo 'No data'; 
      endif; ?>
</div>
<?php 
return ob_get_clean();
}
add_shortcode('sc_tbtc_pro','myshortcode_tbtc_pro');