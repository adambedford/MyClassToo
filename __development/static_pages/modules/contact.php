<?php

if(isset($_POST['frm_contact_is_sent']) && $_POST['frm_contact_is_sent']=='y') {
	//proceed knowing form is submitted
	echo 'YES';
	//validation
	$errors = false;
	if($_POST['frm_contact_name']=='') $errors = true;
	if($_POST['frm_contact_email']=='') $errors = true;
	if($_POST['frm_contact_message']=='') $errors = true;
	
	if(!$errors) {
		//no fields missing
		$to = 'myclasstoo@gmail.com';
		$from = $_POST['frm_contact_email'];
		$subject = ucwords(str_replace('_',' ',$_POST['frm_contact_subject']));
		$headers = 'From:'.$from;
		$message = $_POST['frm_contact_message'];
		
		$mail = mail($to,$subject,$message,$headers);
		
		if($mail) {
			echo UI::notification(1,'Your message has been sent. We will respond as soon as possible.');
		} else {
			echo UI::notification(3,'There was an error. Please try again.');
		}
		
		
	} else {
		//fields missing
		//header('Location: '.$_SERVER['PHP_SELF'].'?alert=true&alert_type=2&alert_message=Please ensure all required fields are completed.');
		echo UI::notification(2,'Please ensure all required fields are completed.');
	}
	
	
	
}

?>


<h1>Contact Us</h1>

<form name="frm_contact" id="frm_contact" class="ui_frm_validate" action="<?php $_SERVER['PHP_SELF'];?>" method="POST">

<div class="form_row">
	<label for="frm_contact_name">Name:</label>
    <input type="text" name="frm_contact_name" id="frm_contact_name" class="required">
</div>

<div class="form_row">
	<label for="frm_contact_email">Email Address:</label>
    <input type="text" name="frm_contact_email" id="frm_contact_email" class="required email">
</div>

<div class="form_row">
	<label for="frm_contact_subject">Subject:</label>
    <select name="frm_contact_subject" id="frm_contact_subject" >
    	<option value="general" <?php if($_GET['subject']=='general') echo 'selected="selected"';?>>General Enquiry</option>
        <option value="press" <?php if($_GET['subject']=='press') echo 'selected="selected"';?>>Press Enquiry</option>
        <option value="feedback" <?php if($_GET['subject']=='feedback') echo 'selected="selected"';?>>Feedback</option>
        <option value="bug_report" <?php if($_GET['subject']=='bug') echo 'selected="selected"';?>>Report a Bug</option>
        <option value="internship" <?php if($_GET['subject']=='internship') echo 'selected="selected"';?>>Internship</option>
        <option value="partner" <?php if($_GET['subject']=='partner') echo 'selected="selected"';?>>Partner Enquiry</option>
    </select>
</div>

<div class="form_row">
	<label for="frm_contact_message">Message:</label>
    <textarea name="frm_contact_message" id="frm_contact_message" class="required"></textarea>
</div>

<div class="form_row">
    <button type="submit" class="ui_button">Send</button>
</div>
<input type="hidden" name="frm_contact_is_sent" value="y">
</form>

<aside id="contact_info">
	

</aside>
