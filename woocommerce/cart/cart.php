<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="basket" cellspacing="0">
	<thead class = "basket_title"> 
		<tr>
			<th class="basket_title_label basket_title_remove">&nbsp;</th>
			<th class="basket_title_label basket_title_price"><?php _e( 'Price', 'woocommerce' ); ?></th>
			<th class="basket_title_label basket_title_quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="basket_title_label basket_title_subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'basket_item', $cart_item, $cart_item_key ) ); ?>">
					<td class="basket_item_remove">
						<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s" data-icon="m"></a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
						?>
					</td>
					<td class = "basket_item_details">
						<div class="basket_item_thumbnail">
							<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

								if ( ! $_product->is_visible() )
									echo $thumbnail;
								else
									printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail );
							?>
						</div>

						<div class="basket_item_name">
							<?php
								if ( ! $_product->is_visible() )
									echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
								else
									echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class = "h3 basket_item_title">%s</a>', $_product->get_permalink(), $_product->get_title() ), $cart_item, $cart_item_key );

								// Meta data
								echo WC()->cart->get_item_data( $cart_item );

	               				// Backorder notification
	               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
	               					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
							?>
							
								<?php
									echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove basket_item_remove-mobile" title="%s" data-icon="m">Remove</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
								?>
							
						</div>
						<div class="basket_item_price" data-cakeybakeyco-label="Price">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							?>
						</div>
					</td>

					<td class = "basket_item_quantity_container">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0',
									'page'		  => 'basket'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
						?>
					</td>

					<td class="basket_item_subtotal" data-cakeybakeyco-label="Subtotal ">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr class = "basket_controls">
			<td colspan="6" class="actions">
			<div class = "basket_controls_update">	
				<input type="submit" class="btn_flat basket_controls_update_button" name="update_cart" value="<?php _e( 'Update Quantity', 'woocommerce' ); ?>" />
			</div>


				<?php if ( WC()->cart->coupons_enabled() ) { ?>
					<div class="coupon basket_controls_coupon">

						<label for="coupon_code" class="basket_controls_coupon_label"><?php _e( 'Have a voucher?', 'woocommerce' ); ?></label> 
						<input type="text" name="coupon_code" class="input-text basket_controls_coupon_input" id="coupon_code" value="" placeholder="<?php _e( 'Enter your voucher code here', 'woocommerce' ); ?>" /> 
						<input type="submit" class="btn_flat basket_controls_coupon_apply" name="apply_coupon" value="<?php _e( 'Apply Voucher', 'woocommerce' ); ?>" />

						<?php do_action('woocommerce_cart_coupon'); ?>

					</div>
				<?php } ?>



					<?php do_action( 'woocommerce_cart_collaterals' ); ?>

	<?php woocommerce_cart_totals(); ?>

	<!--<?php woocommerce_shipping_calculator(); ?> -->

				<input type="submit" class="wc-forward btn_flat basket_controls_checkout" name="proceed" value="<?php _e( 'Proceed to Checkout', 'woocommerce' ); ?>" />

				<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<?php do_action( 'woocommerce_after_cart' ); ?>
