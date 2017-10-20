<?php

$TOKEN = 'Your-token';
$EVENTID = 'Your-event-id';
$WHITELIST = array('');
$FILENAME = 'Your-list-file';

$url = 'https://www.eventbriteapi.com/v3/events/'.$EVENTID.'/attendees/?status=attending&token='.$TOKEN;
$result = file_get_contents($url, false, $context);
$response = json_decode($result, true);

$jj = 0;

$totalpage = $response['pagination']['page_count'];


foreach($response['attendees'] as $att)
{
        $fullname = $att['profile']['name'];

        if($att['cancelled'] != 1)
        {
                if(!in_array($fullname, $WHITELIST))
                {

                        $attList[$jj]['fullname'] = $fullname;
                        $attList[$jj]['company'] = $att['profile']['company'];
                        $attList[$jj]['jobTitle'] = $att['profile']['job_title'];
                        $jj++;
                }
        }
}

if($totalpage > 1)
{
        for($d=1; $d<$totalpage; $d++)
        {
                $currentpage = $d+1;
                $url = 'https://www.eventbriteapi.com/v3/events/'.$EVENTID.'/attendees/?token='.$TOKEN.'&page='.$currentpage;
                $result = file_get_contents($url, false, $context);
								$response = json_decode($result, true);

                foreach($response['attendees'] as $att)
                {
                        $fullname = $att['profile']['name'];

                        if($att['cancelled'] != 1)
                        {
                                if(!in_array($fullname, $WHITELIST))
                                {

                                        $attList[$jj]['fullname'] = $fullname;
                                        $attList[$jj]['company'] = $att['profile']['company'];
                                        $attList[$jj]['jobTitle'] = $att['profile']['job_title'];
                                        $jj++;
                                }
                        }
                }
        }
}

$attList = json_encode($attList);

file_put_contents($FILENAME, $attList);
?>
