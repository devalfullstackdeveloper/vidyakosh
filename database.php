<?php
/**
 * File for database manipulation
 *
 * @package eFront
*/

/**
* Initialization part
*
* This part is used for database initialization.
*/

/** Maximum query size is 500K. Lower it in case of query problems (like 'server has gone away' in large inserts)*/
define("G_MAXIMUMQUERYSIZE", 500000);
/** The database Host */
define('G_DBTYPE', 'mysql');
define('G_DBHOST', CLOUD_DB_HOST);
/** The database user*/
define('G_DBUSER', CLOUD_DB_USER);
/** The database user password*/
define('G_DBPASSWD', CLOUD_DB_PASS);
/** The database name*/
define('G_DBNAME', CLOUD_DB);
/** The database tables prefix*/
define('G_DBPREFIX', '');


/** The servername offset */
define('G_OFFSET', '');
define('G_DEBUG', 'false');
/**Software root path*/
define('G_ROOTPATH', str_replace("\\", "/", dirname(dirname(__FILE__)))."/");

/**Current version*/
define('G_VERSION_NUM', '3.6.14');

/**ADODB database abstraction class*/
require_once('adodb/adodb.inc.php');
require_once('adodb/adodb-exceptions.inc.php');
//require_once('adodb/adodb-memcache.lib.inc.php');
$ADODB_CACHE_DIR = "adodb/cache";
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;


if (!isset($GLOBALS['db']) || !$GLOBALS['db']) {
	if(function_exists('mysqli_connect') && G_DBTYPE == 'mysql') {
    	$GLOBALS['db'] = ADONewConnection('mysqli');
	} else {
		$GLOBALS['db'] = ADONewConnection(G_DBTYPE);
	}
/*
    $GLOBALS['db']->cacheSecs = 30;
    $GLOBALS['db']->memCache = true;
	$GLOBALS['db']->memCacheHost = array('127.0.0.1'); /// $GLOBALS['db']->memCacheHost = $ip1; will work too
	$GLOBALS['db']->memCachePort = 11211; /// this is default memCache port
	$GLOBALS['db']->memCacheCompress = false; /// Use 'true' to store the item compressed (uses zlib)
*/
	$GLOBALS['db'] -> Connect(G_DBHOST, G_DBUSER, G_DBPASSWD, G_DBNAME);
}

//$perf = NewPerfMonitor($GLOBALS['db']);$perf->UI($pollsecs=5);
if (G_DBTYPE == 'mysql') {
	$GLOBALS['db'] -> Execute("SET NAMES 'UTF8'");
	$GLOBALS['db'] -> charSet = 'utf8';
}
$GLOBALS['db'] -> databaseTime    = 0;
$GLOBALS['db'] -> databaseQueries = 0;
//pr($GLOBALS['db']);exit;
/**
* Execute mySQL code
*
* This function is used to execute an arbitrary SQL query
* <br>Example:
* <code>
* $result = Activeexecute('SELECT * FROM users WHERE id = 1');
* </code>
*
* @param string $sql the SQL query
* @return mixed The result, formed in a MySQL resource
* @version 1.0
* @deprecated
*/
function ActiveexecuteNew($sql)
{
    $thisQuery = microtime(true);

    $result = $GLOBALS['db'] -> Execute($sql);
    if (!$result && G_DEBUG) {
        ActiveprintMessage(_PROBLEMQUERYINGDATABASE.": '".$sql."'<br> ".$GLOBALS['db'] -> ErrorMsg());
    }

    logProcess($thisQuery, $sql);

    return $result;
}

/**
 * Alias for ActiveexecuteNew
 * @see ActiveexecuteNew
 */
function ActiveexecuteQuery($sql) {
	return ActiveexecuteNew($sql);
}

/**
 * Execute code directly -- Changed to an alias of ActiveexecuteNew
 *
 * @deprecated
 * @param $sql
 * @return unknown_type
 */
function Activeexecute($sql)
{   
    return ActiveexecuteNew($sql);
}

/**
* Insert data to a database table
*
* This function is used to insert data to a database table. The data is formed as an associative
* array, where the keys are column names and the values are the column data. The function returns
* the auto_increment value of the insertion id, if one exists
* <br>Example:
* <code>
* $fields = array('name' => 'john', 'surname' => 'doe');
* $result = ActiveinsertTableData('users', $fields);
* </code>
* @param string $table The table to insert data into
* @param array $fields An associative array with the table cell data
* @return mixed The id of the insertion, if an AUTO_INCREMENT id field is set. Otherwise, true in success and false on failure
* @version 1.0
*/
function ActiveinsertTableData($table, $fields)
{
    $thisQuery = microtime(true);

    //Prepend prefix to the table
    $table = G_DBPREFIX.$table;

    if (sizeof($fields) < 1) {
        trigger_error(_EMPTYFIELDSLIST, E_USER_WARNING);
        return false;
    }

    isset($fields['id']) ? $customId = $fields['id'] : $customId = 0;
    $fields = ActiveaddSlashes($fields);
    array_walk($fields, create_function('&$v, $k', 'if (is_string($v)) $v = "\'".$v."\'"; else if (is_null($v)) $v = "null"; else if ($v === false) $v = 0; else if ($v === true) $v = 1;'));
    $sql = "insert into $table (".implode(",", array_keys($fields)).") values (".implode(",", ($fields)).")";

    $result = $GLOBALS['db'] -> Execute($sql);

    logProcess($thisQuery, $sql);
    if ($result) {

        if (!$customId) {
        	$id = $GLOBALS['db'] -> Insert_ID();
        } else {
        	$id = $customId;
        }


        if ($id == 0) {
            return true;
        } else {
            return $id;
        }
    } else {
        return false;
    }
}

/**
 * Insert mutiple values
 *
 * This function is used to insert multiple database values at once.
 * The values are specified in an array of arrays.
 * <br/>Example:
 * <code>
 * $data[] = array('users_LOGIN' => 'admin',
 *            'timestamp' => '1111111111',
 *            'action' => 'lastmove',
 *            'comments' => '0',
 *            'session_ip' => '7f000001');
 * $data[] = array('users_LOGIN' => 'admin',
 *            'timestamp' => '2222222222',
 *            'action' => 'lastmove1',
 *            'comments' => '0',
 *            'session_ip' => '7f000001');

 * ActiveinsertTableDataMultiple('logs', $data);
 * </code>
 *
 * @param string $table The table to insert values into
 * @param array $fields An array of arrays with fields
 * @param boolean $checkGpc Whether to perform a magic_quotes_gpc check
 * @return boolean True if everything is ok
 * @since 3.5.0
 */
function ActiveinsertTableDataMultiple($table, $fields, $checkGpc = true) {
    $thisQuery = microtime(true);

    //Prepend prefix to the table
    $table = G_DBPREFIX.$table;

    if (sizeof($fields) == 0) {
        return false;
    }
    if (!is_array($fields[0])) {            //If we specified a 1-dimensional array, convert it to 2-dimensional
        $fields = array($fields);
    }
	$columns = array();
	foreach ($fields[0] as $key => $value) {
		if (!preg_match("/^`.*`$/", $key)) {
			$columns[] = "`$key`";
		}
	}

    $count     = 0;
    $sqlArray2 = array();
    $sql       = "INSERT INTO ".$table." (".implode(",", $columns).") values ";
    $currentLength[$table] = 0;

    foreach ($fields as $value) {
        $value 		  = ActiveaddSlashes($value, $checkGpc);
    	//Quote strings and insert "null" where the value is null
    	//$anon = create_function('&$v, $k', 'if (is_string($v)) $v = "\'".$v."\'"; else if (is_null($v)) $v = "null";');
    	array_walk($value, 'ActiveNullifyRecursive');
        $valuesString = implode(",", $value);

        $currentLength[$table] += mb_strlen("('".$valuesString."')");
        if ($currentLength[$table] > G_MAXIMUMQUERYSIZE) {
            $count++;
            $currentLength[$table] = 0;
        }
        $sqlArray2[$count][] = "(".$valuesString.")";
        $sqlArray[] = "(".$valuesString.")";
    }

    $bigSqlQuery = $sql.implode(",", $sqlArray);

    foreach ($sqlArray2 as $query) {
        $bigSqlQuery2[] = $sql.implode(",", $query);
    }

    foreach ($bigSqlQuery2 as $value) {
        $result = $GLOBALS['db'] -> Execute($value);
    }

    logProcess($thisQuery, $sql);
    if ($result) {
        return true;
    } else {
        return false;
    }
}
/**
 * Convert empty strings to nulls
 * This function is used as a callback to from ActiveinsertTableDataMultiple
 * to convert empty strings to null values, as they should
 *
 * @param $v array value
 * @param $k array key
 * @return mixed the nullified value
 * @since 3.5
 */
function ActiveNullifyRecursive(&$v, $k) {
	if (is_string($v)) $v = "'".$v."'"; else if (is_null($v)) $v = "null";else if ($v === false) $v = 0; else if ($v === true) $v = 1;
}

/**
* Update table data
*
* This function is used to update data to a database table. The data is formed as an associative
* array, where the keys are column names and the values are the column data.
* <br>Example:
* <code>
* $fields = array('name' => 'john', 'surname' => 'doe');
* $result = ActiveupdateTableData('users', $fields, 'login=jdoe');
* </code>
* @param string $table The table to update data to
* @param array $fields An associative array with the table cell data
* @param string $where The where clause of the SQL Update.
* @return mixed The query result, usually true or false.
* @version 1.0
*/
function ActiveupdateTableData($table, $fields, $where = "")
{
    $thisQuery = microtime(true);

    //Prepend prefix to the table
    $table = G_DBPREFIX.$table;

    if (sizeof($fields) < 1) {
        trigger_error(_EMPTYFIELDSLIST, E_USER_WARNING);
        return false;
    }

    $fields = ActiveaddSlashes($fields);
    //array_walk($fields, create_function('&$v, $k', 'if (is_string($v)) $v = "\'".$v."\'"; else if (is_null($v)) $v = "null"; $v=$k."=".$v;'));
    array_walk($fields, create_function('&$v, $k', 'if (is_string($v)) $v = "\'".$v."\'"; else if (is_null($v)) $v = "null"; else if ($v === false) $v = 0; else if ($v === true) $v = 1; $v=$k."=".$v;'));

    $sql    = "update $table set ".implode(",", $fields);
    if ($where) {
    	$sql.=" where ".$where;
    }
    $result = $GLOBALS['db'] -> Execute($sql);

    logProcess($thisQuery, $sql);

    return $result;
}

/**
* Delete database data
*
* This function is used to delete the database data specified by the where clause.
* <br>Example
* <code>
* $result = ActivedeleteTableData('users');                  //Equivalent to truncate table "users".
* $result = ActivedeleteTableData('users', 'id = 1');        //Delete data from table users, where id = 1.
* </code>
* @param string $table The table to dekete data from
* @param string $where The where clause of the SQL Delete.
* @return mixed The query result, usually true/false.
* @version 1.0
*/
function ActivedeleteTableData($table, $where="")
{
    //Prepend prefix to the table
    $table = G_DBPREFIX.$table;

    $thisQuery = microtime(true);

    $sql = "DELETE FROM ".$table;
    if ($where != "") {
        $sql .= " WHERE ".$where;
    }
    $result = $GLOBALS['db'] -> Execute($sql);

    logProcess($thisQuery, $sql);

    return $result;
}


/**
* Retrieve database data.
*
* This function is used to perform a SELECT query. Multiple parameters may be used, to
* specify the ordering, length and grouping of the data set. It returns an array of associative arrays,
* where each of these arrays holds the column name and the corresponding value for the result row
* <br>Example:
* <code>
* //Retrieve all data from table users:
* $result = ActivegetTableData('users');
* //Retrieve all rows from table users, but only columns "name" and "surname"
* $result = ActivegetTableData('users', 'name, surname');
* //Get the "name" and "surname" for user with login "jdoe"
* $result = ActivegetTableData('users', 'name, surname', 'login=jdoe');
* //Get the same information, but this time ordered by "name"
* $result = ActivegetTableData('users', 'name, surname', 'login=jdoe', 'name');
* //Get the same information, but this time grouped by "surname"
* $result = ActivegetTableData('users', 'name, surname', 'login=jdoe', '', 'surname');
* </code>
* @param string $table The table to retrieve data from
* @param string $fields The fields to retrive, comma-separated string, defaults to *.
* @param string $where The where clause of the SQL Select.
* @param string $order The order by clause of the SQL Select.
* @param string $group The group by clause of the SQL Select.
* @param string $limit The limit clause of the SQL Select.
* @return mixed an array holding the query result.
* @version 1.0
*/
function ActivegetTableData($table, $fields = "*", $where = "", $order = "", $group = "", $limit = "")
{

    $thisQuery = microtime(true);

    $sql = prepareGetTableData($table, $fields, $where, $order, $group, $limit);

    $result = $GLOBALS['db'] -> GetAll($sql);

    logProcess($thisQuery, $sql);

    if ($result == false) {
        return array();
    } else {
        return $result;
    }
}

function ActivecountTableData($table, $fields = "*", $where = "", $order = "", $group = "", $limit = "")
{
    $thisQuery = microtime(true);

    $sql = prepareGetTableData($table, $fields, $where, $order, $group, $limit);

    $result = $GLOBALS['db'] -> GetAll("select count(*) as count from ($sql) count_query");

    logProcess($thisQuery, $sql);

    if ($result == false) {
        return array();
    } else {
        return $result;
    }

}

function prepareGetTableData($table, $fields = "*", $where = "", $order = "", $group = "", $limit = "") {
    $tables = explode(",", $table);
    foreach ($tables as $key => $value) {
        //Prepend prefix to the table
        $tables[$key] = G_DBPREFIX.trim($value);
    }
    $table = implode(",", $tables);
    $table = str_ireplace(" join ", " join ".G_DBPREFIX, $table);

    $sql = "SELECT ".$fields." FROM ".$table;
    if ($where != "") {
        $sql .= " WHERE ".$where;
    }
    if ($group != "") {
        $sql .= " GROUP BY ".$group;
    }
    if ($order != "") {
        $sql .= " ORDER BY ".$order;
    }
    if ($limit != "") {
        $sql .= " limit ".$limit;
    }

    return $sql;
}

/**
* Retrieve table contents Flat
*
* This function, much similar to the ActivegetTableData(), retrieves data from the designated
* database table. The main difference lies at the result array format: This time, each
* field in the result set corresponds to an array in the result array.
* <br/>Example:
* <code>
* $result = ActivegetTableDataFlat("users", "name, surname");
* print_r($result);
* </code>
* Returns:
* <code>
* Array
* (
*     [name]     => Array
*                   (
*                     [0] => 'john',
*                     [1] => 'joe',
*                     [2] => 'mary'
*                   )
*     [surname]  => Array
*                   (
*                     [0] => 'white',
*                     [1] => 'black',
*                     [2] => 'green'
*                   )
* )
* </code>
*
* @param string $table The database table name.
* @param string $fields Comma separated list of the fields to retrieve, defaults to *.
* @param string $where The where clause of the SQL query.
* @return array The query result table.
* @version 2.0
* @see ActivegetTableData()
* Changes from 1.0 to 2.0:
* - Rewritten function in order to accelerate execution. It now uses ActivegetTableData()
*/
function ActivegetTableDataFlat($table, $fields="*", $where="", $order="", $group="")
{
    $thisQuery = microtime(true);

    $sql = "SELECT ".$fields." FROM ".$table;

    if ($where != "") {
        $sql .= " WHERE ".$where;
    }
    if ($order != "") {
        $sql .= " ORDER BY ".$order;
    }
    if ($group != "") {
        $sql .= " GROUP BY ".$group;
    }

    $result = ActivegetTableData($table, $fields, $where, $order, $group);
    $temp   = array();

    for ($i = 0; $i < sizeof($result); $i++) {
        foreach ($result[$i] as $key => $value) {
            $temp[$key][] = $value;
        }
    }

    logProcess($thisQuery, $sql);

    return $temp;

}


/**
* Describes a table field
*
* This function returns the description of a table field, or the whole table if
* a field is not specified.
* <br />Example:
* <code>
* $desc = ActivedescribeTable("logs", array(0 => "id", "comments"));
* print_r($desc);
* //Prints something like:
* Array
* (
*     [0] => Array
*         (
*             [Field] => id
*             [Type] => int(10) unsigned
*             [Null] =>
*             [Key] => PRI
*             [Default] =>
*             [Extra] => auto_increment
*         )
*
*     [1] => Array
*         (
*             [Field] => comments
*             [Type] => varchar(255)
*             [Null] =>
*             [Key] => PRI
*             [Default] => 0
*             [Extra] =>
*         )
*
* )
* </code>
*
* @param string $table The table to describe
* @param array $fields The fields to describe
* @return array The field description
* @version 1.0
*/
function ActivedescribeTable($table, $fields = false) {
    //Prepend prefix to the table
    $table = G_DBPREFIX.$table;

    if (!$fields) {
        $desc = $GLOBALS['db'] -> GetAll("describe $table");
    } else {
    	$desc = array();
        foreach ($fields as $field) {
            //$result = ActiveexecuteNew("describe $table $field");
            $desc = array_merge($desc, $GLOBALS['db'] -> GetAll("describe $table $field"));
        }
    }

    return $desc;
}

/**
* Get table fields
*
* This function returns the desgnated table's fields
*
* @param string $table The database table
* @return array The table fields
* @version 1.0
*/
function ActivegetTableFields($table) {
    //Prepend prefix to the table
    $table = G_DBPREFIX.$table;

    $result = $GLOBALS['db'] -> GetCol("describe $table");
    return $result;
}

/**
 * Show all tables in the database
 *
 * @return array The database tables
 * @since 3.6.0
 */
function ActiveshowTables() {
    $tables = array();
    //Get the database tables
    $result = $GLOBALS['db'] -> Execute("show table status");
    while (!$result->EOF) {
        $tables[] = $result -> fields['Name'];
        $result -> MoveNext();
    }

    return $tables;
}

/**
 * Perform an update or insert, depending on whether the entry
 * actually exists in the database
 *
 * @param string $table The table to update data to
 * @param array $fields An associative array with the table cell data
 * @param string $where The where clause of the SQL Update.
 * @return mixed The query result, usually true or false.
 * @since 3.6.0
 */
function ActiveinsertOrupdateTableData($table, $fields, $where)
{
    //Prepend prefix to the table
    $table = G_DBPREFIX.$table;

	$result = ActivegetTableData($table, '*', $where);

	if (!empty($result)) {
		ActiveupdateTableData($table, $fields, $where);
	} else {
		ActiveinsertTableData($table, $fields);
	}
}


/**
 * Add slashes to parameter
 *
 * This function is used to conditionally perform an addslashes() to the specfified parameter,
 * based on the get_magic_quotes_gpc directive status. If the parameter is an array, then the
 * function is applied recursively to all its elements
 * If $checkGpc is false, ActiveaddSlashes calls addslashes without checking get_magic_quotes_gpc
 * $checkGpc should be false if Quickform exportValues is used (because exportValues performs a stripslashes operation)
 * <br>Example:
 * <code>
 * $values = ActiveaddSlashes($form -> exportValues(), false);     //slash POST variables from HTML_Quickform
 * </code>
 *
 * @param mixed $param The value to add slashes to, can be either a string or an array
 * @param bool $checkGpc If false function does not check get_magic_quotes_gpc directive status
 * @return mixed the slashed parameter
 * @since 3.5.1
  */
function ActiveaddSlashes($param, $checkGpc = true) {
    if (get_magic_quotes_gpc() && $checkGpc) {
        return $param;
    } else {
        if (is_array($param)) {
            //$anon = create_function('&$v, $k', 'is_string($v) ? $v = addslashes($v) : null;');
            array_walk_recursive($param, 'ActiveaddSlashesAux');   //We put the check here because addslashes returns string, thus destroying the real data type
            return $param;
        } else {
            return addslashes($param);
        }
    }
}
/**
 * Auxiliary function used by ActiveaddSlashes
 *
 * @param $v
 * @param $k
 * @return unknown_type
 */
function ActiveaddSlashesAux(&$v, $k) {
    is_string($v) ? $v = addslashes($v) : null;
}


function logProcess($thisQuery, $sql) {
    if ($GLOBALS['db'] -> debug == true) {
        echo '<span style = "color:red">Time spent on this query: '.(microtime(true) - $thisQuery).'</span>';
    }

    $GLOBALS['db'] -> databaseTime = $GLOBALS['db'] -> databaseTime + microtime(true) - $thisQuery;
    $GLOBALS['db'] -> databaseQueries++;

    if (G_DEBUG) {
	    $GLOBALS['db'] -> queries[$GLOBALS['db'] -> databaseQueries]['times'] = microtime(true) - $thisQuery;
	    $GLOBALS['db'] -> queries[$GLOBALS['db'] -> databaseQueries]['sql'] = $sql;
	    foreach (debug_backtrace(false) as $value) {
	    	if (isset($value['file'])) {
		        $backtrace[] = basename(dirname($value['file'])).'/'.basename($value['file']).':'.$value['line'];
	    	}
	    }
	    $GLOBALS['db'] -> queries[$GLOBALS['db'] -> databaseQueries]['trace'] = print_r($backtrace, true);
    }

}

class EfrontDB
{
    public $databaseTime    = 0;
    public $databaseQueries = 0;
    public $queries         = array();

    public function __construct($db) {
        $this -> db = $db;
    }

    public function cacheGetTableData($table, $fields = "*", $where = "", $order = "", $group = "") {
        $this -> initializeStats();
        $sql = $this -> createSQL($table, $fields = "*", $where = "", $order = "", $group = "");

        $result = $this -> db -> GetAll($sql);
        $result OR $result = array();

        $this -> calculateStats();

        return $result;
    }

    private function createSQL($table, $fields = "*", $where = "", $order = "", $group = "") {
        $sql = "SELECT ".$fields." FROM ".$table;

        !$where OR $sql .= " WHERE ".$where;
        !$order OR $sql .= " ORDER BY ".$order;
        !$group OR $sql .= " GROUP BY ".$group;

        return $sql;
    }

    private function initializeStats() {
        $this -> queryTime = microtime(true);
    }
    private function calculateStats() {
        $this -> db -> databaseTime = $this -> db -> databaseTime + microtime(true) - $this -> queryTime;
        $this -> db -> databaseQueries++;
        $this -> db -> queries[$sql][] = microtime(true) - $this -> queryTime;
    }
}
