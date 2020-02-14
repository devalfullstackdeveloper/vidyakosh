<?php

class Errors

{
 
	
	public function Error($msg, $lng)
{
	include APP_PATH."/classes/".$lng.".php";
	if(isset($msg))
	{
	
	$e='<div class="alert alert-success">';
	$e .='<button class="close" data-dismiss="alert"></button>';
	$e .=${$msg} ;
	$e .='</div>';
	return $e;
	}
	 
}
}
?>