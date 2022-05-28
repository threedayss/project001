<?php
    require_once("../Entity/Coupon-Entities.php");

    class ViewCouponC
    {
        protected $list;
        protected $entity;

        function __construct()
        {
            $this->entity = new Coupon();
            $this->list = array();
        }

        public function viewCoupon()
        {
            $this->list = $this->entity->displayAllCoupons();

            return $this->list;
        }
    }
?>