<?php
    require_once("../Entity/menuEntity.php");

    class ViewMenuC
    {
        protected $list;
        protected $entity;

        function __construct()
        {
            $this->entity = new Menu();
            $this->list = array();
        }

        public function viewMenu()
        {
            $this->list = $this->entity->getItemsInfo();

            return $this->list;
        }
    }
?>