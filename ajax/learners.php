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
$table = 'learners';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => 'id', 'dt' => 0 ),
	array( 'db' => 'learner_name',  'dt' => 1 ),
	array( 'db' => 'learner_email',   'dt' => 2 ),
 
	array(
		'db'        => 'learner_parent',
		'dt'        => 3,
		'formatter' => function( $d, $row ) {
     		$RS=$GLOBALS['db']->Execute("select * from users where id='" . trim($row["learner_parent"]) . "'");

			return $RS->fields["user_name"];
		}
	),
	
	
	array( 'db' => 'learner_phone',     'dt' => 4 ),
	array( 'db' => 'learner_user',     'dt' => 5 ),
	array( 'db' => 'learner_active',     'dt' => 6 ),
	array( 'db' => 'learner_date',     'dt' => 7 ),
	
	array(
		'db'        => 'id',
		'dt'        => 8,
		'formatter' => function( $d, $row ) {
			return '<a href="learners-add-edit.php?mode=edit&id=' .$d. '"   class="btn mini green"><i class="icon-edit"></i></a>  <a href="roster.php?id=' .$d. '"   class="btn mini blue"><i class="icon-book"></i></a> ';
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


