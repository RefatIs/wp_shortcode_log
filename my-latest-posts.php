<?php

/**
 * 
 * Plugin Name: My Custom Latest Posts
 * Description: Плагин для вывода последних постов с логированием ошибок.
 * Author:      RefatIs
 * Author URI:  https://kwork.ru/user/RefatIs
 * Version: 1.0
 * 
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/admin-page.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

function my_latest_posts_shortcode($atts)
{
    try {
        $log = new Logger('MLP');
        $stream = new StreamHandler(__DIR__ . '/logs/plugin.log', Level::Debug);
        $log->pushHandler($stream);

        $post_count = get_option('mlp_posts_number', '10');

        $query = new WP_Query([
            'posts_per_page' => $post_count,
            'post_status' => 'publish',
        ]);

        if (!$query->have_posts()) {
            $log->warning('There is no posts available.');
            return 'There is no posts available.';
        }

        $output = '<ul>';
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        }
        $output .= '</ul>';

        wp_reset_postdata();


        return $output;
    } catch (Exception $e) {
        $log->error('Error displaying recent posts: ' . $e->getMessage());
        return 'An error occurred while displaying posts.';
    }
}
add_shortcode('my-latest-posts', 'my_latest_posts_shortcode');
