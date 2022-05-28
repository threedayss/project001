<?php
    require_once("../Entity/orderEntity.php");

    class ViewOrderC
    {
        protected $entity;
        protected $order;

        function __construct()
        {
            $this->entity = new Order();
            $this->order = array();
        }

        public function viewOrders()
        {
            $this->order = $this->entity->getOrdersInfo();

            return $this->order;
        }
    }
?>