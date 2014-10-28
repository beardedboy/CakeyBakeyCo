<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) ) );
?>

<?php if ( $heading ): ?>
  <h2 class = "h4 single_product_info_desc_title" ><?php echo $heading; ?></h2>
<?php endif; 
 $content = get_the_content();
?>

<div class = "pg single_product_info_desc_content" itemprop = "description"><?php echo $content; ?></div>
