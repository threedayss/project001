<?php
    require_once("../Entity/Coupon-Entities.php");

    class SearchCouponC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Coupon();
            $this->result = array();
        }

        function checkKeyword($keyword)
        {
            $this->result = $this->entity->getCouponInfo($keyword);

            return $this->result;
        }
    }
?>