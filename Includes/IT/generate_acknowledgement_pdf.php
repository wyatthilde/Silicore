<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 1/24/2019
 * Time: 12:04 PM
 */

include('../../Includes/Security/database.php');

$database = new Database();

$id = test_input($_GET['id']);
$name = test_input($_GET['name']);
$inventoryId = test_input($_GET['inventoryId']);
$type = test_input($_GET['type']);
$userId = test_input($_GET['userId']);
$assigneeSignature = test_input($_GET['assigneeSignature']);
$assignerSignature = test_input($_GET['assignerSignature']);


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-alpha.12/dist/npm/index.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<link href="../../Includes/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<div id="pdf-content" class="container bg-white mr-3 ml-3" style="width:789px;height:1169px;"></div>
<script>
    $(function() {
        let id = "<?php echo $id;?>";
        let name = "<?php echo $name;?>";
        let inventory_id = "<?php echo $inventoryId;?>";
        let type = "<?php echo $type;?>";
        let assigneeSignature = "<?php echo $assigneeSignature;?>";
        let assignerSignature = "<?php echo $assignerSignature;?>";
        let userId = "<?php echo $userId;?>";
        acknowledgementPdf(id, name, inventory_id, type, assigneeSignature, assignerSignature, userId);
    });

    function acknowledgementPdf(id, name, inventory_id, type, assigneeSignature, assignerSignature, userId) {
        let formData = {};
        let date = new Date();
        let div = $('#pdf-content');
        formData['inventory_id'] = inventory_id;
        let paycomData = {};
        paycomData['id'] = id;
        $.ajax({
            url: '../../Includes/IT/paycombyidget.php',
            type: 'POST',
            data: JSON.stringify(paycomData),
            success: function (response) {
                let data = JSON.parse(response);
                let paycom = data[0].paycom_id;
                $.ajax({
                    url: '../../Includes/IT/serialbyidget.php',
                    type: 'POST',
                    data: JSON.stringify(formData),
                    success: function (response) {
                        let dollar = null;
                        if (type === 'Cell Phone') {
                            dollar = '$900';
                        }
                        if (type === 'Radio') {
                            dollar = '$850';
                        }
                        if (type === 'Tablet') {
                            dollar = '$1500';
                        }
                        if (type === 'Laptop') {
                            dollar = '$2000';
                        }
                        if (type === 'Hotspot') {
                            dollar = '$600';
                        }
                        let serial = JSON.parse(response)[0].part_number;
                        let content = '<table class="table-borderless ml-5 mr-5">' +
                            '<tr>' +
                            '<td><img src="../../Images/vprop_logo_minborder.png" style="width:25%;">' +
                            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                            'IT Asset Assignment Form</td>' +
                            '</tr>' +
                            '<tr><td>&nbsp;</td></tr>' +
                            '<tr>' +
                            '<td>Employee Name: ' + name + '<td> Date: ' + date.toDateString() + '</td>' +
                            '</tr>' +
                            '<tr><td>&nbsp;</td></tr>' +
                            '<tr>' +
                            '<td>Paycom Employee Number: ' + paycom + '</td>' +
                            '</tr>' +
                            '<tr><td>&nbsp;</td></tr>' +
                            '<tr><td>&nbsp;</td></tr>' +
                            '<tr><td>&nbsp;</td></tr>' +
                            '<tr><td>&nbsp;</td></tr>' +
                            '<tr><td>&nbsp;</td></tr>' +
                            '<tr>' +
                            '<td colspan="2">I understand that <u>' + dollar + '</u> ' +
                            'will be deducted from my final paycheck if I do not return the ' + type + ' (SN:' + serial + ') assigned to me within 1 day after termination of employment.' +
                            '</td>' +
                            '</tr>' +
                            '<tr><td>&nbsp;</td></tr>' +
                            '<tr><td>&nbsp;</td></tr>' +
                            '<tr><td>&nbsp;</td></tr>' +
                            '<tr><td>&nbsp;</td></tr>' +
                            '<tr><td>&nbsp;</td></tr>' +
                            '<tr>' +
                            '<td><img src="'+assigneeSignature+'" height="50px" class="border-bottom"></td><td><div class="border-bottom mt-4">'+ date.toDateString()+'</div></td>' +
                            '</tr>' +
                            '<tr><td>Employee Signature</td><td>Date</td></tr>' +
                            '<tr><td>&nbsp;</td></tr>' +
                            '<tr><td>&nbsp;</td></tr>' +
                            '<td><img src="'+assignerSignature+'" height="50px" class="border-bottom"></td><td><div class="border-bottom mt-4">'+ date.toDateString()+'</div></td>' +
                            '</tr>' +
                            '<tr><td>IT Services Signature</td><td>Date</td></tr>' +
                            '</table>';
                        div.append(content);
                        html2canvas(document.querySelector('#pdf-content'), {
                            scale: 2,
                            logging: true,
                            allowTaint: true
                        }).then(canvas => {
                            let doc = new jsPDF();
                            doc.addHTML(div,function() {
                                doc.addImage(canvas.toDataURL('image/jpeg'), 'JPEG', 0, 0, 0, 0);
                                let pdf = doc.output('blob');
                                let formData = new FormData();
                                formData.append('file', pdf, type+'-Acknowledgement-' + name + '-' + date.toDateString());
                                formData.append('request', id);
                                formData.append('userId', userId);
                                $.ajax({
                                    url: '../../Includes/IT/uploadpdf.php',
                                    dataType: 'text',
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    data: formData,
                                    type: 'POST',
                                    success: function(response){
                                        $('#pdf-content').append(response);
                                        if(parseInt(response) === 1) {
                                           window.location.href = ('../../Includes/IT/useracknowledgement.php?status=complete');

                                        } else {
                                            window.location.href('../../Includes/IT/useracknowledgement.php?status=error');

                                        }
                                    },
                                    complete: function() {

                                    }
                                });
                            });

                        });
                    },
                    error: function () {

                    },
                    complete: function () {

                    }
                });
            }
        });

    }
</script>
