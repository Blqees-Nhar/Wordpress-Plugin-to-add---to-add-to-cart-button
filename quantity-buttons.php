<?php
/*
Plugin Name: Quantity Buttons
Description: Adds + and - buttons to quantity inputs on the product page and wherever it appears.
Version: 1.2
Author: Your Name
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Hook to add custom scripts
add_action( 'wp_enqueue_scripts', 'quantity_buttons_scripts' );

function quantity_buttons_scripts() {
    wp_enqueue_script( 'quantity-buttons', plugins_url( '/js/quantity-buttons.js', __FILE__ ), array( 'jquery' ), '1.0', true );
    wp_enqueue_style( 'quantity-buttons-css', plugins_url( '/css/quantity-buttons.css', __FILE__ ) );
}

// Add + and - buttons to quantity input on product pages and loop
add_filter( 'woocommerce_quantity_input_args', 'quantity_buttons_add_custom_quantity_fields', 10, 2 );
add_filter( 'woocommerce_loop_add_to_cart_link', 'quantity_buttons_add_loop_quantity_fields', 10, 2 );

function quantity_buttons_add_custom_quantity_fields( $args, $product ) {
    if (is_product() || is_shop() || is_product_category() || is_product_tag()) {
        $args['quantity'] = '<button type="button" class="minus">-</button>' . $args['input_value'] . '<button type="button" class="plus">+</button>';
    }
    return $args;
}

function quantity_buttons_add_loop_quantity_fields( $link, $product ) {
    if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() ) {
        $quantity_input = woocommerce_quantity_input( array(), $product, false );
        $link = '<div class="quantity">' . $quantity_input . '<a href="' . esc_url( $product->add_to_cart_url() ) . '" data-quantity="1" class="button add_to_cart_button ajax_add_to_cart" data-product_id="' . esc_attr( $product->get_id() ) . '" data-product_sku="' . esc_attr( $product->get_sku() ) . '" aria-label="' . esc_attr( $product->add_to_cart_description() ) . '" rel="nofollow">' . esc_html( $product->add_to_cart_text() ) . '</a></div>';
    }
    return $link;
}
?>
