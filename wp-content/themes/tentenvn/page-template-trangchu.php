
<?php 
/*
Template Name: page-template-trangchu
*/
get_header(); 
?>	

<div class="page-wrapper">
	<div class="qb_content">
		<div class="banner_news_homepage">
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<?php echo do_shortcode('[sc_banner_hp]'); ?>
					</div>
					<div class="col-sm-3">
						<?php echo do_shortcode('[sc_news_hp]'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>




