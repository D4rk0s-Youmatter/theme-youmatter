<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;

class FrontPage extends Controller
{
    use Partials\Hero;
    use Partials\PostCard;
    use Partials\Transitions;

    protected $acf = true;

    function randomTransitions()
    {
      return self::getRandomTransitions();
    }

    public static function getCategories()
    {
        $args = array(
            'taxonomy' => 'category',
            'parent' => 0,
            'hide_empty' => false,
            'exclude' => [1],
            'meta_query' => array(
                array(
                    'key'     => 'in_newsletter',
                    'value'   => true,
                    'compare' => '='
                ),
            ),
        );
        $terms = get_terms($args);

        $categories = [];
        foreach ($terms as $term) {
            $icon = get_field('icon', $term);
            if ($icon){
                $categories[] = \App::getCatCardDetails($term);
            }
        }
        return $categories;
    }

    public static function thirdSectionTitle()
    {
        return get_field('third_section_title', self::pageId());
    }

    public static function thirdSectionSubtitle()
    {
        return get_field('third_section_subtitle', self::pageId());
    }

    public static function thirdSectionText()
    {
        return get_field('third_section_text', self::pageId());
    }
    public static function themesTitle()
    {
        return get_field('themes_title', self::pageId());
    }


    ///-------- ^^^^ TODO @jerem CLEAN ABOVE ^^^^ ---------////    
    public static function lastPosts()
    {
        $number_posts_to_get = 4;
        $transitions_articles_recent_posts = get_option("featured_post_list_recent_posts");
        if ($transitions_articles_recent_posts) {
            $number_posts_to_get = 3;
            $transitions_article_data = json_decode($transitions_articles_recent_posts);
        }
        $args = array(
            "posts_per_page" => $number_posts_to_get
        );
        $posts = new WP_Query($args);

        if ($transitions_articles_recent_posts) {
            array_push($posts->posts, $transitions_article_data);
        }
        //echo "<pre>";
        //wp_die(print_r($posts->posts));
        return $posts;
    }

    /** @author : D4rk0s */
    public static function mostReadPosts()
    {
        global $wpdb;

        $query = "select post_id
                  from $wpdb->postmeta postmeta
                  inner join $wpdb->posts posts on posts.ID = postmeta.post_id 
                  where meta_key = 'views'
                  AND posts.post_date >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
                  AND posts.post_type = 'post'
                  order by CAST(meta_value AS UNSIGNED) DESC
                  LIMIT 8";

        $results = $wpdb->get_results($query);
        $postIds = array_map(function($data) { return $data->post_id; }, $results);
        $posts = get_posts(['include' => $postIds, 'numberposts' => 10]);

        // Gestion apparemment d'un article provenant de wp_4 à afficher (transition)
        $transitions_articles_popular = get_option("featured_post_list_popular_posts");
        if ($transitions_articles_popular) {
            $data = json_decode($transitions_articles_popular, false, 512, JSON_THROW_ON_ERROR);
            if (count($posts) === 8) {
                array_pop($posts);
            }
            $posts[] = new \WP_Post($data);
        }

        return $posts;
    }

    public static function featuredPosts()
    {
        $sticky_posts = self::getStickyPosts();
        $sticky_posts_count = count($sticky_posts);
        $fill_posts = 2 - $sticky_posts_count;
        
        if ($sticky_posts_count >= 2) {
            $stickies_args = array(
                "posts_per_page" => 2,
                "post__in" => $sticky_posts,
                'ignore_sticky_posts' => 1
            );
            $sticky_posts = new WP_Query($stickies_args);
            return $sticky_posts;
        }
        elseif ($fill_posts != 2) {
            $stickies_args = array(
                "posts_per_page" => 2,
                "post__in" => $sticky_posts,
            );
            $sticky_posts_query = new WP_Query($stickies_args);

            $args = array(
                "posts_per_page" => $fill_posts,
                "post__not_in" => $sticky_posts,
            );
            $my_posts = new WP_Query($args);

            $final_query = new WP_Query();
            $final_query->posts = array_merge($sticky_posts_query->posts, $my_posts->posts);
            
            $final_query->post_count = $sticky_posts_query->post_count + $my_posts->post_count;

            return $final_query;
        }
        else {
            $args = array(
                "posts_per_page" => 2
            );
            $posts = new WP_Query($args);
            return $posts;
        }
    }
    public static function themesList()
    {
        $themeList = [];
        if (have_rows('themes', self::pageId())) {

            $themes = get_field('themes', self::pageId());
            //wp_die(print_r($themes));

            foreach ($themes as $theme) {
                //wp_die(print_r($theme));
                $themeList[] = $theme["themes"];
            }
        }
        //wp_die(print_r($themeList));
        return $themeList;

    }
    public static function fundamentalsList()
    {
        $fundamentalList = [];
        if (have_rows('fundamentals', self::pageId())) {

            $fundamentals = get_field('fundamentals', self::pageId());
            //wp_die(print_r($themes));

            foreach ($fundamentals as $fundamental) {
                //wp_die(print_r($theme));
                $fundamentalList[] = $fundamental["fundamental"];
            }
        }
        //wp_die(print_r($fundamentalList));
        return $fundamentalList;

    }
    private static function getStickyPosts()
    {
        return get_option('sticky_posts');
    }
    private static function pageId()
    {
        return get_option('page_on_front');
    }

}
