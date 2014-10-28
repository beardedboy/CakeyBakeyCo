<?php
/**
 * Subtitle
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $post, $product;

echo "<div class = 'single_product_info_subtitle'>".get_post_meta( $post->ID, '_subtitle', true )."</div><!-- end .single_product_info_subtitle -->";

?>
