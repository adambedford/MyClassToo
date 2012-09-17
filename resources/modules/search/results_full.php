<?php

/*
	Establish a new connection with FB and retrieve user's friend list.
	Then loop through returned friends and add IDs to array for later use in SQL query
*/
$friends = new Connections();
$friend_ids = array();
foreach($friends->established_friends() as $friend) {
	$friend_ids[] = $friend['u_id'];
}
$term = $_GET['m_search_txt'];
$sql_find_user = sprintf("SELECT * FROM tbl_Users WHERE (u_first_name LIKE '%s' OR u_last_name LIKE '%s') AND u_id IN (".implode(',',$friend_ids).")",
	mysql_real_escape_string($term.'%'),
	mysql_real_escape_string($term.'%')
);
$query_find_user = mysql_query($sql_find_user) or die(mysql_error());

while($find_user = mysql_fetch_assoc($query_find_user)) {
	
	echo '<div class="user_view_element clearfix">
	
		 <img src="http://graph.facebook.com/'.$find_user['u_oauth_uid'].'/picture">
		 <a href="/account/schedule/view/'.$find_user['u_id'].'/">'.$find_user['u_first_name'].' '.$find_user['u_last_name'].'</a>
	
		 </div>';
}

?>
