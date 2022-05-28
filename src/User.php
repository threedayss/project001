<?php



class User
{
    public $full_name;
    public $username;

    public $password;

    public $phone_number;

    public $profile;

    public $status;

    public function getfull_name()
    {
        return $this->full_name;
    }

    public function setfull_name($full_name)
    {
        $this->full_name = $full_name;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getusername()
    {
        return $this->username;
    }

    public function setusername($username)
    {
        $this->username = $username;
    }

    public function getphonenumber()
    {
        return $this->phone_number;
    }

    public function setphonenumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    
    public function getprofile()
    {
        return $this->profile;
    }

    public function setprofile($profile)
    {
        $this->profile = $profile;
    }

    public function getstatus()
    {
        return $this->status;
    }

    public function setstatus($status)
    {
        $this->status = $status;
    }


    public function getFullName(){

        return $this->first_name . " " . $this->last_name;

    }
}
