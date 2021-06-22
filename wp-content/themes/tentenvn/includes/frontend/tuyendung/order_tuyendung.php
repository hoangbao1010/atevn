<?php 
	add_action( 'wp_ajax_get_detail_order_tuyendung', 'get_detail_order_tuyendung_init' );
	add_action( 'wp_ajax_nopriv_get_detail_order_tuyendung', 'get_detail_order_tuyendung_init' );

	if (!function_exists('get_detail_order_tuyendung_init')) {
		function get_detail_order_tuyendung_init(){
			$response = ['status' => 0, 'msg' => 'Có lỗi xẩy ra, vui lòng thử lại'];
			if (isset($_POST['wp_nonce']) && $_POST['wp_nonce'] != '') {
				if (!wp_verify_nonce( $_POST['wp_nonce'], 'woocommerce-order-tuyendung')) {
					wp_send_json($response);
					exit();
				}
			}else{
				wp_send_json($response);
				exit();
			}

			if (isset($_POST['post_id']) && $_POST['post_id'] != '') {
				$regex = '/^[0-9]{1,}$/';
				if (!preg_match($regex, $_POST['post_id'])) {
					$response = ['status' => 0, 'msg' => 'Dịch vụ không tồn tại'];
					wp_send_json($response);
					exit();
				}

				$post = get_post($_POST['post_id']);
				if (empty($post)) {
					$response = ['status' => 0, 'msg' => 'Dịch vụ không tồn tại'];
					wp_send_json($response);
					exit();
				}
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
				$data_post = [
					'id' => $post->ID,
					'title' => $post->post_title,
					'img' => isset($image[0]) ? $image[0] : '',
				];

				$response = ['status' => 1, 'msg' => 'success', 'data' => $data_post];
			}
			wp_send_json($response);
			exit();
		}
	}

	add_filter('wpcf7_validate_text', 'custom_text_order_tuyendung', 20, 2);
	add_filter('wpcf7_validate_text*', 'custom_text_order_tuyendung', 20, 2);

	// add_filter('wpcf7_validate_email', 'custom_email_order_tuyendung', 20, 2);
	// add_filter('wpcf7_validate_email*', 'custom_email_order_tuyendung', 20, 2);

	add_filter('wpcf7_validate_number', 'custom_number_order_tuyendung', 20, 2);
	add_filter('wpcf7_validate_number*', 'custom_number_order_tuyendung', 20, 2);

	// add_filter('wpcf7_validate_textarea', 'custom_textarea_order_tuyendung', 20, 2);
	// add_filter('wpcf7_validate_textarea*', 'custom_textarea_order_tuyendung', 20, 2);

	if (!function_exists('custom_text_order_tuyendung')) {
		function custom_text_order_tuyendung($result, $tag){
			if (isset($_POST['type']) && ($_POST['type'] == 'order_tuyendung')) {
				if ('full-name' == $tag->name) {
					$full_name = $_POST['full-name'];
					if ($full_name != '') {
			            $valid_xss = validate_xss(trim($full_name));

						if (!empty($valid_xss)) {
				            $result->invalidate($tag, $valid_xss);
				        }
				    }else{
				    	$result->invalidate($tag, 'Vui lòng nhập họ tên');
				    }
				}

				if ('date' == $tag->name) {
					$date = $_POST['date'];
					if ($date != '') {
			            $valid_xss = validate_xss(trim($date));

						if (!empty($valid_xss)) {
				            $result->invalidate($tag, $valid_xss);
				        }
				    }
				    // else{
				    // 	$result->invalidate($tag, 'Vui lòng nhập họ tên');
				    // }
				}

				if ('address' == $tag->name) {
					$address = $_POST['address'];
					if ($address != '') {
			            $valid_xss = validate_xss(trim($address));

						if (!empty($valid_xss)) {
				            $result->invalidate($tag, $valid_xss);
				        }
				    }else{
				    	$result->invalidate($tag, 'Vui lòng nhập địa chỉ');
				    }
				}

				if ('phone' == $tag->name) {
					$phone = $_POST['phone'];
					if ($phone != '') {
			            $regex = '/^[0-9]{5,30}$/';
						if (!preg_match($regex, $phone)) {
			                $result->invalidate($tag, 'Số điện thoại không hợp lệ');
			            }
				    }else{
				    	$result->invalidate($tag, 'Vui lòng nhập số điện thoại');
				    }
				}
			}

			return $result;
		}
	}

	if (!function_exists('custom_email_order_tuyendung')) {
		function custom_email_order_tuyendung($result, $tag){
			if (isset($_POST['type']) && ($_POST['type'] == 'order_tuyendung')) {
				if ('email' == $tag->name) {
					$email = $_POST['email'];
					if ($email != '') {
			            if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email)) {
			            } else {
			                $result->invalidate($tag, 'Địa chỉ email không hợp lệ');
			            }
				    }else{
				    	$result->invalidate($tag, 'Vui lòng nhập email');
				    }
				}
			}

			return $result;
		}
	}

	if (!function_exists('custom_number_order_tuyendung')) {
		function custom_number_order_tuyendung($result, $tag){
			if (isset($_POST['type']) && ($_POST['type'] == 'order_tuyendung')) {
				if ('dem_tuyendung' == $tag->name) {
					$dem_tuyendung = $_POST['dem_tuyendung'];
					if ($dem_tuyendung != '') {
						$regex = '/^[0-9]{1,}$/';
			            if (!preg_match($regex, $dem_tuyendung)) {
			                $result->invalidate($tag, 'Chọn số lượng không hợp lệ');
			            }else if($dem_tuyendung < 5){
			            	$result->invalidate($tag, 'Chọn số lượng tối thiểu là 5');
			            }
				    }else{
				    	$result->invalidate($tag, 'Vui lòng chọn số lượng (tối thiểu là 5)');
				    }
				}
			}
			return $result;
		}
	}

	add_action('wpcf7_before_send_mail', 'save_form_order_tuyendung');

	if (!function_exists('save_form_order_tuyendung')) {
		function save_form_order_tuyendung($WPCF7_ContactForm){
			$submission = WPCF7_Submission::get_instance();
		    if ( $submission ) {
		        $posted_data = $submission->get_posted_data();
		        if (isset($posted_data['type']) && $posted_data['type'] == 'order_tuyendung') {
		        	if (isset($posted_data['tuyendung_id']) && $posted_data['tuyendung_id'] != '') {
						$regex = '/^[0-9]{1,}$/';
						if (!preg_match($regex, $posted_data['tuyendung_id'])) {
							echo json_encode(["into" => "#".$_POST['_wpcf7_unit_tag'],"status" => "validation_failed", "message" => 'Sản phẩm không tồn tại！']);
			    			die();
						}

						$post = get_post($posted_data['tuyendung_id']);
						if (empty($post)) {
							echo json_encode(["into" => "#".$_POST['_wpcf7_unit_tag'],"status" => "validation_failed", "message" => 'Sản phẩm không tồn tại！']);
			    			die();
						}

						$content_send_mail = '
			        		<table class="order_tour_bt" cellspacing="0" cellpadding="3" border="1" width="100%">
								<tbody>
									<tr>
										<td colspan="3" style="font-weight: 700;text-transform:uppercase;font-size:17px;background:#394748;color:#fff;padding:10px;">Thông tin người đặt</td>
									</tr>
									<tr>
										<td width="150">Họ và tên </td>
										<td colspan="2">'.$posted_data["full-name"].'</td>
									</tr>
									<tr>
										<td>Số điện thoại liên hệ </td>
										<td colspan="2">'.$posted_data["phone"].'</td>
									</tr>
									<tr>
										<td>Địa chỉ Email </td>
										<td colspan="2">'.$posted_data["email"].'</td>
									</tr>
									<tr>
										<td>Địa chỉ</td>
										<td colspan="2">'.$posted_data["address"].'</td>
									</tr>
									<tr>
										<td>Nội dung</td>
										<td colspan="2">'.$posted_data["content"].'</td>
									</tr>
									<tr>
										<td colspan="3" style="font-weight: 700;text-transform:uppercase;font-size:17px;background:#394748;color:#fff;padding:10px;">Thông tin dịch vụ</td>
									</tr>
									<tr>
										<td>Tên món ăn</td>
										<td colspan="2">'.$post->post_title.'</td>
									</tr>
							
								</tbody>
							</table>';
			        	$headers = array(
				            'Content-Type: text/html; charset=UTF-8',
				            'From: ' .$posted_data["full-name"] . ' <>',
				            'Reply-To: ' . $posted_data["email"]
				        );
			        	$check_send = wp_mail('truonggiang120795@gmail.com', "Form tuyển dụng", $content_send_mail, $headers);
			        	if (!empty($check_send) && $check_send == 1) {
			        		return true;
			        	}else{
			        		echo json_encode(["into" => "#".$_POST['_wpcf7_unit_tag'],"status" => "validation_failed", "message" => 'Có lỗi xẩy ra trong quá trình gửi mail, Xin vui lòng thử lại！']);
				    		die();
			        	}
					}else{
						echo json_encode(["into" => "#".$_POST['_wpcf7_unit_tag'],"status" => "validation_failed", "message" => 'Sản phẩm không tồn tại！']);
			    		die();
					}
				}
			}
		}
	}

function validate_xss($value = '')
{
	$result = '';
	$arr_xss = array('<script', '<a', '<link', '<?', '<?php', '<iframe', '</iframe>', 'onload=', '<xml', '<input', '<html', '<meta', '<object', '<meta', '<applet', '&lt;script', '&lt;a', '&lt;link', '&lt;?', '&lt;?php', '&lt;iframe', '&lt;/iframe>', 'onload=', '&lt;xml', '&lt;input', '&lt;html', '&lt;meta', '&lt;object', '&lt;meta', '&lt;applet',);
	foreach ($arr_xss as $key => $value_arr_xss) {
		if (strpos($value, $value_arr_xss) !== false) {
			$result = 'Nội dung nhập có chứa từ khóa không hợp lệ';
			return $result;
			break;
		}
	}
	return $result;
}
?>