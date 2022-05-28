<?php
require '../Entity/Account-Entities.php';

class LoginController extends Account {
    public function __construct($usrnm, $pswd, $profile) {
        parent::__construct($usrnm, $pswd, $profile);
    }

    public function validateLogin() {
        $boo;

		if($this->usrnm == "" || $this->pswd == "" || $this->profile == "") {
            $boo = "emptyInput";
        }
			
		else {
			$boo = parent::verifyLogin();
		}
     
        return $boo;
    }
}
