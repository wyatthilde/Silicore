<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 1/14/2019
 * Time: 2:05 PM
 */

?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.6.4/jquery.timeago.js"></script>
<style>
    .outer-wrapper {
        margin: 5px 15px;
        min-width: 85px;
    }

    .column-wrapper {
        height: 190px;
        width: 50px;
        background: #CFD8DC;
        transform: rotate(180deg);
        margin: 0 auto;
    }

    .column-silo1 {
        position: relative;
        display: block;
        bottom: 0;
        width: 50px;
        height: 0%;
        background: #90A4AE;
    }

    .percentage-silo1 {
        margin-top: 18px;
        /*padding: 20px 20px;*/
        position: relative;
        border-radius: 4px;
        text-align: center;
        font-size: 100%;
        min-width: 50%;
    }

    .column-silo2 {
        position: relative;
        display: block;
        bottom: 0;
        width: 50px;
        height: 0%;
        background: #90A4AE;
    }

    .percentage-silo2 {
        margin-top: 18px;
        /*padding: 20px 20px;*/
        position: relative;
        border-radius: 4px;
        text-align: center;
        font-size: 100%;
        min-width: 50%;

    }

    .column-silo6 {
        position: relative;
        display: block;
        bottom: 0;
        width: 50px;
        height: 0%;
        background: #90A4AE;
    }

    .percentage-silo6 {
        margin-top: 18px;
        /*padding: 20px 20px;*/
        position: relative;
        border-radius: 4px;
        text-align: center;
        font-size: 100%;
        min-width: 50%;
    }

    .column-silo7 {
        position: relative;
        display: block;
        bottom: 0;
        width: 50px;
        height: 0%;
        background: #90A4AE;
    }

    .percentage-silo7 {
        margin-top: 18px;
        /*padding: 20px 20px;*/
        position: relative;
        border-radius: 4px;
        text-align: center;
        font-size: 100%;
        min-width: 50%;
    }

    .column-silo8 {
        position: relative;
        display: block;
        bottom: 0;
        width: 50px;
        height: 0%;
        background: #90A4AE;
    }

    .percentage-silo8 {
        margin-top: 18px;
        /*padding: 20px 20px;*/
        position: relative;
        border-radius: 4px;
        text-align: center;
        font-size: 100%;
        min-width: 50%;
    }

    .column-silo9 {
        position: relative;
        display: block;
        bottom: 0;
        width: 50px;
        height: 0%;
        background: #90A4AE;
    }

    .percentage-silo9 {
        margin-top: 18px;
        /*padding: 20px 20px;*/
        position: relative;
        border-radius: 4px;
        text-align: center;
        font-size: 100%;
        min-width: 50%;
    }

    .top {
        height: 50px;
        width: 100px;
        /* border-top-left-radius: 100px;
         border-top-right-radius: 100px;*/
        background-color: white;
        margin: 0 auto;
    }

    .square {
        height: 200px;
        width: 100px;
        background-color: white;
        margin: 0 auto;
    }

    .trending-chart text {
        fill: white;
    }


</style>

<div class="container pl-0 pr-0">
    <div class="card-group">
    </div>
    <div class="card mt-4 bg-secondary text-white mb-4 text-center">
        <div class="card-header">
            <h4>Trends</h4>
            <div class="badge badge-light">Updated <span class="refresh"></span></div>
        </div>
        <div class="card-body card-chart">
            <div id="silos-trending" class="trending-chart" style="height:400px"></div>
        </div>
    </div>
</div>
<script>

    $(function () {
        let time = "<?php echo date(DATE_ISO8601); ?>";
        $('.refresh').text($.timeago(time));
        generateSilos();
        updateSilos();
        updateChart();
        setInterval(function () {
            let timeDisplay = $.timeago(time);
            $('.refresh').text(timeDisplay);
            console.log('1 minute update');
        }, 60000);
        setTimeout(function () {
            time = new Date();
            updateSilos();
            updateChart();
            $('.refresh').text(time);
            console.log('10 minute refresh');

        }, 600000);
    });

    function generateSilos() {
        let siloArray = [1, 2, 6, 7, 8, 9];
        siloArray.forEach(function (silo) {
            let cardStart = '<div class="card mb-3 bg-secondary text-white text-center">';
            let cardHeader = '<div class="card-header"><h4>Silo ' + silo + '</h4></div>';
            let cardBody = '';
            if (silo === 1) {
                cardBody = '<div class="card-body"><div class="outer-wrapper"><div class="top"><div class="badge badge-secondary display-5 percentage-silo' + silo + ' rounded-0 bg-primary">--</div></div>';
            }
            if (silo === 2) {
                cardBody = '<div class="card-body"><div class="outer-wrapper"><div class="top"><div class="badge badge-secondary display-5 percentage-silo' + silo + ' rounded-0 bg-secondary">--</div></div>';
            }
            if (silo === 6) {
                cardBody = '<div class="card-body"><div class="outer-wrapper"><div class="top"><div class="badge badge-secondary display-5 percentage-silo' + silo + ' rounded-0 bg-success">--</div></div>';
            }
            if (silo === 7) {
                cardBody = '<div class="card-body"><div class="outer-wrapper"><div class="top"><div class="badge badge-secondary display-5 percentage-silo' + silo + ' rounded-0 bg-info">--</div></div>';
            }
            if (silo === 8) {
                cardBody = '<div class="card-body"><div class="outer-wrapper"><div class="top"><div class="badge badge-secondary display-5 percentage-silo' + silo + ' rounded-0 bg-warning">--</div></div>';
            }
            if (silo === 9) {
                cardBody = '<div class="card-body"><div class="outer-wrapper"><div class="top"><div class="badge badge-secondary display-5 percentage-silo' + silo + ' rounded-0 bg-danger">--</div></div>';
            }

            let cardContent = '<div class="square"><div class="column-wrapper"><div class="column-silo' + silo + '"></div></div></div></div></div>';
            let cardFooter = '<div class="card-footer"><div><strong class="tons-silo' + silo + '"></strong></div></div></div>';
            $('.card-group').append(cardStart + cardHeader + cardBody + cardContent + cardFooter);
        });

    }

    function updateSilos() {
        let siloArray = [1, 2, 6, 7, 8, 9];
        siloArray.forEach(function (silo) {
            $.ajax({
                url: '../../Includes/Production/silo' + silo + '_get.php',
                dataSrc: '',
                success: function (response) {
                    let data = JSON.parse(response);

                    let $cardDeck = $('.card-group');

                    let reading = data[0].value;

                    let color = '#c2b280';

                    if (reading >= 90) {
                        //color = '#FFEB3B';
                    }
                    else if (reading < 90 && reading >= 60) {
                        //color = '#FFEB3B';
                    }
                    else if (reading < 60 && reading >= 20) {
                        //color = '#00E676';
                    }
                    else if (reading < 20 && reading >= 10) {
                        //color = '#FF3D00';
                    }
                    else if (reading < 10 && reading >= 0) {
                        //color = '#FF3D00';
                    }

                    $cardDeck.find('.column-silo' + silo).css({
                        background: color
                    });


                    if (reading > 99) {
                        $cardDeck.find('.percentage-silo' + silo).text('100%');
                        $cardDeck.find('.column-silo' + silo).animate({
                            height: '100%',
                        });
                    } else {
                        $cardDeck.find('.percentage-silo' + silo).text(Math.round(reading) + '%');
                        $cardDeck.find('.column-silo' + silo).animate({
                            height: reading + '%',
                        });
                    }
                    if (silo === 1) {
                        $cardDeck.find('.tons-silo' + silo).text(((reading / 100) * 250).toFixed(3) + ' tons');

                    } else if (silo === 2) {
                        $cardDeck.find('.tons-silo' + silo).text(((reading / 100) * 1000).toFixed(3) + ' tons');
                    } else {
                        $cardDeck.find('.tons-silo' + silo).text(((reading / 100) * 1500).toFixed(3) + ' tons');

                    }
                }
            });
        });
    }

    function updateChart() {
        let $silos = $('#silos-trending');
        let date = new Date();
        $silos.children().remove();
        $('.card-chart').append('<div class="spinner-border" role="status">\n' +
            '  <span class="sr-only">Loading...</span>\n' +
            '</div>');
        let data = [];
        $.ajax({
            url: '../../Includes/Production/silo_get_all.php',
            dataSrc: '',
            success: function (response) {
                let responseData = JSON.parse(response);
                $.each(responseData, function (key, value) {
                    data.push({"timestamp": value.timestamp, "value1": value.silo1_val, "value2": value.silo2_val, "value6": value.silo6_val, "value7": value.silo7_val, "value8": value.silo8_val, "value9": value.silo9_val});
                });
                let config = ({
                    element: 'silos-trending',
                    data: data,
                    xkey: 'timestamp',
                    ykeys: ['value1', 'value2', 'value6', 'value7', 'value8', 'value9'],
                    labels: ['Silo 1', 'Silo 2', 'Silo 6', 'Silo 7', 'Silo 8', 'Silo 9'],
                    fillOpacity: 0.9,
                    postUnits: '%',
                    pointSize: 3,
                    lineWidth: 2,
                    resize: 'true',
                    gridTextWeight: '700',
                    hideHover: 'auto',
                    behaveLikeLine: true,
                });
                config.element = 'silos-trending';
                $('.card-chart').find('.spinner-border').remove();
                Morris.Line(config);
                $('')
            }
        });
    }
</script>