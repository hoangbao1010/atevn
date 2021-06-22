<?php 
/*
Template Name: page-template-lienhe
*/
get_header(); 
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
		<?php 
		if(have_posts()) :
			while(have_posts()) : the_post();
				the_content();
			endwhile;
		endif;
		?>
	</div>
</div>
<?php get_footer(); ?>