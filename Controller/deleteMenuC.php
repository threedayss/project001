<?php
	require_once("../Entity/menuEntity.php");
	
    class DeleteMenuC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Menu();
            $this->result = array();
        }

        public function deleteItem($food_id)
        {
            $this->result = $this->entity->deleteItem($food_id);

            return $this->result;
        }
    }
?>