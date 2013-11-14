jQuery(document).on('click', '#sendFace', function(){
		window.open('//facebook.com/sharer.php?u='+jQuery('#copyurl').val(), 'FBSHARE', 'width=500,height=300');
});


jQuery(document).on('click', '#cancelMore', function(){
	jQuery('#collectMore').html('').slideUp();
	jQuery('#actionButtons').slideDown();
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
});

function askformore( data ) {
	data.recipient 	= jQuery('#recipient').val();
	data.send_url	= jQuery('#urlID').val();
	t_askformore = Handlebars.compile( jQuery('#handlebars-askformore').html() );
	jQuery('#collectMore').html( t_askformore(data) ).slideDown();
	jQuery('#actionButtons').slideUp();
}