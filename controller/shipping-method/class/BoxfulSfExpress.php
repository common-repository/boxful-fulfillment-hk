<?php



add_action('woocommerce_shipping_init', 'bf_sf_express_shipping_method');

function bf_sf_express_shipping_method()
{
    class BOXFUL_SF_Express_Shipping_Method extends WC_Shipping_Method
    {
        public function __construct($instance_id = 0)
        {
            $this->instance_id = absint($instance_id);
            $this->id = 'bf_sf_express';
            $this->method_title = '順豐快遞';
            $this->method_description = '每一筆固定費用';
            $this->supports = array(
                'shipping-zones',
                'instance-settings',
                'instance-settings-modal',
            );
            $this->title = '順豐快遞';
            $this->enabled = 'yes';
            $this->init();
        }

        function init()
        {
            $this->init_form_fields();
            $this->init_settings();
            add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
        }

        function init_form_fields()
        {
            $this->instance_form_fields = [
                'title' => [
                    'title'       => '物流顯示名稱',
                    'type'        => 'text',
                    'description' => null,
                    'default'     => '順豐快遞'
                ],
                'cost'  => [
                    'title'       => '每筆費用',
                    'type'        => 'number',
                    'description' => null,
                    'default'     => 0
                ]
            ];
        }

        public function calculate_shipping($package = array())
        {
            $intance_settings = $this->instance_settings;
            $this->add_rate(array(
                    'id'      => $this->id,
                    'label'   => $intance_settings['title'],
                    'cost'    => $intance_settings['cost'],
                    'package' => $package,
                    'taxes'   => false,
                )
            );
        }
    }
}

