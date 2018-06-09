<?php
//step1

    
    $rest_url = "http://localhost:8080/taskmanager/public/hr/reminder-email/";
    
    
		
	// Get cURL resource
	$curl = curl_init();
	// Set some options - we are passing in a useragent too here
	curl_setopt_array($curl, 
						array(
							CURLOPT_RETURNTRANSFER => 1,
							CURLOPT_URL => $rest_url,
							CURLOPT_USERAGENT => 'Codular Sample cURL Request'
						)
					);
	// Send the request & save response to $resp
	//$resp = curl_exec($curl);
	// Close request to clear up some resources
	curl_close($curl);
	
	//echo $content = file_get_contents("http://localhost:8080/taskmanager/public/hr/reminder-email/");
	
?>