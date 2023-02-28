<?php 

add_shortcode('inv_user_login_form', 'inv_user_login'); 
 add_action('wp_ajax_inv_login_callback', 'inv_login_callback');

 add_action('wp_ajax_nopriv_inv_login_callback', 'inv_login_callback');

    

function inv_user_login(){

	if ( is_user_logged_in() ) { 
		echo '<div class="login_page_messg"><h6><a href="'.wp_logout_url().'">Logout</a></h6></div>';
	} else { ?>
		<div class="buyer_seller_reg_form" id="login_form_page">
      <form>
         <span class="login100-form-title">
            Sign In
        </span>
        <div>
            <input type="email" name="email" id="invemail" placeholder="emails">
            <input type="password" name="password" id="invpassword" placeholder="password">
            <input type="button" name="submit" value="login" id="invlogin">
        </div>
        <span id="bs_error_message"></span>
    </form>
</div>

		<?php 
	} 
}





function inv_login_callback() {

    var_dump($_POST['invemail']);

    $bs_email    = $_POST['invemail'];
    $bs_password = $_POST['invpassword'];
   /* var_dump( $bs_email);
    var_dump( $bs_password );*/
    //exit();
    $exists      = email_exists($bs_email);
    $bs_username = username_exists($bs_email);
    //var_dump(expression)

    if ($exists || $bs_username) {
        if ($exists) {
            $user        = get_user_by('email', $bs_email);
        }
        if ($bs_username) {
            $user        = get_user_by('login', $bs_email);
        }

        ///$infouser=get_user_by('login', $user->user_login);   
        $useractive=get_user_meta($user->ID,'account_activated',true);
     
        if($useractive === '1'){

            // $user = get_user_by( 'email', $bs_email );
            if ($user && wp_check_password($bs_password, $user
                ->data->user_pass, $user->ID)) {
                //echo "Login Successfully";
                $user_login  = $user
                    ->data->user_login;
                // print_r($user_login);
                // die('dfs');
                wp_clear_auth_cookie();
                wp_set_current_user($user->ID); // Set the current user detail
                wp_set_auth_cookie($user->ID); // Set auth details in cookie
                echo "Logged in successfully";
                // wp_redirect(home_url());
                
            }
            else {
                echo "Password Not Matched";
            }            
            
        }else{
            echo "Please check your email and verify your account";
        }   
        
    }
    else {
        echo "User Not Exists";
    }
    wp_die();
 

 }

 echo '<script type="text/javascript">
           var ajax_url = "' . admin_url('admin-ajax.php') . '";
         </script>';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">

<script type="text/javascript">

var $ = jQuery.noConflict();

$( document ).ready(function() {
jQuery(document).on('click', '#invlogin', function () {

	jQuery('#bs_error_message').text('');

	let bs_email = document.getElementById('invemail').value;
	let bs_password = document.getElementById('invpassword').value;	
 
   /* console.log(bs_email);
    console.log(bs_password);*/
 
	if (bs_email == '' || bs_password == '') {

		jQuery('#bs_error_message').text('Both Fields are Required');

	} else {

		// jQuery('form').append(`<div class="loader"></div>`);

		jQuery("#invlogin").attr("disabled", true);
		//console.log('111');

		jQuery('#bs_error_message').text('Processing');
		var data = {
			
			'action': 'inv_login_callback',

			'bs_email': bs_email,

			'bs_password': bs_password,

		};

		// Send Ajax Request

		jQuery.post(ajax_url, data, function (response) {

			// jQuery('.loader').remove();

			jQuery('#bs_error_message').text(response);

			jQuery("#invlogin").removeAttr("disabled");

			if (response == 'Logged in successfully') {

				setTimeout(function () {

					window.location.replace("http://localhost/wp");

				}, 1000);

			}

		});
	//}
  	}
   })
});
</script>	