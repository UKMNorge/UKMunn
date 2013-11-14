<?php
$MAXSEND = 5;

$info = explode('-', $_POST['send_url']);
$ID = $info[0];
$PASS = $info[1];

$ERROR = false;

// CHECK IF POPULAR
$SQL = new SQL("SELECT *
				FROM `ukm_unn_send`
				WHERE `send_to` = '#id'",
				array('id' => $_POST['send_to']));
$res = $SQL->run();
if( mysql_num_rows( $res ) >= $MAXSEND ) {
	$ERROR = 'Mottakeren har allerede fått mer enn '.$MAXSEND.' invitasjoner til å delta på UKM';
	$_SESSION['error'] = $ERROR;
}

$SQL = new SQLins('ukm_unn_send');
$SQL->charset();
$SQL->add('unn_id', $ID);
$SQL->add('send_type', $_POST['send_type']);
$SQL->add('send_to', $_POST['send_to']);
$SQL->add('sender_ip', $_SERVER['REMOTE_ADDR']);
$SQL->run();
?>