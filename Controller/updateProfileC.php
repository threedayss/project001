<?php
    require("../Entity/profileEntity.php");

    class updateProfileC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Profile();
            $this->result = "";
        }

        public function validateDetails($UPName, $desc, $status, $functions)
        {
            if(!is_numeric($UPName))
            {
                $this->result = $this->entity->updateProfile($UPName, $desc, $status, $functions);

                return $this->result;
            }
            else
                return false;     
        }
        
    }
?>