<?php
    require_once("../Entity/profileEntity.php");

    class createProfileC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Profile();
            $this->result = array();
        }

        public function validateDetails($UPName, $desc, $functions)
        {
            $this->result = $this->entity->addProfile($UPName, $desc, $functions);

            return $this->result;
        }
    }
?>