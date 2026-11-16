<?php

/**
 * WYSIWYG block render template.
 *
 * @var array $block Block settings and attributes.
 */

Timber\Timber::render('blocks/wysiwyg.twig', [
    'wysiwyg' => get_field('wysiwyg'),
]);
