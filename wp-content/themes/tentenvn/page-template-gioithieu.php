<?php 
/*
Template Name: page-template-gioithieu
*/
get_header(); 
?>	

<div class="page-wrapper">
	<div class="g_content">
		<div id="breadcrumb" class="breadcrumb">
			<ul>
				<?php  echo the_breadcrumb(); ?>
			</ul>
		</div> 
		<div class="container">
			<div class="row">
				<div class="col-sm-9">
					<div class="g_content_left">
						<?php 
							if(have_posts()) :
								while(have_posts()) : the_post();
								the_content();
							endwhile;
							endif;
						?>
					</div>

				</div>
				<div class="col-sm-3 sidebar">
					<?php dynamic_sidebar('sidebar1'); ?> 
				</div>
			</div>

		</div><!-- container -->
	</div>
</div>
<?php get_footer(); ?>