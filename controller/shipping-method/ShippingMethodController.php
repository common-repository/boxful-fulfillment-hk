<?php

class ShippingMethodController
{
    function __construct()
    {
        $this->init();
        if (is_admin()) {
            new AdminShippingMethodController();
        } else {
            new UserShippingMethodController();
        }
    }

    public function addMethod()
    {
        require_once(BOXFUL_FULFILLMENT_HK_PLUGIN_DIR . "controller/shipping-method/class/" . "BoxfulLogistic.php");
        require_once(BOXFUL_FULFILLMENT_HK_PLUGIN_DIR . "controller/shipping-method/class/" . "BoxfulSfExpress.php");
        require_once(BOXFUL_FULFILLMENT_HK_PLUGIN_DIR . "controller/shipping-method/class/" . "BoxfulPickupp.php");
    }

    public function init()
    {
        $this->addMethod();
        add_filter('woocommerce_shipping_methods', [$this, 'addBFShippingMethod']);
    }

    function addBFShippingMethod($methods)
    {
        $methods['bf_logistic'] = 'BOXFUL_Logistic_Shipping_Method';
        $methods['bf_sf_express'] = 'BOXFUL_SF_Express_Shipping_Method';
        $methods['bf_pickupp'] = 'BOXFUL_Pickupp_Shipping_Method';
        return $methods;
    }
}

require_once(BOXFUL_FULFILLMENT_HK_PLUGIN_DIR . "controller/shipping-method/" . "AdminShippingMethodController.php");
require_once(BOXFUL_FULFILLMENT_HK_PLUGIN_DIR . "controller/shipping-method/" . "UserShippingMethodController.php");

new ShippingMethodController();