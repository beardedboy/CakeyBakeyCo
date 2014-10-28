<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;
$internal_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;


// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

//Increase internal loop
$internal_loop++;

// Extra post classes
$classes = array();

if($woocommerce_loop['loop'] == 1 || $woocommerce_loop['loop'] == 4 || $woocommerce_loop['loop'] == 7 ){ ?>
	<!--<div class="row product_row">-->
<?php }

$classes[] = 'product_list_item';

?>
<li <?php post_class( $classes ); ?>>
	<a class ="product_link" href="<?php the_permalink(); ?>">
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>


			<?php
				/**
			 	* woocommerce_before_shop_loop_item_title hook
			 	*
			 	* @hooked woocommerce_show_product_loop_sale_flash - 10
			 	* @hooked woocommerce_template_loop_product_thumbnail - 10
			 	*/
				do_action( 'woocommerce_before_shop_loop_item_title' );
			?>

		<span class = "product_list_item_content">
			<span class = "product_list_item_content_desc">
				<h3 class = "h3 product_list_item_content_desc_title"><?php the_title(); ?></h3>
				<?php
					/**
					 * woocommerce_after_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_template_loop_rating - 5
					 * @hooked woocommerce_template_loop_price - 10
					 */
					//echo apply_filters( 'woocommerce_short_description', $post->post_excerpt );
					do_action( 'woocommerce_after_shop_loop_item_title' );
				?>
			</span>
			<?php if($product->is_in_stock()){ ?>
			<span class="btn_flat product_list_item_content_btn">BUY</span>
			<?php } else{ ?>
			<span class="product_outofstock">Out of stock</span>
			<?php } ?>
		</span><!-- end product_list_item_content -->
	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</a>
</li>

<?php
if($woocommerce_loop['loop'] == 3 || $woocommerce_loop['loop'] == 6 || $woocommerce_loop['loop'] == 9 ){ ?>
	<!--</div><!-- end row -->
	<?php
 } ?>