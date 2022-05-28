<?php
    require_once("../Entity/menuEntity.php");

    class SearchMenuC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Menu();
            $this->result = array();
        }

        function checkKeyword($keyword)
        {
            $this->result = $this->entity->getMenuInfo($keyword);

            return $this->result;
        }
    }
?>