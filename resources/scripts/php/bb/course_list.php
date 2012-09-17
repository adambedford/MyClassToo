<?php
/*
*  This is a simple code example used to demonstrate how to connect to Bb 9.0 WebServices
*  c. 2010 Blackboard Inc All Rights Reserved
*
*
*  This example presumes that you are authenticating as the user and that the WSDL is discoverable.
*  In production usage you would want to cache the WSDL locally.
*  See http://www.edugarage.com/ for more examples
*  Uses WSo2 framework for PHP to implement ws-security.
*/
# usage get_course_list.php user_id password
$BBURL = "http://some.edu/"; #set to your bb system, include at end.
$INITIAL_SHARED_SECRET = "abcdefg";
#setup some classes and a variable called $class_map.  This makes our life easier manipulating the calls.
#generate using the wsdl2php.php script from wso2.

include("context_classes.php");

#Setup Security Options
$security_options = array("useUsernameToken" => TRUE, "includeTimeStamp"=>TRUE);
$policy = new WSPolicy(array("security"=>$security_options));
$wsToken = new WSSecurityToken(
				array(
				"user" => "session",
				"password" => "nosession",
				"passwordType" => "PlainText"
				)
			);
#Initial security token is set to password "nosession", later changes to session id below.

$client = new WSClient(array(
	"wsdl"=>$BBURL ."webapps/ws/services/Context.WS?wsdl",
	"securityToken" => $wsToken,
	"useSOAP"=>"1.1",
	"policy"=> $policy,
	"classmap"=>$class_map
));
$proxy = $client->getProxy();
//initialize the session and set securityToken password to the session ID.
$initialize_response = $proxy->initialize();
$client->securityToken->password = $initialize_response->return;

//if invoked with register it will setup the tool.  You must enable it.
if ($argv[1] == "register") {
	print "Registering Tool\n";
	#register the tool (1st time only)
	$register_tool_obj = new registerTool();
	$register_tool_obj->clientVendorId= "Bb";
	$register_tool_obj->clientProgramId= "PHPTEST";
	$register_tool_obj->registrationPassword = "foobar";
	$register_tool_obj->description= "Created by WSo2 Script";
	$register_tool_obj->initialSharedSecret=$INITIAL_SHARED_SECRET;
	$register_tool_obj->requiredTicketMethods= array("Context.WS:login", "Context.WS:loginTool", "Context.WS:emulateUser", "Context.WS:extendSessionLife", "Context.WS:getMemberships", "Context.WS:getMyMemberships" );
	$register_tool_obj->requiredToolMethods == array("Context.WS:login", "Context.WS:loginTool", "Context.WS:emulateUser", "Context.WS:extendSessionLife", "Context.WS:getMemberships", "Context.WS:getMyMemberships" );
	$result = $proxy->registerTool($register_tool_obj);
	exit;
}
//

$input = new login();
$input->userid = $argv[1];
$input->password = $argv[2];
$input->clientVendorId = "Bb";
$input->clientProgramId = "PHPTEST";
$input->loginExtraInfo = ""; //must be no null.  Even though this field is currently unused.
$input->expectedLifeSeconds = 3600;
try {
	$response = $proxy->login($input);
	if (!$response->return) {
		exit ("Login Failed:  user/name password incorrect\n");
	}
} catch (Exception $e) {
// in case of an error, process the fault
    if ($e instanceof WSFault) {
        printf("Soap Fault: %s\n", $e->Reason);
	printf($client->getLastRequest());
	printf("\n\nResponse\n");
	printf($client->getLastResponse());
    } else {
        printf("Message = %s\n", $e->getMessage());
    }
}

try {
$response = $proxy->getMyMemberships();

} catch (Exception $e) {
    // in case of an error, process the fault
    if ($e instanceof WSFault) {
        printf("Soap Fault: %s\n", $e->Reason);
    } else {
        printf("Message = %s\n", $e->getMessage());
    }
}
print var_dump($response);

?>