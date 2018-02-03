<?php
			$dataFromTheForm = 1; // request data from the form
			
            //$soapUrl = "http://watlowleads.com/wsdl_auth/server.php?wsdl"; // asmx URL of WSDL
            $soapUrl = "http://localhost/WSDL_API/server.php?wsdl"; // asmx URL of WSDL
            $soapUser = "codezone45";  //  username
            $soapPassword = "wsdl@123#"; // password
            // xml post structure

            $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                                <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                                  <soap:Body>
                                    <getLeadDeatils xmlns="http://watlowleads.com/wsdl_auth/server.php?wsdl"> // xmlns value to be set to your\'s WSDL URL
                                      <luid>'.$dataFromTheForm.'</luid> 
                                      <uid>'.$dataFromTheForm.'</uid> 
                                    </getLeadDeatils>
                                  </soap:Body>
                                </soap:Envelope>';   // data from the form, e.g. some ID number

               $headers = array(
                            "Content-type: text/xml;charset=\"utf-8\"",
                            "Accept: text/xml",
                            "Cache-Control: no-cache",
                            "Pragma: no-cache",
                            "Content-length: ".strlen($xml_post_string),
                        ); //SOAPAction: your op URL

                $url = $soapUrl;

                // PHP cURL  for https connection with auth
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                // converting
                echo $response = curl_exec($ch); 
                curl_close($ch);
				?>