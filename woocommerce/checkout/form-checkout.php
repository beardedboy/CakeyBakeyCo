<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wc_print_notices();

//do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout form" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div id="customer_details" class = "row">

			<div class="col-7-12 checkout_input">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				<?php do_action('cbc_delivery_details'); ?>
				<div class = "checkout_input_item">
					<h4 id="order_review_heading" class = "h4 checkout_input_item_header"><?php _e( 'Your order summary', 'woocommerce' ); ?></h3>
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>
			</div>

			<div class="col-5-12 checkout_summary">
				<h3 class = "h3 checkout_summary_item_header">Your Order Progress</h3>
				<div class = "checkout_summary_item">
					<h4 class = "h4 checkout_summary_item_header">Billing Address</h3>
					<div class = "checkout_summary_item_content">
						<address>
						Mark Rudman<br>
						First Floor Flat<br>
						1 Ralph Road<br>
						Bristol<br>
						BS7 9QR
						</address>
					</div>
				</div>
				<div class = "checkout_summary_item">
					<h4 class = "h4 checkout_summary_item_header">Delivery Address</h3>
					<div class = "checkout_summary_item_content">
												<address>
						Mark Rudman<br>
						First Floor Flat<br>
						1 Ralph Road<br>
						Bristol<br>
						BS7 9QR
						</address>
					</div>
				</div>
				<div class = "checkout_summary_item">
					<h4 class = "h4 checkout_summary_item_header">Order Notes</h3>
					<div class = "checkout_summary_item_content">Pending</div>
				</div>
			</div>

		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>


	<?php endif; ?>


</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>