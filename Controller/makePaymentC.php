<?php
    require_once("../Entity/transactionEntity.php");
    require_once("../Entity/orderEntity.php");

    class MakePaymentC
    {
        protected $entityT;
        protected $entityO;
        protected $message;

        function __construct()
        {
            $this->entityT = new Transaction();
            $this->entityO = new Order();
            $this->message = array();
        }

        public function validatePayment($email, $cardNo, $expiry, $order_id, $table_num, $coupon_id)
        {
            date_default_timezone_set("Asia/Singapore");
            $expiredMY = explode("/", $expiry);
            $todayYear = (int)date("Y");
            $todayMonth = (int)date("m");
            $year =(int)$expiredMY[1];
            $month = (int)$expiredMY[0];

            if($year > $todayYear)
            {   
                $messageO= $this->entityO->submitOrder($order_id, $table_num);
                $messageT = $this->entityT->processPayment($email, $cardNo, $expiry, $order_id, $table_num, $coupon_id);

                if($messageO == FALSE || $messageT["result"] == FALSE)
                {
                    $message["result"] = FALSE;
                    $message["errorMsg"] = "Please try again";
                }
                else
                {
                    $message["result"] = TRUE;

                    $this->message = $message;
                }
                    
            }
            elseif($year == $todayYear)
            {
                if($month > $todayMonth || $month == $todayMonth)
                {
                    $this->messageO = $this->entityO->submitOrder($order_id, $table_num);
                    $this->messageT = $this->entity->processPayment($email, $cardNo, $expiry, $order_id, $table_num, $coupon_id);

                    if($messageO == FALSE || $messageT["result"] == FALSE)
                    {
                        $message["result"] = FALSE;
                        $message["errorMsg"] = "Please try again";

                        $this->message = $message;
                    }
                    else
                    {
                        $message["result"] = TRUE;

                        $this->message = $message;
                    }
                        
                }
                elseif($month < $todayMonth)
                {
                    $message["result"] = FALSE;
                    $message["errorMsg"] = "Credit card has expired";

                    $this->message = $message;
                }
            }
            else
            {
                $message["result"] = FALSE;
                $message["errorMsg"] = "Credit card has expired";

                $this->message = $message;
            }

            return $this->message;
        }
    }
?>