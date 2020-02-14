<?php

class Users
{
    public $id;
    public $user_name;
    public $user_email;
    public $user_hash;
    public $user_active;
    public $user_token;
    public $user_db;
    public $user_db_host;
    public $user_db_pass;
    public $user_db_port;
    public $user_password;
    public $user_type;
    public $user_phone;
    public $user_country;
    public $user_state;
    
    
    function LOGIN($email, $password, $usertype)
    {
        if ($usertype == "admin") {
            $GET_USER = $GLOBALS['db']->Execute("select * from users where user_email='" . trim($email) . "' and user_password='" . md5(($password)) . "'");
            if (!$GET_USER->EOF) {
                $_SESSION["id"]        = trim($GET_USER->fields["id"]);
                $_SESSION["user_hash"] = trim($GET_USER->fields["user_hash"]);
                $_SESSION["user_type"] = trim($GET_USER->fields["user_type"]);
                
                
                header("Location: dashboards/application/dashboard.php");
            } //!$GET_USER->EOF
            else {
                header("Location: index.php?msg=M_1");
            }
        } //$usertype == "admin"
        if ($usertype == "learner") {
            $GET_USER = $GLOBALS['db']->Execute("select * from learners where learner_user='" . trim($email) . "' and learner_password='" . md5(($password)) . "'");
            if (!$GET_USER->EOF) {
                $_SESSION["id"]        = trim($GET_USER->fields["id"]);
                $_SESSION["user_type"] = "learner";
                
                
                header("Location: dashboards/application/dashboard.php");
            } //!$GET_USER->EOF
            else {
                 header("Location: index.php?msg=M_1");
            }
        } //$usertype == "learner"
    }
    
    
    
    public function UPDATE_USER($mode, $records)
    {
        
        $CHECK_USER = $GLOBALS['db']->Execute("select * from users where user_email='" . $records["user_email"] . "' and id <> '" . $records["id"] . "' ");
        
        if ($CHECK_USER->EOF) {
            
            ActiveupdateTableData('users', $records, "id='" . $records["id"] . "'");
            
            
            
            header("Location: users-add-edit.php?mode=" . $mode . "&msg=M_4&id=" . $records["id"] . "");
        } //$CHECK_USER->EOF
        else {
            header("Location: users-add-edit.php?mode=" . $mode . "&msg=M_3&id=" . $records["id"] . "");
        }
        
    }
    public function GET_USER_BY_ID($id)
    {
        
        $GET_USER = $GLOBALS['db']->Execute("select * from users where id='" . $id . "'");
        
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
        $this->user_db       = trim($GET_USER->fields["user_db"]);
        $this->user_db_host  = trim($GET_USER->fields["user_db_host"]);
        $this->user_db_user  = trim($GET_USER->fields["user_db_user"]);
        $this->user_db_pass  = trim($GET_USER->fields["user_db_pass"]);
        $this->user_db_port  = trim($GET_USER->fields["user_db_port"]);
        $this->user_password = trim($GET_USER->fields["user_password"]);
        
        
        
        
        return $this;
        
        
    }
    public function DELETE_USER_BY_ID($id)
    {
        
        $GET_USER = $GLOBALS['db']->Execute("select * from users where id='" . trim($id) . "'");
        $GLOBALS['db']->Execute("drop database " . $GET_USER->fields["user_db"] . "");
        $GLOBALS['db']->Execute("delete from enroll where client_id='" . trim($id) . "'");
        $GLOBALS['db']->Execute("delete from learners where learner_parent='" . trim($id) . "'");
        $GLOBALS['db']->Execute("delete from courses where course_license_id='" . trim($GET_USER->fields["user_hash"]) . "'");
        $GLOBALS['db']->Execute("delete from users where id='" . trim($id) . "'");
        
        
        header("Location: users.php");
    }
    
    public function CREATE_USER($mode, $array)
    {
        
        $CHECK_USER = $GLOBALS['db']->Execute("select * from users where user_email='" . $array["user_email"] . "' ");
        if ($CHECK_USER->EOF) {
            ActiveinsertTableData("users", $array);
     //       $db = "CREATE DATABASE `" . $array["user_db"] . "` CHARACTER SET 'utf8'  COLLATE 'utf8_general_ci';";
    //        $GLOBALS['db']->Execute($db);
            
       //     $NewDBConnection = mysqli_connect("radcos", "root", "", $array["user_db"]);
       //     $this->RUN_SQL_FILE($NewDBConnection, APP_PATH . "/db/db");
            
            
            mkdir(APP_PATH . "/data/" . $array["user_hash"]);
            header("Location: users.php?msg=M_6");
        } //$CHECK_USER->EOF
        else {
            header("Location: users-add-edit.php?mode=" . $mode . "&msg=M_3");
        }
        
        
    }
    
    
    
    
    
    public function RUN_SQL_FILE($connection, $location)
    {
        //load file
        $commands = file_get_contents($location);
        
        //delete comments
        $lines    = explode("\n", $commands);
        $commands = '';
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line && !$this->startsWith($line, '--')) {
                $commands .= $line . "\n";
            } //$line && !$this->startsWith($line, '--')
        } //$lines as $line
        
        //convert to array
        $commands = explode(";", $commands);
        
        //run commands
        $total = $success = 0;
        foreach ($commands as $command) {
            if (trim($command)) {
                $success += (@mysqli_query($connection, $command) == false ? 0 : 1);
                $total += 1;
            } //trim($command)
        } //$commands as $command
        
        //return number of successful queries and total number of queries found
        return array(
            "success" => $success,
            "total" => $total
        );
    }
    
    
    // Here's a startsWith function
    public function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
    
}
?>