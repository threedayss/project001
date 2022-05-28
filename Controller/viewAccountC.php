<?php
    require_once("../Entity/accountEntity.php");

    class ViewAccountC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Account();
            $this->result = array();
        }

        public function viewUsers()
        {
            $this->result = $this->entity->getUsersInfo();

            return $this->result;
        }
    }
?>