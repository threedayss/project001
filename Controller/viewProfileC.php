<?php
    require_once("../Entity/profileEntity.php");

    class ViewProfileC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Profile();
            $this->result = array();
        }

        public function viewProfiles()
        {
            $this->result = $this->entity->getProfilesInfo();

            return $this->result;
        }
    }
?>