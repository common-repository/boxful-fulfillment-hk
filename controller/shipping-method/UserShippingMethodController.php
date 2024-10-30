<?php

class UserShippingMethodController
{
    function __construct()
    {
    }
}


add_action('woocommerce_checkout_update_order_meta', 'custom_meta_to_order', 20, 1);
function custom_meta_to_order($order_id)
{
    $order = wc_get_order($order_id);
    $shipping_method = $order->get_shipping_method();
}

add_action('woocommerce_review_order_after_shipping', 'shipping_choose_cvs');
function shipping_choose_cvs()
{
    $chosen_shipping = wc_get_chosen_shipping_method_ids();
    $host = get_site_url();
    $data = [];
}

function unsetCVSData()
{
    setcookie("boxful_cvs_store_id", "", time() - 3600);
    setcookie("boxful_cvs_store_name", "", time() - 3600);
    setcookie("boxful_cvs_store_address", "", time() - 3600);
    setcookie("boxful_cvs_open", "", time() - 3600);
}

add_filter('woocommerce_package_rates', 'packageRate', 10, 2);

function packageRate($rates)
{
    global $woocommerce;
    $weight = $woocommerce->cart->get_cart_contents_weight();
    $bf_cross_border_cost = 0;
    $shipping_method_list = $woocommerce->shipping->get_shipping_methods();
    
    return $rates;
}

new UserShippingMethodController();