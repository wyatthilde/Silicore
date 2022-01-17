<?php
use Icewind\SMB\ServerFactory;
use Icewind\SMB\BasicAuth;

require('../../Includes/SMB/vendor/autoload.php');

$serverFactory = new ServerFactory();
$auth = new BasicAuth('FleetMGPS', 'ghmr', 'V1st@Trucks');
$server = $serverFactory->createServer('wellhead.ghmr.local', $auth);
$share = 'Fleetmatics_GPS$';
$share = $server->getShare($share);

date_default_timezone_set("UTC");

$username = 'rest_maalt@maalttransport.com';
$password = 'EkhaSu9rqgTh';
$token_endpoint = 'https://fim.api.us.fleetmatics.com/token';
$trucks_endpoint = 'https://fim.api.us.fleetmatics.com/cmd/v1/vehicles';
$history_endpoint = 'https://fim.api.us.fleetmatics.com/rad/v1/vehicles/%s/status/history?enddatetimeutc=%s&startdatetimeutc=%s';
$app_id = 'fleetmatics-p-us-6J2fCBN8gUdBXqXejp4qJr4t0i7NoUoZFV0GhwaS';
$end_date = date('Y-m-d\Th:i:s', time());
$start_date = date('Y-m-d\Th:i:s', strtotime($end_date) - (24 * 60 * 60));

//Call method and set variable to authorization string
$token = get_token($token_endpoint, $username, $password);

//Call get_trucks and store the response object to the trucks variable
$trucks = get_trucks($trucks_endpoint, $app_id, $token);

//$data = '';

//Iterate through each truck entry and call get_truck_history
$delimiter = ',';
$fh = $share->write('fleet-report-' . date('Y-m-d-Hms') . '.csv');
$header =
    'Vehicle Number' . ',' .
    'Vehicle Name' . ',' .
    'Update UTC' . ',' .
    'Odometer (km)' . ',' .
    'Is Private' . ',' .
    'Driver Number' . ',' .
    'First Name' . ',' .
    'Last Name' . ',' .
    'Address Line 1' . ',' .
    'Address Line 2' . ',' .
    'Locality' . ',' .
    'Administrative Area' . ',' .
    'Postal Code' . ',' .
    'Country' . ',' .
    'Latitude' . ',' .
    'Longitude' . ',' .
    'Speed' . "\r\n";

fwrite($fh, $header);
foreach($trucks as $truck) {
    echo $truck->VehicleNumber . '<br>';
    if($truck->VehicleNumber != null && $truck->VehicleNumber != '') {
        $truck_history = get_truck_history($history_endpoint, $app_id, $token, $truck->VehicleNumber, $start_date, $end_date);
        if (count($truck_history) > 0) {
            foreach ($truck_history as $element) {
                $data .= 
                    $element->VehicleNumber. ',' .
                    $element->VehicleName. ',' .
                    $element->UpdateUtc. ',' .
                    $element->OdometerInKM. ',' .
                    $element->IsPrivate. ',' .
                    $element->DriverNumber. ',' .
                    $element->FirstName. ',' .
                    $element->LastName. ',' .
                    $element->Address->AddressLine1. ',' .
                    $element->Address->AddressLine2. ',' .
                    $element->Address->Locality. ',' .
                    $element->Address->AdministrativeArea. ',' .
                    $element->Address->PostalCode. ',' .
                    $element->Address->Country. ',' .
                    $element->Latitude. ',' .
                    $element->Longitude. ',' .
                    $element->Speed . "\r\n";
            }
        }
    }
}

fwrite($fh, ($data));

fclose($fh);

function make_authorization_header($username, $password)
{
    //Base64 encode username:password; note: the ':' must be present between them
    $encodedString = base64_encode($username . ':' . $password);

    //Return concatenated Authorization string
    return 'Authorization: Basic ' . $encodedString;
}

function get_token($url, $username, $password)
{
    //Create necessary headers for REST call
    $headers = array();
    $headers[] = make_authorization_header($username, $password);    //Send to function to Base64 encode
    $headers[] = 'Accept: text/plain';                               //Authorization token comes back as plain text

    $session = curl_init($url);                             //Initialize transfer with URL
    curl_setopt($session, CURLOPT_HEADER, false);           //Exclude header info in response
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    //Return transfer as a string of the return value of curl_exec()
    curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    //Pass in headers

    //Execute transfer of $session
    $response = curl_exec($session);

    //Get http code outcome of the #session transfer
    $http_code = curl_getinfo($session, CURLINFO_HTTP_CODE);

    //Measure false response/error
    if($response === false)
    {
        echo 'Error: '. curl_error($session);
    }

    //close transfer connection
    curl_close($session);

    //Evaluate variable for non 200(OK) http code
    if($http_code !== 200)
    {
        echo 'Error: Http Status Code returned '. $http_code;
    }

    return $response;
}

function get_trucks($url, $app_id, $token) {
    $headers = array();
    $headers[] = 'Authorization: Atmosphere atmosphere_app_id=' . $app_id . ', Bearer ' . $token;
    $headers[] = 'Accept: application/json';

    $session = curl_init($url);
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

    //Execute transfer of $session
    $response = curl_exec($session);

    //Get http code outcome of the #session transfer
    $http_code = curl_getinfo($session, CURLINFO_HTTP_CODE);

    //Measure false response/error
    if($response === false)
    {
        echo 'Error: '. curl_error($session);
    }

    //close transfer connection
    curl_close($session);

    //Evaluate variable for non 200(OK) http code
    if($http_code !== 200)
    {
        echo 'Error: Http Status Code returned '. $http_code;
    }

    return json_decode($response);
}

function get_truck_history($url, $app_id, $token, $vehicle_number, $start, $end) {
    $url = sprintf($url, $vehicle_number, $end, $start);
    $url = str_replace(' ', '%20', $url);
    $headers = array();
    $headers[] = 'Authorization: Atmosphere atmosphere_app_id=' . $app_id . ', Bearer ' . $token;
    $headers[] = 'Accept: application/json';

    $session = curl_init($url);
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

    //Execute transfer of $session
    $response = curl_exec($session);

    //Get http code outcome of the #session transfer
    $http_code = curl_getinfo($session, CURLINFO_HTTP_CODE);

    //Measure false response/error
    if($response === false)
    {
        echo 'Error: ' . curl_error($session);
    }

    //close transfer connection
    curl_close($session);

    //Evaluate variable for non 200(OK) http code
    if($http_code !== 200)
    {
        echo 'Error: Http Status Code returned ' . $http_code . '<br>' . $url . '<br>';
    }

    return json_decode($response);
}