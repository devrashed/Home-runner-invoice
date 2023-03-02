<?php
namespace HomerunnerBilling\Admin;

use WP_List_Table;
use Stripe\StripeClient;
use Stripe\Exception\AuthenticationException;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('\WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class CustomerListTable extends WP_List_Table
{
    public function __construct($args = array())
    {
        $args = wp_parse_args(
            $args,
            array(
                'singular' => 'homebill_customer',
                'plural'   => 'homebill_customers',
                'screen'   => get_current_screen()->id,
                'ajax'     => false,
            )
        );

        parent::__construct($args);
    }

    // Define the columns that will be displayed in the table
    function get_columns()
    {
        $columns = array(
            'title'        => __('Name'),
            'email'        => __('Email'),
            'date_created' => __('Date Created'),
        );
        return $columns;
    }



    // Queryable Columns
    function get_queryable_columns()
    {
        return array();
    }

    // Sortable Columns
    function get_sortable_columns()
    {
        return array();
    }

    // Define the data that will be displayed in the table
    function prepare_items()
    {
        list($columns, $hidden, $sortable) = $this->get_column_info();

        // will utilize the $per_page variable to set the number of items to display on each page.
        $per_page = 9999; // Number of items to display per page

        try {
            $stripe = new StripeClient(get_option('homebill_stripe_secret_key'));
            $customers = $stripe->customers->all();
            $this->items = $customers->data;
            $total_items = count($customers->data);
        }
        catch (AuthenticationException $e) {
            $this->items = [];
            $total_items = 0;
        }

        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page'    => $per_page,
        ));
    }

    public function single_row($customer)
    {
        $classes = 'homebill-customer';
        ?>
        <tr id="homebill-customer-<?php echo $customer->id; ?>" class="<?php echo $classes; ?>">
            <?php $this->single_row_columns($customer); ?>
        </tr>
        <?php
    }

    // Define the content for each column
    function column_default($customer, $column_name)
    {
        do_action('manage_homebill_customers_custom_column', $column_name, $customer);
    }

    function column_cb($customer)
    {
        printf('<input id="cb-select-%1$d" type="checkbox" name="ids[]" value="%1$d" />', $customer->id);
    }

    function column_title($customer)
    {
        printf('<strong>%s</strong>', $customer->name);

        $actions = [];

        $actions['edit'] = sprintf(
            '<a href="%s" title="%s">%s</a>',
            add_query_arg(array('id' => $customer->id, 'action' => 'edit')),
            esc_attr__('Edit this item'),
            __('Edit')
        );

        $actions['delete'] = sprintf(
            '<a href="%s" title="%s">%s</a>',
            add_query_arg(array('id' => $customer->id, 'action' => 'delete')),
            esc_attr__('Delete this item'),
            __('Delete')
        );

        echo $this->row_actions($actions);
    }

    function column_email($customer)
    {
        echo $customer->email;
    }

    function column_date_created($customer)
    {
        echo date('Y-m-d H:i:s', $customer->created);
    }

}


// // Create an instance of the custom class and display the table
// //function wp_show_list_data() {
// $my_list_table = new Wppost_data();
// $my_list_table->prepare_items();
// $my_list_table->display();
// //}

?>