<?php
namespace HomerunnerBilling;

if (!defined('ABSPATH')) {
	exit;
}

final class CustomersPage
{
	function __construct()
	{
		add_action('admin_menu', [$this, 'admin_menu'], 20);
	}

	function admin_menu()
	{
		$page = add_submenu_page(
			"homebill", // url handle from main menu
			__('Customers', 'homebill'), // page title name
			__('Customers', 'homebill'), // sub menu name 
			"manage_options", // menu handle 
			"homebill-customers", // URL 
			array($this, 'customers_list_table'),
		);

		add_action("load-$page", [$this, 'load_page']);

		add_submenu_page(
			"homebill", // url handle from main menu
			__('Create Customer Account', 'homebill'), // page title name
			__('Add New Customer', 'homebill'), // sub menu name 
			"manage_options", // menu handle 
			"homebill-new-customer", // URL 
			array($this, 'customer_create'),
		);
	}

	public function load_page()
	{
		global $customers_table;

		$customers_table = new Customer_List_Table();
		$customers_table->prepare_items();
	}

	public function customers_list_table()
	{
		global $customers_table;

		?>
		<div class="wrap">
			<h1>Customers</h1>
			<?php
			$customers_table->display();
			?>
		</div>
		<?php
	}

	function customer_create()
	{
		?>
		<div class="wrap">
			<h1>Create Customer</h1>
			<?php require_once 'customer-form.php'; ?>
		</div>
		<?php
	}
}