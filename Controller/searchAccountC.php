<?php
    require_once("../Entity/accountEntity.php");

    class SearchAccountC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Account();
            $this->result = array();
        }

        function checkKeyword($keyword)
        {
            $this->result = $this->entity->getUserInfo($keyword);

            return $this->result;
        }
    }
?>