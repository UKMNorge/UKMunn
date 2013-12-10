<?php
$MAXSEND = 3;

$info = explode('-', $_POST['send_url']);
$ID = $info[0];
$PASS = $info[1];

$ERROR = false;

require_once('card.controller.php');

// CHECK IF POPULAR
$SQL = new SQL("SELECT *
				FROM `ukm_unn_send`
				WHERE `send_to` = '#id'",
				array('id' => $_POST['send_to']));
$res = $SQL->run();
if( mysql_num_rows( $res ) >= $MAXSEND ) {
	$ERROR = $TWIG['card']['recipient']. ' har allerede fått '.$MAXSEND.' invitasjoner til å delta på UKM. '
		   .'For å ikke spamme '. $TWIG['card']['recipient'].' sender systemet maks '. $MAXSEND .' invitasjoner per mottaker';
	$_SESSION['error'] = $ERROR;
} else {
	switch( $_POST['send_type'] ) {

		//// SEND SMS
		case 'sms':
			require_once('UKM/sms.class.php');
			$sms = new SMS('unnukm',1);
			$sms->text('Hei! Noen unner deg en UKM-opplevelse. Se '. $TWIG['card']['canonical'])
				->to($_POST['send_to'])
				->from('UKM')
				->ok();
			break;


		//// SEND E-MAIL
		case 'email':
			require_once('UKM/inc/twig-admin.inc.php');
			require_once('UKM/mail.class.php');

			define('TWIG_PATH', str_replace('controllers','', __DIR__));
			$TWIG['card']['mailmode'] = true;
			$TWIG['card']['url'] = $TWIG['url'];
			if( !empty( $TWIG['card']['message'] ) ) {
				$message = explode(' ', $TWIG['card']['message']);
				$TWIG['card']['message'] = implode(' ', array_splice($message, 0, 8) );
				if( sizeof( $message ) > 8 )
					$TWIG['card']['message'] .= '...';
			}
			$text = TWIGrender('card', $TWIG['card']);
			$mail = new UKMmail();
			$mail->subject('Noen unner deg en UKM-opplevelse!')
				 ->to($_POST['send_to'])
				 ->text($text)
				 ->ok();
			break;
	}
}

$SQL = new SQLins('ukm_unn_send');
$SQL->charset();
$SQL->add('unn_id', $ID);
$SQL->add('send_type', $_POST['send_type']);
$SQL->add('send_to', $_POST['send_to']);
$SQL->add('sender_ip', $_SERVER['REMOTE_ADDR']);
$SQL->run();
?>