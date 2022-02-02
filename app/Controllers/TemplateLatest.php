<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateLatest extends Controller
{
    use Partials\Hero;
    
    protected $acf = true;

    public function __construct()
    {
        add_action('wp_ajax_latest_articles', [$this, 'articlesListAjax']);
        add_action('wp_ajax_nopriv_latest_articles', [$this, 'articlesListAjax']);
    }

    private static function articlesPageStatic()
    {
        return isset($_POST['page']) && intval($_POST['page']) ? $_POST['page'] : 1;
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

    public static function articlesListAjax()
    {
        check_ajax_referer('latest_nonce', 'security');

        $paged = self::articlesPageStatic();
        $lang = sanitize_text_field($_POST['lang']);
        $authors = sanitize_text_field($_POST['authors']);

        $args = array(
            'posts_per_page' => 6,
            'paged' => $paged,
            'lang' => $lang,
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

    public function news()
    {
        global $post;
        $users = get_field('users', $post->ID);
        $u = [];
        if(!empty($users)){
            foreach($users as $user){
                $u[] = $user['user']['ID'];
            }
        }

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 6,
            'post_status' => 'publish',
            'author__in' => $u
        );
        $query = new \WP_Query($args);

        return $query;
    }
}
