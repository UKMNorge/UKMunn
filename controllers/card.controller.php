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
	
$spacePOS = strpos($TWIG['card']['sender'], ' ');
if($spacePOS > 0 )
	$TWIG['card']['sender_firstname'] = substr( $TWIG['card']['sender'], 0, $spacePOS );
else
	$TWIG['card']['sender_firstname'] = $TWIG['card']['sender'];

$TWIG['card']['canonical'] = $TWIG['url']->base . $TWIG['card']['id'] .'-'. $TWIG['card']['url'] .'/';
