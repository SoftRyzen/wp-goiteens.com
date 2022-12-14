<?php
defined('ABSPATH') || exit;

//TODO Code Example

/**
 * Create admin submenu page
 */
add_action('admin_menu', 'register_esputnik_menu_item');
function register_esputnik_menu_item()
{
    add_submenu_page('wpcf7',
        __('Esputnik integration', 'contact-form-7'),
        __('Esputnik', 'contact-form-7'),
        'manage_options',
        'wpcf7-esputnik',
        'wpcf7_admin_esputnik_page'
    );
}

/**
 * Register settings group for Esputnik
 */
add_action('admin_init', 'register_esputnik_settings_fields');
function register_esputnik_settings_fields()
{
    register_setting('esputnik_settings', '_esputnik_options');
    register_setting('esputnik_settings', '_esputnik_login');
    register_setting('esputnik_settings', '_esputnik_token');
}

/**
 * Register callback for submenu
 * @return void
 */
function wpcf7_admin_esputnik_page()
{ ?>
    <div class="wrap">
        <h1><?php echo __('Esputnik integration'); ?></h1>

        <form method="post">
            <?php settings_fields('esputnik_settings'); ?>
            <?php do_settings_sections('esputnik_settings'); ?>
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row"><label for="esputnik_login"><?php echo __('Esputnik login'); ?></label></th>
                    <td><input type="text" required name="esputnik_login" class="regular-text"
                               value="<?php echo esc_attr(get_option('_esputnik_login')); ?>"/></td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="esputnik_token">  <?php echo __('Esputnik token'); ?></label>
                    </th>
                    <td><input class="regular-text" type="text" required name="esputnik_token"
                               value="<?php echo esc_attr(get_option('_esputnik_token')); ?>"/></td>
                </tr>
                </tbody>
            </table>

            <?php submit_button(); ?>

        </form>
    </div>
<?php }

/**
 * Store esputnik settings as array
 */
add_action('admin_init', 'save_esputnik_options_data');
function save_esputnik_options_data()
{
    if (isset($_POST)) {
        if (isset($_POST['esputnik_login'])) {
            update_option('_esputnik_login', $_POST['esputnik_login']);
        }
        if (isset($_POST['esputnik_token'])) {
            update_option('_esputnik_token', $_POST['esputnik_token']);
        }

        var_dump($_POST);
        // Create an empty array.
        $esputnik_options = array();

        $arr_inputs = array('esputnik_login', 'esputnik_token');
        foreach ($_POST as $key => $value) {
            if (in_array($key, $arr_inputs))
                $esputnik_options[$key] = $value;
        }
        update_option('_esputnik_options', $esputnik_options);
    }
}

