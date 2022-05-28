<?php
	require_once("../Entity/Coupon-Entities.php");
    class DeleteCouponC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Coupon();
            $this->result = array();
        }

        public function deleteItem($coupon_id)
        {
            $this->result = $this->entity->deleteItem($coupon_id);

            return $this->result;
        }
    }
?>