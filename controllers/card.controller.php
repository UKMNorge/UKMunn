<?php

$CARD = new SQL("SELECT * FROM `ukm_unn`
				 WHERE `id` = '#id'
				 AND `url` = '#pass'",
				 array('id' => $ID, 'pass' => $PASS));
$CARD->charset();
$res = $CARD->run();

$TWIG['card'] = mysql_fetch_assoc( $res );

foreach( $TWIG['card'] as $key => $val )
	$TWIG['card'][$key] = utf8_encode( $val );
	

$TWIG['card']['canonical'] = $TWIG['url']->base . $TWIG['card']['id'] .'-'. $TWIG['card']['url'] .'/';


$name = explode(' ', $TWIG['card']['sender']);
$ant_names = sizeof($name);
$firstname = array_splice($name, 0, ceil($ant_names/2));
$TWIG['card']['sender_firstname'] = implode($firstname, ' ');