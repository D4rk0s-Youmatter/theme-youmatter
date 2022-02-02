<?php

namespace App\Controllers\Utils;

/*
/* Gets the categories list for post without the 2 main categories 
/*
*/

trait GetFilteredCategories
{
    public static function GetFilteredCategories($post_ID)
    {
        $terms = get_the_terms($post_ID, 'category');
         
        if (!empty($terms)) {
            foreach ($terms as $term) {
                if ( !str_contains($term->name, 'Actualité') && !str_contains($term->name, 'news')) { // the term ID you want to exclude
                    $outTerms[] = $term;
                }
            }
            return $outTerms;
        }
    }
}
