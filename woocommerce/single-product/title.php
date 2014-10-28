<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;

$productType = '';
	$terms = get_the_terms( $post->ID, 'product_cat' );

	if ( $terms && ! is_wp_error( $terms ) ) : 

	foreach ( $terms as $term ) {
		if ($term->slug=='cupcakes'){
			$productType = ' Cupcakes';

		}
		elseif($term->slug=='layercakes'){
			$productType = ' Layer Cake';

		}
	}
	endif;	
?>
<h1 itemprop="name" class="h1 single_product_info_title"><?php the_title(); ?><?php echo $productType; ?></h1>