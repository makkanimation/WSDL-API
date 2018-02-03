<?php
//phpinfo();
require_once('lib/nusoap.php');
//$client = new nusoap_client("http://watlowleads.com/wsdl_auth/server.php?wsdl");
$client = new nusoap_client("http://localhost/WSDL_API/server.php?wsdl");
 
$error = $client->getError();
if ($error) {
	echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
}

//Use basic authentication method
$client->setCredentials("codezone45", "wsdl@123#", "basic");
$result = "";
 
if ($client) {
	$result = $client->call("getLeadDeatils", array("luid" => "3","uid" => "3"));
}
 

if ($client->fault) {
	echo "<h2>Fault</h2><pre>";
			print_r($result);
	echo "</pre>";
} else {
	$error = $client->getError();
	if ($error) {
		echo "<h2>Error</h2><pre>" . $error . "</pre>";
	} 
	else {
		echo "<h2>Lead Details</h2>";
		echo $result;
		/* echo '<pre>';
			print_r($_SERVER);
		echo '</pre>'; */
		$resArr = json_decode($result, True);
		if($resArr['status']=='True')
		{
			$xml_user_info = new SimpleXMLElement("<?xml version=\"1.0\"?><LeadDeatils></LeadDeatils>");
				array_to_xml($resArr['data'],$xml_user_info);
				//generated file name
				$xml_file = $xml_user_info->asXML('users.xml');
				if($xml_file){
					echo '<br>XML file have been generated successfully.';
				}else{
					echo '<br>XML file generation error.';
				}
			
		}
	}
}


	function array_to_xml($array, &$xml_user_info) {
		foreach($array as $key => $value) {
			if(is_array($value)) {
				if(!is_numeric($key)){
					$subnode = $xml_user_info->addChild("$key");
					array_to_xml($value, $subnode);
				}else{
					$subnode = $xml_user_info->addChild("CRMLead$key");
					array_to_xml($value, $subnode);
				}
			}else {
				$xml_user_info->addChild("$key",htmlspecialchars("$value"));
			}
		}
	}
 
?>