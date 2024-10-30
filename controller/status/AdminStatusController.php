<?php
class AdminStatusController
{
    function __construct()
    {
        $this->init();
    }

    public function init()
    {
        add_filter(
            'bulk_actions-edit-shop_order',
            [$this, 'append_customized_order_status_bulk']
        );
    }

    public function append_customized_order_status_bulk($bulk_actions)
    {
        $bulk_actions['mark_ready-to-ship'] = '將狀態變更為準備出貨';
        $bulk_actions['mark_shipment'] = '將狀態變更為已出貨';
        return $bulk_actions;
    }
}