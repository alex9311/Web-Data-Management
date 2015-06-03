<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Get cURL resource
	$curl = curl_init();
	// Set some options - we are passing in a useragent too here
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
    		//CURLOPT_URL => 'http://testcURL.com/?item1=value&item2=value2',
    		CURLOPT_URL => 'http://127.0.0.1:5984/movies/_design/examples/_view/movies_num_actors',
	));
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	print_r($resp);
	// Close request to clear up some resources
	curl_close($curl);
}

?>
