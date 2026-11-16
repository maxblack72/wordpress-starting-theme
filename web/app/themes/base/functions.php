<?php

Timber\Timber::init();

// Directory where Twig templates are located.
Timber\Timber::$dirname = ['views'];

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
});

// Register every block found in the blocks directory.
add_action('init', function () {
    foreach (glob(get_theme_file_path('blocks/*/block.json')) as $block_json) {
        register_block_type(dirname($block_json));
    }
});

// Register the field groups of every block.
add_action('acf/init', function () {
    foreach (glob(get_theme_file_path('blocks/*/fields.php')) as $fields_file) {
        require_once $fields_file;
    }
});

// Minimal toolbar for WYSIWYG fields: no images, headings or tables.
add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
    $toolbars['Minimal'] = [
        1 => ['bold', 'italic', 'link', 'unlink', 'bullist', 'numlist'],
    ];

    return $toolbars;
});

// Allow only the blocks defined in the theme (blocks/*/block.json).
add_filter('allowed_block_types_all', function () {
    $allowed = [];

    foreach (glob(get_theme_file_path('blocks/*/block.json')) as $block_json) {
        $data = json_decode(file_get_contents($block_json), true);

        if (!empty($data['name'])) {
            $allowed[] = $data['name'];
        }
    }

    return $allowed;
});

// Disable core patterns, remote patterns, the block directory and Openverse.
add_action('after_setup_theme', function () {
    remove_theme_support('core-block-patterns');
});
add_filter('should_load_remote_block_patterns', '__return_false');
add_action('admin_init', function () {
    remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');
});
add_filter('block_editor_settings_all', function ($settings) {
    $settings['enableOpenverseMediaCategory'] = false;

    return $settings;
});
