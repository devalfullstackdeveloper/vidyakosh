<?php
include_once "../config.php";
$validate->VALIDATE();
$row = array();
$return_arr = array();
$row_array = array();

if((isset($_GET['name']) && strlen($_GET['name']) > 0) || (isset($_GET['id']) && is_numeric($_GET['id'])))
{

    $RS=$GLOBALS['db']->Execute("select * from users where user_type='client' and user_name LIKE '%".$_GET['name']."%' ");
    /* limit with page_limit get */

    

        if(!$RS->EOF)
        {

            while (!$RS->EOF) 
            {
                $row_array['id'] = $RS->fields["id"];
                $row_array['text'] = $RS->fields["id"]." : ". utf8_encode($RS->fields["user_name"]);
                array_push($return_arr,$row_array);
				$RS->MoveNext();
            }

        }
}
else
{
    $row_array['id'] = 0;
    $row_array['text'] = utf8_encode('Start Typing....');
    array_push($return_arr,$row_array);

}

$ret = array();
/* this is the return for a single result needed by select2 for initSelection */
if(isset($_GET['id']))
{
    $ret = $row_array;
}
/* this is the return for a multiple results needed by select2
* Your results in select2 options needs to be data.result
*/
else
{
    $ret['results'] = $return_arr;
}
echo json_encode($ret);

 
?>


