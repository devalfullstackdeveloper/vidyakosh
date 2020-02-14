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
$table = 'courses';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => 'id', 'dt' => 0 ),
	array( 'db' => 'coursecode', 'dt' => 1 ),
	array( 'db' => 'course_id',  'dt' => 2 ),
	
	array( 'db' => 'course_status',     'dt' => 3 ),
	array( 'db' => 'course_mode',     'dt' => 4 ),
	array(
		'db'        => 'coursecode',
		'dt'        => 5,
		'formatter' => function( $d, $row ) {
			$COUNT = $GLOBALS['db']->Execute("select * from enroll where course_id='".$d."' ");
 			return $COUNT->RecordCount();
			 
		}
	),
	array(
		'db'        => 'coursecode',
		'dt'        => 6,
		'formatter' => function( $d, $row ) {
			$COUNT = $GLOBALS['db']->Execute("select * from assignments where course_id='".$d."' ");
 			return $COUNT->RecordCount();
			 
		}
	),
	array( 'db' => 'course_version',     'dt' => 7 ),
	array( 'db' => 'course_schema',     'dt' => 8 ),
 
	
	array(
		'db'        => 'uploaded_time',
		'dt'        => 9,
		'formatter' => function( $d, $row ) {
			return date('F j, Y, g:i a',$d);
		}
	),
 
	
	array(
		'db'        => 'coursecode',
		'dt'        => 10,
		'formatter' => function( $d, $row ) {
			$r='<div class="btn-group"> <a class="btn mini green" href="#" data-toggle="dropdown" data-close-others="true"> Course Options <i class="icon-angle-down"></i> </a>
                              <ul class="dropdown-menu pull-right">';
                                
                             
                               
                             
			if($row["course_status"]=="processing")
			{
			$r .= '<li><a href="'.APP_URL.'libs/parser.php?cid=' .$d. '">Process Course </a> </li>';
			
			}
			if($row["course_status"]=="ready")
			{
			$r .= '<li><a href="'.APP_URL.'libs/purge-course.php?cid=' .$d. '">Purge Course </a> </li>';
			$r .= '<li><a href="'.APP_URL.'dashboards/application/enroll.php?cid='.$d.'">Enroll Students </a> </li>';
			if($row["course_mode"]=="browse")
			{
			$r .= '<li><a href="'.APP_URL.'dashboards/application/courses.php?cid='.$d.'&mode=normal">Normal Mode </a> </li>';

			}
			else
			{
						$r .= '<li><a href="'.APP_URL.'dashboards/application/courses.php?cid='.$d.'&mode=browse">Browse Mode </a> </li>';

			
			}
			}
			$r .='</ul>
                            </div>';
			return $r;
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


