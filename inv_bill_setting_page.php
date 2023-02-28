<?php 
if ( ! defined('ABSPATH')) exit;  // if direct access 

/**
 *  setting page
 */
//require_once 'inv_bill_customer_create.php';

final class invSettimngPage  
{
	
	function __construct()
	{

		add_action( 'admin_menu', [$this, 'inv_setting_page_setup_menu']);

		add_action( 'admin_init', [$this, 'inv_setting_page_init']);
		

	}	

	function inv_setting_page_setup_menu(){

	    add_menu_page(
	__('Invoice Bill','inv_connect'),   // page title name 
	__('Invoice Bill','inv_connect'),  // menu name 
	"manage_options",  // handle submenu 
	"inv-api",     // URL 
	array($this, 'inv_settings_page_menu'), // page name or function name. 
	"dashicons-admin-settings",  // icon name 
	4
);

	add_submenu_page(
	"inv-api",        // url handle from main menu
	__('Stripe Config','inv_connect'),// page title name
	__('Stripe Config','inv_connect'), // sub menu name 
	"manage_options",   // menu handle 
	"inv-api",    // URL 
	array($this, 'inv_settings_page_menu'),// page name or function name.
);

		add_submenu_page(
	"inv-api",        // url handle from main menu
	__('Create Customer Account','inv_connect'),// page title name
	__('Add New Customer','inv_connect'), // sub menu name 
	"manage_options",   // menu handle 
	"inv-create-account",    // URL 
	/*function() {
            $instasntcustomer = new inv_customercreate();
            $instasntcustomer->inv_stripe_form();
      }*/
    array($this, 'inv_strip_create'),    
	

	
);

	}
  function inv_strip_create (){

  	require_once 'demo_customer.php';
  }

 function inv_settings_page_menu(){

		$this->inv_setting_options = get_option( 'inv_setting_option_name' ); ?>

		<div class="wrap">
			<h2>Stripe Configuration</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
				settings_fields( 'inv_setting_option_group' );
				do_settings_sections( 'inv-setting-admin' );
				submit_button();
				?>
			</form>
		</div>

		<?php
	}	
	
	public function inv_setting_page_init() {
		register_setting(
			'inv_setting_option_group', // option_group
			'inv_setting_option_name', // option_name
			array( $this, 'rk_setting_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'inv_setting_setting_section', // id
			'Settings', // title
			array( $this, 'inv_setting_section_info' ), // callback
			'inv-setting-admin' // page
		);

		add_settings_field(
			'apikey', // id
			'Api Key', // title
			array( $this, 'inv_api_callback' ), // callback
			'inv-setting-admin', // page
			'inv_setting_setting_section' // section
		);

	}	

	public function inv_setting_section_info() {
		
	}

	public function rk_setting_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['apikey'] ) ) {
			$sanitary_values['apikey'] = sanitize_text_field( $input['apikey'] );
		}

		if ( isset( $input['mode'] ) ) {
			$sanitary_values['mode'] = sanitize_text_field( $input['mode'] );
		}

		return $sanitary_values;
	}

	/* callback function */ 

	public function inv_api_callback() {
		printf(
			'<input class="regular-text" type="text" name="inv_setting_option_name[apikey]" id="apikey" value="%s"> ',
			isset( $this->inv_setting_options['apikey'] ) ? esc_attr( $this->inv_setting_options['apikey']) : ''
		);
	}

	/*Setting Api */




}  /*END THE class*/
?>

