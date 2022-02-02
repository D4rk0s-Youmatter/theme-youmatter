<?php
namespace App\Controllers\Partials;

trait PostCard
{
    public static function getTimeAgo($date) {
        //wp_die(print_r($post));
        return sprintf( pll__( '%s ago', 'youmatter' ), human_time_diff( $date, current_time( 'timestamp' ) ) );
    }
    public static function getCardCategory($post_id) {
        $yoast_primary_cat_id = get_post_meta($post_id, "_yoast_wpseo_primary_category", true);

        if (isset($yoast_primary_cat_id)) {
            $catData = get_category($yoast_primary_cat_id);
            return array(
                "cat_name" => $catData->name,
                "cat_permalink" => get_term_link($catData->term_id)
            );
        }
        
        $items = self::getCategories();
        $cats = $items['cats'];
        $subcats = $items['subcats'];

        if (!empty($cats)) {
            $catData = $cats[0];
            return array(
                "cat_name" => $catData->name,
                "cat_permalink" => get_term_link($catData->term_id)
            );
        }

        if (!empty($subcats)) {
            $catData = get_category($subcats[0]);
            return array(
                "cat_name" => $catData->name,
                "cat_permalink" => get_term_link($catData->term_id)
            );
        }

        return null;
    }
    public static function getCategories()
    {
        $args = array(
            'taxonomy' => 'category',
            'parent' => 0,
            'hide_empty' => false
        );
        $terms = get_terms($args);

        $categories = [];
        foreach ($terms as $term) {
            if (!str_contains($term->name, 'Actualité') && !str_contains($term->name, 'news')) {
                $categories[] = $term;
            }
        }
        return $categories;
    }
}
