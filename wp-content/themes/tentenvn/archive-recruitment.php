<?php  get_header(); ?>	
<div id="wrap">
  <div class="qb_content">
   <div class="breadcrumb">
    <div class="container">
      <div class="breadcrumb_ct">
        <?php $postType = get_queried_object(); ?>
        <h2 class="title_page"><?php echo esc_html($postType->labels->singular_name); ?></h2>
        <?php echo the_breadcrumb(); ?>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="archive_recruitment_page">
      <div class="row">
        <div class="col-sm-3 ">
          <?php if(is_active_sidebar('sidebar')) : ?>
            <div class="qb_sidebar_right">
              <?php dynamic_sidebar('sidebar'); ?>
            </div>
            <?php else : echo 'No data';
            endif; ?>
          </div>
          <div class="col-sm-9">
            <?php   $ngaynophs = get_post_meta( $post->ID, '_ngaynophs', true );
            $ngayhh = get_post_meta( $post->ID, '_ngayhh', true ); ?>
            <div class="list_work_new  qb_defauilt">
              <?php if(have_posts()) : ?>

                <ul class="list_tuyendung_arc">
                  <?php while (have_posts()) : the_post(); ?>
                    <li>
                      <div class="wrap_figure">
                        <?php 
                        global $post;
                        $td_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size = 'large'); ?>
                        <figure style="background: url('<?php echo $td_image[0]; ?>');"><a href="<?php the_permalink(); ?>"></a></figure>
                      </div>
                      <div class="text_widget">
                        <h4><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h4>
                        <div class="excerpt">
                          <p> <?php echo excerpt(30);?></p>
                        </div>
                        <?php if(!empty($ngaynophs) && !empty($ngayhh) ){ ?>
                          <span class="date_time_td">Thời hạn tuyển dụng: <?php echo $ngaynophs; ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> <?php echo $ngayhh; ?></span>
                        <?php }?>
                        <a href="<?php the_permalink() ?>"  class="read_more">Xem thêm >></a>
                      </div>
                    </li>
                  <?php endwhile; 
                  wp_reset_postdata();
                  ?>
                </ul>
                <?php else : echo 'No data'; 
                endif; ?>
              </div>
              <?php get_template_part('includes/frontend/pagination/pagination'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php get_footer(); ?>

