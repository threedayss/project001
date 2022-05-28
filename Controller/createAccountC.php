<?php
    require_once("../Entity/accountEntity.php");

    class createAccountC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Account();
            $this->result = array();
        }

        public function validateDetails($usrnm, $pswd, $phone, $profile, $name)
        {
            $this->result = $this->entity->addUser($usrnm, $pswd, $phone, $profile, $name);

            return $this->result;
        }
    }
?>