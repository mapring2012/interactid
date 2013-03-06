			<a title="" class="leftUserDrop">              
            <?php $imagepath = $this->baseUrl().'/data/uploads/thumb/';
                $image = (isset($_SESSION["Logo"]))?$_SESSION["Logo"]:"default.jpg";
            ?>
          <img src="<?php echo $imagepath.$image; ?>" />
			</a> <span>    
       <?php
							if ($_SESSION ['UserSession']) {
								echo $_SESSION ['UserSession'];
							}
							?> 
</span>
			<ul class="leftUser">
				<li><a href="#" title="" class="sProfile">My profile </a></li>
				<li><a href="#" title="" class="sMessages">Messages </a></li>
				<li><a href="#" title="" class="sSettings">Settings </a></li>
				<li><a href="#" title="" class="sLogout">Logout </a></li>
			</ul>