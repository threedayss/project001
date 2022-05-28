<?php
    require_once("../Entity/emailRecordEntity.php");

    class viewEmailC
    {
        protected $entity;
        protected $result;

        function __construct()
        {
            $this->entity = new EmailRecord();
            $this->result = array();
        }

        public function viewRecord()
        {
            $this->result = $this->entity->getRecord();

            return $this->result;
        }
    }
?>