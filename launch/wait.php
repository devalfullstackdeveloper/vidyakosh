<?php
error_reporting(E_ERROR);
session_start();
include_once "languages/ApplicationErrors.php";
include_once "languages/ApplicationResources.php";
include_once "languages/ApplicationResources_en_US.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>LMSWait</title>
    <!-- Page Script -->

    <script type="text/javascript" language="JavaScript">
//<![CDATA[
function doLoad(){
parent.document.title = "<?=$LOADING?>...";
}
//]]>
    </script>

</head>

    <body onload="doLoad();">
    </body>
    
</html>
