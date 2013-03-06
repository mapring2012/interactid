<div class="menuLine">
		<div class="bc">
			<ul id="menuLi" class="menuLi">
				<li class="<?php echo ($this->controller == 'index')?'current':''?>"><a href="<?php echo $this->baseUrl();?>/<?php echo $this->translate('lang')?>/index/dashboard"><?php echo $this->translate('home')?></a>
                    <ul>
                            <li>
                                <a title="" href="<?php echo $this->baseUrl ();?>/<?php echo $this->translate('lang')?>/index/administrator" class="">
                                <!-- <span class="icos-admin2"></span> -->Administrator</a>
                            </li>
                     </ul>
                </li>				
                <li class="<?php echo ($this->controller == 'organisme')?'current':''?>"><a href="<?php echo $this->baseUrl();?>/<?php echo $this->translate('lang')?>/organisme/index"><?php echo $this->translate('organisme'); ?></a>
                    <ul>
                            <li class="">
                                <a title="" href="<?php echo $this->baseUrl();?>/<?php echo $this->translate('lang')?>/organisme/add" class="">
                                <!-- <span class="icos-admin2"></span> --><?php echo $this->translate('create_organisme'); ?></a>
                            </li>
                            <li>
                                <a title="" href="<?php echo $this->baseUrl();?>/<?php echo $this->translate('lang')?>/organisme/index" class="this">
                                <!-- <span class="icos-admin2"></span> --><?php echo $this->translate('view_organisme'); ?></a>
                            </li>
                                                    	
                     </ul>
                </li>
                <li class="<?php echo ($this->controller == 'site')?'current':''?>"><a href="<?php echo $this->baseUrl();?>/<?php echo $this->translate('lang')?>/site/index"><?php echo $this->translate('site'); ?></a>
                     <ul>
					 <li class="">
                                <a title="" href="<?php echo $this->baseUrl();?>/<?php echo $this->translate('lang')?>/site/add" class="">
                                <!-- <span class="icos-admin2"></span> --><?php echo $this->translate('create_site'); ?></a>
                            </li>
                           <li>
                                <a title="" href="<?php echo $this->baseUrl();?>/<?php echo $this->translate('lang')?>/site/index" class="this">
                                <!-- <span class="icos-admin2"></span> --><?php echo $this->translate('view_site'); ?></a>
                            </li>
                                                    	
                     </ul> 
                </li>
                <li class="<?php echo ($this->controller == 'typeequipement')?'current':''?>"><a href="<?php echo $this->baseUrl();?>/<?php echo $this->translate('lang')?>/typeequipement/index"><?php echo $this->translate('type_equipement'); ?></a>
                    <ul>
							<li class="">
                                <a title="" href="<?php echo $this->baseUrl();?>/<?php echo $this->translate('lang')?>/typeequipement/add" class="">
                                <!-- <span class="icos-admin2"></span> --><?php echo $this->translate('create_type_equipement'); ?></a>
                            </li>
                           <li>
                                <a title="" href="<?php echo $this->baseUrl();?>/<?php echo $this->translate('lang')?>/typeequipement/index" class="this">
                                <!-- <span class="icos-admin2"></span> --><?php echo $this->translate('type_equipement'); ?></a>
                            </li>
                                                    	
                     </ul>
                </li>	
                <li><a href="<?php echo $this->baseUrl();?>/<?php echo $this->translate('lang')?>/equipement/index"><?php echo $this->translate('equipement'); ?></a></li>							

			</ul>
		</div>
	</div>