<?php
    require("../Entity/accountEntity.php");

    class updateAccountC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Account();
            $this->result = "";
        }

        public function validateDetails($usrnm, $pswd, $phone, $name, $profile, $status)
        {
            if(!is_numeric($usrnm))
            {
                $this->result = $this->entity->updateUser($usrnm, $pswd, $phone, $name, $profile, $status);

                return $this->result;
            }
            else
                return false;     
        }
        
    }
?>