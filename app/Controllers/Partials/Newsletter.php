<?php
namespace App\Controllers\Partials;

trait Newsletter
{
    public static function newsletterCategories()
    {
        $args = array(
            'taxonomy' => array( 'category' ),
            'order' => 'ASC',
            'orderby' => 'name',
            'hide_empty' => false,
            'meta_key' => 'in_newsletter',
            'meta_value' => 1
        );

        $categories = new \WP_Term_Query($args);

        return array_map(function ($item) {
            return array(
                'name' => $item->name,
                'id' => $item->term_id,
                'icon' => wp_get_attachment_url(
                    get_field('icon', 'category_' . $item->term_id)
                )
            );
        }, $categories->terms);
    }
}
