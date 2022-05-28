<?php
    require_once("../Entity/orderEntity.php");

    class UpdateProgressC
    {
        protected $entity;
        protected $message;

        function __construct()
        {
            $this->entity = new Order();
            $this->message = array();
        }

        public function updateProgress($order_id, $food_id)
        {
            $this->message = $this->entity->updateProgress($order_id, $food_id);

            return $this->message;
        }
    }
?>