<?php
namespace HomerunnerBilling;

if (!defined('ABSPATH')) {
    exit;
}

/**
 *  User registration form
 */
final class UserRegistration
{
    function __construct()
    {
        add_action('wp_ajax_nopriv_inv_registeration_callback', [$this, 'inv_bill_registeration_form']);
        add_action('wp_ajax_inv_registeration_callback', [$this, 'inv_bill_registeration_form']);
        add_shortcode('inv_user_regsitration_form', [$this, 'inv_user_regsitration']);
    }

    function inv_user_regsitration()
    {
        if (is_user_logged_in()) {
            echo '<h6>You have already login</h6>';
        } else { ?>
            <div class="buyer_seller_reg_form">
                <div class="menus_bs">
                    <h4>Create your account</h4>

                </div>
                <form method="POST" name="user_registeration">
                    <label>Username*</label>
                    <input type="text" name="username" placeholder="Enter Your Username" id="inv_username" required />
                    <br />
                    <label>Email address*</label>
                    <input type="text" name="useremail" id="inv_email" placeholder="Enter Your Email" required />
                    <br />
                    <label>Password*</label>
                    <input type="password" name="password" id="inv_password" placeholder="Enter Your password" required />

                    <br>
                    <input type="button" id="inv_registeration" value="SignUp" />
                </form>
                <span id="bs_error_message" style="color:darkred;"></span>
            </div>
            <?php
        }
    }

    /* ==== user Registration form ===== */
    function inv_bill_registeration_form()
    {
        $inv_username = $_REQUEST['inv_username'];
        $inv_email = $_REQUEST['inv_email'];
        $inv_password = $_REQUEST['inv_password'];
        $exists = email_exists($inv_email);
        if ($exists) {
            echo "That E-mail is already Exist";
        } else {
            $userdata = array(
                'user_pass'     => $inv_password,
                'user_login'    => $inv_username,
                'user_nicename' => $inv_username,
                'user_email'    => $inv_email,
                'role'          => 'subscriber',
            );

            $user_id = wp_insert_user($userdata);

            if (!is_wp_error($user_id)) {
                echo "You have registered Successfully";
            }
        }

        wp_die();
    }
}