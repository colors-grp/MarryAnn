<table id="header-counter">
    <tr style="height: 85px;">
            <td>
                    <div class="clock-item clock-days countdown-time-value"
                            style="width: 80px;">
                            <div class="wrap">
                                    <div class="inner">
                                            <div id="canvas_days" class="clock-canvas"></div>
                                            <div class="text" style="position: relative; top: 3px;">
                                                    <p class="val">0</p>
                                                    <p class="type-days type-time">DAYS</p>
                                            </div>
                                    </div>
                            </div>
                    </div>
            </td>
            <td style="width: 15px;"></td>
            <td>
                    <div class="clock-item clock-hours countdown-time-value"
                            style="width: 80px;">
                            <div class="wrap">
                                    <div class="inner">
                                            <div id="canvas_hours" class="clock-canvas"></div>
                                            <div class="text" style="position: relative; top: 3px;">
                                                    <p class="val">0</p>
                                                    <p class="type-hours type-time">HOURS</p>
                                            </div>
                                    </div>
                            </div>
                    </div>
            </td>
            <td style="width: 15px;"></td>
            <td>
                    <div class="clock-item clock-minutes countdown-time-value"
                            style="width: 80px;">
                            <div class="wrap">
                                    <div class="inner">
                                            <div id="canvas_minutes" class="clock-canvas"></div>
                                            <div class="text" style="position: relative; top: 3px;">
                                                    <p class="val">0</p>
                                                    <p class="type-minutes type-time">MINUTES</p>
                                            </div>
                                    </div>
                            </div>
                    </div>
            </td>
            <td style="width: 15px;"></td>
            <td id="seconds">
                    <div class="clock-item clock-seconds countdown-time-value"
                            style="width: 80px;">
                            <div class="wrap">
                                    <div class="inner">
                                            <div id="canvas_seconds" class="clock-canvas"></div>
                                            <div class="text" style="position: relative; top: 3px;">
                                                    <p class="val">0</p>
                                                    <p class="type-seconds type-time">SECONDS</p>
                                            </div>
                                    </div>
                            </div>
                    </div>
            </td>
    </tr>
</table>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script type="text/javascript"
        src="http://hitseven.net/SS/h7-assets/resources/js/kinetic.js"></script>
<script type="text/javascript"
        src="http://hitseven.net/SS/h7-assets/resources/js/jquery.final-countdown-home.js"></script>

<link href="http://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet" type="text/css" >
<link type="text/css" rel="stylesheet" href="http://hitseven.net/SS/h7-assets/resources/bootstrap/css/bootstrap-theme.css" >
<link type="text/css" rel="stylesheet" href="http://hitseven.net/SS/h7-assets/resources/bootstrap/css/bootstrap.css" >
<link rel="stylesheet" type="text/css" href="http://hitseven.net/SS/h7-assets/resources/css/demo.css" >

<?php
date_default_timezone_set('Africa/Cairo');
$start_date = new DateTime("2014/05/29 00:00:00");
$now_date = new DateTime(date('Y/m/d H:i:s'));
date_add($now_date, date_interval_create_from_date_string('1 hour'));
$end_date = new DateTime("2014/06/28 23:59:59");
// "-2209078800"
$start_date->format("U");
$end_date->format("U");
$now_date->format("U");
// false
$start_unix = $start_date->getTimestamp();
$end_unix = $end_date->getTimestamp();
$now_unix = $now_date->getTimestamp();
//if ($rounds==FALSE) {$rounds[0]->start_date = $rounds[0]->end_date = $rounds[0]->now = 0;}
?>
<script type="text/javascript">
    $('#header-counter').final_countdown({
        start: <?=$start_unix;?>, 
        end: <?=$end_unix;?>, 
        now: <?=$now_unix;?>});
    //$('#seconds').hide();
</script>