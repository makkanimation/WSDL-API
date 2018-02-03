<?php
function doAuthenticate() {
	
	if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW'])) {
	 
		if ($_SERVER['PHP_AUTH_USER'] == "codezone45" && $_SERVER['PHP_AUTH_PW'] == "wsdl@123#")
			return true;
		else
			return false;
	}
}
 

function getLeadDeatils($luid) {
	
	//  $serverval = explode(':' , base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
	
	if (!doAuthenticate())
		return json_encode(array('status'=>'false','msg'=>'Username and Password does not match'));
	
		if($luid =='')
		return json_encode(array('status'=>'false','msg'=>'Luid is blank'));

	if($luid =='All')
			$conditions= 'where wsdlActive=1 and 1 = 1';
		else
			$conditions = 'where wsdlActive=1 and LUID = '.$luid;
		
		
		
		/*$details =  array(0=>array(
				'LUID'=>'2',
				'ReceivedDateTime'=>'2017-08-14T15:06:39Z',
				'ParentName'=>'Bob',
				'First_Name'=>'Jhon',
				'Last_Name'=>'Smith',
				'ContactTitle'=>'Sell Agent',
				'Email'=>'bobsmith@acme.com'),
				1=>array(
				'LUID'=>'3',
				'ReceivedDateTime'=>'2017-08-14T15:06:39Z',
				'ParentName'=>'Ryan',
				'First_Name'=>'Dom',
				'Last_Name'=>'Smith',
				'ContactTitle'=>'Purchasing Agent1',
				'Email'=>'dom@acme.com')
		);
		$arr = array();
		foreach($details as $p)
		{
			if($p['LUID']==$luid)
				$arr=$p;
			
		}
		return json_encode(array('status'=>'True','msg'=>'Luid is find successfully', 'data'=>$details));
		*/
		
		// conection 
		$con = mysqli_connect("74.205.125.89","watlowleadUSER","3nQy~4z3");
		$db  = mysqli_select_db($con,"watlowleadsDB");
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		
		$sql = "select LUID,ReceivedDateTime,ParentName,First_Name,Last_Name,ContactTitle,Email,DUNS,Company,Address,County,City,State,ZipCode,Country,PhoneSupplied,PhoneResearched,Fax,WebAddress,SIC,SICDesc,NAICS,NAICSDesc,LeadSource1,LeadSource2,LeadSource3,LeadSource4,LineOfBusiness,LeadComments,noOfEmployees from watlow_lead ".$conditions;
		$res = mysqli_query($con,$sql);
		$rows = mysqli_num_rows($res);
		if($rows > 0)
		{	
			$arr =  array();
			while($value =  mysqli_fetch_assoc($res))
			{
				$arr[] = $value;
			}
			$result = array('status'=>'True','msg'=>'Luid is find successfully', 'data'=>$arr);
			if($luid =='All')
				$updateSql = "update watlow_lead set wsdlActive=0";
			else
				$updateSql = "update watlow_lead set wsdlActive=0 ".$conditions;
			
			$res = mysqli_query($con,$updateSql); 
		}
		else
		{
			return json_encode(array('status'=>'false','msg'=>'This is old lead. You are already downloaded.'));
		}
		
		return json_encode($result);
}
 
?>