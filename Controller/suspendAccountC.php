<?php
    require("../Entity/accountEntity.php");
    
    class suspendAccountC 
    {
        protected $data;
        protected $entity;


        function __construct()
        {
            $this->entity = new Account();
            $data = array();
        }   

        public function suspend($usrnm)
        {
            $data = $this->entity->suspendUser($usrnm);

            return $data;
        }
    }
?>