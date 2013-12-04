<?php
require_once('UKM/inc/password.inc.php');
require_once('UKM/inc/handlebars.inc.php');

$TWIG = array_merge($TWIG, $_POST);

$password = UKM_ordpass();

$password = md5( rand(0,100) . $password . rand(100, 10000) );
$password = substr($password, strlen( $password ) - 5 );

$SQL = new SQLins('ukm_unn');
$SQL->charset();
$SQL->add('recipient', $_POST['recipient']);
$SQL->add('sender', $_POST['sender']);
$SQL->add('category', $_POST['category']);
$SQL->add('message', $_POST['message']);
$SQL->add('url', $password);
$res = $SQL->run();

$ID = $SQL->insid();

$TWIG['invite'] = new StdClass;
$TWIG['invite']->id = $ID;
$TWIG['invite']->pass = $password;
$TWIG['invite']->urlID = $TWIG['invite']->id .'-'. $TWIG['invite']->pass;


$spacePOS = strpos($TWIG['sender'], ' ');
if($spacePOS > 0 )
	$TWIG['sender_firstname'] = substr( $TWIG['sender'], 0, $spacePOS );
else
	$TWIG['sender_firstname'] = $TWIG['sender'];
