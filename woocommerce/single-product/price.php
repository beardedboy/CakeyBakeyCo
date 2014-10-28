<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

//print_r($product->is_in_stock());
//print_r($product->is_on_sale());

?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">

	<p class="single_product_info_price"><?php echo $product->get_price_html(); ?></p>
	<meta itemprop="price" content="<?php echo wp_strip_all_tags($product->get_price_html()); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
	
</div>



