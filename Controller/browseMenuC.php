<?php
    require_once("../Entity/menuEntity.php");

    class BrowseMenuC
    {
        protected $list;
        protected $entity;

        function __construct()
        {
            $this->entity = new Menu();
            $this->list = array();
        }

        public function browseMenu()
        {
            $this->list = $this->entity->getMenuList();

            return $this->list;
        }
    }
?>