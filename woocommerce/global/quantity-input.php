<?php
/**
 * Product quantity inputs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php if( esc_attr( $page ) == 'basket'){?>
<div class="product_quantity product_quantity-basket" data-cakeybakeyco-label="Quantity">
	<label for = "<?php echo esc_attr( $input_name ); ?>" class = "product_quantity_label basket_item_quantity_label">Quantity</label>
	<input type="number" step="<?php echo esc_attr( $step ); ?>" <?php if ( is_numeric( $min_value ) ) : ?>min="<?php echo esc_attr( $min_value ); ?>"<?php endif; ?> <?php if ( is_numeric( $max_value ) ) : ?>max="<?php echo esc_attr( $max_value ); ?>"<?php endif; ?> name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php _ex( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="input-text qty text form_input-number product_quantity_input basket_item_quantity_input" size="4" />
	<input type="button" value="+" class="plus product_quantity_button basket_item_quantity_button" />
	<input type="button" value="-" class="minus product_quantity_button basket_item_quantity_button" />
</div>
<?php } else{ ?>
<div class="product_quantity">
	<label for = "<?php echo esc_attr( $input_name ); ?>" class = "product_quantity_label">Quantity</label>
	<input type="number" step="<?php echo esc_attr( $step ); ?>" <?php if ( is_numeric( $min_value ) ) : ?>min="<?php echo esc_attr( $min_value ); ?>"<?php endif; ?> <?php if ( is_numeric( $max_value ) ) : ?>max="<?php echo esc_attr( $max_value ); ?>"<?php endif; ?> name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php _ex( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="input-text qty text form_input-number product_quantity_input" size="4" />
	<input type="button" value="+" class="plus product_quantity_button" />
	<input type="button" value="-" class="minus product_quantity_button" />
</div>
<?php } ?>