<?php 
get_header();
?>
<div id="wrap">
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
		<div class="container">
			<div class="qb_single_recruitment_page">
				<div class="row">
					<div class="col-sm-3 ">
						<?php if(is_active_sidebar('sidebar')) : ?>
							<div class="qb_sidebar_right">
								<?php dynamic_sidebar('sidebar'); ?>
							</div>
							<?php else : echo 'No data';
							endif; ?>
						</div>
						<div class="col-sm-9">
							<div class="single_ct">
								<h2 class="title_defauilt_single_page"><?php the_title(); ?></h2>
								<div class="date_time_dt">
									<?php  
									$ngaynophs = get_post_meta( $post->ID, '_ngaynophs', true );
									$ngayhh = get_post_meta( $post->ID, '_ngayhh', true );
									?>	
									<?php if(!empty($ngaynophs) && !empty($ngayhh) ){ ?>
										<span class="date_time_td"><?php echo $ngaynophs; ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> <?php echo $ngayhh; ?></span>
									<?php }?>
								</div>
							</div>
							<div class="ct_text">
								<?php the_content(); ?>
								<?php wp_nonce_field( 'woocommerce-order-tuyendung', 'woocommerce-order-tuyendung'); ?>
								<a href="javascipt:void(0);" class="order_tuyendung" data-id="<?php the_ID(); ?>" data-dismiss="modal" data-target="#popup_tuyendung">Nộp đơn</a>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="popup" id="popup_tuyendung">
			<div class="content_popup">
				<h2 class="title_form_datmua">Form tuyển dụng</h2>
				<div class="wrap_content_pop">
					<div class="content_tour">
<!-- 						<div class="wrap_figure">
							<figure class="image_tuyendung"><img src="<?php echo BASE_URL; ?>/images/langgombattrang_img1.jpg"></figure>
						</div> -->
						<div class="textwidget info_tuyendung">
							<h3><?php the_title(); ?></h3>
						</div>
					</div>
					<div class="form_pop">
						<?php echo do_shortcode('[contact-form-7 id="129" title="Recruitment form"]'); ?>
					</div>
					<div class="close_popup" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			var disableSubmit = false;
			jQuery('button[type="submit"]').click(function() {
				if (disableSubmit == true) {
					return false;
				}
				disableSubmit = true;
				return true;
			})

			var wpcf7Elm = document.querySelector( '.wpcf7' );
			wpcf7Elm.addEventListener( 'wpcf7submit', function( event ) {
				disableSubmit = false;
			}, false );
			
			jQuery(document).on('click','.order_tuyendung',function(e){
				e.preventDefault();
				var post_id = (jQuery(this).data('id') != '') ? jQuery(this).data('id') : null;
				var wp_nonce = (jQuery('#woocommerce-order-tuyendung').val() != '') ? jQuery('#woocommerce-order-tuyendung').val() : null;

				jQuery.ajax({
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					type: 'post',
					dataType: 'json',
					data: {
						action: 'get_detail_order_tuyendung',
						post_id : post_id,
						wp_nonce : wp_nonce,
					},	
					beforeSend: function(){
						jQuery('.form_pop form')[0].reset();
						jQuery('.wpcf7-not-valid-tip').remove();
					},
					success: function(response) {
						if (response.status == 1) {
							if (response.data.img != '') {
								jQuery('.content_tour .wrap_figure .image_tuyendung img').attr('src',response.data.img);
							}
							jQuery('.content_tour .info_tuyendung h3').html(response.data.title);
							jQuery('input[name=tuyendung_id]').val(response.data.id);
							jQuery('.popup_tuyendung').modal('show');
						}else{
							autohidenotify2('danger','top right','Thông báo: ',response.msg,8000);
						}
					},
					error: function( jqXHR, textStatus, errorThrown ){
						autohidenotify2('danger','top right','Thông báo: ','Có lỗi xẩy ra, vui lòng thử lại sau',8000);
					}
				});	
			});

			function autohidenotify2(style,position,title,message,delay) {
				if(style == "danger"){
					icon = "fa fa-exclamation";
				}else if(style == "warning"){
					icon = "fa fa-warning";
				}else if(style == "success"){
					icon = "fa fa-check";
				}else if(style == "info"){
					icon = "fa fa-question";
				}else{
					icon = "fa fa-circle-o";
				}   
				jQuery.notify({       
					title: title,
					message: message,
					icon: icon
				}, {
					type: style,
					style: 'metro',
					className: style,
					globalPosition:position,
					showAnimation: "show",
					showDuration: 200,
					hideDuration: 200,
					delay: delay,
					autoHide: true,
					clickToHide: true
				});
			}
		</script>
	</div>
</div>
</div>
<?php 
get_footer();
?>