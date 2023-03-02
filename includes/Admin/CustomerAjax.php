<?php
namespace HomerunnerBilling\Admin;

use Stripe\StripeClient;

if (!defined('ABSPATH')) {
    exit;
}

class CustomerAjax
{
    public function __construct()
    {
        add_action('wp_ajax_homebill_create_customer', [$this, 'create_customer_ajax']);
    }

    public function create_customer_ajax()
    {
        if (!current_user_can('manage_options')) {
            wp_send_json([
                'success' => false,
                'message' => 'You are not allowed to create customer',
            ]);
        }

        if (empty($_POST['name'])) {
            wp_send_json([
                'success' => false,
                'message' => 'Name is required',
            ]);
        } elseif (empty($_POST['email'])) {
            wp_send_json([
                'success' => false,
                'message' => 'Email is required',
            ]);
        }

        $stripe = new StripeClient(get_option('homebill_stripe_secret_key'));

        $name = wp_unslash($_POST['name']);
        $email = wp_unslash($_POST['email']);

        $customer = $stripe->customers->create([
            'name'  => $name,
            'email' => $email,
        ]);

        wp_send_json([
            'success'  => true,
            'message'  => 'Customer created successfully',
            'customer' => $customer,
        ]);
    }
}