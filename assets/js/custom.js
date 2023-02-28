let ajaxurl = invo_ajax_object.ajax_url;
//let userId = invo_ajax_object.userID;

jQuery(document).on('click', '#inv_registeration', function() {
    
	console.log('222');

	jQuery('#bs_error_message').text('');

	let inv_username = document.getElementById('inv_username').value;
    let inv_email = document.getElementById('inv_email').value;
    let inv_password = document.getElementById('inv_password').value;

/*  console.log('inv_username');
    console.log('inv_email');
    console.log('inv_password');*/

	
	if (inv_username === '' || inv_email === '' || inv_password === '') {

		jQuery('#bs_error_message').text('All above Fields are Required');

	} else {

		if (IsEmail(inv_email) == false) {

			jQuery('#bs_error_message').text('email is not valid');

		} else {

			jQuery('form').append(`<div class="loader"></div>`);
			jQuery("#inv_registeration").attr("disabled", true);
			var form_data = new FormData();
			form_data.append('action', 'inv_registeration_callback');
			form_data.append('inv_username', inv_username); 
			form_data.append('inv_email', inv_email);
			form_data.append('inv_password', inv_password);
	
			jQuery.ajax({
				url: ajaxurl,
				type: 'POST',
				dataType : 'json',
				action: 'inv_registeration_callback',
				contentType: false,
				processData: false,
				data: form_data,
				success: function (response) {

					jQuery('.loader').remove();

					if (response == 'You have registered Successfully') {

						jQuery("form").trigger("reset");

						jQuery('#bs_error_message').text(response);

						setTimeout(function () {

							window.location.replace("https://freesale.org.uk/login/");

						}, 1000);


					} else {

						jQuery("#bs_registeration").removeAttr("disabled");

						jQuery('#bs_error_message').text(response);

					}

				}
			});
		}

	}

});

/* ===== email validation check ==== */

function IsEmail(email) {
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!regex.test(email)) {
		return false;
	} else {
		return true;

	}
}



/* ==== Login script ====*/


jQuery(document).on('click', '#invlogin', function () {

	jQuery('#bs_error_message').text('');

	let bs_email = document.getElementById('bs_email').value;
	let bs_password = document.getElementById('bs_password').value;	
 
    /*console.log(bs_email);
    console.log(bs_password);*/
 
	if (bs_email == '' || bs_password == '') {

		jQuery('#bs_error_message').text('Both Fields are Required');

	} else {

		// jQuery('form').append(`<div class="loader"></div>`);

		jQuery("#invlogin").attr("disabled", true);
		console.log('111');

		jQuery('#bs_error_message').text('Processing');
		var data = {

			'action': 'invs_login_callback',

			'bs_email': bs_email,

			'bs_password': bs_password,

		};

		// Send Ajax Request
				console.log('222');
		jQuery.post(ajaxurl, data, function (response) {

			// jQuery('.loader').remove();

			jQuery('#bs_error_message').text(response);

			jQuery("#invlogin").removeAttr("disabled");

			if (response =='Logged in successfully') {

				setTimeout(function () {

					window.location.replace("http://localhost/wp");

				}, 1000);

			}

		});

		//}

	}

});
	









