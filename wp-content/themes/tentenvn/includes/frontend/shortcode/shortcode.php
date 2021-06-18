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

			// shortcode sidebar news
		function myshortcode_sidebar_news(){ 
			ob_start();?>
			<div class="qb_sidebar_news">
				<?php $title_hp = get_cat_name(1);?>
				<h2 class="title_news"><a href="<?php echo get_category_link(1); ?>" target="_blank"><?php echo $title_hp; ?></a></h2>
				<div class="sidebar_news_ct">
					<?php $news_arg = array(
						'post_type' => 'post',
						'order' => 'ASC',
						'orderby' => 'date',
						'post_status' => 'publish',
						'cat' => 1,
						'posts_per_page' => 5
					);
					$news_query = new WP_Query($news_arg);
					if($news_query->have_posts()) : ?>
						<?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
							<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<?php endwhile; 
						wp_reset_postdata();
						?>
						<?php else : echo 'No data'; 
						endif; ?>
					</div>
				</div>
				<?php 
				return ob_get_clean();
			}
			add_shortcode('sc_sidebar_news','myshortcode_sidebar_news');
