<?php
/**
 * Plugin Name: Disable Comments
 * Description: Disables comments and pings site-wide.
 * Version: 1.0.0
 */

// Close comments and pings on the front end.
add_filter('comments_open', '__return_false', 20);
add_filter('pings_open', '__return_false', 20);

// Hide existing comments.
add_filter('comments_array', '__return_empty_array', 10);

// Remove comment support from all post types.
add_action('init', function () {
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}, 100);

// Remove the Comments menu and the Discussion settings page.
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
    remove_submenu_page('options-general.php', 'options-discussion.php');
});

// Remove the comments item from the admin bar.
add_action('admin_bar_menu', function ($wp_admin_bar) {
    $wp_admin_bar->remove_node('comments');
}, 999);

// Block direct access to the comments screens.
add_action('admin_init', function () {
    global $pagenow;
    if (in_array($pagenow, ['edit-comments.php', 'options-discussion.php'], true)) {
        wp_safe_redirect(admin_url());
        exit;
    }
});

// Disable the comments REST endpoint and the XML-RPC method.
add_filter('rest_endpoints', function ($endpoints) {
    unset($endpoints['/wp/v2/comments'], $endpoints['/wp/v2/comments/(?P<id>[\d]+)']);
    return $endpoints;
});
add_filter('xmlrpc_methods', function ($methods) {
    unset($methods['wp.newComment']);
    return $methods;
});
