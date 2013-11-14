<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('vendor/autoload.php');
require_once('UKM/sql.class.php');


$app = new Silex\Application(); 
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));


$url = new StdClass;
$url->base 		= 'http://unn.ukm.local/';
$url->create 	= $url->base.'/';
$url->send 		= $url->base.'send/';
$url->sent		= $url->base.'sendt/';
$url->print		= $url->base.'print/';


$TWIG = array('url' => $url);

$app->get('/', function() use($app, $TWIG) {
	require_once('controllers/invite.controller.php');	
	return $app['twig']->render( 'invite.twig.html', $TWIG );
}); 

$app->post('/', function() use($app, $TWIG) {

	if( sizeof( $_POST ) == 0 )
        return $app->redirect('/');

	require_once('controllers/create.controller.php');	
	$HTML = $app['twig']->render( 'send.twig.html', $TWIG );
	$HTML .= HANDLEBARS( dirname(__FILE__) );
	return $HTML;
}); 




$app->post('/send/', function() use($app, $TWIG) {
	require_once('controllers/send.controller.php');
	if(!$ERROR)
		return $app->redirect('/sendt/'.$ID.'-'.$PASS.'/');
	return $app->redirect('/ikke_sendt/'. $ID.'-'.$PASS.'/');
});

$app->get('/sendt/{ID}-{PASS}/', function($ID, $PASS) use($app, $TWIG) {
	require_once('controllers/card.controller.php');	
	return $app['twig']->render( 'sent.twig.html', $TWIG );
});
$app->get('/ikke_sendt/{ID}-{PASS}/', function($ID, $PASS) use($app, $TWIG) {
	require_once('controllers/card.controller.php');
	$TWIG['error'] = $_SESSION['error'];
	return $app['twig']->render( 'not_sent.twig.html', $TWIG );
});



$app->get('/{ID}-{PASS}/', function($ID, $PASS) use($app, $TWIG) {
	require_once('controllers/card.controller.php');	
	return $app['twig']->render( 'recipient.twig.html', $TWIG );
}); 
$app->get('/print/{ID}-{PASS}/', function($ID, $PASS) use($app, $TWIG) {
	require_once('controllers/card.controller.php');	
	return $app['twig']->render( 'printcard.twig.html', $TWIG );
}); 


$app->run(); 
?>