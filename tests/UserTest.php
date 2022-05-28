<?php 

require_once("src/User.php");
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {

    public $user;

    public function SetUp():void {

        $this->user = new User();

    }

	public function testThatWeCanGetFirstName() {

        $this->user->setfull_name('Billy');
		$this->assertEquals($this->user->getfull_name(), 'Billy');
	
	}

    public function testThatWeCanGetLastName(){

        $this->user->setusername('Miller');
        $this->assertEquals($this->user->getusername(), 'Miller');

	}

    public function testPassword(){

        $this->user->setPassword('123');
        $this->assertEquals($this->user->getPassword(), '123');

	}

    public function testPhone_number(){

        $this->user->setphonenumber('90901010');
        $this->assertEquals($this->user->getphonenumber(), '90901010');
	}

    public function testprofile(){

        $this->user->setprofile('User Admin');
        $this->assertEquals($this->user->getprofile(), 'User Admin');
	}

    public function teststatus(){

        $this->user->setstatus('Active');
        $this->assertEquals($this->user->getstatus(), 'Active');
	}
    
    public function testCreateAccount()
    {
        $this->user->setfull_name('Thaxter Durrett');
        $this->user->setusername('tdurrett0');
        $this->user->setPassword('zgOidjp6h');
        $this->user->setphonenumber('53011261');
        $this->user->setprofile('User Admin');
        $this->user->setstatus('Active');
        $this->assertEquals($this->user->getfull_name(), 'Thaxter Durrett');
        $this->assertEquals($this->user->getusername(), 'tdurrett0');
        $this->assertEquals($this->user->getPassword(), 'zgOidjp6h');
        $this->assertEquals($this->user->getphonenumber(), '53011261');
        $this->assertEquals($this->user->getprofile(), 'User Admin');
        $this->assertEquals($this->user->getstatus(), 'Active');
    }
}
