<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 1/18/2019
 * Time: 1:09 PM
 */
include('../../Includes/security.php');
try {
    if (isset($_GET["id"]) && isset($_GET["name"]) && isset($_GET['inv_id']) && isset($_GET['serial']) && isset($_GET['dollar']) && isset($_GET['type']) && isset($_GET['request'])) {
        $id = htmlspecialchars($_GET["id"]);
        $name = htmlspecialchars($_GET["name"]);
        $type = htmlspecialchars($_GET["type"]);
        $invId = htmlspecialchars($_GET["inv_id"]);
        $serial = htmlspecialchars($_GET["serial"]);
        $dollar = htmlspecialchars($_GET["dollar"]);
        $userId = htmlspecialchars($_GET["userId"]);
        $request = htmlspecialchars($_GET["request"]);
        $status = null;
    } else {
        if (isset($_GET['status'])) {
            $id = null;
            $name = null;
            $type = null;
            $invId = null;
            $serial = null;
            $dollar = null;
            $userId = null;
            $request = null;
            $status = htmlspecialchars($_GET['status']);
        } else {
            header("location: ../../Controls/IT/inventorymanagement.php");
        }

    }
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}
?>
<head>
    <meta name="viewport" content="width=device-width;
    initial-scale=1; maximum-scale=1; user-scalable=0;"/>
    <title>
        Silicore
    </title>
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
    <style>
        .big-icon {
            font-size: 64px;
        }

        @media (min-width: 992px) {
            .container {
                max-width: 50%;
            }
        }

        .checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            stroke: #7ac142;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .checkmark {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: block;
            stroke-width: 2;
            stroke: #fff;
            stroke-miterlimit: 10;
            margin: 10% auto;
            box-shadow: inset 0px 0px 0px #7ac142;
            animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
        }

        .checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }

        @keyframes stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes scale {
            0%, 100% {
                transform: none;
            }
            50% {
                transform: scale3d(1.1, 1.1, 1);
            }
        }

        @keyframes fill {
            100% {
                box-shadow: inset 0px 0px 0px 30px #7ac142;
            }
        }
        .svg-box {
            display:inline-block;
            position: relative;
            width:150px;
        }
        .yellow-stroke {
            stroke: #FFC107;
        }
        .alert-sign {
            stroke-width:6.25;
            stroke-linecap: round;
            position: absolute;
            top: 40px;
            left: 68px;
            width: 15px;
            height: 70px;
            animation: 0.5s alert-sign-bounce cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .alert-sign .dot {
            stroke:none;
            fill: #FFC107;
        }

        @keyframes alert-sign-bounce {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(0);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
<div class="container pt-4">
    <div class="card">
        <ul class="list-group list-group-flush pdf">
            <li class="list-group-item text-center">
                <img src="../../Images/vprop_logo_minborder.png" style="width:10%;">
                <h4 class="card-title">Asset Acknowledgement</h4>
            </li>
            <li class="list-group-item text-center" id="update">
                <p class="card-text" id="date"></p>
                <p class="card-text text-center">
                    <strong id="name"></strong> understand that <strong id="dollar"></strong> will be deducted from my final paycheck if I do not return the <span id="type"></span> (SN: <span id="serial"></span>) assigned to me within 1 day after termination of employment.
                </p>
            </li>
            <li class="list-group-item content">
                <small>Please acknowledge by signing in box below</small>
                <div class="wrapper">
                    <canvas id="assignee-signature-pad" class="assignee-signature-pad w-100 border border-dark bg-white" height="350px"></canvas>
                </div>
            </li>
            <li class="list-group-item content">
                <strong>IT Services Technician Use Only</strong>
                <small>Please acknowledge by signing in box below</small>
                <div class="wrapper">
                    <canvas id="assigner-signature-pad" class="assigner-signature-pad w-100 border border-dark bg-white" height="350px"></canvas>
                </div>
            </li>
        </ul>

        <div class="card-footer content">
            <button class="btn btn-outline-secondary" id="clear">Clear</button>
            <button class="btn btn-outline-success float-right" id="save-png">Done</button>
        </div>
    </div>
</div>
</body>


<script>
    $(function () {
        let date = new Date();
        let name = "<?php echo $name; ?>";
        let dollar = "<?php echo $dollar; ?>";
        let type = "<?php echo $type; ?>";
        let inventoryId = "<?php echo $invId; ?>";
        let serial = "<?php echo $serial; ?>";
        let request = "<?php echo $request; ?>";
        let userId = "<?php echo $userId ?>";
        let status = "<?php echo $status; ?>";
        if (status !== "") {
            if (status === "complete") {
                $('.content').remove();
                $('.card').append('<div class="text-center"><div class="col-xl-12"><i class="fa fa-check-circle big-icon text-success"></i></div><div class="col-xl-12"><h5>Success</h5>' +
                    '<div class="col-xl-12"><small>Redirecting back to Inventory Management</small></div>');
                window.location.href = '../../Controls/IT/inventorymanagement.php';
                return 1;
            }
            if (status === 'error') {
                $('.content').remove();
                $('.card').append('<div class="text-center"><div class="col-xl-12"><i class="fa fa-times-circle big-icon text-danger"></i></div><div class="col-xl-12"><h5>Error</h5>' +
                    '<div class="col-xl-12"><small>Redirecting back to Inventory Management</small></div>');
                window.location.href = '../../Controls/IT/inventorymanagement.php';
                return 0;
            }
        }
        $('#name').text('I, ' + name + ',');
        $('#dollar').text(dollar);
        $('#serial').text(serial);
        $('#type').text(type);
        $('#date').text(date.toDateString());
        let canvas = document.getElementById('assignee-signature-pad');
        let canvasAssigner = document.getElementById('assigner-signature-pad');

        function resizeCanvas() {
            let ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            canvasAssigner.width = canvasAssigner.offsetWidth * ratio;
            canvasAssigner.height = canvasAssigner.offsetHeight * ratio;
            canvasAssigner.getContext("2d").scale(ratio, ratio);
        }

        //window.onresize = resizeCanvas;
        resizeCanvas();
        let signaturePad = new SignaturePad(canvas, {
            backgroundColor: "rgb(255,255,255)"
        });
        let signaturePad2 = new SignaturePad(canvasAssigner, {
            backgroundColor: "rgb(255,255,255)"
        });
        document.getElementById('save-png').addEventListener('click', function () {
            let img_b64 = signaturePad.toDataURL('image/jpeg');
            let img_b642 = signaturePad2.toDataURL('image/jpeg');
            let blob = dataURItoBlob(img_b64);
            let blob2 = dataURItoBlob(img_b642);
            let img = document.createElement("img");
            let img2 = document.createElement("img");
            img.src = URL.createObjectURL(blob);
            img2.src = URL.createObjectURL(blob2);
            let formData = {};
            formData['id'] = request;
            formData['type'] = type;
            formData['inventoryId'] = inventoryId;
            formData['name'] = name;
            formData['userId'] = userId;
            formData['requestId'] = request;
            formData['assigneeSignature'] = img_b64;
            formData['assignerSignature'] = img_b642;
            let $div = $('#update');
            $.ajax({
                url: '../../Includes/IT/create_acknowledgement_pdf.php',
                data: formData,
                type: 'post',
                beforeSend: function () {
                    $('.content').remove();
                    $div.children().remove();
                    $div.append('<div class="spinner-border text-primary spinner" role="status">\n' +
                        '  <span class="sr-only">Loading...</span>\n' +
                        '</div>');
                },
                success: function (response) {
                    if (parseInt(response) === 1) {
                        $div.children().remove();
                        $div.append('<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">' +
                            '<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>' +
                            '<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>' +
                            '</svg>' +
                            '<br>' +
                            '<h3>Success!</h3>');
                        setTimeout(function () {
                            location.href = '../../Controls/IT/inventorymanagement.php';
                        }, 2500);
                    } else {
                        $div.children().remove();
                        $div.append('<div class="svg-box"> <svg class="circular yellow-stroke"> <circle class="path" cx="75" cy="75" r="50" fill="none" stroke-width="5" stroke-miterlimit="10"/> </svg> <svg class="alert-sign yellow-stroke"> <g transform="matrix(1,0,0,1,-615.516,-257.346)"> <g transform="matrix(0.56541,-0.56541,0.56541,0.56541,93.7153,495.69)"> <path class="line" d="M634.087,300.805L673.361,261.53" fill="none"/> </g> <g transform="matrix(2.27612,-2.46519e-32,0,2.27612,-792.339,-404.147)"> <circle class="dot" cx="621.52" cy="316.126" r="1.318" /> </g> </g> </svg> </div>' +
                            '<br>' +
                            '<h3>Warning!</h3><p>This acknowledgement may have already been signed non-digitally.</p>');
                        setTimeout(function () {
                            location.href = '../../Controls/IT/inventorymanagement.php';
                        }, 2500);
                    }
                }
            });
        });
        document.getElementById('clear').addEventListener('click', function () {
            signaturePad.clear();
            signaturePad2.clear();
        });

    });

    function dataURItoBlob(dataURI) {
        // convert base64/URLEncoded data component to raw binary data held in a string
        var byteString;
        if (dataURI.split(',')[0].indexOf('base64') >= 0)
            byteString = atob(dataURI.split(',')[1]);
        else
            byteString = unescape(dataURI.split(',')[1]);

        // separate out the mime component
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

        // write the bytes of the string to a typed array
        var ia = new Uint8Array(byteString.length);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        return new Blob([ia], {type: mimeString});
    }

</script>