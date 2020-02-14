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
$table = 'roster_course_'.$_SESSION["enrollcid"];
	$CHECK_VIEW = $db->Execute("SHOW TABLES LIKE '".$table."'");
	if($CHECK_VIEW->EOF)
	{
		$db->Execute("CREATE 
VIEW `".$table."` AS 
SELECT
users.id AS userid,
users.user_name AS user_name,
users.user_email AS user_email,
users.user_active AS user_active,
users.user_type AS user_type,
users.user_uname AS user_uname,
enroll.enrolledby AS enrolledby,
enroll.course_status AS course_status,
enroll.date_created AS date_created,
enroll.learner_id AS learner_id,
enroll.id AS id,
enroll.course_id AS course_id,
teacherstudent.teacher_id AS assignedteacher
FROM
(enroll
JOIN users ON ((enroll.learner_id = users.user_uname)))
LEFT JOIN teacherstudent ON teacherstudent.course_id = enroll.course_id AND teacherstudent.student_id = enroll.learner_id
where (`enroll`.`course_id` = '".$_SESSION["enrollcid"]."')");	
	 
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
	 array( 'db' => 'date_created',   'dt' => 5 ),
	 array( 'db' => 'course_status',   'dt' => 6 ),
	  array(
		'db'        => 'assignedteacher',
		'dt'        => 7,
		'formatter' => function( $d, $row ) {
			$users = new Users;
			$user=$users->GET_USER_BY_NAME($d);
			return $user->user_name;
		}
	),
	 array(
		'db'        => 'user_uname',
		'dt'        => 8,
		'formatter' => function( $d, $row ) {
			return '<input type="checkbox" value="'.$d.'" class="checkboxes" id="data" name="data[]">';
		}
	),
  
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


