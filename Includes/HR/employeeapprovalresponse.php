<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 10/25/2018
 * Time: 4:26 PM
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
if (isset($output['first_name']))
{
    $first_name = test_input($output['first_name']);
}
if (isset($output['last_name']))
{
    $last_name = test_input($output['last_name']);
}
if (isset($output['manager_name']))
{
    $manager_name = test_input($output['manager_name']);
}
if($first_name != null && $last_name != null){
$employee_name = $first_name . ' ' . $last_name;
}

$result = null;

$last_asset_request_read = $database->get('sp_hr_EmployeeByIdGet("' . $id .  '");');

$paycom_read = $database->get('sp_hr_PaycomIdByIdGet("' . $id .  '");');

$last_asset_request = json_decode($last_asset_request_read);

$paycom_obj = json_decode($paycom_read);

$is_approved = $last_asset_request[0]->is_approved;

$paycom_id = $paycom_obj[0]->paycom_id;

echo '<head><link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" ></script><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script><script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script></head>';
echo '<div class="container w-25 mt-5">';
if($email_approval == 1){
    if($is_approved == 0){
        if($paycom_id != null) {
            echo '<div class="card text-center">';
            echo '<div class="card-header">';
            echo '<img src="../../Images/vprop_logo_navbar.png">';
            echo '<h3>Employee Approval</h3>';
            echo '</div>';
            echo '<div class="card-body">';
            $result = $database->insert("sp_hr_ApproveEmployeeById('" . $id . "');");
            echo 'You have approved ' . $employee_name;
            echo '</div>';
            echo '<div class="card-footer">';
            echo '<a href="../../Controls/General/main.php" class="btn btn-basic float-right">Okay</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="card text-center shadow">';
            echo '<div class="card-header">';
            echo '<img src="../../Images/vprop_logo_navbar.png">';
            echo '<h3>Employee Approval</h3>';
            echo '</div>';
            echo '<div class="card-body">';
            echo '<div class="form-row">';
            echo '<div class="form-group col-xl-12"><p class="muted">A Paycom ID must be entered before approving.</p></div>';
            echo '<div class="form-group col-xl-12"><input class="form-control" id="paycom-id" placeholder="Paycom ID"><div id="feedback"></div></div>';
            echo '</div>';
            echo '</div>';
            echo '<div class="card-footer">';
            echo '<button type="button" class="btn btn-success float-right" id="submit">Approve</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
    elseif($is_approved == 1)
    {
        echo '<div class="card text-center shadow ">';
        echo '<div class="card-header ">';
        echo '<img src="../../Images/vprop_logo_navbar.png">';
        echo '<h3>Employee Approval</h3>';
        echo '</div>';
        echo '<div class="card-body">';
        echo $employee_name . ' is already approved.';
        $result = 0;
        echo '</div>';
        echo '<div class="card-footer ">';
        echo '<a href="../../Controls/General/main.php" class="btn btn-basic float-right">Okay</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

}
if($email_approval == 0){
    if($is_approved == 0)
    {
        echo '<div class="card text-center shadow ">';
        echo '<div class="card-header ">';
        echo '<img src="../../Images/vprop_logo_navbar.png">';
        echo '<h3>Asset Request</h3>';
        echo '</div>';
        echo '<div class="card-body">';
        echo $employee_name . ' will remain pending.';
        $result = 0;
        echo '</div>';
        echo '<div class="card-footer ">';
        echo '<a href="../../Controls/General/main.php" class="btn btn-basic float-right">Okay</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    elseif($is_approved == 1)
    {
        echo '<div class="card text-center shadow ">';
        echo '<div class="card-header ">';
        echo '<img src="../../Images/vprop_logo_navbar.png">';
        echo '<h3>Asset Request</h3>';
        echo '</div>';
        echo '<div class="card-body">';
        echo $employee_name . ' is already approved.';
        $result = 0;
        echo '</div>';
        echo '<div class="card-footer ">';
        echo '<a href="../../Controls/General/main.php" class="btn btn-basic float-right">Okay</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

if ($result == 1) {
    $requests_read = $database->get('sp_AssetRequestsById("' . $id . '");');
    $requests = json_decode($requests_read);
    foreach($requests as $requested_asset){
    if($requested_asset->type !== 'Email' || $requested_asset->type !== 'Silicore') {
        $email_subject = $requested_asset->type . ' needed - ' . $employee_name;
        $email_body = $employee_name . ' needs a ' . $requested_asset->type . '</br> Manager: ' . $manager_name;
        $dev_team_email = 'devteam@vprop.com';
        $help_desk_email = 'help@vprop.com';
        if ($requested_asset->type != null) {
            if ($requested_asset->type == 'Cell Phone') {
                ob_start();
                $database->insert("sp_asset_request_respond('" . $email_approval . "','"  . $id . "','" . $requested_asset->id . "')");
                $asset_email_result = SendPHPMail($dev_team_email, $email_subject, $email_body, "");//email help@vistasand.com
                $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
                //echo json_encode($response_array);
            } elseif ($requested_asset->type == 'Laptop') {
                ob_start();
                $database->insert("sp_asset_request_respond('" . $email_approval . "','"  . $id . "','" . $requested_asset->id . "')");
                $asset_email_result = SendPHPMail($dev_team_email, $email_subject, $email_body, "");//email help@vistasand.com
                $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
                //echo json_encode($response_array);
            } elseif ($requested_asset->type == 'Desktop') {
                ob_start();
                $database->insert("sp_asset_request_respond('" . $email_approval . "','"  . $id . "','" . $requested_asset->id . "')");
                $asset_email_result = SendPHPMail($dev_team_email, $email_subject, $email_body, "");//email help@vistasand.com
                $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
                //echo json_encode($response_array);
            } elseif ($requested_asset->type == 'Tablet') {
                ob_start();
                $database->insert("sp_asset_request_respond('" . $email_approval . "','"  . $id . "','" . $requested_asset->id . "')");
                $asset_email_result = SendPHPMail($dev_team_email, $email_subject, $email_body, "");//email help@vistasand.com
                $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
                //echo json_encode($response_array);
            } elseif ($requested_asset->type == 'Radio') {
                ob_start();
                $database->insert("sp_asset_request_respond('" . $email_approval . "','"  . $id . "','" . $requested_asset->id . "')");
                $asset_email_result = SendPHPMail($dev_team_email, $email_subject, $email_body, "");//email help@vistasand.com
                $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
                //echo json_encode($response_array);
            } elseif ($requested_asset->type == 'Uniform') {
                ob_start();
                $database->insert("sp_asset_request_respond('" . $email_approval . "','"  . $id . "','" . $requested_asset->id . "')");
                $asset_email_subject = 'Uniform Request';
                $asset_email_result = SendPHPMail($dev_team_email, $asset_email_subject, $email_body, "");//email mine_uniforms@vprop.com
                $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
                //echo json_encode($response_array);
            } elseif ($requested_asset->type == 'Credit Card') {
                ob_start();
                $database->insert("sp_asset_request_respond('" . $email_approval . "','"  . $id . "','" . $requested_asset->id . "')");
                $asset_email_subject = 'Credit Card Request';
                $asset_email_result = SendPHPMail($dev_team_email, $asset_email_subject, $email_body, ""); //email mine_ccrequest@vprop.com
                $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
                //echo json_encode($response_array);
            } elseif ($requested_asset->type == 'Fuel Card') {
                ob_start();
                $database->insert("sp_asset_request_respond('" . $email_approval . "','"  . $id . "','" . $requested_asset->id . "')");
                $asset_email_subject = 'Fuel Card Request';
                $asset_email_result = SendPHPMail($dev_team_email, $asset_email_subject, $email_body, "");//email mine_fuelcard@vprop.com
                $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
                //echo json_encode($response_array);
            } elseif ($requested_asset->type == 'Business Card') {
                ob_start();
                $database->insert("sp_asset_request_respond('" . $email_approval . "','"  . $id . "','" . $requested_asset->id . "')");
                $asset_email_subject = 'Business Card Request';
                $asset_email_result = SendPHPMail($help_desk_email, $asset_email_subject, $email_body, ""); //email help@vistasand.com
                $response_array = array('response' => $asset_email_result, 'email' => $dev_team_email);
                //echo json_encode($response_array);
            }
        }
    }
    }
    ob_start();
    SendPHPMail('devteam@vprop.com', ('Employee Approved - ' . $employee_name), ('You have approved ' . $employee_name . '<br/> All requests regarding this approval have been sent.'), "");
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<script>
    $(function() {
        let $paycomId =  $('#paycom-id');
        $paycomId.on('input', function() {
            if($(this).val().length < 4) {
                $(this).removeClass().addClass('form-control is-invalid');
                $('#feedback').removeClass().addClass('invalid-feedback').text('Paycom ID must be at least 4 characters.');
            } else {
                $(this).removeClass().addClass('form-control is-valid');
                $('#feedback').removeClass().addClass('valid-feedback').text('Looks good!');
            }
        });
        $('#submit').on('click', function() {
            if($paycomId.val().length < 4){
                $paycomId.removeClass().addClass('form-control is-invalid');
                $('#feedback').removeClass().addClass('invalid-feedback').text('Paycom ID must be at least 4 characters.');
                return false;
            }else{
                let formData = {};
                formData['id'] = <?php echo $id; ?>;
                formData['paycom_id'] = $('#paycom-id').val();
                $.ajax({
                    url: '../../Includes/HR/updatepaycom.php',
                    type: 'POST',
                    data: JSON.stringify(formData),
                    success: function(response) {
                        if(parseInt(response) === 1){
                            location.reload();
                        }
                    },
                    error: function() {
                        alert('Error updating database, please try again.');
                    }
                });
            }

        });
    });
</script>
