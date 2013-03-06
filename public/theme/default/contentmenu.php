<input type="hidden" value="0" ID="hdfsupportcount" />
<div class="contentTop">
		<span class="pageTitle"><i class="icon-dashboard"></i><?php echo $this->translate('home')?></span>
            <div id="globalLinksModule" class="yui-closed" >
            	<div id="globalLinksCtrl">
            	   <a id="aSupport" class="yui-toggle" title="show/hide content"><em>toggle</em></a>
                </div>
                <div id="globalLinks" style="width: 313px;">
                    <span class="first">|</span>
                    <a href="#" id="employees_link"><?php echo $this->translate('employees')?></a>
                    <span>|</span>
                    <a href="<?php echo $this->baseUrl();?>/<?php echo $this->translate('lang')?>/index/administrator" id="admin_link">Admin</a>
                    <span>|</span>
                    <a onclick="#" id="training_link">Support</a>
                    <span>|</span>
                    <a href="#" id="help_link"><?php echo $this->translate('help')?></a>
                    <span>|</span>
                    <a class="last" href="#" id="about_link"><?php echo $this->translate('about')?></a>
                </div>
                <div id="welcome">
                    <?php echo $this->translate('welcome');?>, <strong><a href="#" id="welcome_link"><?php
							if ($_SESSION ['UserSession']) {
								echo $_SESSION ['UserSession'];
							}
							?> </a></strong> <span>|</span> <a class="utilsLink" href="<?php echo $this->url(array('controller'=>'index','action'=>'logout'));?>" id="logout_link"><?php echo $this->translate('sign_out')?></a> 
                </div>
            </div>
		<div class="clear"></div>
</div>
<script type="text/javascript"> 
    $(document).on('click', '[id$=aSupport]', function (e) {
	$('[id$=globalLinksModule]').toggleClass('yui-closed');
        var dist = -313,
            count = $('[id$=hdfsupportcount]'),
            support = $('[id$=globalLinks]');
        switch(count.val()){
            case '0':
                    count .val(1);
                    dist = 0.00294318;
                break;
            case '1':
                    count.val(0);
                    dist = 313;
                break;
        } 
        support.stop().animate({
            width:dist
        });
    });
</script>   