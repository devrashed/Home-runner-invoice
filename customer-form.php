<form method="POST" id="homebill-customer-form">
    <table class="form-table">
        <tr>
            <th>
                <?php _e('Name'); ?>
            </th>
            <td><input type="text" id="name" name="name"></td>
        </tr>
        <tr>
            <th>
                <?php _e('Email') ?>
            </th>
            <td><input type="email" id="email" name="email"></td>
        </tr>
    </table>

    <p class="submit">
        <input type="hidden" name="action" value="homebill_create_customer" />
        <input type="submit" name="submit" id="submit" class="button button-primary"
            value="<?php esc_attr_e('Create Customer') ?>">
    </p>

    <div class="form-notice"></div>
</form>