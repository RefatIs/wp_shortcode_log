<?php

function mlp_plugin_menu()
{
    add_submenu_page(
        'options-general.php',
        'Настройки плагина',
        'Настройки плагина',
        'manage_options',
        'mlp-settings',
        'mlp_settings_page',
    );
}
add_action('admin_menu', 'mlp_plugin_menu');

function mlp_settings_page()
{
    if (isset($_POST['submit'])) {
        update_option('mlp_posts_number', htmlspecialchars($_POST['mlp_posts_number'])); ?>
        <div class="notice notice-success is-dismissible">
            <p>Информация сохранена!</p>
        </div><?php
            } ?>

    <h1>Настройки плагина "My Latest Posts"</h1>

    <form method="post">

        <table class="form-table">
            <tr>
                <th>Кол-во постов</th>
                <td><input type="number" name="mlp_posts_number" value="<?php echo get_option('mlp_posts_number', '10') ?>" class="regular-text" required></td>
            </tr>
        </table>

        <input type="submit" name="submit" value="Сохранить изменения" class="button button-primary button-large">

    </form>

<?php
}
