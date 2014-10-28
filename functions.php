<?php

/**************************************************************************************
***************************************************************************************

Theme WooCommerce Extensions

***************************************************************************************
***************************************************************************************/

function cbc_GetStoreData(){
	global $woocommerce;

	return array(
		"cart_url" => WC()->cart->get_cart_url(),
		"shop_page_url" => get_permalink( woocommerce_get_page_id( 'shop' ) ),
		"cart_contents_count" => WC()->cart->cart_contents_count,
		"cart_contents" => sprintf(_n('%d', '%d', $cart_contents_count, 'cakeybakeyco'), $cart_contents_count),
		"cart_items" => WC()->cart->get_cart(),
		"cart_total" => WC()->cart->get_cart_total(),
	);
}

function cbc_CartContent() { 

	$output = '';

  	if ( sizeof( WC()->cart->get_cart() ) > 0 ):

	  	foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

	  		$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
			$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(array(60,60)), $cart_item, $cart_item_key );

			$quantity = $cart_item['quantity'];
			$_desc = '';

			$blah = $_product->variation_data;
			$_type = $_product->product_type;
			$_variation = woocommerce_get_formatted_variation( $blah, true);

			if($_type == 'simple'){
				$_desc = $cart_item['data']->post->post_excerpt;
			}
			elseif($_type == "variation"){
				$_desc = $_variation;
			}


	  		$output .= '<li class = "mini_basket_list_item">';
			$output .= '<div class = "mini_basket_list_item_thumb">'.$thumbnail.'</div>';
			$output .= '<div class =  "mini_basket_list_item_detail">';
			$output .= '<a href="'.get_permalink( $product_id ).'" class = "mini_basket_list_item_detail_title">'.$product_name.'</a>';
			$output .= '<h2 class = "mini_basket_list_item_detail_desc">'.$_desc.'</h2>';
			$output .= '<div class = "mini_basket_list_item_quantity">
                            <span class ="mini_basket_list_item_detail_quantity_title">Quantity</span>
                            <span class ="mini_basket_list_item_detail_quantity_amount">'.$quantity.'</span>
                        </div>';
            $output .= '</div>';
	        $output .= '</li>';


	  	}
	else: $output = '<div class = "mini_basket_empty"><h2 class = "mini_basket_empty_title">Your basket\'s empty</h2><a class = "">Why not fill me up!</a></div>';

	endif;

	return $output;
}

/**************************************************************************************
***************************************************************************************

Main Navigation Walker Class

***************************************************************************************
***************************************************************************************/


class mainnav_walker extends Walker_Nav_Menu{
		/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */


	function start_el( &$output, $item, $depth, $args )
	{	
		/* The menu handle from the register_nav_menu statement in functions.php
		$theme_location = 'main-nav';

		$theme_locations = get_nav_menu_locations();

		$menu_obj = get_term( $theme_locations[$theme_location], 'nav_menu' );

		// Echo count of items in menu
		echo $menu_obj->count;*/

		if ($item->title == 'Basket'){

			$data = cbc_GetStoreData();
			$cartTotal = cbc_CartContent();

			$cart_url = $data["cart_url"];
			$shop_page_url = $data["shop_page_url"];
			$cart_contents_count = $data["cart_contents_count"];
			$cart_contents = $data["cart_contents"];
			$cart_total = $data["cart_total"];
			$cart_items = $data["cart_items"];

			if($cart_contents_count > 0 ){
				$counter = '<span class = "badge mini_basket_badge">'.$cart_contents_count.'</span>';
			}
			else{
				$counter = '';
			}
			$output .= '<li class = "nav_divider"></li><li class = "mini_basket_wrapper mini_basket_link_icon-desktop">';

			$attributes  = '';
	 
			! empty ( $item->attr_title )
				// Avoid redundant titles
				and $item->attr_title !== $item->title
				and $attributes .= ' title="' . esc_attr( $item->attr_title ) .'"';
	 
	 		$attributes .= ' href="' . $cart_url .'"';

			$attributes .= 'class= "mini_basket_link_title" ';
	 
			$attributes  = trim( $attributes );
			$title       = apply_filters( 'the_title', $item->title, $item->ID );

			$item_output = '<div class="mini_basket_link">'.$counter
                            ."$args->before<a $attributes>$args->link_before$title</a>"
							."$args->link_after$args->after"
							.'<div class = "mini_basket">
							<ul class = "mini_basket_list">'.$cartTotal.'</ul>';

			if($cart_contents_count > 0){
				$item_output .= '<div class = "mini_basket_subtotal">
								<span class = "mini_basket_subtotal_label">Sub-Total  </span>
								<span class = "mini_basket_subtotal_value">'.$cart_total.'</span>
							</div><!-- end mini_basket_subtotal -->
							<footer class = "mini_basket_footer">
							<a class = "btn_flat btn_flat-full" href="'.$cart_url.'">View basket</a>
                            </footer><!-- end mini_basket_footer -->
                            </div><!-- end mini_basket -->
                            </div><!-- end mini_basket_link -->';
            }

		}

		else{

			$dropdown = $args->walker->has_children;
			$styledropdown = $dropdown ? ' nav_main_list_item-dropdown' : '';
			$icondropdown = $dropdown ? '<span class = "icon-dropdown"></span>' : '';

			if ($depth > 0) {
				$output .= '<li class = "nav_main_list_item_sublist_item">';
			}
			else{
					$output .= '<li class = "nav_main_list_item '.$styledropdown.'">';
			}

			$attributes  = '';
	 
			! empty ( $item->attr_title )
				// Avoid redundant titles
				and $item->attr_title !== $item->title
				and $attributes .= ' title="' . esc_attr( $item->attr_title ) .'"';
	 
			! empty ( $item->url )
				and $attributes .= ' href="' . esc_attr( $item->url ) .'"';
	 
			$attributes  = trim( $attributes );
			$title       = apply_filters( 'the_title', $item->title, $item->ID );


			$item_output = "$args->before<a $attributes>$args->link_before$title</a>"
							. "$args->link_after$args->after". $icondropdown;

		};
	 
			// Since $output is called by reference we don't need to return anything.
			$output .= apply_filters(
				'walker_nav_menu_start_el'
				,   $item_output
				,   $item
				,   $depth
				,   $args
			);
	}
 
	/**
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	function start_lvl( &$output )
	{
		$output .= '<ul class="nav_main_list_item_sublist sublist-closed">';
	}
 
	/**
	 * @see Walker::end_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	function end_lvl( &$output )
	{
	    $output .= "</ul>";
	}
 
	/**
	 * @see Walker::end_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	function end_el( &$output )
	{
		$output .= '</li>';
	}

	function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

	                if ( !$element )
                        return;

	                $id_field = $this->db_fields['id'];
	                $id       = $element->$id_field;
	
	                //display this element
	                $this->has_children = ! empty( $children_elements[ $id ] );
	                if ( isset( $args[0] ) && is_array( $args[0] ) ) {
	                        $args[0]['has_children'] = $this->has_children; // Backwards compatibility.
	                }

	                $cb_args = array_merge( array(&$output, $element, $depth), $args);


	                call_user_func_array(array($this, 'start_el'), $cb_args);

	
	                // descend only when the depth is right and there are childrens for this element
	                if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {
	
	                        foreach( $children_elements[ $id ] as $child ){
									//print_r($children_elements[$id]);
	                                if ( !isset($newlevel) ) {
	                                        $newlevel = true;
	                                        //start the child delimiter
	                                        $cb_args = array_merge( array(&$output, $depth), $args);
	                                        call_user_func_array(array($this, 'start_lvl'), $cb_args);
	                                }
	                                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
	                        }
	                        unset( $children_elements[ $id ] );
	                }
	
	                if ( isset($newlevel) && $newlevel ){
	                        //end the child delimiter
	                        $cb_args = array_merge( array(&$output, $depth), $args);
	                        call_user_func_array(array($this, 'end_lvl'), $cb_args);
	                }
	
	                //end this element
	                $cb_args = array_merge( array(&$output, $element, $depth), $args);
	                call_user_func_array(array($this, 'end_el'), $cb_args);
	        }

}

/**************************************************************************************
***************************************************************************************

Footer Navigation Walker Class

***************************************************************************************
***************************************************************************************/

class footernav_walker extends Walker_Nav_Menu
{
	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
	public function start_el( &$output, $item, $depth, $args )
	{
		$output     .= '<li class = "nav_footer_list_item">';
		$attributes  = '';

		$attributes .= ' href="' . esc_attr( $item->url ) .'"';
 
		$attributes  = trim( $attributes );
		$title       = apply_filters( 'the_title', $item->title, $item->ID );
		$item_output = "<a $attributes>$args->link_before$title</a>"
						. "$args->link_after$args->after";
 
		// Since $output is called by reference we don't need to return anything.
		$output .= apply_filters(
			'walker_nav_menu_start_el'
			,   $item_output
			,   $item
			,   $depth
			,   $args
		);
	}
 
	/**
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	public function start_lvl( &$output )
	{
		$output .= '<ul class="nav_footer_list">';
	}
 
	/**
	 * @see Walker::end_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	public function end_lvl( &$output )
	{
		$output .= '</ul>';
	}
 
	/**
	 * @see Walker::end_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	function end_el( &$output )
	{
		$output .= '</li>';
	}
}



/****************************************************************************************

Function to set everything up for the theme

****************************************************************************************/

function cakeybakeyco_setup(){

	// Theme Cleanup

	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'index_rel_link');
	add_action('wp_head', 'cbc_add_social_head_meta_tags', 10);

	// REGISTER THEME NAVIGATIONS
	add_action( 'init', 'register_main_nav' );

	add_action( 'wp_enqueue_scripts', 'cbc_load_js' );	
	add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );
	
	//ADDS CUSTOM FONTS
	add_action('wp_print_styles', 'load_fonts');

	//ADDS WOOCOMMERCE SUPPORT
	add_action( 'after_setup_theme', 'woocommerce_support' );

	//CHANGES PAGE TITLE
	add_filter('wp_title', 'cbc_main_title', 10, 2);

	//SET ADMIN CHANGES
	add_filter('login_headerurl', 'cbc_wpc_url_login');
	add_action('login_head', 'cbc_login_css');
	add_filter('admin_footer_text', 'cbc_remove_footer_admin');

	// WOOCOMMERCE SETUP ACTIONS

	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

	add_action('woocommerce_before_main_content', 'cbc_wrapper_start', 10);
	add_action('woocommerce_after_main_content', 'cbc_wrapper_end', 10);

	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	remove_action('woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail', 10);
	add_action('woocommerce_before_shop_loop_item_title','cbc_product_loop_img', 10);

	remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_sale_flash', 10);

	//Moves the notices with the main section of the page
	remove_action('woocommerce_before_single_product', 'wc_print_notices', 10);
	add_action ('woocommerce_before_single_product_summary', 'wc_print_notices', 10);

	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

	add_action( 'woocommerce_single_product_summary', 'cbc_single_product_desc_wrapper_title_start', 1 );
	add_action( 'woocommerce_single_product_summary', 'cbc_single_product_subtitle', 8 );
	add_action( 'woocommerce_single_product_summary', 'cbc_single_product_desc_wrapper_end', 35 );
	add_action( 'woocommerce_single_product_summary', 'cbc_add_hr', 35 );
	add_action( 'woocommerce_single_product_summary', 'cbc_single_product_desc_wrapper_start', 35 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_product_description_tab', 40 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	add_action( 'woocommerce_single_product_summary', 'cbc_single_product_desc_wrapper_end', 40 );
	
	add_action( 'woocommerce_single_product_summary', 'cbc_add_hr', 40 );
	add_action( 'woocommerce_single_product_summary', 'cbc_single_product_allergy_advice', 50 );
	add_action( 'woocommerce_single_product_summary', 'cbc_add_hr', 50 );
	add_action( 'woocommerce_single_product_summary', 'cbc_single_product_ingredients', 50 );
	add_action( 'woocommerce_single_product_summary', 'cbc_add_hr', 55 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 55 );

	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

	//add_filter('woocommerce_short_description', 'cbc_filter_short_description', 10);


    add_action('cbc_header', 'mobileBasket');

    function cbc_basket(){
    	do_action('cbc_header');
    }



	function cbc_cart_totals_coupon_html( $coupon ) {
		if ( is_string( $coupon ) ) {
			$coupon = new WC_Coupon( $coupon );
		}

		$value  = array();

		if ( ! empty( WC()->cart->coupon_discount_amounts[ $coupon->code ] ) ) {
			$discount_html = '-' . wc_price( WC()->cart->coupon_discount_amounts[ $coupon->code ] );
		} else {
			$discount_html = '';
		}

		$value[] = apply_filters( 'woocommerce_coupon_discount_amount_html', $discount_html, $coupon );

		if ( $coupon->enable_free_shipping() ) {
			$value[] = __( 'Free delivery voucher', 'woocommerce' );
		}

		// get rid of empty array elements
		$value = array_filter( $value );

		$value = implode( ', ', $value ) . ' <a href="' . add_query_arg( 'remove_coupon', $coupon->code, defined( 'WOOCOMMERCE_CHECKOUT' ) ? WC()->cart->get_checkout_url() : WC()->cart->get_cart_url() ) . '" class="basket_controls_coupon_remove">' . __( 'Remove', 'woocommerce' ) . '</a>';

		echo apply_filters( 'woocommerce_cart_totals_coupon_html', $value, $coupon );
	}

	function cbc_cart_totals_coupon_label( $coupon ) {
		if ( is_string( $coupon ) )
		$coupon = new WC_Coupon( $coupon );

		echo apply_filters( 'woocommerce_cart_totals_coupon_label', esc_html( __( 'Voucher:', 'woocommerce' ) . ' ' . $coupon->code ), $coupon );
	}


	/**
 	* Custom Add To Cart Messages
 	* Add this to your theme functions.php file
 	**/
	add_filter( 'wc_add_to_cart_message', 'custom_add_to_cart_message' );

	function custom_add_to_cart_message() {
		global $woocommerce;
	 
		// Output success messages
		if (get_option('woocommerce_cart_redirect_after_add')=='yes') :
	 
			$return_to 	= get_permalink(woocommerce_get_page_id('shop'));
	 
			$message 	= sprintf('<a href="%s" class="link">%s</a> %s', $return_to, __('Continue Shopping &rarr;', 'woocommerce'), __('Product successfully added to your cart.', 'woocommerce') );
	 
		else :
	 
			$message 	= sprintf('<div class ="product_in_cart_message">Product successfully added to your basket <span class ="product_in_cart_message_divider">|</span> <a href="%s" class="link link_view_basket">%s</a></div>', get_permalink(woocommerce_get_page_id('cart')), __('View Basket', 'woocommerce') );
	 
		endif;
	 
			return $message;
	}

    // Changes the output of sale prices displayed on the single product page
    add_filter( 'woocommerce_get_price_html', 'cbc_display_sale_price', 100, 2 );

	// Display Fields set in product settings page in admin section
	add_action( 'woocommerce_product_options_general_product_data', 'cbc_add_custom_general_fields' );
 
	// Saves Fields set in product settings page in admin section
	add_action( 'woocommerce_process_product_meta', 'cbc_add_custom_general_fields_save' );

	//This function adds more custom fields to the product pages in the admin section of the website.
	function cbc_add_custom_general_fields(){
		global $woocommerce, $post;
  
  			echo '<div class="cbc_options_group">';
  			// Textarea
			woocommerce_wp_textarea_input( 
				array( 
					'id'          => '_ingredients',
					'class'		  => 'cbc_admin_textarea', 
					'label'       => __( 'Ingredients', 'woocommerce' ), 
					'placeholder' => '', 
					'description' => __( '', 'woocommerce' ) 
				)
			);
			woocommerce_wp_textarea_input( 
				array( 
					'id'          => '_allergy', 
					'class'		  => 'cbc_admin_textarea',
					'label'       => __( 'Allergy Advice', 'woocommerce' ), 
					'placeholder' => '', 
					'description' => __( '', 'woocommerce' ) 
				)
			);
			woocommerce_wp_textarea_input( 
				array( 
					'id'          => '_subtitle', 
					'class'		  => 'cbc_admin_textarea',
					'label'       => __( 'Subtitle', 'woocommerce' ), 
					'placeholder' => '', 
					'description' => __( '', 'woocommerce' ) 
				)
			);
			woocommerce_wp_textarea_input( 
				array( 
					'id'          => '_socialdesc', 
					'class'		  => 'cbc_admin_textarea',
					'label'       => __( 'SEO Description', 'woocommerce' ), 
					'placeholder' => '', 
					'description' => __( '', 'woocommerce' ) 
				)
			);
  			echo '</div>';	

	}

	function cbc_add_custom_general_fields_save( $post_id ){

	$woocommerce_textarea_1 = $_POST['_ingredients'];
	if( !empty( $woocommerce_textarea_1 ) )
		update_post_meta( $post_id, '_ingredients', esc_html( $woocommerce_textarea_1 ) );

	$woocommerce_textarea_2 = $_POST['_allergy'];
	if( !empty( $woocommerce_textarea_2 ) )
		update_post_meta( $post_id, '_allergy', esc_html( $woocommerce_textarea_2 ) );

	$woocommerce_textarea_3 = $_POST['_subtitle'];
	if( !empty( $woocommerce_textarea_3 ) )
		update_post_meta( $post_id, '_subtitle', esc_html( $woocommerce_textarea_3 ) );

	$woocommerce_textarea_4 = $_POST['_socialdesc'];
	if( !empty( $woocommerce_textarea_4 ) )
		update_post_meta( $post_id, '_socialdesc', esc_html( $woocommerce_textarea_4 ) );
	
	}

	
	function cbc_display_sale_price( $price, $product ){

		if( $product->has_child() && $product->is_on_sale() ) {
			$price = "";
			$price .= "From ";
			$price .= woocommerce_price($product->get_price());
			return $price;
		}
    	return str_replace( '<ins>', '', $price );
	}


	/*Function to add custom html tag around a products short description
	function cbc_filter_short_description( $desc ){
	    global $product;
	    $newDesc = '<div class = "single_product_info_desc_container-dropdown">';
	    $newDesc .= '<h2 class = "h4 single_product_info_desc_title" data-iconafter="g">Ingredients</h2>';
	    $newDesc .= '<div class="pg single_product_info_desc_content visuallyhidden">'.wp_strip_all_tags($desc).'</div>';
	    $newDesc .= '</div><!--end single_product_info_desc_container -->';
	    return $newDesc;
	}*/

	function cbc_add_social_head_meta_tags(){
		wc_get_template( 'single-product/social.php' );
	}

	//Function to add custom field entitled 'Subtitle' to single product page
	//function cbc_single_product_subtitle(){
	//	global $product;
	//	echo '<div class = "single_product_info_subtitle">'.get_post_meta($post_id, "subtitle", true).'</div>';
	//}

	function cbc_single_product_subtitle() {
        wc_get_template( 'single-product/subtitle.php' );
    }

    function cbc_single_product_allergy_advice() {
        wc_get_template( 'single-product/allergy.php' );
    }

    function cbc_single_product_ingredients() {
        wc_get_template( 'single-product/ingredients.php' );
    }

    function cbc_single_product_desc_wrapper_start(){
    	echo '<div class = "single_product_info_desc_container">';
    }

    function cbc_single_product_desc_wrapper_title_start(){
    	echo '<div class = "single_product_info_desc_container-title">';
    }

    function cbc_single_product_desc_wrapper_end(){
    	echo '</div><!-- single_product_info_desc_container -->';
    }

    function cbc_add_hr(){
    	echo '<hr class = "hr single_product_hr">';
    }


	//Function echos a revised thumbnail function only
	function cbc_product_loop_img() {
		echo cbc_product_loop_thumbnail();
	}

	//Function that replaces the default thumbnail image generation in the Woocommerce product page loop with one that gives the
	//images 100% responsive width.
	function cbc_product_loop_thumbnail( $size = 'shop_catalog', $placeholder_width = 1, $placeholder_height = 0  ) {
		global $post;
		if ( has_post_thumbnail() ){
			$blah = wp_get_attachment_image_src( get_post_thumbnail_id() ,$size );
     		return '<img width="100%" class = "product_list_item_img" src="' . $blah[0] . '">';
		}
	}

	function cbc_custom_single_product_image_html( $html, $post_id ) {
		global $product;
		$content;

		$content .= "<div class ='single_product_images_main_container'>";

		if($product->is_on_sale()){	
			$content .= "<span class ='onsale'>On Sale</span>";
    		$content .= get_the_post_thumbnail( $post_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array('class'	=> "woocommerce-main-image zoom single_product_images_main", width => "") );
		}
		elseif(!$product->is_in_stock()){
			$content .= "<span class ='onsale'>Out of stock</span>";
    		$content .= get_the_post_thumbnail( $post_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array('class'	=> "woocommerce-main-image zoom single_product_images_main", width => "") );
		}
		else{
    		$content .= get_the_post_thumbnail( $post_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array('class'	=> "woocommerce-main-image zoom single_product_images_main", width => "") );
		}
		$content .= "</div>";
		return $content;
	}

	add_filter('woocommerce_single_product_image_html', 'cbc_custom_single_product_image_html', 10, 2);

	add_filter( 'post_thumbnail_html', 'cbc_remove_width_attribute', 10 );
	add_filter( 'image_send_to_editor', 'cbc_remove_width_attribute', 10 );

	function cbc_remove_width_attribute( $html ) {
	   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
	   return $html;
	}


	//Function to add Site title before each individual page title.  Eg. > 'Cupcakes' becomes 'Cakey Bakey Co. - Cupcakes'
	function cbc_main_title($title, $sep){
		//Determines what type of product it is so the product category can be added onto the title tag.
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

		//Get site title 
		$sep = " | ";
		$bloginfo = get_bloginfo();
		$pagetitle = $title;

		if( is_home() || is_front_page() ){

			$title = $bloginfo;
			return $title;

		}

		$title = $pagetitle.$productType.$sep.$bloginfo;

		return $title;
	}

	//Function to load custom font into themeƒ
	function load_fonts() {
            wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,800,700');
            wp_enqueue_style( 'googleFonts');
        }

	//Register theme menus

	function register_main_nav(){
		register_nav_menus(
			array(
				'main-nav' => __( 'Main Navigation', 'cakeybakeyco' ),
				'footer-one' => __( 'Footer One' , 'cakeybakeyco'),
				'footer-two' => __( 'Footer Two' , 'cakeybakeyco'),
				'footer-three' => __( 'Footer Three' , 'cakeybakeyco' )
			)
		);
	}

	function mobileBasket(){
		$data = cbc_GetStoreData();
		$basket = '<div class = "mini_basket_link mini_basket_link-mobile">';

		$basket .= '<a href="'.$data['cart_url'].'" class = "icon-basket mini_basket_link_icon-mobile icon-basket-empty">';

		if($data['cart_contents_count'] > 0 ){
			$basket .= '<span class = "badge mini_basket_badge mini_basket_badge-mobile">'.$data['cart_contents_count'].'</span>';
		}
		else{
			$basket .= '';
		}

		$basket .= '</a></div>';

		echo $basket;

	}

	function mainNav(){
		return array(
		    'theme_location'  => 'main-nav',
		    'menu'            => 'Main Navigation',
		    'container'       => '',
		    'container_class' => '',
		    'container_id'    => '',
		    'menu_class'      => 'nav_main_list',
		    'menu_id'         => '',
		    'echo'            => true,
		    'fallback_cb'     => 'wp_page_menu',
		    'before'          => '',
		    'after'           => '',
		    'link_before'     => '',
		    'link_after'      => '',
		    'items_wrap'      => '<div class = "nav_main_container"> <ul class="%2$s"> <a href = "#" class = "nav_main_btn nav_main_btn-close"> <span class = "icon-close"></span> Close</a>%3$s</ul> </div>',
		    'depth'           => 0,
		    'walker'          => new mainnav_walker()
		);
	}

	function footerNav1(){
		return array(
		    'theme_location'  => 'footer-one',
		    'menu'            => 'Footer Links #1',
		    'container'       => '',
		    'container_class' => '',
		    'container_id'    => '',
		    'menu_class'      => 'nav_footer_list',
		    'menu_id'         => '',
		    'echo'            => true,
		    'fallback_cb'     => 'wp_page_menu',
		    'before'          => '',
		    'after'           => '',
		    'link_before'     => '',
		    'link_after'      => '',
		    'items_wrap'      => '<nav class = "nav nav_footer"><h1 class = "nav_footer_title">Ordering</h1> <ul class="%2$s">%3$s</ul> </nav>',
		    'depth'           => 0,
		    'walker'          => new footernav_walker()
		);
	}

	function footerNav2(){
		return array(
		    'theme_location'  => 'footer-two',
		    'menu'            => 'Footer Links #2',
		    'container'       => '',
		    'container_class' => '',
		    'container_id'    => '',
		    'menu_class'      => 'nav_footer_list',
		    'menu_id'         => '',
		    'echo'            => true,
		    'fallback_cb'     => 'wp_page_menu',
		    'before'          => '',
		    'after'           => '',
		    'link_before'     => '',
		    'link_after'      => '',
		    'items_wrap'      => '<nav class = "nav nav_footer"><h1 class = "nav_footer_title">Information</h1> <ul class="%2$s">%3$s</ul> </nav>',
		    'depth'           => 0,
		    'walker'          => new footernav_walker()
		);
	}

	function footerNav3(){
			return array(
			    'theme_location'  => 'footer-three',
			    'menu'            => 'Footer Links #3',
			    'container'       => '',
			    'container_class' => '',
			    'container_id'    => '',
			    'menu_class'      => 'nav_footer_list',
			    'menu_id'         => '',
			    'echo'            => true,
			    'fallback_cb'     => 'wp_page_menu',
			    'before'          => '',
			    'after'           => '',
			    'link_before'     => '',
			    'link_after'      => '',
			    'items_wrap'      => '<nav class = "nav nav_footer"><h1 class = "nav_footer_title">Social</h1> <ul class="%2$s">%3$s</ul> </nav>',
			    'depth'           => 0,
			    'walker'          => new footernav_walker()
			);
	}

	function woocommerce_support() {
	    add_theme_support( 'woocommerce' );
	}

 
	function child_manage_woocommerce_styles() {
	    //first check that woo exists to prevent fatal errors
	    if ( function_exists( 'is_woocommerce' ) ) {
	        //dequeue scripts and styles
	        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
	        	wp_dequeue_style( 'woocommerce-layout' );
				wp_dequeue_style( 'woocommerce-smallscreen' );
				wp_dequeue_style( 'woocommerce-general' );
				wp_dequeue_script( 'wc-add-to-cart' );
				wp_dequeue_script( 'wc-cart-fragments' );
				wp_dequeue_script( 'woocommerce' );
				wp_dequeue_script( 'jquery-blockui' );
				wp_dequeue_script( 'jquery-placeholder' );
	        }
	    }	 
	}


	// Function to override the default plus/minus quantity buttons on the variable single product page


	/*
		WOOCOMMERCE SETUP FUNCTIONS
	*/
	function cbc_wrapper_start() {
		if(is_shop() || is_product_tag() || is_product() ){
			echo '<section class="main_content main_content-large">';
		}
		else{
			echo '<section class="main_content">';
		}
	}

	function cbc_wrapper_end() {
	  echo '</section>';
	}

	/****************************************************************************************************************

	ADMIN SETTINGS

	****************************************************************************************************************/

	// Use your own external URL logo link
	function cbc_wpc_url_login(){
		return "http://cakeybakey.co/";
	}

	// Custom WordPress Login Logo
	function cbc_login_css() {
		wp_enqueue_style( 'login_css', get_template_directory_uri() . '/css/login.css' );
	}

	// Custom WordPress Footer
	function cbc_remove_footer_admin () {
		$year = date('Y');
		$footer = '&copy; ';
		$footer .= $year;
		$footer .= ' - Cakey Bakey Co.';
		echo $footer;
		//echo '&copy; $year - Cakey Bakey Co.';
	}


	// Register Script
	function cbc_load_js() {

		wp_deregister_script('jquery');

		wp_register_script( 'jquery', get_template_directory_uri().'/js/vendor/jquery.js', false, '1.11.1', true );
		wp_enqueue_script( 'jquery' );

		wp_register_script( 'modernizr', get_template_directory_uri().'/js/vendor/modernizr.js', false, '2.8.3', false );
		wp_enqueue_script( 'modernizr' );

		wp_register_script( 'jsmain', get_template_directory_uri().'/js/deploy/production.min.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'jsmain' );

	}

}

add_action( 'after_setup_theme', 'cakeybakeyco_setup' );

?>