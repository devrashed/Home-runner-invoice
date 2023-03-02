<?php
/**
 * Plugin Name: Homerunner Billing
 * Description: Homerunner billing management wordpress plugin
 * Plugin URI: https://hudsoncreative.com/
 * Author: Rashed khan
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html 
 */

namespace HomerunnerBilling;

if (!defined('ABSPATH')) {
   exit;
}

final class Plugin
{
   const version = '1.0';

   function __construct()
   {
      $this->define_constants();
      register_activation_hook(HOMEBILL_FILE, [$this, 'activate']);
      add_action('plugins_loaded', [$this, 'setup']);
      add_action('wp_enqueue_scripts', [$this, 'frontend_scripts']);
      add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
   }

   function enqueue_scripts()
   {
      wp_enqueue_script('homebill-frontend', plugins_url('assets/js/frontend.js', __FILE__), array('jquery'), 0.3, false);
      wp_localize_script('homebill-frontend', 'homebill_frontend_vars', array('ajax_url' => admin_url('admin-ajax.php')));
   }

   function admin_scripts()
   {
      wp_enqueue_script(
         'homebill-admin-customer',
         plugins_url('assets/js/admin-customer.js', __FILE__),
         array('jquery'),
         HOMEBILL_VERSION,
         true
      );
   }

   /**
    * Define the required plugin constants
    *
    * @return void
    */
   public function define_constants()
   {
      define('HOMEBILL_VERSION', self::version);
      define('HOMEBILL_FILE', __FILE__);
      define('HOMEBILL_PATH', __DIR__);
      define('HOMEBILL_URL', plugin_dir_url(__FILE__));
   }

   public function setup()
   {
      require_once 'vendor/autoload.php';

      require_once 'class-settings-page.php';
      require_once 'class-user-registration.php';
      require_once 'class-user-login.php';
      require_once 'class-customer-controller.php';
      require_once 'class-customers-page.php';
      require_once 'class-customer-list-table.php';

      new SettingsPage();
      new CustomersPage();
      new UserRegistration();
      new UserLogin();
      new CustomerController();

   }

   /**
    * Plugin Activatoin Hook
    */

   public function activate()
   {
      update_option('homebill_version', HOMEBILL_VERSION);
   }
}

new Plugin();