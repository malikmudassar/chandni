<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();     
        
        $this->session = \Config\Services::session();
        
        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
        } else {
            $user_id = "";
        }

        if (!(isset($request->uri->getSegments()[1]))) {
            $method = "index";
        } else {
            $method = $request->uri->getSegments()[1];
        }

        $ip_address = $request->getIPAddress();

        $this->insertActivity($user_id, $_SERVER['PHP_SELF'], get_called_class(), $method, $ip_address);
        if ($user_id!="" && !isset($_SESSION["venues"])) {
            $venues = $this->getAllCompanyVenues();
            $_SESSION["venues"] = $venues;
        }
    }

    function insertActivity($user_id, $page, $controller, $method, $ip_address) {
        $data = array(
            "tblcompany_id" => SITE_ID,
            "tblcompany_user_id" => $user_id,
            "ip_address" => $ip_address,
            "page" => $page,
            "controller" => $controller,
            "method" => $method,
            "created_at" => date("Y-m-d H:i:s")
        );

        $userActivityModel = model('App\Models\UserActivityModel');
        $userActivityModel->insert($data);
    }

    function getAllCompanyVenues() {
        $companyVenueModel = model('App\Models\CompanyVenueModel');
        $data = $companyVenueModel->where("tblcompany_id", SITE_ID)->get()->getResult();

        return $data;
    }

    function show($array, $exit) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";

        if ($exit) { exit; }
    }

    function getStrBtwTags($str1, $str2, $string, $removeStr=false) {
        $ex = explode($str1, $string);

        $ex1 = explode($str2, $ex[1]);

        if ($removeStr) {
            return str_replace($str1.$ex1[0].$str2, "", $string);
        }

        return $ex1[0];
    }

    // function getTemperature() {
    //     $curl = curl_init();

    //     curl_setopt_array($curl, [
    //         CURLOPT_URL => "https://weather.com/weather/today/l/43.73,-79.76?par=google",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_CUSTOMREQUEST => "GET",
    //     ]);

    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);
        
    //     curl_close($curl);
         
    //     if ($err) {
    //         echo "cURL Error #:" . $err;
    //     } else {
    //         //echo $response;
    //     }

    //     $ex = explode('<h1 class="CurrentConditions--location--kyTeL">Brampton, Ontario, Canada</h1>', $response);
    // // echo '<pre>';
    // //     print_r($ex[1]);
    // //     exit;
    //     $ex1 = explode('<div class="CurrentConditions--secondary', $ex[0]);
    
    //     $ex2 = explode("As of ", $ex1[0]);
    //     $ex3 = explode("</span>", $ex2[1]);
        
    //     $as_of_time = trim($ex3[0]);

    //     $tmp0 = $this->getStrBtwTags("</div><div class=", '"><s', trim($ex3[1]), true);
    //     $tmp01 = $this->getStrBtwTags("pan", '">', trim($tmp0), true);

    //     $tmp1 = $this->getStrBtwTags("<div", '">', trim($ex3[2]), true);
    //     $ex4 = explode("<div", $tmp1);
    //     $tmp2 = str_replace($ex4[0], "", $tmp1);
    //     $tmp3 = $this->getStrBtwTags("<div", '">', trim($tmp2), true);

    //     $ex5 = explode("<s", $tmp3);
    //     $tmp4 = $this->getStrBtwTags("pan ", '">', trim($ex5[1]), true);

    //     $ex6 = explode("<s", trim($ex3[3]));
    //     $tmp5 = $this->getStrBtwTags("pan ", '">', trim($ex6[1]), true);

    //     $temperature = array(
    //         'as_of_time' => trim($ex3[0]),
    //         'current_temperature' => trim($tmp01),
    //         'condition' => trim($ex4[0]),
    //         'day_temperature' => trim($tmp4),
    //         'night_temperature' => trim($tmp5),
    //     );

    //     return $temperature;
    // }
}
