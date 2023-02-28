let ajaxurl = admin_ajax_object.ajax-url;

/*==== Create Customer =======*/   

jQuery(document).on('click', '#invcustomer', function () { 

	alert('sss');
	
	var cname = document.getElementById('cname').value;
	var cemail = document.getElementById('cemail').value;
	console.log('111');

	jQuery.ajax({
		url: ajaxurl, 
		type: 'POST',
		dataType : 'json',
		data: {
            'action':'inv_create_product', 
            'cname' : cname,
            'cemail' : cemail
        },
        success:function(data) {
        // This outputs the result of the ajax request (The Callback)

        	window.alert(data);
        },
        error: function(errorThrown){
        	window.alert(errorThrown);
        }

    });

});
