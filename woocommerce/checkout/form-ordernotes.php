<?php global $checkout; ?>
<div class="checkout_input_item">

<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) ) : ?>

	<?php if ( ! WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only() ) : ?>

		<h3><?php _e( 'Additional Information', 'woocommerce' ); ?></h3>

	<?php endif; ?>

	<?php foreach ( $checkout->checkout_fields['order'] as $key => $field ) : ?>

		<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

	<?php endforeach; ?>

<?php endif; ?>

<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>

</div> 