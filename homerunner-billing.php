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
      add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
   }

   function enqueue_scripts()
   {
      wp_enqueue_script('jquery');
      // wp_enqueue_script('jQuery-min', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), '3.2.1', true);
      wp_enqueue_script('homebill-frontend', plugins_url('assets/js/custom.js', __FILE__), array('jquery'), 0.3, false);
      wp_localize_script('homebill-frontend', 'homebill_frontend_vars', array('ajax_url' => admin_url('admin-ajax.php')));
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

      new SettingsPage();
      new UserRegistration();
      new UserLogin();
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