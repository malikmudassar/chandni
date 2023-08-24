<?php
// This code includes a simplified delete function and adds the event after deletion --

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
        if ($http_code != 200) {
            throw new Exception('Error: Failed to get timezone');
        }

        return $data['value'];
    }

    public function deleteCalendarEvent($calendar_id, $event_id, $access_token)
    {
        $url_event = 'https://www.googleapis.com/calendar/v3/calendars/' . $calendar_id . '/events/' . $event_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_event);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token, 'Content-Type: application/json'));
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code != 204) {
            throw new Exception('Error: Failed to delete event');
        }
        return true;
    }

public function CreateCalendarEvent($calendar_id, $summary, $description, $location, $emails, $event_time, $event_timezone, $access_token)
    {
        
        $time_parts = explode('/', $event_time);
        $event_time = $time_parts[0];
        $url_event = 'https://www.googleapis.com/calendar/v3/calendars/' . $calendar_id . '/events';
        $curlPost = array(
            'summary' => $summary,
            'description' => $description,
            'location' => $location,
            'attendees' => array_map(function ($email) {
                return array('email' => $email);
            }, $emails)
        );

        // if ($all_day == 1) {
        //     $curlPost['start'] = array('date' => $event_time, 'timeZone' => $event_timezone);
        //     $curlPost['end'] = array('date' => $event_time, 'timeZone' => $event_timezone);
        // } else {
            $curlPost['start'] = array('dateTime' => $event_time, 'timeZone' => $event_timezone);
            $curlPost['end'] = array('dateTime' => $event_time, 'timeZone' => $event_timezone);
        // }

        // echo "<pre>";print_r($curlPost);die();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_event);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curlPost));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token, 'Content-Type: application/json'));
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        //echo "http_code :".$http_code;die();
        if ($http_code != 200) {
            throw new Exception('Error: Failed to create event');
        }

        $data = json_decode($response, true);
        return $data['id'];
    }


}

$capi = new GoogleCalendarApi();
$client_id = '288739849334-7jjf6ghskrasdg0qjg0ul26q4gt6ljl5.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'https://chandani.dinxstudio.com/ModifyEvent/googleevent';
$calendar_id = 'primary'; // Calendar ID (e.g., 'primary' for the primary calendar)
$event_id = $_SESSION["EVENTS"]["calendar_event_id"]; // Event ID of the event to be deleted
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    try {
        $access_token_data = $capi->GetAccessTokenRefresh($client_id, $redirect_uri, $client_secret, $code);
        $access_token = $access_token_data['access_token'];
        $is_deleted = $capi->deleteCalendarEvent($calendar_id, $event_id, $access_token);
        if ($is_deleted) {
            // Event deleted successfully, add the new event

            $events = array(
                'datetime' => $_SESSION["MODIFYEVENTS"]["STEP-1"]["event_datetime"],
                'clientName' => $_SESSION["name"],
                'hallid' => $_SESSION["MODIFYEVENTS"]["STEP-2"]["tblcompany_venue_id"],
                'eventTime' => $_SESSION["MODIFYEVENTS"]["STEP-1"]["event_time"]
              );
  
              if($events['eventTime']=='Morning Event'){ 
                  $eventStartTime='T08:00:00-04:00';
                  $eventEndTime='T15:00:00-04:00';
              }
              
              if($events['eventTime']=='Evening Event'){ 
                  $eventStartTime='T18:00:00-04:00';
                  $eventEndTime='T01:00:00-04:00';
                  
              }
              
              if($events['eventTime']=='Full Day Event'){ 
                  $eventStartTime='T08:00:00-04:00';
                  $eventEndTime='T01:00:00-04:00';
              }
              
              
              $event_start_time = $events['datetime'].$eventStartTime;
              $event_end_time = $events['datetime'].$eventEndTime;
              
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

            $event_summary = $clientName.' - '.$hallname;
            $event_location = '2935 Drew Rd, Mississauga, ON L4T 0A1';
            $event_description = $hallname.' is booked for '.$clientName;
            $event_time = $event_start_time . '/' . $event_end_time;

            $event_timezone = $capi->GetUserCalendarTimezone($access_token);
            $emails = ['info@chandnihalls.com']; // Add your email addresses here
                $new_event_id = $capi->CreateCalendarEvent($calendar_id, $event_summary, $event_description, $event_location, $emails, $event_time, $event_timezone, $access_token);
                if ($new_event_id) {
                    //echo 'Event deleted and new event added successfully. New event ID: ' . $new_event_id;
                    $_SESSION["EVENTS"]["new_calendar_event_id"]=$new_event_id;
                    header("Location: https://chandani.dinxstudio.com/ModifyEvent/thankyou");
                } else {
                    echo 'Error adding new event.';
                }
        } else {
            echo 'Error deleting event.';
        }
    } catch (Exception $e) {
        echo "here-3";
        echo 'Error deleting event: ' . $e->getMessage();
    }
} else {
    $auth_url = 'https://accounts.google.com/o/oauth2/auth?';
    $auth_url .= 'client_id=' . $client_id;
    $auth_url .= '&redirect_uri=' . urlencode($redirect_uri);
    $auth_url .= '&response_type=code';
    $auth_url .= '&scope=https://www.googleapis.com/auth/calendar';
    echo '<div class="main-panel">';
    echo '<div class="content-wrapper">';
    echo '<div class="row">';
    echo '<div class="card">';
    echo ' <div class="card-body">';
    echo '<h2 class="card-title"> ADD To Calendar</h2>';
    echo '<a href="'.$auth_url.'" target="_blank"  class="btn btn-primary mr-2">Add</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}


?>
