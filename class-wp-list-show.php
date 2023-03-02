<?php 
namespace HomerunnerBilling;

if (!defined('ABSPATH')) {
    exit;
}

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Wppost_data extends WP_List_Table 
{
    // Define the columns that will be displayed in the table
    function get_columns() {
        $columns = array(
            'title' => __('Title'),
            'author' => __('Author'),
            'date' => __('Date'),
        );
        return $columns;
    }
 
    // Define the data that will be displayed in the table
    function prepare_items() {
        global $wpdb;
 
        $per_page = 2; // Number of items to display per page
 
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
 
        $this->_column_headers = array($columns, $hidden, $sortable);
 
        $current_page = $this->get_pagenum();
 
        $query_args = array(
            'post_type' => 'post',
            'orderby' => isset($_GET['orderby']) ? $_GET['orderby'] : 'date',
            'order' => isset($_GET['order']) ? $_GET['order'] : 'desc',
            'posts_per_page' => $per_page,
            'paged' => $current_page,
        );
 
        $query = new WP_Query($query_args);
 
        $this->items = $query->posts;
 
        $total_items = $query->found_posts;
 
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page' => $per_page,
        ));
    }
 
    // Define the content for each column
    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'title':
                return $item->post_title;
            case 'author':
                return get_the_author_meta('display_name', $item->post_author);
            case 'date':
                return $item->post_date;
            default:
                return '';
        }
    }
 
    // Make the title column sortable
    function get_sortable_columns() {
        $sortable_columns = array(
            'title' => array('post_title', false),
        );
        return $sortable_columns;
    }
 
}


// Create an instance of the custom class and display the table
//function wp_show_list_data() {
    $my_list_table = new Wppost_data();
    $my_list_table->prepare_items();
    $my_list_table->display();
//}
 
?>