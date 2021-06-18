<?php 
get_header(); 
?>	
<div id="wrap">
	<div class="qb_content">
		<div class="breadcrumb">
			<div class="container">
				<div class="breadcrumb_ct">
					<?php $cat_knowledge_name = get_cat_name(1);?>
					<h2><?php echo $cat_knowledge_name; ?></h2>
					<?php  echo the_breadcrumb(); ?>
				</div>
			</div>
		</div> 
		<div class="single_page">
			<div class="container">
				<div class="row">
					<div class="col-sm-3 ">
						<?php if(is_active_sidebar('sidebar')) : ?>
							<div class="qb_sidebar_right">
								<?php dynamic_sidebar('sidebar'); ?>
							</div>
							<?php else : echo 'No data';
							endif; ?>
						</div>
						<?php 
						if(have_posts()) :
							while(have_posts()) : the_post(); ?>
								<div class=" col-sm-9">
									<article class="content_single_post">
										<div class="single_post_info">
											<h2><?php the_title(); ?></h2>
										</div>
										<div class="text_content">
											<?php  the_content(); ?>
										</div>
									</article>
									<?php $related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 4, 'post__not_in' => array($post->ID) ) ); ?>
									<?php if($related){ ?>
										<div class="related_posts">
											<h2 class="title_defauilt">Các bài viết khác</h2>
											<ul> 
												<?php
												if( $related ) foreach( $related as $post ) {
													setup_postdata($post); ?>
													<li>
														<h4><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
													</li>
												<?php }
												wp_reset_postdata(); ?>
											</ul>   
										</div>
									<?php } ?> 
								</div>
							<?php endwhile;
						else:
						endif;
						wp_reset_postdata();
						?>
					</div>
				</div>
			</div>
		</div>
	</div>


	<?php get_footer(); ?>


