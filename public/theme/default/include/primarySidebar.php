		<ul class="nav">
			<li><a class="<?php if($this->controller == 'index'){ echo 'active';}?>" href="<?php echo $this->url(array('controller'=>'index','action'=>'dashboard','lang'=>$this->translate('lang')));?>" title=""><img
					src="<?php echo $this->baseUrl();?>/images/icons/mainnav/dashboard.png"
					alt="" /><span><?php echo $this->translate('home')?></span></a></li>
			<li><a class="<?php if($this->controller == 'organisme'){ echo 'active';}?>"
				href="<?php echo $this->url(array('controller'=>'organisme','action'=>'index','lang'=>$this->translate('lang')));?>"
				title=""><img
					src="<?php echo $this->baseUrl();?>/images/icons/mainnav/organisme.png"
					alt="" /><span>Organisme</span></a></li>
			<!-- <li><a href="./forms.html" title=""><img src="<?php echo $this->baseUrl();?>/images/icons/mainnav/forms.png" alt="" /><span>Fourmisseur</span></a>
                 <ul>
                     <li><a href="./forms.html" title=""><span class="icol-list"></span>Inputs &amp; xxxxxxxx </a></li>
                     <li><a href="./form_validation.html" title=""><span class="icol-alert"></span>Validation </a></li>
                     <li><a href="./form_editor.html" title=""><span class="icol-pencil"></span>File uploader &amp; WYSIWYG </a></li>
                     <li><a href="./form_wizards.html" title=""><span class="icol-signpost"></span>Form wizards </a></li>
                 </ul>
             </li> -->
			<li><a class="<?php if($this->controller == 'site'){ echo 'active';}?>" href="<?php echo $this->baseUrl();?>/<?php echo $this->translate('lang')?>/site/index" title=""><img
					src="<?php echo $this->baseUrl();?>/images/icons/mainnav/site.png"
					alt="" /><span>Site</span></a></li>
			<li><a class="<?php if($this->controller == 'typeequipement'){ echo 'active';}?>" 
                    href="<?php echo $this->url(array('controller'=>'typeequipement','action'=>'index','lang'=>$this->translate('lang')));?>" title="">
                    <img src="<?php echo $this->baseUrl();?>/images/icons/mainnav/type.png"
					alt="" /><span>Type equipement</span></a></li>
			<li><a href="./tables.html" title=""><img
					src="<?php echo $this->baseUrl();?>/images/icons/mainnav/equip.png"
					alt="" /><span>Equipement</span></a>
				<ul>
					<li><a href="./tables.html" title=""><span class="icol-frames"></span>Standard
							tables </a></li>
					<li><a href="./tables_dynamic.html" title=""><span
							class="icol-refresh"></span>Dynamic table </a></li>
					<li><a href="./tables_control.html" title=""><span
							class="icol-bullseye"></span>Tables with xxxxxxx </a></li>
					<li><a href="./tables_sortable.html" title=""><span
							class="icol-transfer"></span>Sortable and xxxxxxxxx </a></li>
				</ul></li>
			<!--  <li><a href="./other_calendar.html" title=""><img src="<?php echo $this->baseUrl();?>/images/icons/mainnav/other.png" alt="" /><span>Gestionnaire</span></a>
                 <ul>
                     <li><a href="./other_calendar.html" title=""><span class="icol-dcalendar"></span>Calendar </a></li>
                     <li><a href="./other_gallery.html" title=""><span class="icol-images2"></span>Images gallery </a></li>
                     <li><a href="./other_file_manager.html" title=""><span class="icol-files"></span>File manager </a></li>
                     <li><a href="#" title="" class="exp"><span class="icol-alert"></span>Error pages  <span class="dataNumRed">6 </span></a>
                         <ul>
                             <li><a href="./other_403.html" title="">403 error </a></li>
                             <li><a href="./other_404.html" title="">404 error </a></li>
                             <li><a href="./other_405.html" title="">405 error </a></li>
                             <li><a href="./other_500.html" title="">500 error </a></li>
                             <li><a href="./other_503.html" title="">503 error </a></li>
                             <li><a href="./other_offline.html" title="">Website is xxxxxxx error </a></li>
                         </ul>
                     </li>
                     <li><a href="./other_typography.html" title=""><span class="icol-create"></span>Typography </a></li>
                     <li><a href="./other_invoice.html" title=""><span class="icol-money2"></span>Invoice template </a></li>
                 </ul>
             </li>-->
		</ul>