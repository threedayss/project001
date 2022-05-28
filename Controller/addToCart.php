<?php
    require_once("../Entity/orderEntity.php");

    class AddToCartC
    {
        protected $entity;
        protected $list;
        protected $result;

        function __construct()
        {
            $this->entity = new Order();
            $this->list = array();
            $this->result = array();
        }

        public function getMenuInfo($food_id)
        {
            $this->list = $this->entity->getMenuInfo($food_id);

            return $this->list;
        }

        public function addToCart($order_id, $table_num, $food_id, $quantity)
        {
            $this->result = $this->entity->addToCart($order_id, $table_num, $food_id, $quantity);

            return $this->result;
        }

        public function getCartList($order_id)
        {
            $this->list = $this->entity->getCartList($order_id);

            return $this->list;
        }

        public function minusQuantityCart($order_id, $food_id)
        {
            $this->result = $this->entity->minusQuantityCart($order_id, $food_id);

            return $this->result;
        }

        public function addQuantityCart($order_id, $food_id)
        {
            $this->result = $this->entity->addQuantityCart($order_id, $food_id);

            return $this->result;
        }

        public function removeItemCart($order_id, $food_id)
        {
            $this->result = $this->entity->removeItem($order_id, $food_id);

            return $this->result;
        }

        public function clearCart($order_id)
        {
            $this->result = $this->entity->clearCart($order_id);

            return $this->result;
        }
    }
?>