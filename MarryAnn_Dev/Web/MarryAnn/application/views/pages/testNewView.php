<html>
    <body>
        <p>
            Total Users:  <?=$total_players[0];?>
            <br>
            All Categories:<br>
            Users with No Score Anywhere:  <?=$ddntPlayCount[0];?>  (0 score in the 4 Categories)<br>
            Users with scores in all categories: <?=$played[0];?> (>0 in the 4 categories)<br>
            <br>
            <br>
            <br>
            <?php
                for($i=1;$i<5;$i++){
                    echo $cat_names[$i].':<br>';
                    echo 'All Users:    ' . $total_players[$i].'<br>';
                    echo 'Users with No Score: 			'.$ddntPlayCount[$i].'<br>';
                    echo 'Users with Scores:				'.$played[$i].'<br>';
                    echo 'Average user score for players:		'.$avg_score[$i].'<br><br><br><br>';
                }
            ?>
        </p>
    </body>
</html>