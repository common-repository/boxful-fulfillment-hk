<?php
/*
 * Plugin Name: Boxful Fulfillment HK
 * Plugin URI: https://www.boxful.com/fulfillment
 * Version: 1.0.0
 * Description: Boxful Fulfillment HK
 * Author: BoxfulFulfillmentHK
 * License: GPL
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 */

define('BOXFUL_FULFILLMENT_HK_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('BOXFUL_FULFILLMENT_HK_PLUGIN_URI', plugin_dir_url(__FILE__));

class BoxfulFulfillment
{
    private $adminController;

    function __construct()
    {
        if (is_admin()) {
            $this->enableAdminView();
        } else {


        }
    }

    private function enableAdminView()
    {
        add_action('admin_menu', array($this, 'initialMenu'), 100);
        $this->adminController = new BoxfulFulfillmentAdminController();
    }

    public function initialMenu()
    {
        $subTitle = $title = "Boxful Fulfillment HK";
        add_submenu_page(
            'woocommerce',
            $subTitle,
            $subTitle,
            'manage_options',
            'sub_boxful_fulfillment',
            array($this->adminController, 'render')
        );
    }
}

require_once(BOXFUL_FULFILLMENT_HK_PLUGIN_DIR . "controller/" . "BoxfulFulfillmentAdminController.php");

require_once(BOXFUL_FULFILLMENT_HK_PLUGIN_DIR . "controller/status/" . "StatusController.php");

require_once(BOXFUL_FULFILLMENT_HK_PLUGIN_DIR . "controller/order-list/" . "OrderListController.php");

require_once(BOXFUL_FULFILLMENT_HK_PLUGIN_DIR . "controller/shipping-method/" . "ShippingMethodController.php");

new BoxfulFulfillment();