<?php
    require_once("../Entity/orderEntity.php");

    class SearchOrderC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Order();
            $this->result = array();
        }

        public function checkKeyword($order_id)
        {
            $this->result = $this->entity->getOrderInfo($order_id);

            return $this->result;
        }
    }
?>