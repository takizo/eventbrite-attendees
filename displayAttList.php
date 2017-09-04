<?php

	$url = 'url-to-list.php-files';
	$result = file_get_contents($url, false, $context);
	$response = json_decode($result, true);


	print_r($response);

?>
