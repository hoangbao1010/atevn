
<?php 
/*
Template Name: page-template-trangchu
*/
get_header(); 
?>	

<div class="page-wrapper">
	<div class="g_content">
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




