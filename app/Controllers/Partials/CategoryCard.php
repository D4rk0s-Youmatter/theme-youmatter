<?php
namespace App\Controllers\Partials;

trait CategoryCard
{
    public static function getCatCardDetails($term)
    {
        $icon_url = wp_get_attachment_url(get_field('icon', $term));

        if (!$data = @file_get_contents($icon_url)) {
            $icon = null;
        } else {
            $icon = file_get_contents($icon_url);
        }

        return array(
            'termName' => $term->name,
            'termIcon' => $icon,
            'termUrl' => get_category_link($term->term_id)
        );
    }
}
