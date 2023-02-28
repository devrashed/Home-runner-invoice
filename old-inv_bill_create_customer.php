<?php 
if ( ! defined('ABSPATH')) exit;  // if direct access 

/**
 *  Customer create page
*/


require_once 'vendor/autoload.php';

class inv_customercreate{

   function __construct(){

     add_action('wp_ajax_inv_create_product', [$this,'inv_customer_create_stripe']);
     add_action('wp_ajax_nopriv_inv_create_product', [$this,'inv_customer_create_stripe']);

     //add_shortcode('show_form', [$this,'inv_stripe_form'])   
   }


function inv_customer_create_stripe() {
    
    $stripe = new \Stripe\StripeClient('sk_test_51K1r3dHKcilHec9tGEs1W0FUx6P9IRiyw1i41g9gy0Wv4SpyzO7zjQIzo05NkmzmNWNbPP2ygAkMxzECkSseUeP700DwyCjZOa');

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

//    $data = $_POST['data'];
   
    
    $customer = $stripe->customers->create([
        'name' => $_POST['stemail'],
        'email' =>$_POST['stname']
     ]);
    
    // do something with $customer
    // ...
    
    wp_send_json_success(
        array(
            'message' => __('Customer created.')
        )
    );
}



 function inv_stripe_form(){

$options = get_option('inv_setting_option_name', array() );
$options['apikey'];

?>
<form method="POST" name="user_registeration" id="user_registeration" > 
    <table width="500"> 
        <tr>
            <td>Name :</td>
            <td> <input type="text" id="stname" name="stname"> </td>
        </tr>
        <tr>
            <td>Email : </td>
            <td><input type="email" id="stemail" name="stemail"> 
             
            </td>
        </tr>
        <tr>
            <td><input type="button" name="Submit" id="invcustomer" value="Submit" /> 

            </td>
        </tr>  
    </table>
</form>    

<?php 
    } 

 } /*end the class*/
?>