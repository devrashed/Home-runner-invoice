<?php
namespace HomerunnerBilling\Admin;

use Stripe\StripeClient;

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
			"homebill",
			__('Customers', 'homebill'),
			__('Customers', 'homebill'),
			"manage_options",
			"homebill",
			array($this, 'page_content'),
		);

		add_action("load-$page", [$this, 'load_page']);
	}

	public function load_page()
	{
		global $customers_table;

		$req_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

		if ('delete' === $req_action && !empty($_REQUEST['id'])) {
			$customer_id = $_REQUEST['id'];
			$stripeclient = new StripeClient(get_option('homebill_stripe_secret_key'));
			$stripeclient->customers->delete($customer_id);

			wp_redirect(admin_url('admin.php?page=homebill'));
			exit;
		}

		if (empty($req_action)) {
			$customers_table = new CustomerListTable();
			$customers_table->prepare_items();
		}
	}

	public function page_content()
	{
		$req_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

		?>
		<div class="wrap">
			<?php

			if ($req_action == 'add') {
				?>
				<h1>Create Customer</h1>
				<?php
				require_once 'views/create-customer-form.php';

			} elseif ($req_action == 'edit') {
				?>
				<h1>Edit Customer</h1>
				<?php
				require_once 'views/edit-customer-form.php';
			} else if (empty($req_action)) {
				?>
					<h1 class="wp-heading-inline">Customers</h1>
					<a href="<?php echo add_query_arg('action', 'add'); ?>" class="page-title-action">Add New</a>
					<hr class="wp-header-end">
					<?php
					global $customers_table;
					$customers_table->display();
			}
			?>
		</div>
		<?php
	}
}