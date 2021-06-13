<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="<?php if(get_option('meta_des')){echo get_option('meta_des');} ?>" /> 
	<meta name="keywords" content="<?php if(get_option('meta_key')){echo get_option('meta_key');} ?> ">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php if(is_front_page()){echo bloginfo('name');}else{ wp_title('',true,''); } ?></title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i" rel="stylesheet">
	<!-- css -->
	      <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/images/favicon.ico">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/slick.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
	<!-- js -->
	<script src="<?php echo BASE_URL; ?>/js/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/js/slick.js"></script>
	<?php wp_head(); ?>
</head>


<body <?php body_class() ?>>

	<div class="bg_opacity"></div>

	<?php if ( wp_is_mobile() ) { ?>
		<div id="menu_mobile_full">
			<nav class="mobile-menu">
				<p class="close_menu"><span><i class="fa fa-times" aria-hidden="true"></i></span></p>
				<?php 
				$args = array('
					theme_location' => 'menu_mobile');
					?>
					<?php wp_nav_menu($args);?>
				</nav>
			</div>
		<?php }?>

		<header>
			<div class="header">
				<div class="top_header">
					
				</div>
				<div class="middle_header">
					<span class="icon_mobile_click"><i class="fa fa-bars" aria-hidden="true"></i></span>
					<div class="container">
						<div class="logo_site">
							<?php 
							if(has_custom_logo()){
								the_custom_logo();
							}
							else { ?> 
								<h2><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h2>
							<?php } ?>
						</div>

						<div class="search_header">
							<form role="search" method="get" id="searchform" action="<?php echo home_url('/');  ?>">
								<div class="search">
									<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" placeholder="Tìm kiếm sản phẩm, model ...">
									<input type="hidden" value="product" name="post_type">
									<button type="submit" id="searchsubmit">Tìm kiếm</button>
								</div>
							</form>
						</div>
						<div class="phone_header">
							<?php 	$phone = get_option('phone');
							$phone_trim = trim($phone); ?>
							<h1 title="Hỗ trợ khách hàng"><span><?php echo $phone_trim; ?></span></h1>
						</div>
					</div>
				</div>

				<div class="bottom_header ">
					<div class="container">
						<span class="icon_mobile_click"><i class="fa fa-bars" aria-hidden="true"></i></span>
						<nav class="nav nav_primary">
							<?php 
							$args = array(
								'theme_location' => 'primary',
								'menu_class' => 'qb_memu_header',
							);?>
							<?php wp_nav_menu($args); ?>
						</nav>
					</div>
				</div>
			</div>
		</header>



