<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/24/2018
 * Time: 1:45 PM
 */

include('../../Includes/Security/database.php');
include('../../Includes/emailfunctions.php');

$database = new Database();

$url = $_SERVER['QUERY_STRING'];

parse_str(base64_decode($url), $output);

if (isset($output['id']))
{
    $id = test_input($output['id']);

}

if (isset($output['is_approved']))
{
    $email_approval = test_input($output['is_approved']);

}
if (isset($output['name']))
{
    $name = test_input($output['name']);
}
if (isset($output['type']))
{
    $type = test_input($output['type']);
}
if (isset($output['requestor']))
{
    $requestor = test_input($output['requestor']);
}
if (isset($output['email']))
{
    $email = test_input($output['email']);

    if(!isset($_SESSION['user_id'])) {
        $user_id_read = $database->get('sp_UserIdByEmailGet("' . $email .  '");');
        $user_id = json_decode($user_id_read);
        $identifier = $user_id[0]->id;
    }
    else{
        $identifier = $_SESSION['user_id'];
    }
}

$last_asset_request_read = $database->get('sp_AssetRequestById("' . $id .  '");');
$last_asset_request = json_decode($last_asset_request_read);
$is_approved = $last_asset_request[0]->is_approved;

$approved_by = $last_asset_request[0]->approved_by_name;
$approved_date = $last_asset_request[0]->approved_date;




echo '<head><link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" ></script><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script></head>';
echo '<div class="container w-25 mt-5">';
if($email_approval == '1'){
    if($is_approved == null){
        echo '<div class="card text-center shadow border-success">';
        echo '<div class="card-header border-success">';
        echo '<img src="../../Images/vprop_logo_navbar.png">';
        echo '<h3>Asset Request</h3>';
        echo '</div>';
        echo '<div class="card-body">';
         $database->insert("sp_asset_request_respond('" . $email_approval . "','"  . $identifier . "','" . $id . "')");

        echo 'You have approved ' . $name . '\'s request for a <strong>' . $type . '</strong>.<p class="text-muted">Request sent by ' . $requestor . '</p>';
        echo '</div>';
        echo '<div class="card-footer border-success">';
    }
    elseif($is_approved == 0)
    {
        echo '<div class="card text-center shadow border-danger">';
        echo '<div class="card-header border-danger">';
        echo '<img src="../../Images/vprop_logo_navbar.png">';
        echo '<h3>Asset Request</h3>';
        echo '</div>';
        echo '<div class="card-body">';
        echo $approved_by . ' has denied ' . $name . '\'s request for a <strong>' . $type . '</strong> on ' . $approved_date . '.<p class="text-muted">Request sent by ' . $requestor . '</p>';
        echo '</div>';
        echo '<div class="card-footer border-danger">';
    }
    elseif($is_approved == 1)
    {
        echo '<div class="card text-center shadow border-success">';
        echo '<div class="card-header border-success">';
        echo '<img src="../../Images/vprop_logo_navbar.png">';
        echo '<h3>Asset Request</h3>';
        echo '</div>';
        echo '<div class="card-body">';
        echo $approved_by . ' has approved ' . $name . '\'s request for a <strong>' . $type . '</strong> on ' . $approved_date . '.<p class="text-muted">Request sent by ' . $requestor . '</p>';
        echo '</div>';
        echo '<div class="card-footer border-success">';
    }

}
if($email_approval == '0'){
    if($is_approved == null){
        echo '<div class="card text-center shadow border-danger">';
        echo '<div class="card-header border-danger">';
        echo '<img src="../../Images/vprop_logo_navbar.png">';
        echo '<h3>Asset Request</h3>';
        echo '</div>';
        echo '<div class="card-body">';
        $database->insert("sp_asset_request_respond('" . $email_approval . "','"  . $identifier . "','" . $id . "')");

        echo 'You have denied ' . $name . '\'s request for a <strong>' . $type . '</strong>.<p class="text-muted">Request sent by ' . $requestor . '</p>';
        echo '</div>';
        echo '<div class="card-footer border-danger">';
    }
    elseif($is_approved == 0)
    {
        echo '<div class="card text-center shadow border-danger">';
        echo '<div class="card-header border-danger">';
        echo '<img src="../../Images/vprop_logo_navbar.png">';
        echo '<h3>Asset Request</h3>';
        echo '</div>';
        echo '<div class="card-body">';
        echo $approved_by . ' has denied ' . $name . '\'s request for a <strong>' . $type . '</strong> on ' . $approved_date . '.<p class="text-muted">Request sent by ' . $requestor . '</p>';
        echo '</div>';
        echo '<div class="card-footer border-danger">';
    }
    elseif($is_approved == 1)
    {
        echo '<div class="card text-center shadow border-success">';
        echo '<div class="card-header border-success">';
        echo '<img src="../../Images/vprop_logo_navbar.png">';
        echo '<h3>Asset Request</h3>';
        echo '</div>';
        echo '<div class="card-body">';
        echo $approved_by . ' has approved ' . $name . '\'s request for a <strong>' . $type . '</strong> on ' . $approved_date . '.<p class="text-muted">Request sent by ' . $requestor . '</p>';
        echo '</div>';
        echo '<div class="card-footer border-danger">';
    }
}


echo '<a href="../../Controls/General/main.php" class="btn btn-basic float-right">Okay</a>';
echo '</div>';
echo '</div>';
echo '</div>';

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

