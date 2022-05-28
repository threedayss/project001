<?php
    require_once("../Entity/profileEntity.php");

    class SearchProfileC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Profile();
            $this->result = array();
        }

        function checkKeyword($keyword)
        {
            $this->result = $this->entity->getProfileInfo($keyword);

            return $this->result;
        }
    }
?>