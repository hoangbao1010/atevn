<?php 
	// shortcode sk sidebar homepage
function myshortcode_banner_homepage(){ 
	ob_start();?>
	<div class="banner_homepage">
		<?php $banner_arg = array(
			'post_type' => 'slide',
			'order' => 'ASC',
			'orderby' => 'date',
			'post_status' => 'publish',
			'posts_per_page' => -1
		);
		$banner_query = new WP_Query($banner_arg);
		if($banner_query->have_posts()) : ?>
			<ul>
				<?php while ($banner_query->have_posts()) : $banner_query->the_post(); ?>
					<li>
						<?php 
						global $post;
						$banner_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size = 'large'); ?>
						<figure style="background: url('<?php echo $banner_image[0]; ?>');"><a href="#"></a></figure>
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
	add_shortcode('sc_banner_hp','myshortcode_banner_homepage');

	// shortcode tintuc homepage
	function myshortcode_news_homepage(){ 
		ob_start();?>
		<div class="news_homepage">
			<?php $title_hp = get_cat_name(31);?>
			<h2 class="title_home_page"><a href="<?php echo get_category_link(31); ?>">Tin tức</a></h2>
			<?php $news_arg = array(
				'post_type' => 'post',
				'order' => 'ASC',
				'orderby' => 'date',
				'post_status' => 'publish',
				'cat' => 31,
				'posts_per_page' => 5
			);
			$news_query = new WP_Query($news_arg);
			if($news_query->have_posts()) : ?>
				<ul>
					<?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
						<li>
							<?php 
							global $post;
							$cptpp_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size = 'large'); ?>
							<a href="<?php the_permalink(); ?>" target="_blank">
								<figure style="background: url('<?php echo $cptpp_image[0]; ?>');"></figure>
								<h4><?php the_title(); ?></h4>
							</a>
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
		add_shortcode('sc_news_hp','myshortcode_news_homepage');
