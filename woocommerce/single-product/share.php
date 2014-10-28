<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

?>

<?php do_action( 'woocommerce_share' ); 

$content = '';
$content .= '<div class = "single_product_info_desc_container">';
$content .= '<h2 class = "h4 single_product_info_desc_title">Share</h2>';
//$content .= '<a class="twitter-share-button" href="https://twitter.com/share">Tweet</a> ';
//$content .= '<a href="//gb.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark" ><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a>';
$content .= '<ul class = "product_social_list">';
$content .= '<li class = "product_social_list_item"><a class = "product_social_list_item_link icon-fb" target="_blank" title="Facebook share" href="http://www.facebook.com/sharer.php?u=<?php  echo get_permalink($post->ID); ?>"></a></li>';
$content .= '<li class = "product_social_list_item"><a class = "product_social_list_item_link icon-pin" target="_blank" title="Pinterest share" href="http://www.facebook.com/sharer.php?u=<?php  echo get_permalink($post->ID); ?>"></a></li>';
$content .= '<li class = "product_social_list_item"><a class = "product_social_list_item_link icon-twt" target="_blank" title="Twitter share" href="http://www.facebook.com/sharer.php?u=<?php  echo get_permalink($post->ID); ?>"></a></li>';
$content .= '</ul>';
$content .= '</div><!-- end single_product_info_desc_container -->';

echo $content;

?>