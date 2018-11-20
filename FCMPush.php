<?php
ini_set('display_errors','on');

require_once 'include/DB_Functions.php';
$db = new DB_Functions();

#API access key from Google API's Console
	define('API_ACCESS_KEY','YOUR-API-KEY-HERE');


if($getDeviceID = $db->getDeviceID()){

	$count = count($getDeviceID);
	// echo $count;

	foreach ($getDeviceID as $key => $value) {
		/*
			DEVICE ID's That would be Get From Your Databases
			Once User Registered in your Database
			then you'll get All Device ID's 	
		*/
		$registrationIds	=	$value['device_id'];

	#prep the bundle
     $msg = array
          (
			'body' 	=> 'YOUR-CONTENT-WANT-TO-TRIGGER-TO-Users',
			'title'	=> 'YOUR-TITLE',
           	'isSilent' => FALSE
          );
    
	$fields = array
			(
				'to'		=> $registrationIds, 
				'data' => $msg
			);
	
	$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);

		#Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, true );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		#Echo Result Of FireBase Server
		echo $result;
	}
}

/*
AT THE END YOU'll GET JSON RESPONSE 
In Which Devices that Push Notifications Sent Successfully
*/