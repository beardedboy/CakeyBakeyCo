<?php
/**
 * Social Meta Tags
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

	$imageUrl = wp_get_attachment_url( get_post_thumbnail_id() ); //main image url

	$currentpost = get_post(); 
	$description = get_post_meta( $post->ID, '_socialdesc', true ); // Description
	$subtitle = get_post_meta( $post->ID, '_subtitle', true ); //subtitle of product

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



<link href="[profile_url]" rel="publisher" />  <!-- links to Google+ page -->

<!-- Open Graph data -->
<meta property="og:site_name" content="Cakey Bakey Co" />
<meta property="og:title" content=" <?php echo the_title(); echo $productType; ?> " />
<meta property="og:url" content=" <?php echo get_permalink(); ?>" />
<meta property="og:image" content=" <?php echo $imageUrl; ?> " />
<meta property="og:description" content=" <?php echo $description; ?> " />
<meta property="og:locale" content="en_GB" />
<meta property="og:brand" content="Cakey Bakey Co" />

<meta property="article:publisher" content="https://www.facebook.com/cakeybakeyco" />
<meta property="fb:app_id" content="fb_insights_id here" />

<?php if( is_product() ){ ?>

<meta property="og:type" content="product" />
<meta property="product:price:amount" content="10.00" />
<meta property="product:price:currency" content="GBP" />

<?php } ?>

<!-- Twitter Card data -->
<meta name="twitter:site" content="@CakeyBakeyCo">
<meta name="twitter:title" content="<?php echo the_title(); echo $productType; ?>">
<meta name="twitter:creator" content="@CakeyBakeyCo">
<meta name="twitter:domain" content="cakeybakey.co">
<meta name="twitter:image:src" content="<?php echo $imageUrl; ?>">
<meta name="twitter:description" content="<?php echo $description; ?>">

<?php if( is_product() ){ ?>

<meta name="twitter:card" content="product">
<meta name="twitter:label1" content="Sizes">
<meta name="twitter:data1" content="<?php echo $subtitle; ?>">
<meta name="twitter:label2" content="Price">
<meta name="twitter:data2" content="£10">



<?php } ?>




