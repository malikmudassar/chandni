<?php
//it does not include any google library
class GoogleCalendarApi
{
    public function getAccessToken($client_id, $client_secret, $redirect_uri, $code)
    {
        $url = 'https://oauth2.googleapis.com/token';
        $data = array(
            'code' => $code,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        curl_close($ch);

        $access_token = json_decode($response, true)['access_token'];
        return $access_token;
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
}

$capi = new GoogleCalendarApi();
$client_id = '288739849334-7jjf6ghskrasdg0qjg0ul26q4gt6ljl5.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'https://chandani.dinxstudio.com/ManageReservation/deletecalendar';
$calendar_id = 'primary'; // Calendar ID (e.g., 'primary' for the primary calendar)
$event_id = $_SESSION["EVENTS"]["calendar_event_id"]; // Event ID of the event to be deleted

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    try {
        $access_token = $capi->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
        $is_deleted = $capi->deleteCalendarEvent($calendar_id, $event_id, $access_token);
        if ($is_deleted) {
           // echo 'Event deleted successfully.';
           header("Location: https://chandani.dinxstudio.com/ManageReservation/delete/".$_SESSION["EVENTS"]["delete_event_id"]."");
        } else {
            //echo 'Error deleting event.';
            header("Location: https://chandani.dinxstudio.com/ManageReservation/delete/".$_SESSION["EVENTS"]["delete_event_id"]."");
        }
    } catch (Exception $e) {
        //echo 'Error deleting event: ' . $e->getMessage();
        header("Location: https://chandani.dinxstudio.com/ManageReservation/delete/".$_SESSION["EVENTS"]["delete_event_id"]."");
    }
} else {
    $auth_url = 'https://accounts.google.com/o/oauth2/auth?';
    $auth_url .= 'client_id=' . $client_id;
    $auth_url .= '&redirect_uri=' . urlencode($redirect_uri);
    $auth_url .= '&response_type=code';
    $auth_url .= '&scope=https://www.googleapis.com/auth/calendar';

    // Output the JavaScript code to auto-click the button and hide it
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("delete-event-btn").click();
                document.getElementById("delete-event-btn").style.display = "none";
            });
          </script>';

    echo '<a href="' . $auth_url . '" id="delete-event-btn">Click here to delete event.</a>';
}

?>
