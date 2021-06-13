<?php
/**
 * Cấu hình cơ bản cho WordPress
 *
 * Trong quá trình cài đặt, file "wp-config.php" sẽ được tạo dựa trên nội dung 
 * mẫu của file này. Bạn không bắt buộc phải sử dụng giao diện web để cài đặt, 
 * chỉ cần lưu file này lại với tên "wp-config.php" và điền các thông tin cần thiết.
 *
 * File này chứa các thiết lập sau:
 *
 * * Thiết lập MySQL
 * * Các khóa bí mật
 * * Tiền tố cho các bảng database
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Thiết lập MySQL - Bạn có thể lấy các thông tin này từ host/server ** //
/** Tên database MySQL */
define( 'DB_NAME', 'banhangtaikho' );

/** Username của database */
define( 'DB_USER', 'root' );

/** Mật khẩu của database */
define( 'DB_PASSWORD', '' );

/** Hostname của database */
define( 'DB_HOST', 'localhost' );

/** Database charset sử dụng để tạo bảng database. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Kiểu database collate. Đừng thay đổi nếu không hiểu rõ. */
define('DB_COLLATE', '');

/**#@+
 * Khóa xác thực và salt.
 *
 * Thay đổi các giá trị dưới đây thành các khóa không trùng nhau!
 * Bạn có thể tạo ra các khóa này bằng công cụ
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Bạn có thể thay đổi chúng bất cứ lúc nào để vô hiệu hóa tất cả
 * các cookie hiện có. Điều này sẽ buộc tất cả người dùng phải đăng nhập lại.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '1>.]5([#R?Xj==SZlj1wVI939]agg0&A;}fSb^wOUJ?+1g9aPU!DiC`t~ cS;[-g' );
define( 'SECURE_AUTH_KEY',  'v%*b&{B5BgV4g~`DjC1d~2kno^xFiJfz1&<J^e3SF )VZ{Txq*vF[o[9E|/U|N.c' );
define( 'LOGGED_IN_KEY',    '$h+qhCrYo@u7;gggKnl.MoFwhm(Esh( PB@e.x;IYnK+xwU*!-O45)>MXsyh|KP#' );
define( 'NONCE_KEY',        'rEA~a{t5A{X@En.pfpUhI%xNm?AzS=%]HT-4-t`h!cuqD!qC,I,Es?6mTk5a%6</' );
define( 'AUTH_SALT',        '-2_3y.AOeuImu0;]XpMCI/9ki4%99xzG^)>e+6Vz^MB0$C!Giy`o2|~Qpie|rSdi' );
define( 'SECURE_AUTH_SALT', '0A|;Vy/}Fh?310zc{^E#=l@dlUvVH`BHQ)&3:GV2M;M/lFl)X~]T@KpKn&CLBG`}' );
define( 'LOGGED_IN_SALT',   'v#7{X8ZoV3(:^0t{VKMg0I:6Q1+h]aJ!Q@zn:!^Tczx>#HM};Hayj^ff46)R|z/P' );
define( 'NONCE_SALT',       'q38 -Cc+e7Ou(u# =de|WPw#WZ#J52L ZrX_Ym`*7Vo&q!0/xbssp+m@#vDMGShO' );

/**#@-*/

/**
 * Tiền tố cho bảng database.
 *
 * Đặt tiền tố cho bảng giúp bạn có thể cài nhiều site WordPress vào cùng một database.
 * Chỉ sử dụng số, ký tự và dấu gạch dưới!
 */
$table_prefix  = 'wp_';

/**
 * Dành cho developer: Chế độ debug.
 *
 * Thay đổi hằng số này thành true sẽ làm hiện lên các thông báo trong quá trình phát triển.
 * Chúng tôi khuyến cáo các developer sử dụng WP_DEBUG trong quá trình phát triển plugin và theme.
 *
 * Để có thông tin về các hằng số khác có thể sử dụng khi debug, hãy xem tại Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* Đó là tất cả thiết lập, ngưng sửa từ phần này trở xuống. Chúc bạn viết blog vui vẻ. */

/** Đường dẫn tuyệt đối đến thư mục cài đặt WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Thiết lập biến và include file. */
require_once(ABSPATH . 'wp-settings.php');
