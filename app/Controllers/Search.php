<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;

class Search extends Controller
{
    use Partials\Hero;

    public function __construct()
    {
        add_action('wp_ajax_search_items', [$this, 'searchResultsStatic']);
        add_action('wp_ajax_nopriv_search_items', [$this, 'searchResultsStatic']);
    }

    public function currentPage()
    {
        return self::getcurrentPage();
    }

    public function searchResults()
    {
        return self::getResults();
    }

    public function searchTerm()
    {
        return self::getcurrentSearch();
    }

    public static function searchResultsStatic()
    {
        check_ajax_referer('search_nonce', 'security');

        $data = self::getResults();

        wp_send_json_success($data);

        wp_die();
    }

    private static function getcurrentPage()
    {
        return isset($_POST['page']) && intval($_POST['page']) ? $_POST['page'] : 1;
    }

    private static function getcurrentSearch()
    {
        if (isset($_POST['s'])) {
            return sanitize_text_field($_POST['s']);
        }

        if (isset($_GET['s'])) {
            return sanitize_text_field($_GET['s']);
        }

        return null;
    }

    private static function getResults()
    {

        $per_page = get_option('posts_per_page');
        $paged = self::getcurrentPage();
        $search = self::getcurrentSearch();
        $posts_per_parge = get_option('posts_per_page');

        if (!$search) {
            return array(
                'total_pages' => 1,
                'items_label' => null,
                'items' => null
            );
        }

        $args =  array(
            'post_type' => array("post", "page"),
            'posts_per_page' => $posts_per_parge,
            'orderby' => 'post_date',
            'paged' => $paged,
            's' => self::getcurrentSearch()
        );

        $search_query = new \WP_Query($args);

        $search_query->parse_query( $args );

        relevanssi_do_query( $search_query );

        $db_query_results = array(
                'current_page' => $paged,
                'total_pages' => ceil($search_query->found_posts / $per_page),
                'items_label' => sprintf(pll__('%d results found'), $search_query->found_posts),
                'items' => array_map(function ($item) {
                    $item_details = ctype_digit($item->type) ?
                        array_merge(
                            \Category::categoryDetails(get_term($item->ID), true),
                            array('layout' => 'cat')
                        ) :
                        \App::getCardDetails($item, 'classique', false);
    
                    return \App\template('partials.card', $item_details);
                }, $search_query->posts)
            );
        return $db_query_results;
    }
}
