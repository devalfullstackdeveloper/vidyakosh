<?php

class Validation

{
	public $id;
	public $user_name;
	public $user_email;
	public $user_hash;
	public $user_active;
	public $user_token;
	public $user_uname;
	public $user_lmsuser;
 
	public $user_password;
	public $user_type;
	public $user_phone;
	public $user_country;
	public $user_state;
	
	public function VALIDATE_ADMIN()
	{
	if($_SESSION["user_type"]=="admin")
	{
	}
	else
	{
	header("Location: " . APP_URL . "dashboards/application/dashboard.php");
	}
	}
	public function VALIDATE()
    {
		if(isset($_SESSION["user_type"]))
		{
        if ($_SESSION["user_type"] == "admin" or $_SESSION["user_type"] == "learner" or $_SESSION["user_type"] == "teacher") {
            $GET_USER = $GLOBALS['db']->Execute("select * from users where user_uname='" . trim($_SESSION["user_uname"]) . "'");
            if (!$GET_USER->EOF) {
                
                
                
                $this->id            = trim($GET_USER->fields["id"]);
                $this->user_name     = trim($GET_USER->fields["user_name"]);
                $this->user_email    = trim($GET_USER->fields["user_email"]);
                $this->user_phone    = trim($GET_USER->fields["user_phone"]);
                $this->user_state    = trim($GET_USER->fields["user_state"]);
                $this->user_country  = trim($GET_USER->fields["user_country"]);
                $this->user_zip      = trim($GET_USER->fields["user_zip"]);
                $this->user_active   = trim($GET_USER->fields["user_active"]);
                $this->user_hash     = trim($GET_USER->fields["user_hash"]);
                $this->user_type     = trim($GET_USER->fields["user_type"]);
                $this->user_token    = trim($GET_USER->fields["user_token"]);
         		$this->user_uname    = trim($GET_USER->fields["user_uname"]);
				$this->user_lmsuser    = trim($GET_USER->fields["user_lmsuser"]);
                $this->user_password = trim($GET_USER->fields["user_password"]);
                return $this;
            } //!$GET_USER->EOF
            else {
                header("Location: " . APP_URL . "index.php?msg=M_2");
            }
        } //$_SESSION["user_type"] == "admin" or $_SESSION["user_type"] == "client"
         
    }
	else
	{
	 header("Location: " . APP_URL . "index.php?msg=M_2");	
	}
	}
	
	
	
	
}
?>