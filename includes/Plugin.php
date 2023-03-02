<?php
namespace HomerunnerBilling;

if (!defined('ABSPATH')) {
   exit;
}

final class Plugin
{
   /**
    * Plugin name
    *
    * @var string
    */
   public $name = 'Homerunner Billing';

   /**
    * Singleton The reference the *Singleton* instance of this class.
    *
    * @var Plugin
    */
   protected static $instance = null;

   /**
    * Override clone method to prevent cloning of the instance of the
    *
    * @return void
    */
   public function __clone()
   {
   }

   /**
    * Override unserialize method to prevent unserializing.
    *
    * @return void
    */
   public function __wakeup()
   {
   }

   /**
    * Protected constructor to prevent creating a new instance of the
    * *Singleton* via the `new` operator from outside of this class.
    */
   private function __construct()
   {
      $this->define_constants();
      $this->include_files();
      $this->register_hooks();
      $this->initialize();
   }

   /**
    * Define the required plugin constants
    *
    * @return void
    */
   public function define_constants()
   {
      define('HOMEBILL_DIR', plugin_dir_path(HOMEBILL_PLUGIN_FILE));
      define('HOMEBILL_URL', plugin_dir_url(HOMEBILL_PLUGIN_FILE));
      define('HOMEBILL_BASENAME', plugin_basename(HOMEBILL_PLUGIN_FILE));
   }

   public function include_files()
   {
      require_once HOMEBILL_DIR . 'vendor/autoload.php';
   }

   private function register_hooks()
   {
      add_action('plugins_loaded', [$this, 'setup']);
      add_action('wp_enqueue_scripts', [$this, 'frontend_scripts']);
      add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
   }

   public function enqueue_scripts()
   {
      wp_enqueue_script(
         'homebill-frontend',
         HOMEBILL_URL . 'assets/js/frontend.js',
         array('jquery'),
         HOMEBILL_VERSION,
         true
      );
      wp_localize_script(
         'homebill-frontend',
         'homebill_frontend_vars',
         array('ajax_url' => admin_url('admin-ajax.php'))
      );
   }

   public function admin_scripts()
   {
      wp_enqueue_script(
         'homebill-admin-customer',
         HOMEBILL_URL . 'assets/js/admin-customer.js',
         array('jquery'),
         HOMEBILL_VERSION,
         true
      );
   }

   public function initialize()
   {
      new UserRegistration();
      new UserLogin();

      if (is_admin()) {
         new Admin\Menu();
         new Admin\CustomersPage();
         new Admin\CustomerAjax();
         new Admin\SettingsPage();
      }
   }

   /**
    * Returns the *Singleton* instance of this class.
    */
   public static function get_instance()
   {
      if (is_null(self::$instance)) {
         self::$instance = new self();
      }

      return self::$instance;
   }
}