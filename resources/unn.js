jQuery(document).on('click', '#sendFace', function(){
	window.open('//facebook.com/sharer.php?u='+jQuery('#copyurl').val(), 'FBSHARE', 'width=500,height=300');
	thankyou( 'facebook' );
	log('facebook');
});

jQuery(document).on('click', '#sendManual', function(){
	jQuery('#sendUrlContainer').slideDown();
	jQuery('#actionButtons').slideUp();
	log('manual');
});

jQuery(document).on('click', '#cancelMore, #cancelThankYou', function(){
	jQuery('#collectMore').html('').slideUp();
	jQuery('#actionButtons').slideDown();
	jQuery('#sendUrlContainer').slideUp();
	jQuery('#thankyou').slideUp();
});


jQuery(document).on('click', '#sendSMS', function(){
  askformore( {'askfor': 'mobilnummeret',
  			   'askfor_type': 'tel',
  			   'action': 'Send SMS',
 			   'method': 'sms'
  			   } );
});

jQuery(document).on('click', '#sendMail', function(){
  askformore( {'askfor': 'e-postadressen',
  			   'askfor_type': 'email',
  			   'action': 'Send e-post',
  			   'method': 'email'
  			   } );
});

jQuery(document).on('click', '#sendPrint', function(){
	window.open(jQuery('#printurl').val(), 'PRINT', 'width=800,height=400');	
	thankyou( 'utskrift' );
	log('print');
});

function askformore( data ) {
	data.recipient 	= jQuery('#recipient').val();
	data.send_url	= jQuery('#urlID').val();
	t_askformore = Handlebars.compile( jQuery('#handlebars-askformore').html() );
	jQuery('#collectMore').html( t_askformore(data) ).slideDown();
	jQuery('#actionButtons').slideUp();
}

function thankyou( sendMethod ) {
	var data = {};
	data.recipient 	= jQuery('#recipient').val();
	data.method 	= sendMethod;

	t_thankyou		= Handlebars.compile( jQuery('#handlebars-thankyou').html() );
	jQuery('#thankyou').html( t_thankyou( data ) ).slideDown();
	jQuery('#actionButtons').slideUp();

}
jQuery(document).on('click','#cookies_toggle', function(){
    if(jQuery(this).attr('data-action') == 'show') {
        jQuery( jQuery(this).attr('data-toggle') ).slideDown();
        jQuery(this).attr('data-action', 'hide');
    } else {
        jQuery(this).attr('data-action', 'show');
        jQuery( jQuery(this).attr('data-toggle') ).slideUp();
    }
});
jQuery(document).on('click','#cookies_hide', function(){
    if(jQuery(this).attr('data-action') == 'show') {
        jQuery( jQuery(this).attr('data-toggle') ).slideDown();
        jQuery(this).attr('data-action', 'hide');
    } else {
        jQuery(this).attr('data-action', 'show');
        jQuery( jQuery(this).attr('data-toggle') ).slideUp();
    }
});

function log( method ) {
	jQuery.post('/log/' + jQuery('#cardID').val() + '/', 
				{'send_type': method},
				function(){});
}