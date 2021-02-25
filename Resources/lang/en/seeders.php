<?php
use Illuminate\Support\Str;

return [
    'data_rows'  => [
        'unique_id'        => 'Unique ID',
        'author_id'        => 'User ID',
        'author'           => 'User',
        'avatar'           => 'Avatar',
        'id'               => 'ID',
        'name'             => 'Name',
        'title'            => 'Title',
        'order'            => 'Order',
        'slug'             => 'Slug',
        'status'           => 'Status',
        'title'            => 'Title',
        'display_name'     => 'Display Name',
        'created_at'       => 'Created At',
        'updated_at'       => 'Updated At',
    ],
    'data_types' => [
        'calendar' => [
            'singular' => Str::singular('Calendar'),
            'plural'   => Str::plural('Calendar'),
        ],
    ],
    'menu_items' => [
        'calendar'   => 'Calendar',
    ],
];