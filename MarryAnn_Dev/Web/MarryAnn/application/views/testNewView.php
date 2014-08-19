<<html>
    <title>
        <script type="text/javascript"
		src="http://hitseven.net/SS/h7-assets/resources/js/kinetic.js"></script>
	<script type="text/javascript"
		src="http://hitseven.net/SS/h7-assets/resources/js/jquery.final-countdown-home.js"></script>
         <?php 
            $date = date('Y-m-d H:i:s');
            //$date = new DateTime("1899-12-31");
            // "-2209078800"
            $date->format("U");
            // false
            $unix = $date->getTimestamp();    
         //if ($rounds==FALSE) {$rounds[0]->start_date = $rounds[0]->end_date = $rounds[0]->now = 0;}
            /*
         ?>
            //$('.countdown').final_countdown({start: <?=$rounds[0]->start_date;?>, end: <?=$rounds[0]->end_date;?>, now: <?=$rounds[0]->now; */ ?>});
    </title>
    <body>
        <?="now now date=".$date.'</br>';?>
        <?="now unix=".$unix;?>
    </body>
</html>