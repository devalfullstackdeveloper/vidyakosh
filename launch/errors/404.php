<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>SCORM Player General Error</title>
		<!-- Page Script -->
		<script type="text/javascript" language="JavaScript">
        	//<![CDATA[
			function doLoad(){
			
			    try{parent.doDisableControls(true);}
                catch(error){}
			
			    try{parent.getEl('loading').remove();}
                catch(error){}
			}
        	//]]>
        </script>
    </head>
    <body onload="doLoad();">
        <p><b>SCORM Player Error</b></p>
        <p>An application error has occured with the description:</p>
        <p><i>HTTP standard response code indicating that the client was able to communicate with the server, but the server either could not find what was requested, or it was configured not to fulfill the request and not reveal the reason why.</i></p>
        <p>The error details are:</p>
        <table border="1" width="640">
            <tr>
                <td nowrap="nowrap"><b>Error Message</b></td><td>Page Not Found</td>
            </tr>
            <tr>
                <td nowrap="nowrap"><b>Error Type</b></td><td>HTTP Server Status</td>
            </tr>
            <tr>
                <td nowrap="nowrap"><b>Error Number</b></td><td>HTTP 404</td>
            </tr>
        </table>
    </body>
</html>
