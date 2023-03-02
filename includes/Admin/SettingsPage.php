<?php
namespace HomerunnerBilling\Admin;

if (!defined('ABSPATH')) {
	exit;
}
final class SettingsPage
{
	function __construct()
	{
		add_action('admin_menu', [$this, 'admin_menu'], 100);
		add_action('admin_init', [$this, 'admin_init']);
	}

	function admin_menu()
	{
		add_submenu_page(
			"homebill",
			__('Plugin Settings', 'homebill'),
			__('Settings', 'homebill'),
			"manage_options",
			"homebill-settings",
			array($this, 'page_content'),
		);
	}

	function page_content()
	{
		?>
		<div class="wrap">
			<h2>Plugin Settings</h2>
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

	public function admin_init()
	{
		register_setting(
			'homebill_settings', // option_group
			'homebill_stripe_secret_key', // option_name
		);

		add_settings_section(
			'homebill_stripe',
			'Stripe Settings',
			array($this, 'inv_setting_section_info'),
			'homebill'
		);

		add_settings_field(
			'homebill_stripe_secret_key',
			'Secret Key',
			array($this, 'secret_key_field'),
			'homebill',
			'homebill_stripe'
		);
	}

	public function inv_setting_section_info()
	{
	}

	public function secret_key_field()
	{
		printf(
			'<input class="regular-text" type="text" name="homebill_stripe_secret_key" id="homebill_stripe_secret_key" value="%s"> ',
			get_option('homebill_stripe_secret_key')
		);

	}


}