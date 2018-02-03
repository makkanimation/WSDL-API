<?php
 
require_once 'functions.php';
require_once 'lib/nusoap.php';
 
$server = new soap_server();
$server->configureWSDL("Lead Deatils", "urn:LeadDeatils");

//Register web service function so that clients can access
$server->register("getLeadDeatils",
			array("luid" => "xsd:string","uid" => "xsd:string"), // input
			array("return" => "xsd:string"),// output
			"urn:LeadDeatils",
			"urn:LeadDeatils#getLeadDeatils",
			"rpc",
			"encoded",
			"Retrieve Lead Details for a given Lead"
	);
 
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA'])? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
// $server->service($POST_DATA);
@$server->service(file_get_contents("php://input"));

 ?>