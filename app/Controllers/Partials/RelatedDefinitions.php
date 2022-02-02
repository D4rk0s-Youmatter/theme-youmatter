<?php
namespace App\Controllers\Partials;

trait RelatedDefinitions
{
    public function relatedDefinitions()
    {
        $args = array(
            'post_type' => 'definition',
            'posts_per_page' => 3,
            'orderby' => 'rand',
            'post__not_in' => array(get_the_ID()),
            'date_query' => array(
                array(
                    'year' => date('Y', strtotime('-1 year')),
                    'compare' => '>='
                )
            )
        );

        $query = new \WP_Query($args);

        return $query->posts;
    }
}
