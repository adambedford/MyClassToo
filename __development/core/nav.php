        	<ul id="nav_main" class="clearfix"> 
            	<?php if(isset($login) && $login==true) { 
					$url = '/account/home/';
				} else {
					$url = '/';
				}
				?>
                
                <li><a href="<?php echo $url; ?>">Home</a></li>
                <li><a href="/more/about/">About</a></li>
                <li><a href="/more/faq/">FAQ</a></li>
                <li><a href="http://myclasstoo.tumblr.com">Blog</a></li>
				<?php if(isset($login) && $login==true) { 
					echo '<li><a href="/account/settings/index.php" id="nav_account">Account</a></li>';
				} ?>
            </ul>
