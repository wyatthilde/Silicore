<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/11/2019
 * Time: 10:16 AM
 */

require_once('../../Includes/Security/database.php');
$db = new Database();
$query = 'sp_qc_CoaBySiteAndSampleGet("' . $siteId . '", "' . $sampleId . '")';
$result = json_decode($db->get($query))[0]->result;
$siteCode = substr(basename($_SERVER['PHP_SELF']), 0, 2);
$repeat = 0;
if($result > 0) {
    //ask to rewrite
   $repeat = 1;
}
?>
<title>Certificate of Analysis</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<style>
    .big-checkbox {
        height: 16px;
        width: 16px;
    }
</style>
<div class="container w-25">
    <div class="card mt-5">
        <div class="card-header text-center">
            <h3>Certificate of Analysis</h3>
        </div>
        <div class="card-body">
            <span id="repeatAlert" class="text-danger"></span>
            <div class="form-row">
                <div class="form-group col">
                    <label for="typeSelect">Sample Type</label>
                    <select id="typeSelect" class="form-control">
                        <option value="0">Select sample type</option>
                        <option value="1">-40/+70</option>
                        <option value="2">-50/+140</option>
                        <option value="3">Not Shown</option>
                    </select>
                </div>
            </div>
            <strong>What needs to be included?</strong>
            <div class="form-row">
                <div class="form-group col">
                    <div class="form-check">
                        <input class="form-check-input big-checkbox" type="checkbox" id="productNameCheck">
                        <label class="form-check-label" for="productNameCheck">Product Name</label>
                    </div>
                </div>
            </div>
            <div id="productGroup" class="d-none">
                <div class="form-row">
                    <div class="form-group col">
                        <input class="form-control" id="productNameInput" placeholder="Product name">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <div class="form-check">
                        <input class="form-check-input big-checkbox" type="checkbox" id="rndSphereCheck">
                        <label class="form-check-label" for="rndSphereCheck">Roundness - Sphericity</label>
                    </div>
                </div>
            </div>
            <div id="rndSphereGroup" class="d-none">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="rndInput">Roundness</label>
                        <input id="rndInput" class="form-control" disabled>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="sphereInput">Sphericity</label>
                        <input id="sphereInput" class="form-control" disabled>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <div class="form-check">
                        <input class="form-check-input big-checkbox" type="checkbox" id="densityCheck">
                        <label class="form-check-label" for="densityCheck">Density</label>
                    </div>
                </div>
            </div>
            <div id="densityGroup" class="d-none">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="bulkGramsInput">Bulk</label>
                        <div class="input-group mb-3">
                            <input class="form-control" id="bulkGramsInput">
                            <div class="input-group-append">
                                <span class="input-group-text">g/cm<sup>3</sup></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="bulkLbInput">Bulk</label>
                        <div class="input-group mb-3">
                        <input class="form-control" id="bulkLbInput">
                        <div class="input-group-append">
                            <span class="input-group-text">lb/ft<sup>3</sup></span>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="apparentInput">Apparent</label>
                        <div class="input-group mb-3">
                        <input class="form-control" id="apparentInput">
                        <div class="input-group-append">
                            <span class="input-group-text">g/cm<sup>3</sup></span>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <div class="form-check">
                        <input class="form-check-input big-checkbox" type="checkbox" id="acidCheck">
                        <label class="form-check-label" for="acidCheck">Acid Solubility</label>
                    </div>
                </div>
            </div>
            <div id="acidGroup" class="d-none">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="acidInput">Acid Solubility</label>
                        <input class="form-control" id="acidInput">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col">
                    <div class="form-check">
                        <input class="form-check-input big-checkbox" type="checkbox" id="siltCheck">
                        <label class="form-check-label" for="siltCheck">Silt %</label>
                    </div>
                </div>
            </div>
            <div id="siltGroup" class="d-none">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="siltInput">Silt %</label>
                        <input class="form-control" id="siltInput" disabled>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col">
                    <div class="form-check">
                        <input class="form-check-input big-checkbox" type="checkbox" id="moistureCheck">
                        <label class="form-check-label" for="moistureCheck">Moisture Rate</label>
                    </div>
                </div>
            </div>
            <div id="moistureGroup" class="d-none">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="moistureInput">Moisture Rate %</label>
                        <input class="form-control" id="moistureInput" disabled>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col">
                    <div class="form-check">
                        <input class="form-check-input big-checkbox" type="checkbox" id="turbidityCheck">
                        <label class="form-check-label" for="turbidityCheck">Turbidity</label>
                    </div>
                </div>
            </div>
            <div id="turbidityGroup" class="d-none">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="turbidityInput">Turbidity</label>
                        <input class="form-control" id="turbidityInput" disabled>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <div class="form-check">
                        <input class="form-check-input big-checkbox" type="checkbox" id="crushCheck">
                        <label class="form-check-label" for="crushCheck">Crush Resistance</label>
                    </div>
                </div>
            </div>
            <div id="crushGroup" class="d-none">
                <table class="table" id="crushTable">
                    <thead>
                    <tr>
                        <th>Stress (PSI)</th>
                        <th>% Fines</th>
                    </tr>
                    </thead>
                    <tbody id="crushTableBody">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-success" id="coaSubmit">Submit</button>
        </div>
    </div>
</div>
<script>
    $(function () {
        let formData = {};
        formData['sampleId'] = '<?php echo $sampleId;?>';
        formData['siteId'] = '<?php echo $siteId; ?>';
        let weights = JSON.parse('<?php echo json_encode($weightsObject->vars) ?>');
        let percents = JSON.parse('<?php echo json_encode($percentageObject->vars) ?>');
        let repeatWarning = '<?php echo $repeat; ?>';
        let wArray = {};
        for(let i=1; i < 19; i++) {
            wArray[i] = {
                screenSize: weights['screenSize' + i],
                percent: percents['finalpercent' + i]
            };
        }

        kValuesGet(formData);
        rndSphereGet(formData);
        turbidityGet(formData);
        moistureRateGet(formData);
        siltPercentGet(formData);

        $('#rndSphereCheck').on('click', function () {
            if ($('#rndSphereCheck').is(':checked')) {
                $('#rndSphereGroup').toggleClass('d-block', 'd-none');
            } else {
                $('#rndSphereGroup').toggleClass('d-block', 'd-none');
            }
        });
        $('#productNameCheck').on('click', function () {
            if ($('#productNameCheck').is(':checked')) {
                $('#productGroup').toggleClass('d-block', 'd-none');
            } else {
                $('#productGroup').toggleClass('d-block', 'd-none');
            }
        });
        $('#densityCheck').on('click', function () {
            if ($('#densityCheck').is(':checked')) {
                $('#densityGroup').toggleClass('d-block', 'd-none');
            } else {
                $('#densityGroup').toggleClass('d-block', 'd-none');
            }
        });
        $('#turbidityCheck').on('click', function () {
            if ($('#turbidityCheck').is(':checked')) {
                $('#turbidityGroup').toggleClass('d-block', 'd-none');
            } else {
                $('#turbidityGroup').toggleClass('d-block', 'd-none');
            }
        });
        $('#acidCheck').on('click', function () {
            if ($('#acidCheck').is(':checked')) {
                $('#acidGroup').toggleClass('d-block', 'd-none');
            } else {
                $('#acidGroup').toggleClass('d-block', 'd-none');
            }
        });
        $('#moistureCheck').on('click', function () {
            if ($('#moistureCheck').is(':checked')) {
                $('#moistureGroup').toggleClass('d-block', 'd-none');
            } else {
                $('#moistureGroup').toggleClass('d-block', 'd-none');
            }
        });
        $('#siltCheck').on('click', function () {
            if ($('#siltCheck').is(':checked')) {
                $('#siltGroup').toggleClass('d-block', 'd-none');
            } else {
                $('#siltGroup').toggleClass('d-block', 'd-none');
            }
        });
        $('#crushCheck').on('click', function () {
            if ($('#crushCheck').is(':checked')) {
                $('#crushGroup').toggleClass('d-block', 'd-none');
            } else {
                $('#crushGroup').toggleClass('d-block', 'd-none');
            }

        });
        $('#coaSubmit').on('click', function () {
            if ($('#typeSelect').val() === '0') {
                return false;
            }
            if ($('#rndSphereCheck').is(':checked')) {
                let roundness = $('#rndInput').val();
                let sphericity = $('#sphereInput').val();
                if(!roundness) {
                    return false;
                }
                if(!sphericity) {
                    return false;
                }
                formData['rndSphere'] = JSON.stringify({'roundness': roundness, 'sphericity': sphericity});
            }
            if ($('#densityCheck').is(':checked')) {
                let bulkGrams = $('#bulkGramsInput').val();
                let bulkPounds = $('#bulkLbInput').val();
                let apparentGrams = $('#apparentInput').val();
                if(!bulkGrams) {
                    return false;
                }
                if(!bulkPounds) {
                    return false;
                }
                if(!apparentGrams) {
                    return false;
                }
                formData['density'] = JSON.stringify({'bulkGrams': bulkGrams, 'bulkPounds': bulkPounds, 'apparentGrams': apparentGrams});
            }
            if ($('#acidCheck').is(':checked')) {
                let acid = $('#acidInput').val();
                if(!acid) {
                    return false;
                }
                formData['acid'] = acid;
            }

            if ($('#moistureCheck').is(':checked')) {
                let moistureRate = $('#moistureInput').val();
                if(!moistureRate) {
                    return false;
                }
                formData['moistureRate'] = moistureRate;
            }

            if ($('#siltCheck').is(':checked')) {
                let siltPercent = $('#siltInput').val();
                if(!siltPercent) {
                    return false;
                }
                formData['siltPercent'] = siltPercent;
            }

            if ($('#turbidityCheck').is(':checked')) {
                let turbidity = $('#turbidityInput').val();
                if(!turbidity) {
                    return false;
                }
                formData['turbidity'] = turbidity;
            }
            if ($('#productNameCheck').is(':checked')) {
                let productName = $('#productNameInput').val();
                if(productName === "") {
                    return false;
                }
                formData['productName'] = productName;
            }

            if ($('#crushCheck').is(':checked')) {
                if($('#crushTable').hasClass('single-value')) {
                    formData['kvalues'] = JSON.stringify({'singleDesc': $('#singleDesc').text(), 'singleValue': $('#singleValue').text()});
                } else {
                    formData['kvalues'] = JSON.stringify({'hiDesc': $('#hiDesc').text(), 'hiValue': $('#hiValue').text(), 'loDesc': $('#loDesc').text(), 'loValue': $('#loValue').text()});

                }
            }
            //The values below are always included because a Sieve Analysis is always performed on a COA
            formData['weights'] = '<?php echo json_encode($weightsObject); ?>';
            formData['percentages'] = '<?php echo json_encode($percentageObject); ?>';
            formData['labtech'] = '<?php echo $labTech; ?>';
            formData['userId'] = '<?php echo $_SESSION['user_id']; ?>';
            $.ajax({
                url: '../../Includes/QC/coa_pdf.php',
                data: formData,
                type: 'POST',
                beforeSend: function() {
                    //$('.card-body').empty().append('<div class="text-center"><div class="col-xl-12"><i class="fa fa-check-circle big-icon text-warning"></i></div><div class="col-xl-12"><h5>Processing</h5>');
                },
                success: function(response){
                    let result = parseInt(response);
                    if(result === 1) {
                        $('.card-body').empty().append('<div class="text-center"><div class="col-xl-12"><i class="fa fa-check-circle big-icon text-success"></i></div><div class="col-xl-12"><h5>Success</h5>' +
                            '<div class="col-xl-12"><small>Redirecting to samples</small></div>');
                        window.location.href = '../../Controls/QC/<?php echo $siteCode; ?>_samples.php?view=summary&completionStatus=Incomplete&void=A';
                    } else {
                        $('.card-body').empty().append('<div class="text-center"><div class="col-xl-12"><i class="fa fa-check-circle big-icon text-success"></i></div><div class="col-xl-12"><h5>Error</h5>' +
                            '<div class="col-xl-12"><small>Process error. Reloading.</small></div>');
                        setTimeout(function() {
                            location.reload();
                        }, 5000);

                    }
                }
            });
        });
        $('#typeSelect').on('change', function() {
            let el = $(this);
            let result = 0;
            if (el.val() === '1') {
                $.each(wArray, function(key, value){
                    if(value.screenSize <= 70 && value.screenSize > 40) {
                        result += parseFloat(value.percent);
                    }

                });
                formData['inSize'] = parseFloat(result * 100);
            }
            if (el.val() === '2') {
                $.each(wArray, function(key, value){
                    if(value.screenSize <= 140 && value.screenSize > 50) {
                        result += parseFloat(value.percent);
                    }

                });
                formData['inSize'] = parseFloat(result * 100);
            }
        });
        if(repeatWarning === '1') {
          $('#repeatAlert').text('This COA has been rendered before. By hitting submit, you will be overwriting the existing COA.');
        }
    });

    function kValuesGet(formData) {
        $.ajax({
            url: '../../Includes/QC/gb_k_values_by_sample_id.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                let data = JSON.parse(response);
                if (Object.keys(data).length > 1) {
                    let avgArray = {};
                    let lo = {};
                    let hi = {};
                    $.each(data, function (index, item) {
                        avgArray[index] = ((((item.value / item.entries) / 40) * 100).toFixed(2));
                    });
                    let length = Math.max.apply(null, Object.keys(avgArray));
                    for (let i = 0; i < length; ++i) {
                        if (typeof avgArray[length - i] !== 'undefined') {
                            if (avgArray[length - i] <= 10) {
                                hi[length - i] = avgArray[length - i];
                            } else {
                                lo[length - i] = avgArray[length - i];
                            }
                        }
                    }
                    let hiIdx = Math.max.apply(null, Object.keys(hi));
                    let loIdx = Math.min.apply(null, Object.keys(lo));
                    console.log('Highest passing index: ' + hiIdx, 'Lowest failing index: ' + loIdx);
                    console.log('Highest passing value: ' + avgArray[hiIdx], 'Lowest failing value: ' + avgArray[loIdx]);

                    $('#crushTableBody').append('' +
                        '<tr><td><span id="hiDesc">' + data[hiIdx].desc + '</span></td><td><span id="hiValue">' + avgArray[hiIdx] + '</span></td></tr>' +
                        '<tr><td><span id="loDesc">' + data[loIdx].desc + '</span></td><td><span id="loValue">' + avgArray[loIdx] + '</span></td></tr>' +
                        '');
                } else {
                    $('#crushTable').addClass('single-value');
                    $.each(data, function (index, item) {
                        let array = {};
                        array[index] = ((((item.value / item.entries) / 40) * 100).toFixed(2));
                        let length = Math.max.apply(null, Object.keys(array));
                        for (let i = 0; i < length; ++i) {
                            if (typeof array[length - i] !== 'undefined') {
                                    $('#crushTableBody').append('' +
                                        '<tr><td><span id="singleDesc">' + data[length-i].desc + '</span></td><td><span id="singleValue">' + array[length-i] + '</span></td></tr>' +
                                        '');

                            }
                        }
                    });
                }

            }
        });
    }

    Array.max = function(array){
        return Math.max.apply(Math, array);
    };

    function turbidityGet(formData) {
        $.ajax({
            url: '../../Includes/QC/gb_turbidity_get.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                let data = JSON.parse(response)[0];
                $('#turbidityInput').val(data.turbidity);

            }
        });
    }

    function rndSphereGet(formData) {
        $.ajax({
            url: '../../Includes/QC/gb_roundness_sphericity_get.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                let data = JSON.parse(response)[0];
                $('#rndInput').val(data.roundness);
                $('#sphereInput').val(data.sphericity);
            }
        });
    }

    function moistureRateGet(formData) {
        $.ajax({
            url: '../../Includes/QC/gb_moisture_rate_get.php',
            type: 'POST',
            data: formData,
            success: function (response) {
              let data = JSON.parse(response)[0];
                $('#moistureInput').val(data.moisture_rate * 100);
            }
        });
    }

    function siltPercentGet(formData) {
        $.ajax({
            url: '../../Includes/QC/gb_silt_percent_get.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                let data = JSON.parse(response)[0];
                $('#siltInput').val(data.silt_percent);
            }
        });
    }
</script>