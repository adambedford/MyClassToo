<?php
if($login) {
?>
    	<div id="h_logo">
        	<img src="/img/layout/logo.png">
        </div>
        
        <div id="h_tools" class="clearfix">
        	<div id="h_t_uinfo">
            	<span id="h_t_uname"><?php echo ucwords($userInfo['first_name']);?></span>
                <span id="h_t_network"><?php echo Connections::get_college_name($_SESSION['u_college_id']);?></span>
                <span id="h_t_logout"><a href="<?php echo $logoutUrl;?>">[ log out ]</a></span>
                
            </div>
            <div id="h_t_search">
            	<form name="h_t_search_frm" id="h_t_search_frm">
                	<input type="text" name="h_t_search_name" id="h_t_search_name" class="user_search" placeholder="Search friends">
                </form>
            </div>
            <div id="h_t_fbshare">
            	<div id="fb-root"></div>
				<script src="http://connect.facebook.net/en_US/all.js#appId=237055336307807&amp;xfbml=1"></script>
                <fb:like href="http://www.facebook.com/pages/My-Class-Toocom/191385830911043" send="true" width="450" show_faces="false" font=""></fb:like>
            </div>
        </div>

<?php 
} else {
?>

    	<div id="h_logo">
        	<img src="/img/layout/logo.png">
        </div>
        
        <div id="h_tools" class="clearfix">
        	<div id="h_t_fbconnect">
            	<a href="<?php echo '/resources/auth/fblogin.php';?>"><img src="/img/layout/fblogin.png"></a>
                <span id="h_t_reg">or <a href="/register.php" class="ui_ajax_dialog" title="Sign Up for My Class Too now" isol="#frm_register">Sign Up now!</a></span>
            </div>
            <div id="h_t_fbshare">
            	<div id="fb-root"></div>
				<script src="http://connect.facebook.net/en_US/all.js#appId=237055336307807&amp;xfbml=1"></script>
                <fb:like href="http://www.facebook.com/pages/My-Class-Toocom/191385830911043" send="true" width="450" show_faces="false" font=""></fb:like>
            </div>
        </div>


<?php
}
?>