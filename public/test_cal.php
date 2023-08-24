	
<?php
 
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
            throw new Exception('Error : Failed to receieve access token');
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
            throw new Exception('Error : Failed to get timezone');
 
        return $data['value'];
    }
 
 
    public function CreateCalendarEvent($calendar_id, $summary, $all_day, $event_time, $event_timezone, $access_token)
    {
        $url_events = 'https://www.googleapis.com/calendar/v3/calendars/' . $calendar_id . '/events';
 
        $curlPost = array('summary' => $summary);
        if ($all_day == 1) {
            $curlPost['start'] = array('date' => $event_time['event_date']);
            $curlPost['end'] = array('date' => $event_time['event_date']);
        } else {
            $curlPost['start'] = array('dateTime' => $event_time['start_time'], 'timeZone' => $event_timezone);
            $curlPost['end'] = array('dateTime' => $event_time['end_time'], 'timeZone' => $event_timezone);
        }
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
            throw new Exception('Error : Failed to create event');
 
        return $data['id'];
    }
 
}
 
$capi = new GoogleCalendarApi();
const APPLICATION_ID = '647894656673-opuvei3n79v2pf3vlf65ku67c4tn94tj.apps.googleusercontent.com';
const APPLICATION_REDIRECT_URL = 'https://chandani.dinxstudio.com/Administration/home';
const APPLICATION_SECRET = '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';
 
if(isset($_GET['code'])) {
    $CODE = $_GET['code'];
    $data = $capi->GetAccessTokenRefresh(APPLICATION_ID, APPLICATION_REDIRECT_URL, APPLICATION_SECRET, $CODE);
    $access_token = $data['access_token'];
 
    $user_timezone = $capi->GetUserCalendarTimezone($data['access_token']);
    $calendar_id = 'primary';
    $event_title = 'Event Title Meetanshi';
 
// Event starting & finishing at a specific time
    $full_day_event = 0;
    $event_time = ['start_time' => '2021-12-15T13:00:00', 'end_time' => '2021-12-15T13:15:00'];
 
// Full day event
    $full_day_event = 1;
    $event_time = ['event_date' => '2021-12-15'];
 
// Create event on primary calendar
    $event_id = $capi->CreateCalendarEvent($calendar_id, $event_title, $full_day_event, $event_time, $user_timezone, $data['access_token']);
 
    echo 'new event added';
    echo '</br>';
    echo 'event Id:-'.$event_id;
 
}else{
 
    $url =$login_url = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/calendar') . '&redirect_uri=' . APPLICATION_REDIRECT_URL . '&response_type=code&client_id=' . APPLICATION_ID . '&access_type=offline';
 
    echo '<a href="'.$url.'">click here add event</a>';
}
 
 
exit();
?>