<?php
include_once "../config.php";
$validate->VALIDATE();
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'roster_teacher_'.$_SESSION["teacherid"];
	$CHECK_VIEW = $db->Execute("SHOW TABLES LIKE '".$table."'");
	if($CHECK_VIEW->EOF)
	{
			$db->Execute("CREATE 
VIEW `".$table."` AS 
SELECT
users.user_name,
users.user_active,
users.user_uname,
courses.course_id,
courses.coursecode,
teacherstudent.id,
users.lastlogin,
users.user_date,
users.user_email,
enroll.learner_id,
enroll.course_status
FROM
teacherstudent
INNER JOIN users ON users.user_uname = teacherstudent.student_id
INNER JOIN courses ON teacherstudent.course_id = courses.coursecode
INNER JOIN enroll ON teacherstudent.course_id = enroll.course_id AND teacherstudent.student_id = enroll.learner_id
WHERE
teacherstudent.teacher_id  = '".$_SESSION["teacherid"]."' ;");	
	 
	}


// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => 'id', 'dt' => 0 ),
	array( 'db' => 'user_name',  'dt' => 1 ),
	array( 'db' => 'user_uname',  'dt' => 2 ),
	array( 'db' => 'user_email',   'dt' => 3 ),
	array( 'db' => 'user_active',   'dt' => 4 ),
	array( 'db' => 'user_date',   'dt' => 5 ),
  	 
	array(
		'db'        => 'lastlogin',
		'dt'        => 6,
		'formatter' => function( $d, $row ) {
			if($d=="")
			{
				return "Never Logged-in";
			}
			return date('F j, Y', $d);
			
			}
	) ,
	
	array( 'db' => 'course_id',   'dt' => 7 ),
	array( 'db' => 'course_status',   'dt' => 8 ),
	array(
		'db'        => 'coursecode',
		'dt'        => 9,
		'formatter' => function( $d, $row ) {
			$r='<div class="btn-group"><a class="btn green" href="#" data-toggle="dropdown"><i class="icon-user"></i> Manage User <i class="icon-angle-down"></i></a>
  <ul class="dropdown-menu">';
   $r .='<li><a href="gradebook.php?lid='.$row["user_uname"].'&cid='.$d.'"><i class="icon-bar-chart"></i> Gradebook</a></li> <li class="divider"></li>';
	 
  	 
			$r .='
			
    
   
    
   
    <li><a href="profile.php?id=' .$row["user_uname"]. '"><i class="icon-search"></i> View Profile</a></li>
    <li><a href="messages-user.php?numericid=' .$row["user_uname"]. '"><i class="icon-envelope"></i> Message Center</a></li>
    <li><a href="messages-compose.php?to=' .$row["user_uname"]. '"><i class="icon-share"></i> Send Message</a></li>
     
  
			 ';
			 
			 $r .='</ul>
</div>';
return $r;
			
			}
	) ,
	 
  
);

// SQL server connection information
$sql_details = array(
	'user' => G_DBUSER,
	'pass' => G_DBPASSWD,
	'db'   => G_DBNAME,
	'host' => G_DBHOST
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( '../classes/ssp.class.php' );

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);


