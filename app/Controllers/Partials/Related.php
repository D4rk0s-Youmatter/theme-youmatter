<?php
namespace App\Controllers\Partials;

trait Related
{
    public function relatedArticles()
    {
        $args = array(
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

        if (is_single() && get_post_type() !== 'organisations') {
            $first_cat = wp_get_post_categories(get_the_ID(), array(
                'parent' => 0,
            ));

            $excludedCategory = $this->relatedExcludedCategory();

            if (!empty($first_cat)) {
                $args['category__in'] = $first_cat[0];
            }

            if (!empty($excludedCategory)) {
                $args['category__not_in'] = $excludedCategory[0];
            }
        }

        $query = new \WP_Query($args);

        return $query->posts;
    }
}
