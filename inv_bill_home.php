<?php
/**
 * Plugin Name: Homerunner Invoicing
 * Description: Homerunner Invoicing
 * Plugin URI: https://hudsoncreative.com/
 * Author: Rashed khan
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html 
 */

if (!defined('ABSPATH')) {
   exit;
}

final class invintegrate
{

   const version = '1.0';

   function __construct()
   {
      $this->invintegrate_define_constants(); //define asstes

      register_activation_hook(invINTEGARTE_ASSETS_FILE, [$this, 'invintegrate_assets_activate']); // plugin activation

      add_action('plugins_loaded', [$this, 'invintegrate_assets_init_plugin']); // load plugin

      add_action('wp_enqueue_scripts', [$this, 'inv_register_assets']);

      //add_action('admin_enqueue_scripts', [$this, 'admin_inv_register_assets']);
   }

   function inv_register_assets()
   {
      wp_enqueue_script('jquery');
      /* wp_enqueue_script( 'ChosenJs' , plugins_url('/assets/js/chosen.jquery.min.js' , __FILE__ ) , array('jquery'), '1.0.0', false);*/
      wp_enqueue_script('jQuery-min', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', 0.122, true);

      wp_enqueue_script('inv_custom', plugins_url('assets/js/custom.js', __FILE__), array('jquery'), 0.3, false);

      wp_localize_script('inv_custom', 'invo_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

   }

   /* function admin_inv_register_assets(){
   wp_enqueue_script( 'ChosenJs' , plugins_url('/assets/js/chosen.jquery.min.js' , __FILE__ ) , array('jquery'), '1.0.0', false);
   wp_enqueue_script( 'admin_custom', plugins_url( 'assets/js/admin_custom.js', __FILE__ ), array( 'jquery' ), 0.3,false );
   wp_localize_script( 'admin_custom', 'admin_ajax_object', array( 'ajax-url' => admin_url( 'admin-ajax.php' ) ) );
   
   }*/


   /**
    * Define the required plugin constants
    *
    * @return void
    */
   public function invintegrate_define_constants()
   {
      define('invINTEGRATE_ASSETS_VERSION', self::version);
      define('invINTEGARTE_ASSETS_FILE', __FILE__);
      define('invINTEGARTE_ASSETS_PATH', __DIR__);
      define('invINTEGARTE_ASSETS_URL', plugin_dir_url(__FILE__));
   }

   public function invintegrate_assets_init_plugin()
   {
      require_once 'vendor/autoload.php';
      require_once 'inv_bill_setting_page.php';
      require_once 'inv_bill_user_registration_form.php';
      require_once 'inv_bill_user_login.php';

      new invSettimngPage();
      new userresgistration();
      new userlogin();
   }

   /**
    * Plugin Activatoin Hook
    */

   public function invintegrate_assets_activate()
   {

      $installed = get_option('invintegrate_installed');

      if (!$installed) {
         update_option('invintegrate_installed', time());
      }

      update_option('invintegrate_assets_version', invINTEGRATE_ASSETS_VERSION);
   }
}


/**
 * Create a class instance
 */


new invintegrate();