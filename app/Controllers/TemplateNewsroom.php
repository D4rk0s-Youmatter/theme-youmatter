<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateNewsroom extends Controller
{
    use Partials\Hero;

    protected $acf = true;

    public static $articles_pages_count = 0;
    public static $articles_page = 1;
    public static $taxonomy = 0;

    public function __construct()
    {
        add_action('wp_ajax_newsroom_articles', [$this, 'articlesListAjax']);
        add_action('wp_ajax_nopriv_newsroom_articles', [$this, 'articlesListAjax']);
        add_action('wp_ajax_newsroom_organizations', [$this, 'organizationsListAjax']);
        add_action('wp_ajax_nopriv_newsroom_organizations', [$this, 'organizationsListAjax']);
    }

    public static function articlesListAjax()
    {
        //check_ajax_referer('category_nonce', 'security');

        $paged = self::articlesPageStatic();
        $taxonomy = $_POST['taxonomy'] ?
            \App::getParamsList('taxonomy') :
            self::$taxonomy;

        $args = array(
            'posts_per_page' => 6,
            'paged' => $paged,
            'tax_query' => array(
                'relation' => 'AND'
            )
        );

        if ($taxonomy) {
            $args['tax_query'][] = array(
                'taxonomy' => 'newsroom_tax',
                'field' => 'term_id',
                'terms' => $taxonomy
            );
        }

        $data = self::articlesListStatic($args);

        $articles = $data['articles'];

        if ($articles) {
            $articles_html = array_map(function ($article, $i) use ($paged) {
                $layout = $paged === 1 && $i === 0 ? 'large' : 'classique';
                $article_details = \App::getCardDetails($article, $layout, false);
                return \App\template('partials.card', $article_details);
            }, $articles, array_keys($articles));
            $data['articles'] = $articles_html;
        }

        wp_send_json_success($data);

        wp_die();
    }

    private static function articlesListStatic($query_args = [])
    {

        $args = array(
            'post_type' => self::getPostType(),
            'post_status' => 'publish',
            'ignore_sticky_posts' => true
          );

        $query = new \WP_Query(array_merge($args, $query_args));

        return array(
            'total_pages' => $query->max_num_pages,
            'articles' => array_map(function ($article) {
                return $article;
            }, $query->posts)
        );
    }

    private static function articlesPageStatic()
    {
        self::$articles_page = isset($_POST['page']) && intval($_POST['page']) ? $_POST['page'] : 1;
        return self::$articles_page;
    }

    public static function getPress()
    {
        $args = array(
            'post_type' => self::getPostType(),
            'posts_per_page' => 6,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish'
        );

        $query = new \WP_Query($args);

        self::$articles_pages_count = ceil($query->found_posts / 6);

        return $query->posts;
    }

    public static function getPageCount()
    {
        return self::$articles_pages_count;
    }

    public static function getCurrentPage()
    {
        return self::$articles_page;
    }

    public static function taxonomy()
    {
        return self::$taxonomy;
    }

    public static function getCategories()
    {
        return get_terms( array(
            'taxonomy' => self::getTax(),
            'hide_empty' => false,
        ) );
    }

    private static function getPostType()
    {
        return get_current_blog_id() === 5 ? 'post' : 'newsroom';
    }

    private static function getTax()
    {
        return get_current_blog_id() === 5 ? 'category' : 'newsroom_tax';
    }
}
