(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $( window ).load(function() {
	 	$('#mingrana_register').click(function(e) {
	 		console.log("Registrar BC");
	 		e.preventDefault();
	 		var rconf = confirm("Do you want to registrer this POST?");

	 		if ( rconf == true ) {

	 			var post_id = $(this).attr('value');
		 		$.ajax({
	                type: "GET",
	                url: "admin-ajax.php", 
	                dataType: 'text',
	                data: ({ action: 'send_form', id: post_id}),
	                success: function(data){
	                       console.log(data);
	                       var json_data = $.parseJSON(data);
	                       if (json_data['result'] == 'error') {
	                       	 alert(json_data['message']);
	                       } else {
	                       	 alert(json_data['message']);
	                       	 $('#mingrana_register').hide();
	                       	 $('#mingrana_status').html(json_data['status']);
	                       	 $('#mingrana_pdf').html(json_data['file']);
	                       	 $('#mingrana_hash').html(json_data['hash']);
	                       }
	                },
	                error: function(data)  
	                {  
	                			alert("Error sending!");
	                return false;
	                }  

	            }); 

	 		} else {

	 			console.log("cancelado");

	 		}

	 		
	 		
	 		
	 		
	 	});

	 	$('#mingrana_send').click(function(e) {
	 		console.log("Sending Mingrana");
	 		e.preventDefault();
	 		var post_id = $(this).attr('value');
	 		$.ajax({
                type: "GET",
                url: "admin-ajax.php", 
                dataType: 'html',
                data: ({ action: 'send_mingrana', id: post_id}),
                success: function(data){
                          console.log(data);
                },
                error: function(data)  
                {  
                			alert("Error!");
                return false;
                }  

            }); 
	 		
	 		
	 	});


	  });

})( jQuery );
