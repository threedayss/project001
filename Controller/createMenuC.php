<?php
    require("../Entity/menuEntity.php");

    class CreateMenuC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Menu();
            $this->result = array();
        }

        public function validateMenuDetails($food_cat, $food_name, $food_desc, $stock, $price_per_unit, $images_URL)
        {
            $this->result = $this->entity->createMenu($food_cat, $food_name, $food_desc, $stock, $price_per_unit, $images_URL);

            return $this->result;
        }
    }
?>