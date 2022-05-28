<?php
    require("../Entity/menuEntity.php");

    class modifyMenuC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new Menu();
            $this->result = "";
        }

        public function validateDetails($food_id, $food_name, $food_cat, $food_desc, $price_per_unit, $stock, $images_URL)
        {
            if(is_numeric($food_id))
            {
                $this->result = $this->entity->modifyMenu($food_id, $food_name, $food_cat, $food_desc, $price_per_unit, $stock, $images_URL);

                return $this->result;
            }
            else
                return false;     
        }
        
    }
?>