
1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37
38
39
40
41
42
43
44
45
46
47
48
49
50
51
52
53
54
55
56
57
58
59
60
61
62
63
64
65
66
67
<?php
/**
 * @package Google API :  Google Client API
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 *   
 * Description of Contact Controller
 */
 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Googleapi 
{
    /**
     * Googleapi constructor.
     */
    public function __construct() {        
      // load google client api 
        require_once BASH_PATH.'vendor/autoload.php';
        $this->client = new Google_Client();
        $this->client->setApplicationName('Calendar Api');
        $this->ci =& get_instance();
        $this->ci->config->load('calendar');
        $this->client->setClientId($this->ci->config->item('client_id'));
        $this->client->setClientSecret($this->ci->config->item('client_secret'));
        $this->client->setRedirectUri($this->ci->config->base_url().'gc/auth/oauth');
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
        $this->client->addScope('profile');
    }
 
    public function loginUrl() {
        return $this->client->createAuthUrl();
    }
 
    public function getAuthenticate() {
        return $this->client->authenticate();
    }
 
    public function getAccessToken() {
        return $this->client->getAccessToken();
    }
 
    public function setAccessToken() {
        return $this->client->setAccessToken();
    }
 
    public function revokeToken() {
        return $this->client->revokeToken();
    }
 
    public function client() {
        return $this->client;
    }
 
    public function getUser() {
        $google_ouath = new Google_Service_Oauth2($this->client);
        return (object)$google_ouath->userinfo->get();
    }
 
    public function isAccessTokenExpired() {
        return $this->client->isAccessTokenExpired();
    }
}
?>