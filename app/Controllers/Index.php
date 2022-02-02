<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Index extends Controller
{
    use Partials\Hero;

    protected $acf = true;

    private static $articles_per_page = 6;

    public function __construct()
    {
        add_action('wp_ajax_category_articles', [$this, 'articlesListAjax']);
        add_action('wp_ajax_nopriv_category_articles', [$this, 'articlesListAjax']);
    }

    public static function articlesListAjax()
    {
        check_ajax_referer('category_nonce', 'security');

        $paged = self::articlesPageStatic();
        $lang = sanitize_text_field($_POST['lang']);

        $args = array(
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'lang' => $lang
        );

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

    public function articlesCount()
    {
        global $wp_query;

        return $wp_query->found_posts;
    }

    public function articlesPagesCount()
    {
        return self::articlesPagesCountStatic();
    }

    private static function articlesListStatic($query_args = [])
    {
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'ignore_sticky_posts' => true
          );

        $query = new \WP_Query(array_merge($args, $query_args));

        return array(
            'total_pages' => $query->max_num_pages,
            'articles_label' => sprintf(pll__('%d articles found', 'youmatter'), $query->found_posts),
            'articles' => array_map(function ($article) {
                return $article;
            }, $query->posts)
        );
    }

    public function articlesPage()
    {
        return self::articlesPageStatic();
    }

    private static function articlesPagesCountStatic()
    {
        global $wp_query;

        return $wp_query->max_num_pages;
    }

    private static function articlesPageStatic()
    {
        return isset($_POST['page']) && intval($_POST['page']) ? $_POST['page'] : 1;
    }
}
