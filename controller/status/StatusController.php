<?php
class StatusController
{
    function __construct()
    {
        $this->init();
        if (is_admin()) {
            new AdminStatusController();
        } else {
            new UserStatusController();
        }
    }

    public function init()
    {
        add_filter(
            'woocommerce_register_shop_order_post_statuses',
            [$this, 'append_customized_order_post_statuses']
        );
        add_filter(
            'wc_order_statuses',
            [$this, 'append_customized_order_status']
        );
    }

    public function append_customized_order_post_statuses($order_statuses)
    {
        $order_statuses['wc-ready-to-ship'] = array(
            'label'                     => '準備出貨',
            'public'                    => false,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('準備出貨 <span class="count">(%s)</span>',
                '準備出貨 <span class="count">(%s)</span>'),
        );

        $order_statuses['wc-shipment'] = array(
            'label'                     => '已出貨',
            'public'                    => false,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('已出貨 <span class="count">(%s)</span>',
                '已出貨 <span class="count">(%s)</span>'),
        );

        return $order_statuses;
    }

    public function append_customized_order_status($order_statuses)
    {
        $order_statuses['wc-ready-to-ship'] = '準備出貨';
        $order_statuses['wc-shipment'] = "已出貨";
        return $order_statuses;
    }
}

require_once(BOXFUL_FULFILLMENT_HK_PLUGIN_DIR . "controller/status/" . "AdminStatusController.php");
require_once(BOXFUL_FULFILLMENT_HK_PLUGIN_DIR . "controller/status/" . "UserStatusController.php");
new StatusController();