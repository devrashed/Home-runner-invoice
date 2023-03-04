<?php
use Stripe\StripeClient;

$stripe = new StripeClient(get_option('homebill_stripe_secret_key'));
$customer = $stripe->customers->retrieve($_GET['id']);
?>

<form method="POST" id="homebill-customer-form">
    <table class="form-table">
        <tr>
            <th>
                <?php _e('Name'); ?>
            </th>
            <td><input type="text" id="name" name="name" value="<?php echo $customer->name; ?>"></td>
        </tr>
        <tr>
            <th>
                <?php _e('Email') ?>
            </th>
            <td><input type="email" id="email" name="email" value="<?php echo $customer->email; ?>"></td>
        </tr>
    </table>

    <p class="submit">
        <input type="hidden" name="action" value="homebill_update_customer" />
        <input type="hidden" name="id" value="<?php echo $customer->id; ?>" />
        <input type="submit" name="submit" id="submit" class="button button-primary"
            value="<?php esc_attr_e('Update Customer') ?>">
    </p>

    <div class="form-notice"></div>
</form>