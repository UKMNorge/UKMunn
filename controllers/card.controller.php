<?php

$CARD = new SQL("SELECT * FROM `ukm_unn`
				 WHERE `id` = '#id'
				 AND `url` = '#pass'",
				 array('id' => $ID, 'pass' => $PASS));
$CARD->charset();
$res = $CARD->run();

$TWIG['card'] = mysql_fetch_assoc( $res );