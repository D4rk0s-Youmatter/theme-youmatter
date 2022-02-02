<?php
namespace App\Controllers\Partials;

trait Sponsored
{

    public static function sponsoredArticles()
    {
        $sponsoredArticles = get_option('featured_content');
        $response = [];
        global $wpdb;

        //TODO define logo size
        if (!empty($sponsoredArticles)) {
            switch_to_blog(4);

            foreach ($sponsoredArticles as $key=>$value) {
                $article = get_post($key);
                $orgID =$wpdb->get_var("SELECT post_id from wp_4_postmeta WHERE meta_key LIKE 'user_%' AND meta_value LIKE " . $article->post_author);
                $org = get_post($orgID);
                
                array_push($response, array(
                    'id' => $key,
                    'title' => $value,
                    'url' => get_permalink($key),
                    'image' => has_post_thumbnail($key) ? get_the_post_thumbnail_url($key) : get_field('card_default_image', 'options'),
                    'author' => get_the_author_meta( 'first_name', $article->post_author ) . ' ' . get_the_author_meta( 'last_name', $article->post_author ),
                    'org' => $org->post_title,
                    'orgLink' => get_permalink($orgID),
                ));
            }
            restore_current_blog();
        }
        return $response;
    }
}
