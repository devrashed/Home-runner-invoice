<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 *  User Login form
 */
final class userlogin
{

    function __construct()
    {

        add_action('wp_ajax_invs_login_callback', [$this, 'inv_login_callback']);

        add_action('wp_ajax_nopriv_invs_login_callback', [$this, 'inv_login_callback']);

        add_shortcode('inv_user_login_form', [$this, 'inv_user_login']);

        ///add_action('init', [$this,'custom_login']);

    }


    function inv_user_login()
    {

        if (is_user_logged_in()) {
            echo '<div class="login_page_messg"><h6><a href="' . wp_logout_url() . '">Logout</a></h6></div>';
        } else { ?>
            <div class="buyer_seller_reg_form" id="login_form_page">
                <form method="POST">
                    <span class="login100-form-title">
                        Sign In
                    </span>
                    <div>
                        <input type="email" name="bs_email" id="bs_email" placeholder="email">
                        <input type="password" name="bs_password" id="bs_password" placeholder="password">
                        <input type="button" name="submit" value="login" id="invlogin">
                    </div>
                    <span id="bs_error_message"></span>
                </form>
            </div>

            <?php
        }
    }



    //========== Login Form =========

    function inv_login_callback()
    {

        /* echo $_POST['bs_email'];  
        echo $_POST['bs_password'];*/

        $bs_email = $_POST['bs_email'];
        $bs_password = $_POST['bs_password'];
        $exists = email_exists($bs_email);
        $bs_username = username_exists($bs_email);
        //var_dump(expression)
        /*var_dump($bs_email);*/


        if ($exists || $bs_username) {
            if ($exists) {
                $user = get_user_by('email', $bs_email);
            }
            if ($bs_username) {
                $user = get_user_by('login', $bs_email);
            }

            ///$infouser=get_user_by('login', $user->user_login);   
            $useractive = get_user_meta($user->ID, 'account_activated', true);

            if ($useractive === '0') {

                // $user = get_user_by( 'email', $bs_email );
                if ($user && wp_check_password($bs_password, $user
                    ->data->user_pass, $user->ID)) {
                    //echo "Login Successfully";
                    $user_login = $user
                        ->data->user_login;
                    // print_r($user_login);
                    // die('dfs');
                    wp_clear_auth_cookie();
                    wp_set_current_user($user->ID); // Set the current user detail
                    wp_set_auth_cookie($user->ID); // Set auth details in cookie
                    echo "Logged in successfully";
                    wp_redirect(home_url());

                } else {
                    echo "Password Not Matched";
                }

            } else {
                echo "Please check your email and verify your account";
            }

        } else {
            echo "User Not Exists";
        }
        wp_die();


        /*if (isset($_POST['email']) && isset($_POST['password'])) {
        $user = wp_signon(array(
        'user_email' => $_POST['email'],
        'user_password' => $_POST['password'],
        ));
        if (is_wp_error($user)) {
        // Handle login error
        } else {
        wp_redirect(home_url());
        exit;
        }
        }*/

    }




} /*end the class*/