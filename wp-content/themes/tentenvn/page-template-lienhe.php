<?php 
/*
Template Name: page-template-lienhe
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
<?php get_footer(); ?>