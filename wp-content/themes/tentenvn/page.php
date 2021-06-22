<?php get_header(); ?>
<?php 
if(is_cart() || is_checkout()){
	?>
	<div class="page-wrapper">
		<div class="g_content"> 
			<div id="breadcrumb" class="breadcrumb">
				<ul>
					<?php  echo the_breadcrumb(); ?>
				</ul>
			</div> 
			<div class="container">
				<?php 
				if(have_posts()) :
					while(have_posts()) : the_post();
						the_content();
					endwhile;
				endif;
				?>

			</div><!-- container -->
		</div>
	</div>
	<?php
}
else{
	?>
	<div class="page-wrapper">
		<div class="qb_content">
			<div class="breadcrumb">
				<div class="container">
					<div class="breadcrumb_ct">
     <?php $page_title = $wp_query->post->post_title; ?>
     <h2 class="title_page"><?php echo $page_title; ?></h2> 
						<?php  echo the_breadcrumb(); ?>
					</div>
				</div>
			</div>
			<div class="page_defauilt">
				<div class="container">
					<div class="row recipe_defauilt">
						<div class="col-sm-3 df-col-3">
							<?php if(is_active_sidebar('sidebar')) : ?>
								<div class="qb_sidebar_right">
									<?php dynamic_sidebar('sidebar'); ?>
								</div>
								<?php else : echo 'No data';
								endif; ?>
							</div>
							<div class="col-sm-9 df-col-9">
									<?php 
									if(have_posts()) :
										while(have_posts()) : the_post();
											the_content();
										endwhile;
									endif;
									?>
							</div>
						</div>

					</div><!-- container -->
				</div>
			</div>
		</div>
		<?php
	}	

	?>



	<?php get_footer(); ?>