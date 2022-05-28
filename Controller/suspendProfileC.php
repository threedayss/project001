<?php
    require("../Entity/profileEntity.php");
    
    class suspendProfileC extends Profile
    {
        protected $data;
        protected $entity;


        function __construct()
        {
            $this->entity = new Profile();
            $data = array();
        }   

        public function suspend($UPName)
        {
            $data = $this->entity->suspendProfile($UPName);

            return $data;
        }
    }
?>