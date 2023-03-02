<?php
namespace HomerunnerBilling\Admin;

if (!defined('ABSPATH')) {
	exit;
}

class Menu
{
	function __construct()
	{
		add_action('admin_menu', [$this, 'admin_menu']);
	}

	function admin_menu()
	{
		add_menu_page(
			__('Homerunner Billing', 'homebill'),
			__('HR Billing', 'homebill'),
			"manage_options",
			"homebill",
			'__return_empty_string',
			"dashicons-admin-settings",
			24.5
		);
	}
}