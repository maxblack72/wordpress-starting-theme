<?php

// Field group for the WYSIWYG block, registered in code so it is versioned in Git.
acf_add_local_field_group([
    'key'      => 'group_block_wysiwyg',
    'title'    => 'WYSIWYG block',
    'fields'   => [
        [
            'key'          => 'field_block_wysiwyg',
            'label'        => 'WYSIWYG',
            'name'         => 'wysiwyg',
            'type'         => 'wysiwyg',
            'tabs'         => 'visual',
            'toolbar'      => 'minimal',
            'media_upload' => 0,
            'delay'        => 0,
        ],
    ],
    'location' => [
        [
            [
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'acf/wysiwyg',
            ],
        ],
    ],
]);
