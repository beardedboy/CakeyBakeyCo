<?php
/**
 * Cart item data (when outputting non-flat)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 	2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<dl class="basket_item_variation">
	<?php
		foreach ( $item_data as $data ) :
			$key = sanitize_text_field( $data['key'] );
	?>
		<dt class="basket_item_variation_label"><?php echo wp_kses_post( $data['key'] ); ?>:</dt>
		<dd class="basket_item_variation_value"><?php echo wp_kses_post( wpautop( $data['value'] ) ); ?></dd>
	<?php endforeach; ?>
</dl>
