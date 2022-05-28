<?php
    require_once("../Entity/orderEntity.php");

    class ViewHistoryC
    {
        protected $entity;
        protected $list;

        function __construct()
        {
            $this->entity = new Order();
            $this->list = array();
        }

        public function viewHistory()
        {
            $this->list = $this->entity->getHistoryOrder();

            return $this->list;
        }
    }
?>