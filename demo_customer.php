<?php 
 
if ( ! defined('ABSPATH')) exit;  // if direct access 


 require_once 'vendor/autoload.php';

 add_action('wp_ajax_invb_create_account', 'invb_customer_create_stripe');
 add_action('wp_ajax_nopriv_invb_create_account', 'invb_customer_create_stripe');

function invb_customer_create_stripe() {

/*if (empty($request['myplugin_create_product']) || !wp_verify_nonce($request['myplugin_nonce'], 'myplugin_create_product')) {
        wp_send_json_error(
            array(
                'message' => __('Security check failed. Reload the page and try again.')
            )
        );
    }

    if (! current_user_can('manage_options')) {
        wp_send_json_error(
            array(
                'message' => __('Sorry, you can not perform this action')
            )
        );
    }*/

$stripe = new \Stripe\StripeClient('sk_test_51K1r3dHKcilHec9tGEs1W0FUx6P9IRiyw1i41g9gy0Wv4SpyzO7zjQIzo05NkmzmNWNbPP2ygAkMxzECkSseUeP700DwyCjZOa');

  $stname  = $_POST['stname']; 
  $stemail = $_POST['stemail']; 

    $customer = $stripe->customers->create([
        'name' => $stname,
        'email' => $stemail,
     ]);
     return $customer;
    // do something with $customer
    // ...   
    wp_send_json_success(
        array(
            'message' => __('Customer created.')
        )
    );
}


?>

<?php
 echo '<script type="text/javascript">
           var url = "' . admin_url('admin-ajax.php') . '";
         </script>';
?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"> -->
<script>

jQuery(document).on('click', '#bill_customer', function () { 
	
	let stname = document.getElementById('stname').value;
	let stemail = document.getElementById('stemail').value;

    //alert('sss');

	jQuery.ajax({
		url: url, 
		type: 'POST',
		dataType : 'json',
		data: {
            'action':'invb_create_account', 
            'stname' : stname,
            'stemail' : stemail
        },
        success:function(data) {
        // This outputs the result of the ajax request (The Callback)
        	jQuery("form").trigger("reset");
        	alert('successfully insert');
        },
        error: function(errorThrown){
        	//jQuery("form").trigger("reset");
        	window.alert(errorThrown);
        }

    });

});

</script>

<form method="POST" name="user_registeration" id="user_registeration" > 
    <table width="500"> 
        <tr>
            <td>Name :</td>
            <td> <input type="text" id="stname" name="stname"> <?php echo $_POST['stname']?></td>
        </tr>
        <tr>
            <td>Email : </td>
            <td><input type="email" id="stemail" name="stemail"> <?php echo $_POST['stemail']?> </td>
        </tr>
        <tr>
            <td><input type="button" name="Submit" id="bill_customer" value="Submit" /> </td>
        </tr>

    </table>
</form> 	