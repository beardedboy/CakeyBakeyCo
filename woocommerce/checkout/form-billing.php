<?php
/**
 * Checkout billing information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="checkout_input_item">
	<?php if ( WC()->cart->ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3 class = "h3"><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3 class = "h3 checkout_input_item_header"><?php _e( 'Billing Address', 'woocommerce' ); ?></h3>

	<?php endif; ?>

	<div class = "checkout_input_item_content">
		<div class = "checkout_input-address">

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>
	
	<?php foreach ( $checkout->checkout_fields['billing'] as $key => $field ) : ?>

		<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

	<?php endforeach; ?>
	


	<?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?>

	<?php if ( ! is_user_logged_in() && $checkout->enable_signup ) : ?>

		<?php if ( $checkout->enable_guest_checkout ) : ?>

			<p class="form-row form-row-wide create-account">
				<input class="input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true) ?> type="checkbox" name="createaccount" value="1" /> <label for="createaccount" class="checkbox"><?php _e( 'Create an account?', 'woocommerce' ); ?></label>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( ! empty( $checkout->checkout_fields['account'] ) ) : ?>

			<div class="create-account">

				<p><?php _e( 'Create an account by entering the information below. If you are a returning customer please login at the top of the page.', 'woocommerce' ); ?></p>

				<?php foreach ( $checkout->checkout_fields['account'] as $key => $field ) : ?>

					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

				<?php endforeach; ?>

			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

	<?php endif; ?>
	</div>
	
	<div class = "checkout_input-deliverychoice">
		<h4 class = "h4 checkout_input_item_subheader">Where would you like your order delivered?</h4>
		
		<div class = "form_group">
			<div class = "form_group form_group-radio">
				<label class="form_label form_label-radio"><input type = "radio" class = "form_input form_input-radio" name = "delivery" id = "cbc_billing_address" value = "billing">Same as billing address</label>
			</div>
			<div class = "form_group form_group-radio">
				<label class="form_label form_label-radio"><input type = "radio" class = "form_input form_input-radio" name = "delivery" id = "cbc_shipping_address" value = "shipping">Enter a shipping address</label>
			</div>
		</div>

		<div class = "btn_flat btn-sm">Next</div>
	</div>
	
	</div>

</div>