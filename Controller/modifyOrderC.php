<?php
    require_once("../Entity/orderEntity.php");

    class ModifyOrderC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Order();
            $this->result = array();
        }

        public function minusQuantityOrder($order_id, $food_id)
        {
            $this->result = $this->entity->minusQuantityOrder($order_id, $food_id);

            return $this->result;
        }

        public function addQuantityOrder($order_id, $food_id)
        {
            $this->result = $this->entity->addQuantityOrder($order_id, $food_id);

            return $this->result;
        }

        public function removeItemOrder($order_id, $food_id)
        {
            $this->result = $this->entity->removeItemOrder($order_id, $food_id);
            
            return $this->result;
        }
    }
?>