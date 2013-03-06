<html>
<head>
	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php echo $pageTitle;?> - <?php echo $this->translate('site-name');?></title>
	<link href='<?php echo $this->baseUrl();?>/images/favicon.ico' rel='icon' type='image/x-icon' />
	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="<?php echo $this->translate('site-discrition');?>" />
	<meta name="author"	content="<?php echo $this->translate('site-author');?>" />
		 
	 <!--[if IE]> <link href="<?php echo $this->baseUrl ()?>/theme/default/css/ie.css" rel="stylesheet" type="text/css" /> <![endif]-->
     <!-- Le fav and touch icons -->

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
					
  	<link href="<?php echo $this->baseUrl ()?>/theme/default/css/styles.css" rel="stylesheet" type="text/css" />
	<?php echo $cssScript?>
</head>
<!--[if lt IE 7 ]> <body class="ie ie6"> </body><![endif]-->
<!--[if IE 7 ]> <body class="ie ie7"> </body><![endif]-->
<!--[if IE 8 ]> <body class="ie ie8"> </body><![endif]-->
<!--[if IE 9 ]> <body class="ie ie9"> </body><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<!--<![endif]-->
<body>
<style>
.nNote {
    margin-top: 65px;
    clear: both;
}
</style>

     <?php	require_once 'accountheader.php';?> 
     
     <!--success message-->
    <?php 
        if(isset($this->success))
            {
				?>
			     	<div class="fluid">                     
    					<div class="nNote nSuccess" style="">				
    	                 <p><?php echo $this->success;?> </p>
    					</div>
					</div>
			<?php 
			}
     ?>
     <!--end success message-->
     <!--error message-->
    <?php 
        if(isset($this->error))
            {
				?>
			     	<div class="fluid">                     
    					<div class="nNote nFailure" style="">				
    	                 <p><?php echo $this->error;?> </p>
    					</div>
					</div>
			<?php 
			}
     ?>
     <!--end error message-->
 
    <!--error warning-->
    <?php 
        if(isset($this->warning))
            {
				?>
			     	<div class="fluid">                     
    					<div class="nNote nWarning" style="">				
    	                 <p><?php echo $this->warning;?> </p>
    					</div>
					</div>
			<?php 
			}
     ?>
     <!--end error warning-->
     <!--error Inform-->
    <?php 
        if(isset($this->inform))
            {
				?>
			     	<div class="fluid">                     
    					<div class="nNote nInformation" style="">				
    	                 <p><?php echo $this->inform;?> </p>
    					</div>
					</div>
			<?php 
			}
     ?>
     <!--end error Inform-->   
        <?php
			if(!isset($content))
				$content=basename($_SERVER['PHP_SELF']);
				require ('../application/views/scripts/'.$content);
		?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
		
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/forms/ui.spinner.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/forms/jquery.mousewheel.js"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/charts/excanvas.min.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/charts/jquery.flot.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/charts/jquery.flot.orderBars.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/charts/jquery.flot.pie.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/charts/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/charts/jquery.sparkline.min.js"></script>

<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/tables/jquery.sortable.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/tables/jquery.resizable.js"></script>

<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/forms/autogrowtextarea.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/forms/jquery.uniform.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/forms/jquery.inputlimiter.min.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/forms/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/forms/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/forms/jquery.autotab.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/forms/jquery.chosen.min.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/forms/jquery.dualListBox.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/forms/jquery.cleditor.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/forms/jquery.ibutton.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/forms/jquery.validationEngine.js"></script>

<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/uploader/plupload.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/uploader/plupload.html4.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/uploader/plupload.html5.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/uploader/jquery.plupload.queue.js"></script>

<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/wizards/jquery.form.wizard.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/wizards/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/wizards/jquery.form.js"></script>

<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/ui/jquery.collapsible.min.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/ui/jquery.breadcrumbs.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/ui/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/ui/jquery.progress.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/ui/jquery.timeentry.min.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/ui/jquery.colorpicker.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/ui/jquery.jgrowl.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/ui/jquery.fancybox.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/ui/jquery.fileTree.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/ui/jquery.sourcerer.js"></script>

<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/others/jquery.fullcalendar.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/others/jquery.elfinder.js"></script>

<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/plugins/ui/jquery.easytabs.min.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/files/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/files/functions.js"></script>

<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/charts/chart.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl ()?>/theme/default/js/charts/hBar_side.js"></script>
<script>
$('#languageSwitch').change(function() {
    window.location = 'http://<?php echo $_SERVER['SERVER_NAME'];?><?php echo $this->baseUrl(); ?>/' + $(this).val() + '/index/index';
});
</script>
<?php echo $javascript;?>
<script type="text/javascript">
window.setTimeout( hideTagFn, 15000);
function hideTagFn(){
   $('.nNote').fadeOut(500);
}
</script>
</body>
</html>
<?php exit;?>