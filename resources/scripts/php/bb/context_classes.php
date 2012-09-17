<?php

// PHP classes corresponding to the data types in defined in WSDL

class loginTicket {

    /**
     * @var string
     */
    public $ticket;

    /**
     * @var string
     */
    public $clientVendorId;

    /**
     * @var string
     */
    public $clientProgramId;

    /**
     * @var string
     */
    public $loginExtraInfo;

    /**
     * @var long
     */
    public $expectedLifeSeconds;

}

class loginTicketResponse {

    /**
     * @var boolean
     */
    public $return;

}

class extendSessionLife {

    /**
     * @var long
     */
    public $additionalSeconds;

}

class extendSessionLifeResponse {

    /**
     * @var boolean
     */
    public $return;

}

class registerTool {

    /**
     * @var string
     */
    public $clientVendorId;

    /**
     * @var string
     */
    public $clientProgramId;

    /**
     * @var string
     */
    public $registrationPassword;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $initialSharedSecret;

    /**
     * @var array[0, unbounded] of string
     */
    public $requiredToolMethods;

    /**
     * @var array[0, unbounded] of string
     */
    public $requiredTicketMethods;

}

class registerToolResponse {

    /**
     * @var (object)RegisterToolResultVO
     */
    public $return;

}

class RegisterToolResultVO {

    /**
     * @var array[0, unbounded] of string
     */
    public $failureErrors;

    /**
     * @var string
     */
    public $proxyToolGuid;

    /**
     * @var boolean
     */
    public $status;

}

class getMyMembershipsResponse {

    /**
     * @var array[0, unbounded] of (object)CourseIdVO
     */
    public $return;

}

class CourseIdVO {

    /**
     * @var string
     */
    public $externalId;

}

class getMemberships {

    /**
     * @var string
     */
    public $userid;

}

class getMembershipsResponse {

    /**
     * @var array[0, unbounded] of (object)CourseIdVO
     */
    public $return;

}

class getRequiredEntitlements {

    /**
     * @var string
     */
    public $method;

}

class getRequiredEntitlementsResponse {

    /**
     * @var array[0, unbounded] of string
     */
    public $return;

}

class loginTool {

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $clientVendorId;

    /**
     * @var string
     */
    public $clientProgramId;

    /**
     * @var string
     */
    public $loginExtraInfo;

    /**
     * @var long
     */
    public $expectedLifeSeconds;

}

class loginToolResponse {

    /**
     * @var boolean
     */
    public $return;

}

class logoutResponse {

    /**
     * @var boolean
     */
    public $return;

}

class getSystemInstallationIdResponse {

    /**
     * @var string
     */
    public $return;

}

class login {

    /**
     * @var string
     */
    public $userid;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $clientVendorId;

    /**
     * @var string
     */
    public $clientProgramId;

    /**
     * @var string
     */
    public $loginExtraInfo;

    /**
     * @var long
     */
    public $expectedLifeSeconds;

}

class loginResponse {

    /**
     * @var boolean
     */
    public $return;

}

class getServerVersion {

    /**
     * @var (object)VersionVO
     */
    public $unused;

}

class VersionVO {

    /**
     * @var long
     */
    public $version;

}

class getServerVersionResponse {

    /**
     * @var (object)VersionVO
     */
    public $return;

}

class emulateUser {

    /**
     * @var string
     */
    public $userToEmulate;

}

class emulateUserResponse {

    /**
     * @var boolean
     */
    public $return;

}

class initializeResponse {

    /**
     * @var string
     */
    public $return;

}

// define the class map
$class_map = array(
    "loginTicket" => "loginTicket",
    "loginTicketResponse" => "loginTicketResponse",
    "extendSessionLife" => "extendSessionLife",
    "extendSessionLifeResponse" => "extendSessionLifeResponse",
    "registerTool" => "registerTool",
    "registerToolResponse" => "registerToolResponse",
    "RegisterToolResultVO" => "RegisterToolResultVO",
    "getMyMembershipsResponse" => "getMyMembershipsResponse",
    "CourseIdVO" => "CourseIdVO",
    "getMemberships" => "getMemberships",
    "getMembershipsResponse" => "getMembershipsResponse",
    "getRequiredEntitlements" => "getRequiredEntitlements",
    "getRequiredEntitlementsResponse" => "getRequiredEntitlementsResponse",
    "loginTool" => "loginTool",
    "loginToolResponse" => "loginToolResponse",
    "logoutResponse" => "logoutResponse",
    "getSystemInstallationIdResponse" => "getSystemInstallationIdResponse",
    "login" => "login",
    "loginResponse" => "loginResponse",
    "getServerVersion" => "getServerVersion",
    "VersionVO" => "VersionVO",
    "getServerVersionResponse" => "getServerVersionResponse",
    "emulateUser" => "emulateUser",
    "emulateUserResponse" => "emulateUserResponse",
    "initializeResponse" => "initializeResponse");

?>