<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;

$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
?>

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php echo $product->get_tags( ', ', '<p class="single_product_tags" data-icon="A">' . _n( '', '', $tag_count, 'woocommerce' ) . ' ', '.</p>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>