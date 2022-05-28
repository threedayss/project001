<?php
    require_once("../Entity/orderEntity.php");

    class CreateOrderC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Order();
            $this->result = array();
        }

        public function validateDetails($order_id, $table_num, $staff_id)
        {
            if(trim($order_id) == "")
            {
                if(!is_numeric($table_num) || !is_numeric($staff_id))
                    $this->result = FALSE;
                else
                    $this->result = $this->entity->createOrder($table_num, $order_id, $staff_id);
            }
            else
            {
                if(!is_numeric($order_id) || !is_numeric($table_num) || !is_numeric($staff_id))
                    $this->result = FALSE;
                else
                    $this->result = $this->entity->createOrder($table_num, $order_id, $staff_id);
            }

            return $this->result;
        }
    }
?>