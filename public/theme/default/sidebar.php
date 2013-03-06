<div id="sidebar">
	<div class="mainNav">
		<div class="user">
            <?php include('include/user.php');?>
		</div>

		<!-- Responsive nav -->
		<div class="altNav">
			<div class="userSearch">
				<form action="">
					<input type="text" placeholder="search..." name="userSearch" /> <input
						type="submit" value="" />
				</form>
			</div>

			<!-- User nav -->
			<ul class="userNav">
				<li><a href="#" title="" class="profile"></a></li>
				<li><a href="#" title="" class="messages"></a></li>
				<li><a href="#" title="" class="settings"></a></li>
				<li><a href="#" title="" class="logout"></a></li>
			</ul>
		</div>

		<!-- Main nav (Primary Sidebar)-->        
        <?php include('include/primarySidebar.php');?>
	</div>


	<!-- Secondary nav -->
	<div class="secNav">
		<div class="secWrapper">
			<div class="secTop">
	
				<div class="balance">
					<div class="balInfo"><?php echo $pageTitle;?></div>

				</div>
				<a href="#" class="triangle-red"></a>
			</div>

			
			<!-- Tabs container -->
			<div id="tab-container" class="tab-container">
				<ul class="iconsLine ic3 etabs" style="display: none">
					<li><a href="#general" title=""><span class="icos-fullscreen"></span></a></li>
					<li><a href="#alt1" title=""><span class="icos-user"></span></a></li>
					<li><a href="#alt2" title=""><span class="icos-archive"></span></a></li>
				</ul>



				<div id="general"></div>

				<div id="alt1"></div>


				<div id="alt2"></div>
			</div>
            <ul class="subNav" id="nav">
                <?php
        
                 foreach($this->secondSideBar as $value){
                  ?>
            	<li class="<?php echo ($this->action==$value['slug'])?'activeli':'';?>">
                    <a class="<?php echo ($this->action==$value['slug'])?'this':'';?>" href="<?php echo $this->baseUrl();?>/<?php echo $this->translate('lang')?>/<?php echo $this->controller;?>/<?php echo $value['slug'];?>" title="">
                    <!-- <span class="icos-admin2"></span> --><?php echo $value['name'];?></a>
                </li>
                <?php }?>                           	
            </ul>
              <?php
				//include("../application/views/scripts/".$this->controller."/sidebar.phtml");			
            ?>
		</div>
		<div class="clear"></div>
	</div>

</div>