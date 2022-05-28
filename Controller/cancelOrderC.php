<?php
    require_once("../Entity/orderEntity.php");

    class CancelOrderC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Order();
            $this->result = array();
        }

        public function cancelOrder($order_id, $table_num)
        {
            $this->result = $this->entity->cancelOrder($order_id, $table_num);

            return $this->result;
        }
    }
?>