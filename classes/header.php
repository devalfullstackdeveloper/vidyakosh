<?php // compress CSS
	header("content-type: text/css; charset: utf-8");
	header("cache-control: must-revalidate");
	$offset = 365 * 24 * 60 * 60;
	$expire = "expires: ".gmdate("D, d M Y H:i:s", time() + $offset)." GMT";
	header($expire);
	if(!ob_start("ob_gzhandler")) ob_start();
?>

 



<meta charset="windows-1252" />
	<title><?=APP_NAME?></title>
 
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->        
	<link href="<?=APP_URL?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?=APP_URL?>assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?=APP_URL?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?=APP_URL?>assets/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="<?=APP_URL?>assets/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="<?=APP_URL?>assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="<?=APP_URL?>assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="<?=APP_URL?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL PLUGIN STYLES --> 
	<link href="<?=APP_URL?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
	<link href="<?=APP_URL?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
	<link href="<?=APP_URL?>assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
	<link href="<?=APP_URL?>assets/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" media="screen"/>
	<link href="<?=APP_URL?>assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>
    <link href="<?=APP_URL?>assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
    
    
    <link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />

	<link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/chosen-bootstrap/chosen/chosen.css" />
	<link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/clockface/css/clockface.css" />
	<link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
	<link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/bootstrap-datepicker/css/datepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/bootstrap-timepicker/compiled/timepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/bootstrap-colorpicker/css/colorpicker.css" />
	<link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
	<link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
	<link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/jquery-multi-select/css/multi-select-metro.css" />
	<link href="<?=APP_URL?>assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
	<link href="<?=APP_URL?>assets/plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/jquery-tags-input/jquery.tagsinput.css" />
    
         <link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/data-tables/css/TableTools.css" />
    <link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="<?=APP_URL?>assets/plugins/data-tables/DT_bootstrap.css" />
    
	<!-- END PAGE LEVEL PLUGIN STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES --> 
	<link href="<?=APP_URL?>assets/css/pages/tasks.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="<?=APP_URL?>assets/css/pages/profile.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?=APP_URL?>assets/plugins/jquery-nestable/jquery.nestable.css" />
    
    <link href="<?=APP_URL?>assets/css/pages/inbox.css" rel="stylesheet" type="text/css" />
    <link href="<?=APP_URL?>assets/css/pages/blog.css" rel="stylesheet" type="text/css"/>
    	<link rel="stylesheet" href="<?=APP_URL?>assets/plugins/jquery.treeview.css" />
        
        <link href="<?=APP_URL?>assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
        <link href="<?=APP_URL?>assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />
	<!-- END PAGE LEVEL STYLES -->
	<link rel="shortcut icon" href="/favicon.ico" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">

 <?php ob_flush(); ?>