<?php
    require("../Entity/Coupon-Entities.php");

    class modifyCouponC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Coupon();
            $this->result = "";
        }

        public function validateDetails($coupon_id, $coupon_value, $coupon_stock, $coupon_isdate, $coupon_exdate, $coupon_desc)
        {
            if(isset($coupon_id))
            {
                $this->result = $this->entity->modifyCoupon($coupon_id, $coupon_value, $coupon_stock, $coupon_isdate, $coupon_exdate, $coupon_desc);

                return $this->result;
            }
            else
                return false;     
        }
        
    }
?>