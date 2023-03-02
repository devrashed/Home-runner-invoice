<?php
namespace HomerunnerBilling;

if (!defined('ABSPATH')) {
	exit;
}
final class SettingsPage
{
	function __construct()
	{
		add_action('admin_menu', [$this, 'inv_setting_page_setup_menu']);
		add_action('admin_init', [$this, 'inv_setting_page_init']);
	}

	function inv_setting_page_setup_menu()
	{
		add_menu_page(
			__('Invoice Bill', 'homebill'), // page title name 
			__('Invoice Bill', 'homebill'), // menu name 
			"manage_options", // handle submenu 
			"homebill", // URL 
			array($this, 'inv_settings_page_menu'), // page name or function name. 
			"dashicons-admin-settings", // icon name 
			4
		);

		add_submenu_page(
			"homebill", // url handle from main menu
			__('Stripe Config', 'homebill'), // page title name
			__('Stripe Config', 'homebill'), // sub menu name 
			"manage_options", // menu handle 
			"homebill", // URL 
			array($this, 'inv_settings_page_menu'), // page name or function name.
		);
	}

	function inv_settings_page_menu()
	{
		?>

		<div class="wrap">
			<h2>Stripe Configuration</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
				settings_fields('homebill_settings');
				do_settings_sections('homebill');
				submit_button();
				?>
			</form>
		</div>

		<?php
	}

	public function inv_setting_page_init()
	{
		register_setting(
			'homebill_settings', // option_group
			'homebill_stripe_secret_key', // option_name
		);

		add_settings_section(
			'homebill_stripe', // id
			'Settings', // title
			array($this, 'inv_setting_section_info'), // callback
			'homebill' // page
		);

		add_settings_field(
			'homebill_stripe_secret_key', // id
			'Secret Key', // title
			array($this, 'secret_key_field'), // callback
			'homebill', // page
			'homebill_stripe' // section
		);


	}

	public function inv_setting_section_info()
	{
	}

	/* callback function */

	public function secret_key_field()
	{
		printf(
			'<input class="regular-text" type="text" name="homebill_stripe_secret_key" id="homebill_stripe_secret_key" value="%s"> ',
			get_option('homebill_stripe_secret_key')
		);

	}


}