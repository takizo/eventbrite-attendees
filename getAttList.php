<?php

$TOKEN = 'your-token-here';
$EVENTID = 'your-event-id-here';
$WHITELIST = array('Ricky Lee');
$FILENAME = 'list.php';

$url = 'https://www.eventbriteapi.com/v3/events/'.$EVENTID.'/attendees/?token='.$TOKEN;
$result = file_get_contents($url, false, $context);
$response = json_decode($result, true);

$jj = 0;


foreach($response['attendees'] as $att)
{
	$attList[$jj]['fullname'] = $att['profile']['first_name'].' '.$att['profile']['last_name'];
	$attList[$jj]['company'] = $att['profile']['company'];
	$attList[$jj]['jobTitle'] = $att['profile']['job_title'];
	$jj++;
}

$attList = json_encode($attList);

file_put_contents($FILENAME, $attList);
?>
