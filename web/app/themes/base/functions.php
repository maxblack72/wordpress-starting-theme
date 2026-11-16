<?php

Timber\Timber::init();

// Directory where Twig templates are located.
Timber\Timber::$dirname = ['views'];

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
});
