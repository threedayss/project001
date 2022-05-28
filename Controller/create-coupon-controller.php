<?php

require '../Entity/Coupon-Entities.php';

class CreateCpnController extends Coupon {
    public function __construct() {
        parent::__construct();
    }

    //ANY EXTRA VALIDATION, JUST ADD
    public function validateCouponDetails($coupon_code, $coupon_value, $coupon_stock, $coupon_isdate, $coupon_exdate, $coupon_desc) {
        $boo;

        if(empty($coupon_code) || empty($coupon_value) || empty($coupon_stock) || empty($coupon_isdate) || empty($coupon_exdate) || empty($coupon_desc)){
            $boo = "emptyInput";
        }

        else {
            $ent = new Coupon();
            $boo = $ent->verifyCoupon($coupon_code);
        }
        
        return $boo;
    }

    public function createCoupon($coupon_code, $coupon_value, $coupon_stock, $coupon_isdate, $coupon_exdate, $coupon_desc) {
        parent::createCoupon($coupon_code, $coupon_value, $coupon_stock, $coupon_isdate, $coupon_exdate, $coupon_desc);
    }
   
}