<?php 
get_header(); 
$categories = get_the_category();
$category_id = $categories[0]->parent;
?>  
<div id="content">
	<div class="qb_content">
		<div class="breadcrumb">
			<div class="container">
				<div class="breadcrumb_ct">
					<h2 class="title_page"><?php echo $categories[0]->name; ?></h2>
					<?php echo the_breadcrumb(); ?>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="archive_page">
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
<!--                 <?php 
                if(is_category()){
                  ?> <h3 class="title_archives"><a href="<?php echo get_category_link($categories[0]->term_id); ?>"><strong><?php single_cat_title() ?></strong></a> </h3>
                  <?php
                }
                else if(is_tag()){ ?>
                  <h3 class="title_archives">Tag: <strong> <?php single_tag_title(); ?> <strong></h3>
                  <?php } 
                  else if(is_author()){
                    the_post();
                    echo '<h3 class="title_archives">Author: <strong> ' . get_the_author() . '</strong></h3>';
                    rewind_posts();
                  }
                  else if(is_day()){
                    echo '<h3 class="title_archives">Day Archives : <strong>' . get_the_date() . '</strong></h3>';
                  }
                  else if(is_month()){
                    echo '<h3 class="title_archives">Monthly Archives : <strong>' . get_the_date('F Y') . '</strong></h3>';
                  }
                  else if(is_year()){
                    echo '<h3 class="title_archives">Yearly Archives : <strong>' . get_the_date('Y') . '</strong></h3>';
                  }
                  else{
                    echo 'archive';
                  }
                ?> -->
                <div class="qb_archive_post qb_defauilt"> 
                 <?php if(have_posts()) : ?>
                  <ul>
                   <?php while (have_posts()) : the_post(); ?>
                    <li>
                     <div class="wrap_figure">
                      <?php 
                      global $post;
                      $nb_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size = 'large'); ?>
                      <figure style="background: url('<?php echo $nb_image[0]; ?>');"><a href="<?php the_permalink(); ?>"></a></figure>
                    </div>
                    <div class="text_widget">
                      <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4> 
                      <span class="qb_date_post"> Ngày đăng: <?php the_time('d/m/Y'); ?></span>
                      <div class="excerpt">
                       <p> <?php echo excerpt(30);?></p>
                     </div>
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

