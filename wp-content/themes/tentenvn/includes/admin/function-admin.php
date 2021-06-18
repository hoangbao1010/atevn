<?php
add_action('admin_menu', 'ch_essentials_admin');
function ch_essentials_admin() {
    // Infomation Option
	register_setting('zang-settings-header', 'phone');
	register_setting('zang-settings-header', 'address_header');

	// Social Option
	register_setting('zang-settings-socials', 'footer_fb');
	register_setting('zang-settings-socials', 'footer_youtube');
	register_setting('zang-settings-socials', 'footer_ggplus');
	register_setting('zang-settings-socials', 'footer_insta');
	register_setting('zang-settings-socials', 'footer_skype');
	register_setting('zang-settings-socials', 'footer_linkedin');

	/* Base Menu */
	add_menu_page('Theme Option','Ninja Dona Framework','manage_options','template_admin_zang','zang_theme_create_page',get_template_directory_uri() . '/images/favicon-1.png',110);
}
add_action('admin_init', 'zang_custom_settings');
function zang_custom_settings() { 

	/* Infomation Options Section */
	add_settings_section('zang-header-options', 'Chỉnh sửa thông tin','zang_header_options_callback','zang-settings-header' );
	add_settings_field('address-hd','Hotline', 'zang_phone_header','zang-settings-header', 'zang-header-options');
	add_settings_field('phone-hd','Email', 'zang_address_header','zang-settings-header', 'zang-header-options');

	/* Social Options Section */
	add_settings_section('zang-social-options','Chỉnh sửa social','zang_social_options_callback','zang-settings-socials' );
	add_settings_field('facebook','Facebook Link', 'zang_footer_fb','zang-settings-socials', 'zang-social-options');
	add_settings_field('youtube','YouTube Link', 'zang_footer_youtube','zang-settings-socials', 'zang-social-options');
	add_settings_field('ggplus','Google Plus Link', 'zang_footer_ggplus','zang-settings-socials', 'zang-social-options');
	add_settings_field('insta','Instagram Link', 'zang_footer_insta','zang-settings-socials', 'zang-social-options');
	add_settings_field('skype','Skype Link', 'zang_footer_skype','zang-settings-socials', 'zang-social-options');
	add_settings_field('linkedin','Linkedin Link', 'zang_footer_linkedin','zang-settings-socials', 'zang-social-options');

}

function zang_header_options_callback(){
	echo '';
}

function zang_social_options_callback(){
	echo '';
}

function zang_phone_header(){
	$phone = esc_attr(get_option('phone'));
	echo '<input type="text" class="iptext_adm" name="phone" value="'.$phone.'" >';
}
function zang_address_header(){
	$address_header = esc_attr(get_option('address_header'));
	echo '<input type="text" class="iptext_adm" name="address_header" value="'.$address_header.'" placeholder="" ';
}

function zang_footer_fb(){
	$footer_fb = esc_attr(get_option('footer_fb'));
	echo '<input type="text" class="iptext_adm" name="footer_fb" value="'.$footer_fb.'" placeholder="" ';
}
function zang_footer_youtube(){
	$footer_youtube = esc_attr(get_option('footer_youtube'));
	echo '<input type="text" class="iptext_adm" name="footer_youtube" value="'.$footer_youtube.'" placeholder="" ';
}
function zang_footer_ggplus(){
	$footer_ggplus = esc_attr(get_option('footer_ggplus'));
	echo '<input type="text" class="iptext_adm" name="footer_ggplus" value="'.$footer_ggplus.'" placeholder="" ';
}
function zang_footer_insta(){
	$footer_insta = esc_attr(get_option('footer_insta'));
	echo '<input type="text" class="iptext_adm" name="footer_insta" value="'.$footer_insta.'" placeholder="" ';
}
function zang_footer_skype(){
	$footer_skype = esc_attr(get_option('footer_skype'));
	echo '<input type="text" class="iptext_adm" name="footer_skype" value="'.$footer_skype.'" placeholder="" ';
}
function zang_footer_linkedin(){
	$footer_linkedin = esc_attr(get_option('footer_linkedin'));
	echo '<input type="text" class="iptext_adm" name="footer_linkedin" value="'.$footer_linkedin.'" placeholder="" ';
}

// Shortcode
function myshortcode_social_header(){
	ob_start();
	if(get_option('footer_fb') || get_option('footer_skype') || get_option('footer_ggplus') ){
		?>
		<ul>
			<?php if(get_option('footer_fb')){ ?>
				<li><a href="<?php echo get_option('footer_fb'); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
			<?php }?>
			<?php if(get_option('footer_skype')){ ?>
				<li><a href="<?php echo get_option('footer_skype'); ?>" target="_blank"><i class="fa fa-skype"></i></a></li>
			<?php }?>
			<?php if(get_option('footer_ggplus')){ ?>
				<li><a href="<?php echo get_option('footer_ggplus'); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
			<?php }?>
		</ul>	
		<?php
	}
	return ob_get_clean();
}
add_shortcode('sc_social_hd','myshortcode_social_header');


function myshortcode_social_footer(){
	ob_start();
	if(get_option('footer_fb') || get_option('footer_insta') || get_option('footer_ggplus') || get_option('footer_linkedin') || get_option('footer_youtube') ){
		?>
		<ul>
			<?php if(get_option('footer_fb')){ ?>
				<li><a href="<?php echo get_option('footer_fb'); ?>" target="_blank"><img src="<?php echo BASE_URL; ?>/images/social-ft-1.png"></a></li>
			<?php }?>
			<?php if(get_option('footer_insta')){ ?>
				<li><a href="<?php echo get_option('footer_insta'); ?>" target="_blank"><img src="<?php echo BASE_URL; ?>/images/social-ft-2.png"></a></li>
			<?php }?>
			<?php if(get_option('footer_ggplus')){ ?>
				<li><a href="<?php echo get_option('footer_ggplus'); ?>" target="_blank"><img src="<?php echo BASE_URL; ?>/images/social-ft-3.png"></a></li>
			<?php }?>
			<?php if(get_option('footer_linkedin')){ ?>
				<li><a href="<?php echo get_option('footer_linkedin'); ?>" target="_blank"><img src="<?php echo BASE_URL; ?>/images/social-ft-4.png"></a></li>
			<?php }?>
			<?php if(get_option('footer_youtube')){ ?>
				<li><a href="<?php echo get_option('footer_youtube'); ?>" target="_blank"><img src="<?php echo BASE_URL; ?>/images/social-ft-5.png"></a></li>
			<?php }?>

		</ul>	
		<?php
	}
	return ob_get_clean();
}
add_shortcode('sc_social_ft','myshortcode_social_footer');

/* Display Page
-----------------------------------------------------------------*/
function zang_theme_create_page() {
	?>
	<div class="wrap">  
		<?php settings_errors(); ?>  

		<?php  
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'header_page_options';  
		?>  

		<ul class="nav-tab-wrapper"> 
			<li><a href="?page=template_admin_zang&tab=header_page_options" class="nav-tab <?php echo $active_tab == 'header_page_options' ? 'nav-tab-active' : ''; ?>">Infomation</a> </li>
			<li><a href="?page=template_admin_zang&tab=social_page_options" class="nav-tab <?php echo $active_tab == 'social_page_options' ? 'nav-tab-active' : ''; ?>">Social</a></li>	
		</ul>  

		<form method="post" action="options.php">  
			<?php 
			if( $active_tab == 'header_page_options' ) {  
				settings_fields( 'zang-settings-header' );
				do_settings_sections( 'zang-settings-header' ); 
			} else if( $active_tab == 'social_page_options' ) {
				settings_fields( 'zang-settings-socials' );
				do_settings_sections( 'zang-settings-socials' ); 
			}
			?>             
			<?php submit_button(); ?>  
		</form> 

	</div> 

	<?php
}


