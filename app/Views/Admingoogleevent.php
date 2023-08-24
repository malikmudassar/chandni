<?php
//it does not include any google library
class GoogleCalendarApi
{

    public function GetAccessTokenRefresh($client_id, $redirect_uri, $client_secret, $code)
    {
        $url = 'https://accounts.google.com/o/oauth2/token';
        $curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code=' . $code . '&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code != 200) {
            throw new Exception('Error: Failed to receive access token');
        }
        return $data;
    }

    public function GetUserCalendarTimezone($access_token)
    {
        $url_settings = 'https://www.googleapis.com/calendar/v3/users/me/settings/timezone';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_settings);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code != 200)
            throw new Exception('Error: Failed to get timezone');

        return $data['value'];
    }


    public function CreateCalendarEvent($calendar_id, $summary, $description, $location, $all_day, $event_time, $event_timezone, $access_token, $email)
    {
        $url_events = 'https://www.googleapis.com/calendar/v3/calendars/' . $calendar_id . '/events';

        $curlPost = array(
            'summary' => $summary,
            'description' => $description,
            'location' => $location
        );

        if ($all_day == 1) {
            $curlPost['start'] = array('date' => $event_time['event_date']);
            $curlPost['end'] = array('date' => $event_time['event_date']);
        } else {
            $curlPost['start'] = array('dateTime' => $event_time['start_time'], 'timeZone' => $event_timezone);
            $curlPost['end'] = array('dateTime' => $event_time['end_time'], 'timeZone' => $event_timezone);
        }

        $curlPost['attendees'] = array(
            array('email' => $email)
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_events);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token, 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curlPost));
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code != 200)
            throw new Exception('Error: Failed to create event');

        return $data['id'];
    }
}
    
$capi = new GoogleCalendarApi();
const APPLICATION_ID = '288739849334-7jjf6ghskrasdg0qjg0ul26q4gt6ljl5.apps.googleusercontent.com';
const APPLICATION_REDIRECT_URL = 'https://chandani.dinxstudio.com/AdminEvents/Admingoogleevent';
const APPLICATION_SECRET = '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';

if (isset($_GET['code'])) {
    $CODE = $_GET['code'];
    $data = $capi->GetAccessTokenRefresh(APPLICATION_ID, APPLICATION_REDIRECT_URL, APPLICATION_SECRET, $CODE);
    $access_token = $data['access_token'];

    $user_timezone = $capi->GetUserCalendarTimezone($data['access_token']);
    $calendar_id = 'primary';


    $events = array(
              'datetime' => $_SESSION["EVENTS"]["STEP-1"]["event_datetime"],
              'clientName' => $_SESSION["name"],
              'hallid' => $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"],
              'eventTime' => $_SESSION["EVENTS"]["STEP-1"]["event_time"]
            );

            if($events['eventTime']=='Morning Event'){ 
                $eventStartTime='T08:00:00-04:00';
                $eventEndTime='T15:00:00-04:00';
            }
            
            if($events['eventTime']=='Evening Event'){ 
                $eventStartTime='T18:00:00-04:00';
                $eventEndTime='T01:00:00-04:00';
                $enddate= date("Y-m-d", strtotime($events['datetime']) + 86400);
                
            }
            
            if($events['eventTime']=='Full Day Event'){ 
                $eventStartTime='T08:00:00-04:00';
                $eventEndTime='T01:00:00-04:00';
                $enddate= date("Y-m-d", strtotime($events['datetime']) + 86400);
            }
            
            $datetime = $events['datetime'].$eventStartTime;
            $enddatetime = $events['datetime'].$eventEndTime;
            
            $hallname='';
            if($events['hallid']==1){ $hallname='Chandni Chrysler';}
            if($events['hallid']==2){ $hallname='Chandni Gateway';}
            if($events['hallid']==3){ $hallname='Chandni Convention';}
            if($events['hallid']==4){ $hallname='Chandni Country Club';}
            if($events['hallid']==5){ $hallname='Chandni Victoria';}
            $clientName=$events['clientName'];

    $event_title = $clientName.' - '.$hallname;
    $event_location = '2935 Drew Rd, Mississauga, ON L4T 0A1';
    $event_description = $hallname.' is booked for '.$clientName;
    // Event starting & finishing at a specific time
    $full_day_event = 0;
    $event_time = ['start_time' => $eventStartTime, 'end_time' => $eventEndTime];

    // Full day event
    $full_day_event = 1;
    $event_time = ['event_date' => $events['datetime']];

    // List of email addresses to save the event
    $email_list = ['info@chandnihalls.com'];

    // Create event on each email calendar
foreach ($email_list as $email) {
    try {
        $event_id = $capi->CreateCalendarEvent($calendar_id, $event_title, $event_description, $event_location, $full_day_event, $event_time, $user_timezone, $data['access_token'], $email);
        //echo 'Event added for email: ' . $email . ', Event ID: ' . $event_id . '<br>';
        $_SESSION["calendar_event_id"]=$event_id;
        header("Location: https://chandani.dinxstudio.com/AdminEvents/thankyou");
    } catch (Exception $e) {
        echo 'Error adding event for email: ' . $email . ', Message: ' . $e->getMessage() . '<br>';
    }
}

} else {
$url = $login_url = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/calendar') . '&redirect_uri=' . APPLICATION_REDIRECT_URL . '&response_type=code&client_id=' . APPLICATION_ID . '&access_type=offline';

//echo '<a href="'.$url.'">Click here to add an event.</a>';

echo '<div class="main-panel">';
echo '<div class="content-wrapper">';
echo '<div class="row">';
echo '<div class="card">';
echo ' <div class="card-body">';
echo '<h2 class="card-title"> ADD To Calendar</h2>';
echo '<a href="'.$url.'" target="_blank" class="btn btn-primary mr-2">Add</a>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

}

exit();