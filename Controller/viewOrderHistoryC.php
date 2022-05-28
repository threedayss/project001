<?php
    require("../Entity/transactionEntity.php");

    class ViewOrderHistoryC
    {
        protected $entity;
        protected $bill;

        function __construct()
        {
            $this->entity = new Transaction();
            $this->bill = array();
        }

        public function getSubmittedOrder($order_id, $table_num)
        {
            $this->bill = $this->entity->getBill($order_id, $table_num);

            return $this->bill;
        }
    }
?>