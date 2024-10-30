<?php

class OrderListController
{
    function __construct()
    {
        $this->init();
    }

    public function init()
    {
        add_action('admin_enqueue_scripts', [$this, 'initial_admin_style']);
        add_filter('manage_edit-shop_order_columns', [$this, 'order_logistics_column_header'], 20);
        add_action('manage_shop_order_posts_custom_column', [$this, 'order_logistics_column_content']);
    }

    public function initial_admin_style()
    {
        wp_enqueue_style('boxful_status', BOXFUL_FULFILLMENT_HK_PLUGIN_URI . 'style/status.css');
    }


    function order_logistics_column_header($columns)
    {
        $new_columns = array();
        foreach ($columns as $column_name => $column_info) {
            $new_columns[$column_name] = $column_info;
            if ('order_status' === $column_name) {
                $new_columns['order_logistics'] = '物流';
            }
        }
        return $new_columns;
    }

    function order_logistics_column_content($column)
    {
        global $post;
        if ('order_logistics' === $column) {
            $logistics = get_post_meta($post->ID, 'boxful_logistics')[0] ?? '';
            $tracking_number = get_post_meta($post->ID, 'boxful_tracking_number')[0] ?? '';
            $tracking_url = get_post_meta($post->ID, 'boxful_tracking_url')[0] ?? 'https://www.boxful.com/fulfillment';
            echo "<a href=" . esc_url($tracking_url) . " target='_blank'><mark>" . esc_html($logistics . $tracking_number) . "</mark></a>";
        }
    }
}

new OrderListController();