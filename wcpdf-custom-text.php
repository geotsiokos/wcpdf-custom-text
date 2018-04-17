<?php
/**
 * wcpdf-custom-text.php
 *
 * Plugin Name: Custom text for WC pdf invoices
 * Plugin URI: http://www.itthinx.com/plugins/groups-forums
 * Description: Adds a custom text on WC pdf invoices
 * Author: gtsiokos
 * Author URI: http://www.netpad.gr
 *
 * This code is provided subject to the license granted.
 * Unauthorized use and distribution is prohibited.
 * See COPYRIGHT.txt and LICENSE.txt
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This header and all notices must be kept intact.
 *
 * @author gtsiokos
 * @package wcpdf-custom-text
 * Version: 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wpo_wcpdf_after_order_details', 'wpo_wcpdf_custom_text', 10, 2 );
function wpo_wcpdf_custom_text ( $template_type, $order ) {
	global $wpdb, $affiliates_db;

	$referrals_table = $affiliates_db->get_tablename( 'referrals' );
	$output = '';
	$referrer_id = $wpdb->get_var( $wpdb->prepare(" SELECT affiliate_id FROM $referrals_table WHERE post_id = %d", intval( $order->get_id() ) )	);
	
	if ( $referrer_id !== null ) {
		if ( $user_id = affiliates_get_affiliate_user( $referrer_id ) ) {
			if ( $user = get_user_by( 'id', $user_id ) ) {
				$output .= '<div class="custom-text">';
				$output .= 'Your referring affiliate is: ';
				$output .= $user->user_login;
				$output .= '</div>';
				echo $output;
			}
		}
	}
}